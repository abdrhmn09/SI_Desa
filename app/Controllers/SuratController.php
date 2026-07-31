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

    public function pilih()
    {
        $data['jenisSurat'] = $this->jenisSuratModel->findAll();
        $data['title']      = 'Pilih Jenis Surat';
        return view('surat/pilih', $data);
    }

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

    public function submitPengajuan($jenis_id)
    {
        $nik = session()->get('username');
        $penduduk = $this->pendudukModel->where('nik', $nik)->first();

        if (!$penduduk) return redirect()->back()->with('error', 'Data Penduduk Anda tidak ditemukan.');

        $isianDinamis = $this->request->getPost('isian');

        $this->logSuratModel->save([
            'penduduk_id'    => $penduduk['id'],
            'jenis_surat_id' => $jenis_id,
            'data_isian'     => json_encode($isianDinamis),
            'status'         => 'Menunggu',
            'keterangan'     => 'Diajukan secara mandiri melalui sistem'
        ]);

        return redirect()->to('/dashboard')->with('success', 'Surat berhasil diajukan dan menunggu persetujuan.');
    }

    // =========================================================================
    // 2. BAGIAN KEPALA DESA / ADMIN: PERSETUJUAN
    // =========================================================================

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
            $urutan = $db->table('log_surat')
                ->where('jenis_surat_id', $jenisSurat['id'])
                ->where('status !=', 'Menunggu')
                ->where("YEAR(created_at)", $tahun)
                ->countAllResults() + 1;

            $nomorSurat = sprintf('%s/%03d/%s', $jenisSurat['kode_surat'], $urutan, $tahun);

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
    // 3. BAGIAN SYSTEM: TEMPLATE ENGINE, PREVIEW & CETAK
    // =========================================================================

    /**
     * Susun HTML surat dari template `jenis_surat.template_surat` dengan mengganti
     * tag [xxx] memakai data penduduk + isian dinamis. Dipakai bersama oleh
     * preview() (sebelum disetujui) dan cetak() (setelah disetujui), supaya
     * logic penggantian tag tidak dobel ditulis di dua tempat.
     */
    private function renderTemplateSurat(array $pengajuan, array $penduduk, array $jenisSurat): string
    {
        $kkModel = new \App\Models\KartuKeluargaModel();
        $kk = $kkModel->find($penduduk['kartu_keluarga_id']);
        $alamatLengkap = $kk ? trim($kk['alamat'] . ' RT ' . $kk['rt'] . ' / RW ' . $kk['rw']) : '-';

        // ---- Data Identitas Desa ----
        $identitasModel = new \App\Models\IdentitasDesaModel();
        $identitas = $identitasModel->getIdentitas() ?? [];

        $html = $jenisSurat['template_surat'];

        // Nomor surat & tanggal cetak baru ada setelah status "Disetujui". Saat masih
        // "Menunggu" (dilihat lewat preview), tampilkan placeholder yang jelas alih-alih
        // string kosong, supaya tidak membingungkan admin yang mereview.
        $nomorSurat   = $pengajuan['nomor_surat'] ?? '';
        $tanggalCetak = $pengajuan['tanggal_cetak'] ?? '';

        // ---- Ganti tag data surat & penduduk ----
        $html = str_replace('[nomor_surat]', $nomorSurat !== '' ? $nomorSurat : '(diterbitkan setelah disetujui)', $html);
        $html = str_replace('[nama]', $penduduk['nama_lengkap'], $html);
        $html = str_replace('[nik]', $penduduk['nik'], $html);
        $html = str_replace('[tempat_lahir]', $penduduk['tempat_lahir'], $html);
        $html = str_replace('[tanggal_lahir]', date('d-m-Y', strtotime($penduduk['tanggal_lahir'])), $html);
        $html = str_replace('[pekerjaan]', $penduduk['pekerjaan'], $html);
        $html = str_replace('[agama]', $penduduk['agama'], $html);
        $html = str_replace('[jenis_kelamin]', $penduduk['jenis_kelamin'], $html);
        $html = str_replace('[status_kawin]', $penduduk['status_kawin'], $html);
        $html = str_replace('[alamat]', $alamatLengkap, $html);
        $html = str_replace(
            '[tanggal_cetak]',
            $tanggalCetak !== '' ? date('d F Y', strtotime($tanggalCetak)) : date('d F Y') . ' (perkiraan)',
            $html
        );

        // ---- Ganti tag identitas desa ----
        $html = str_replace('[nama_desa]',        $identitas['nama_desa']        ?? '-', $html);
        $html = str_replace('[kode_desa]',        $identitas['kode_desa']        ?? '-', $html);
        $html = str_replace('[nama_kepala_desa]', $identitas['nama_kepala_desa'] ?? '-', $html);
        $html = str_replace('[nip_kepala_desa]',  $identitas['nip_kepala_desa']  ?? '-', $html);
        $html = str_replace('[alamat_kantor]',    $identitas['alamat_kantor']    ?? '-', $html);
        $html = str_replace('[kecamatan]',        $identitas['kecamatan']        ?? '-', $html);
        $html = str_replace('[kabupaten]',        $identitas['kabupaten']        ?? '-', $html);
        $html = str_replace('[provinsi]',         $identitas['provinsi']         ?? '-', $html);
        $html = str_replace('[kodepos]',          $identitas['kodepos']          ?? '-', $html);
        $html = str_replace('[telepon]',          $identitas['telepon']          ?? '-', $html);
        $html = str_replace('[email]',            $identitas['email']            ?? '-', $html);

        // ---- Ganti isian dinamis dari form ----
        $isianDinamis = json_decode($pengajuan['data_isian'], true) ?? [];
        foreach ($isianDinamis as $key => $value) {
            $html = str_replace('[' . $key . ']', htmlspecialchars($value), $html);
        }

        return $html;
    }

    /**
     * Preview surat SEBELUM disetujui — dipakai admin/Kepala Desa di halaman
     * Persetujuan untuk melihat detail/isi surat terlebih dahulu sebelum
     * menekan ACC atau Tolak. Berbeda dari cetak(), method ini tidak mensyaratkan
     * status "Disetujui", tidak auto-print, dan tidak butuh nomor_surat.
     */
    public function preview($log_id)
    {
        $pengajuan = $this->logSuratModel->find($log_id);
        if (!$pengajuan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengajuan surat tidak ditemukan.');
        }

        $penduduk   = $this->pendudukModel->find($pengajuan['penduduk_id']);
        $jenisSurat = $this->jenisSuratModel->find($pengajuan['jenis_surat_id']);

        if (!$penduduk || !$jenisSurat) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data pengajuan tidak lengkap.');
        }

        return view('surat/preview', [
            'title'      => 'Preview Surat — ' . $jenisSurat['nama_surat'],
            'html_surat' => $this->renderTemplateSurat($pengajuan, $penduduk, $jenisSurat),
            'pengajuan'  => $pengajuan,
            'penduduk'   => $penduduk,
            'jenisSurat' => $jenisSurat,
        ]);
    }

    /**
     * Merender HTML Surat yang siap diprint (hanya untuk yang sudah Disetujui).
     */
    public function cetak($log_id)
    {
        $pengajuan = $this->logSuratModel->find($log_id);

        if (!$pengajuan || $pengajuan['status'] !== 'Disetujui') {
            return redirect()->back()->with('error', 'Surat belum disetujui, tidak bisa dicetak.');
        }

        $penduduk   = $this->pendudukModel->find($pengajuan['penduduk_id']);
        $jenisSurat = $this->jenisSuratModel->find($pengajuan['jenis_surat_id']);

        return view('surat/cetak', [
            'html_surat' => $this->renderTemplateSurat($pengajuan, $penduduk, $jenisSurat),
        ]);
    }

    // =========================================================================
    // 4. BAGIAN PENDUDUK: RIWAYAT
    // =========================================================================
    public function riwayat()
    {
        $nik = session()->get('username');
        $penduduk = $this->pendudukModel->where('nik', $nik)->first();

        if (!$penduduk) return redirect()->back()->with('error', 'Data Penduduk tidak ditemukan.');

        $data = [
            'title'   => 'Riwayat Pengajuan Surat',
            'riwayat' => $this->logSuratModel->getRiwayatPenduduk($penduduk['id'])
        ];

        return view('surat/riwayat', $data);
    }

    // =========================================================================
    // 5. BAGIAN ADMIN: PERSETUJUAN & SEMUA RIWAYAT
    // =========================================================================
    public function persetujuan()
    {
        $data = [
            'title'     => 'Persetujuan Surat',
            'pengajuan' => $this->logSuratModel->getPengajuanMenunggu()
        ];
        return view('surat/persetujuan', $data);
    }

    public function tolak($log_id)
    {
        $logSurat = $this->logSuratModel->find($log_id);
        if (!$logSurat || $logSurat['status'] !== 'Menunggu') {
            return redirect()->back()->with('error', 'Data pengajuan tidak valid.');
        }

        $alasan = $this->request->getPost('alasan');

        $this->logSuratModel->update($log_id, [
            'status'     => 'Ditolak',
            'keterangan' => $alasan
        ]);

        return redirect()->back()->with('success', 'Pengajuan surat berhasil ditolak.');
    }

    public function semua()
    {
        $data = [
            'title'   => 'Semua Riwayat Surat',
            'riwayat' => $this->logSuratModel->getRiwayatLengkap()
        ];
        return view('surat/semua', $data);
    }

    // =========================================================================
    // 6. BAGIAN ADMIN: MANAJEMEN JENIS SURAT
    // =========================================================================
    public function jenis()
    {
        $data = [
            'title'      => 'Manajemen Jenis Surat',
            'jenisSurat' => $this->jenisSuratModel->findAll()
        ];
        return view('surat/jenis/index', $data);
    }

    public function jenisCreate()
    {
        $data['title'] = 'Tambah Jenis Surat';
        return view('surat/jenis/create', $data);
    }

    public function jenisStore()
    {
        $rules = [
            'kode_surat'     => 'required|is_unique[jenis_surat.kode_surat]',
            'nama_surat'     => 'required',
            'template_surat' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $formFields = $this->request->getPost('form_fields');
        if (!empty($formFields)) {
            json_decode($formFields);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return redirect()->back()->withInput()->with('error', 'Format Form Dinamis (JSON) tidak valid.');
            }
        }

        $this->jenisSuratModel->save([
            'kode_surat'     => $this->request->getPost('kode_surat'),
            'nama_surat'     => $this->request->getPost('nama_surat'),
            'template_surat' => $this->request->getPost('template_surat'),
            'form_fields'    => empty($formFields) ? null : $formFields
        ]);

        return redirect()->to('/surat/jenis')->with('success', 'Jenis Surat berhasil ditambahkan.');
    }

    public function jenisEdit($id)
    {
        $jenis = $this->jenisSuratModel->find($id);
        if (!$jenis) throw new \CodeIgniter\Exceptions\PageNotFoundException('Jenis surat tidak ditemukan');

        $data = [
            'title' => 'Edit Jenis Surat',
            'jenis' => $jenis
        ];
        return view('surat/jenis/edit', $data);
    }

    public function jenisUpdate($id)
    {
        $jenis = $this->jenisSuratModel->find($id);
        if (!$jenis) return redirect()->back()->with('error', 'Jenis surat tidak ditemukan.');

        $rules = [
            'kode_surat'     => "required|is_unique[jenis_surat.kode_surat,id,{$id}]",
            'nama_surat'     => 'required',
            'template_surat' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $formFields = $this->request->getPost('form_fields');
        if (!empty($formFields)) {
            json_decode($formFields);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return redirect()->back()->withInput()->with('error', 'Format Form Dinamis (JSON) tidak valid.');
            }
        }

        $this->jenisSuratModel->update($id, [
            'kode_surat'     => $this->request->getPost('kode_surat'),
            'nama_surat'     => $this->request->getPost('nama_surat'),
            'template_surat' => $this->request->getPost('template_surat'),
            'form_fields'    => empty($formFields) ? null : $formFields
        ]);

        return redirect()->to('/surat/jenis')->with('success', 'Jenis Surat berhasil diperbarui.');
    }

    public function jenisDelete($id)
    {
        $this->jenisSuratModel->delete($id);
        return redirect()->to('/surat/jenis')->with('success', 'Jenis Surat berhasil dihapus.');
    }
}