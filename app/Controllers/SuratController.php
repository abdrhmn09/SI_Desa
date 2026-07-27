<?php

namespace App\Controllers;

use App\Models\PendudukModel;
use App\Models\JenisSuratModel;
use App\Models\LogSuratModel;

class SuratController extends BaseController
{
    protected PendudukModel $pendudukModel;
    protected JenisSuratModel $jenisSuratModel;
    protected LogSuratModel $logSuratModel;

    public function __construct()
    {
        $this->pendudukModel   = new PendudukModel();
        $this->jenisSuratModel = new JenisSuratModel();
        $this->logSuratModel   = new LogSuratModel();
    }

    // =========================================================================
    // 1. BAGIAN PENDUDUK: PENGAJUAN SURAT
    // =========================================================================
    
    /**
     * Menampilkan daftar surat yang bisa diajukan
     */
    public function pilih()
    {
        $data['jenisSurat'] = $this->jenisSuratModel->findAll();
        $data['title']      = 'Pilih Jenis Surat';
        return view('surat/pilih', $data);
    }

    /**
     * Menampilkan form dinamis berdasarkan JSON form_fields di jenis_surat
     */
    public function formPengajuan($jenis_id)
    {
        $jenisSurat = $this->jenisSuratModel->find($jenis_id);
        if (!$jenisSurat) throw new \CodeIgniter\Exceptions\PageNotFoundException('Jenis surat tidak ditemukan');

        $data = [
            'title' => 'Pengajuan ' . $jenisSurat['nama_surat'],
            'jenis' => $jenisSurat
        ];
        return view('surat/form_pengajuan', $data);
    }

    /**
     * Memproses pengajuan dari Penduduk (Belum ada nomor surat, status Menunggu)
     */
    public function submitPengajuan($jenis_id)
    {
        // Cari ID penduduk yang sedang login (Misal NIK disimpan di session username)
        $nik = session()->get('username');
        $penduduk = $this->pendudukModel->where('nik', $nik)->first();

        if (!$penduduk) return redirect()->back()->with('error', 'Data Penduduk Anda tidak ditemukan.');

        // Ambil data form dinamis yang diisi penduduk
        $isianDinamis = $this->request->getPost('isian'); // Berupa array dari input form

        $this->logSuratModel->save([
            'penduduk_id'    => $penduduk['id'],
            'jenis_surat_id' => $jenis_id,
            'data_isian'     => json_encode($isianDinamis), // Simpan format JSON
            'status'         => 'Menunggu',
            'keterangan'     => 'Diajukan secara mandiri melalui sistem'
        ]);

        return redirect()->to('/dashboard')->with('success', 'Surat berhasil diajukan dan menunggu persetujuan.');
    }

    // =========================================================================
    // 2. BAGIAN KEPALA DESA / ADMIN: PERSETUJUAN
    // =========================================================================

    /**
     * Kepala desa memproses persetujuan (Men-generate Nomor Surat)
     * Menggunakan konsep transaksi aman milik Anda!
     */
    public function setujui($log_id)
    {
        $logSurat = $this->logSuratModel->find($log_id);
        if (!$logSurat || $logSurat['status'] !== 'Menunggu') {
            return redirect()->back()->with('error', 'Data pengajuan tidak valid.');
        }

        $jenisSurat = $this->jenisSuratModel->find($logSurat['jenis_surat_id']);
        $tahun = date('Y');

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Hitung surat jenis yang sama dalam tahun berjalan untuk Auto-Increment Nomor
            $urutan = $db->table('log_surat')
                ->where('jenis_surat_id', $jenisSurat['id'])
                ->where('status !=', 'Menunggu') // Hanya hitung yang sudah di-ACC
                ->where("YEAR(created_at)", $tahun)
                ->countAllResults() + 1;

            $nomorSurat = sprintf('%s/%03d/%s', $jenisSurat['kode_surat'], $urutan, $tahun);

            // Update status menjadi Disetujui
            $this->logSuratModel->update($log_id, [
                'nomor_surat'         => $nomorSurat,
                'status'              => 'Disetujui',
                'ditandatangani_oleh' => session()->get('user_id'),
                'tanggal_cetak'       => date('Y-m-d')
            ]);

            $db->transComplete();
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Gagal menyetujui surat: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Surat berhasil disetujui dengan Nomor: ' . $nomorSurat);
    }

    // =========================================================================
    // 3. BAGIAN SYSTEM: TEMPLATE ENGINE & CETAK (Hasil Akhir)
    // =========================================================================

    /**
     * Merender HTML Surat yang siap diprint
     */
    public function cetak($log_id)
    {
        $pengajuan = $this->logSuratModel->find($log_id);
        
        if (!$pengajuan || $pengajuan['status'] !== 'Disetujui') {
            return redirect()->back()->with('error', 'Surat belum disetujui, tidak bisa dicetak.');
        }

        $penduduk   = $this->pendudukModel->find($pengajuan['penduduk_id']);
        $jenisSurat = $this->jenisSuratModel->find($pengajuan['jenis_surat_id']);

        // 1. Ambil Template mentah dari database
        $html = $jenisSurat['template_surat'];

        // 2. Replace tag Statis Penduduk
        $html = str_replace('[nomor_surat]', $pengajuan['nomor_surat'], $html);
        $html = str_replace('[nama]', $penduduk['nama_lengkap'], $html);
        $html = str_replace('[nik]', $penduduk['nik'], $html);
        $html = str_replace('[tempat_lahir]', $penduduk['tempat_lahir'], $html);
        $html = str_replace('[tanggal_lahir]', date('d-m-Y', strtotime($penduduk['tanggal_lahir'])), $html);
        $html = str_replace('[pekerjaan]', $penduduk['pekerjaan'], $html);
        $html = str_replace('[tanggal_cetak]', date('d F Y', strtotime($pengajuan['tanggal_cetak'])), $html);

        // 3. Replace tag Dinamis dari form yang diisi penduduk (JSON form_fields)
        $isianDinamis = json_decode($pengajuan['data_isian'], true) ?? [];
        foreach ($isianDinamis as $key => $value) {
            $html = str_replace('[' . $key . ']', htmlspecialchars($value), $html);
        }

        // Tampilkan ke view khusus cetak yang berisi CSS printer
        return view('surat/cetak', ['html_surat' => $html]);
    }
}