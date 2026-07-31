<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PendudukModel;
use App\Models\KartuKeluargaModel;

class PendudukController extends BaseController
{
    protected PendudukModel $pendudukModel;
    protected KartuKeluargaModel $kartuKeluargaModel;
    protected $db;

    public function __construct()
    {
        $this->pendudukModel      = new PendudukModel();
        $this->kartuKeluargaModel = new KartuKeluargaModel();
        $this->db                 = \Config\Database::connect();
    }

    /**
     * Menampilkan semua data penduduk, join dengan kartu_keluarga
     * untuk menampilkan No KK.
     */
    public function index()
    {
        $cari         = $this->request->getGet('cari');
        $filterJK     = $this->request->getGet('jk');
        $filterHub    = $this->request->getGet('hubungan');
        $filterVerif  = $this->request->getGet('verifikasi');

        $builder = $this->pendudukModel
            ->select('penduduk.*, kartu_keluarga.no_kk, kartu_keluarga.rt, kartu_keluarga.rw, users.username as linked_user')
            ->join('kartu_keluarga', 'kartu_keluarga.id = penduduk.kartu_keluarga_id', 'left')
            ->join('users', 'users.penduduk_id = penduduk.id', 'left');

        if ($cari) {
            $builder->groupStart()
                    ->like('penduduk.nik', $cari)
                    ->orLike('penduduk.nama_lengkap', $cari)
                    ->groupEnd();
        }
        if ($filterJK)  { $builder->where('penduduk.jenis_kelamin', $filterJK); }
        if ($filterHub) { $builder->where('penduduk.hubungan_keluarga', $filterHub); }
        if ($filterVerif !== null && $filterVerif !== '') {
            $builder->where('penduduk.is_verified', (int)$filterVerif);
        }

        $data['penduduk']         = $builder->orderBy('penduduk.nama_lengkap', 'ASC')->findAll();
        $data['cari']             = $cari;
        $data['filterJK']         = $filterJK;
        $data['filterHubungan']   = $filterHub;
        $data['filterVerifikasi'] = $filterVerif;
        $data['title']            = 'Data Kependudukan';

        return view('penduduk/index', $data);
    }

    /**
     * Menampilkan form tambah data penduduk.
     */
    public function create()
    {
        $data['kartuKeluarga'] = $this->kartuKeluargaModel->orderBy('no_kk', 'ASC')->findAll();
        $data['validation']    = \Config\Services::validation();
        $data['title']         = 'Tambah Data Penduduk';

        return view('penduduk/create', $data);
    }

    /**
     * Menyimpan data penduduk baru.
     */
    public function store()
    {
        $rules = [
            'nik' => [
                'label' => 'NIK',
                'rules' => 'required|numeric|exact_length[16]|is_unique[penduduk.nik]',
                'errors' => [
                    'exact_length' => 'NIK harus tepat 16 digit.',
                    'is_unique'    => 'NIK sudah terdaftar, tidak boleh duplikat.',
                    'numeric'      => 'NIK hanya boleh berisi angka.',
                ],
            ],
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'kartu_keluarga_id' => 'permit_empty|integer',
            'hubungan_keluarga' => 'permit_empty|in_list[Kepala Keluarga,Istri,Anak,Famili Lain,Lainnya]',
            'tempat_lahir' => 'permit_empty|max_length[100]',
            'tanggal_lahir' => 'permit_empty|valid_date',
            'jenis_kelamin' => 'permit_empty|in_list[Laki-laki,Perempuan]',
            'agama' => 'permit_empty|max_length[30]',
            'pendidikan' => 'permit_empty|max_length[50]',
            'pekerjaan' => 'permit_empty|max_length[100]',
            'status_kawin' => 'permit_empty|in_list[Belum Kawin,Kawin,Cerai Hidup,Cerai Mati]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->pendudukModel->save([
            'nik'               => $this->request->getPost('nik'),
            'nama_lengkap'      => $this->request->getPost('nama_lengkap'),
            'kartu_keluarga_id' => $this->request->getPost('kartu_keluarga_id') ?: null,
            'hubungan_keluarga' => $this->request->getPost('hubungan_keluarga'),
            'tempat_lahir'      => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir'     => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin'     => $this->request->getPost('jenis_kelamin'),
            'agama'             => $this->request->getPost('agama'),
            'pendidikan'        => $this->request->getPost('pendidikan'),
            'pekerjaan'         => $this->request->getPost('pekerjaan'),
            'status_kawin'      => $this->request->getPost('status_kawin'),
        ]);

        return redirect()->to('/penduduk')->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit data penduduk.
     */
    public function edit($id)
    {
        $data['penduduk']      = $this->pendudukModel->find($id);
        $data['kartuKeluarga'] = $this->kartuKeluargaModel->orderBy('no_kk', 'ASC')->findAll();
        $data['validation']    = \Config\Services::validation();
        $data['title']         = 'Edit Data Penduduk';

        if (! $data['penduduk']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data penduduk tidak ditemukan.');
        }

        return view('penduduk/edit', $data);
    }

    public function show($id)
    {
        $penduduk = $this->pendudukModel
            ->select('penduduk.*, kartu_keluarga.no_kk, kartu_keluarga.rt, kartu_keluarga.rw, kartu_keluarga.alamat as alamat_kk, users.username as linked_username, users.email as linked_email')
            ->join('kartu_keluarga', 'kartu_keluarga.id = penduduk.kartu_keluarga_id', 'left')
            ->join('users', 'users.penduduk_id = penduduk.id', 'left')
            ->find($id);

        if (! $penduduk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data penduduk tidak ditemukan.');
        }

        // Ambil anggota sesama KK
        $sesamaKK = [];
        if (!empty($penduduk['kartu_keluarga_id'])) {
            $sesamaKK = $this->pendudukModel
                ->where('kartu_keluarga_id', $penduduk['kartu_keluarga_id'])
                ->where('id !=', $id)
                ->findAll();
        }

        return view('penduduk/show', [
            'penduduk'  => $penduduk,
            'sesamaKK'  => $sesamaKK,
            'title'     => 'Detail: ' . $penduduk['nama_lengkap'],
        ]);
    }

    /**
     * Mengubah status verifikasi data penduduk (Toggle Verified / Unverified)
     */
    public function verifikasi($id)
    {
        $penduduk = $this->pendudukModel->find($id);

        if (! $penduduk) {
            return redirect()->to('/penduduk')->with('error', 'Data penduduk tidak ditemukan.');
        }

        $newStatus = $penduduk['is_verified'] ? 0 : 1;
        $this->pendudukModel->update($id, ['is_verified' => $newStatus]);

        $pesan = $newStatus ? 'Data penduduk berhasil diverifikasi!' : 'Status verifikasi data penduduk dibatalkan.';
        return redirect()->back()->with('success', $pesan);
    }

    /**
     * Mengupdate data penduduk.
     */
    public function update($id)
    {
        $penduduk = $this->pendudukModel->find($id);

        if (! $penduduk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data penduduk tidak ditemukan.');
        }

        $rules = [
            'nik' => [
                'label' => 'NIK',
                // is_unique dikecualikan untuk id saat ini, supaya NIK sendiri tidak dianggap duplikat
                'rules' => "required|numeric|exact_length[16]|is_unique[penduduk.nik,id,{$id}]",
                'errors' => [
                    'exact_length' => 'NIK harus tepat 16 digit.',
                    'is_unique'    => 'NIK sudah terdaftar, tidak boleh duplikat.',
                    'numeric'      => 'NIK hanya boleh berisi angka.',
                ],
            ],
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'kartu_keluarga_id' => 'permit_empty|integer',
            'hubungan_keluarga' => 'permit_empty|in_list[Kepala Keluarga,Istri,Anak,Famili Lain,Lainnya]',
            'tempat_lahir' => 'permit_empty|max_length[100]',
            'tanggal_lahir' => 'permit_empty|valid_date',
            'jenis_kelamin' => 'permit_empty|in_list[Laki-laki,Perempuan]',
            'agama' => 'permit_empty|max_length[30]',
            'pendidikan' => 'permit_empty|max_length[50]',
            'pekerjaan' => 'permit_empty|max_length[100]',
            'status_kawin' => 'permit_empty|in_list[Belum Kawin,Kawin,Cerai Hidup,Cerai Mati]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->pendudukModel->update($id, [
            'nik'               => $this->request->getPost('nik'),
            'nama_lengkap'      => $this->request->getPost('nama_lengkap'),
            'kartu_keluarga_id' => $this->request->getPost('kartu_keluarga_id') ?: null,
            'hubungan_keluarga' => $this->request->getPost('hubungan_keluarga'),
            'tempat_lahir'      => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir'     => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin'     => $this->request->getPost('jenis_kelamin'),
            'agama'             => $this->request->getPost('agama'),
            'pendidikan'        => $this->request->getPost('pendidikan'),
            'pekerjaan'         => $this->request->getPost('pekerjaan'),
            'status_kawin'      => $this->request->getPost('status_kawin'),
        ]);

        return redirect()->to('/penduduk')->with('success', 'Data penduduk berhasil diupdate.');
    }

    /**
     * Menghapus data penduduk berdasarkan ID.
     * Penghapusan ditolak jika penduduk masih tercatat sebagai
     * kepala keluarga di salah satu Kartu Keluarga.
     *
     * @param int $id
     */
    // public function delete($id)
    // {
    //     $penduduk = $this->pendudukModel->find($id);

    //     if (! $penduduk) {
    //         throw new \CodeIgniter\Exceptions\PageNotFoundException('Data penduduk tidak ditemukan.');
    //     }

    //     // Cegah hapus jika masih menjadi kepala keluarga pada KK manapun
    //     $isKepalaKK = $this->kartuKeluargaModel
    //         ->where('kepala_keluarga_id', $id)
    //         ->countAllResults();

    //     if ($isKepalaKK > 0) {
    //         return redirect()->to('/penduduk')
    //             ->with('error', 'Data penduduk tidak dapat dihapus karena masih tercatat sebagai Kepala Keluarga. Ubah kepala keluarga terlebih dahulu.');
    //     }

    //     $this->pendudukModel->delete($id);

    //     return redirect()->to('/penduduk')->with('success', 'Data penduduk berhasil dihapus.');
    // }
    public function delete($id)
    {
        try {
            $penduduk = $this->pendudukModel->find($id);

            if (! $penduduk) {
                return redirect()->to('/penduduk')->with('error', 'Data penduduk tidak ditemukan.');
            }

            // Cek apakah dia kepala keluarga
            $isKepalaKK = $this->kartuKeluargaModel
                ->where('kepala_keluarga_id', $id)
                ->countAllResults();

            if ($isKepalaKK > 0) {
                return redirect()->to('/penduduk')
                    ->with('error', 'Data penduduk tidak dapat dihapus karena masih tercatat sebagai Kepala Keluarga. Ubah kepala keluarga terlebih dahulu.');
            }

            // Proses hapus
            $this->pendudukModel->delete($id);

            return redirect()->to('/penduduk')->with('success', 'Data penduduk berhasil dihapus.');

        } catch (\Throwable $e) {
            // MENANGKAP SEGALA JENIS ERROR!
            // Jika gagal hapus karena berelasi dengan tabel log_surat dll, pesan ini akan muncul
            return redirect()->to('/penduduk')
                ->with('error', 'Gagal menghapus: Data penduduk ini masih terkait dengan data lain (misal: riwayat surat). Detail: ' . $e->getMessage());
        }
    }

    // =====================================================================
    // exportPage() — Halaman filter sebelum ekspor Excel
    // =====================================================================
    public function exportPage()
    {
        // Ambil list dusun unik untuk filter
        $dusunList = $this->db->table('kartu_keluarga')
            ->select('dusun')
            ->where('dusun IS NOT NULL', null, false)
            ->where('dusun !=', '')
            ->groupBy('dusun')
            ->orderBy('dusun', 'ASC')
            ->get()->getResultArray();

        return view('penduduk/export', [
            'title'     => 'Ekspor Data Penduduk',
            'dusunList' => array_column($dusunList, 'dusun'),
        ]);
    }

    // =====================================================================
    // export() — Generate & download file Excel berdasarkan filter
    // =====================================================================
    public function export()
    {
        // Kumpulkan filter dari query string
        $filter = [
            'jenis_kelamin'   => $this->request->getGet('jenis_kelamin'),
            'agama'           => $this->request->getGet('agama'),
            'pendidikan'      => $this->request->getGet('pendidikan'),
            'pekerjaan'       => $this->request->getGet('pekerjaan'),
            'status_kawin'    => $this->request->getGet('status_kawin'),
            'golongan_darah'  => $this->request->getGet('golongan_darah'),
            'kewarganegaraan' => $this->request->getGet('kewarganegaraan'),
            'status_tinggal'  => $this->request->getGet('status_tinggal'),
            'hubungan_keluarga' => $this->request->getGet('hubungan_keluarga'),
            'is_dtks'         => $this->request->getGet('is_dtks'),
            'dusun'           => $this->request->getGet('dusun'),
        ];

        $data = $this->pendudukModel->getAllWithKK($filter);

        // ---- Buat spreadsheet ----
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Penduduk');

        // Header
        $headers = [
            'A' => 'No',
            'B' => 'NIK',
            'C' => 'Nama Lengkap',
            'D' => 'No. KK',
            'E' => 'Hubungan Keluarga',
            'F' => 'Tempat Lahir',
            'G' => 'Tanggal Lahir',
            'H' => 'Jenis Kelamin',
            'I' => 'Agama',
            'J' => 'Pendidikan',
            'K' => 'Pekerjaan',
            'L' => 'Status Kawin',
            'M' => 'Golongan Darah',
            'N' => 'Kewarganegaraan',
            'O' => 'Status Tinggal',
            'P' => 'Alamat',
            'Q' => 'Dusun',
            'R' => 'RT',
            'S' => 'RW',
            'T' => 'Nama Ayah',
            'U' => 'NIK Ayah',
            'V' => 'Nama Ibu',
            'W' => 'NIK Ibu',
            'X' => 'No. HP',
            'Y' => 'Email',
            'Z' => 'Status DTKS',
        ];

        // Style header
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                       'startColor' => ['argb' => 'FF1E3A5F']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ];

        foreach ($headers as $col => $label) {
            $sheet->setCellValue($col . '1', $label);
            $sheet->getStyle($col . '1')->applyFromArray($headerStyle);
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Isi data
        $row = 2;
        foreach ($data as $i => $p) {
            $sheet->fromArray([
                $i + 1,
                $p['nik']                  ?? '',
                $p['nama_lengkap']         ?? '',
                $p['no_kk']               ?? '',
                $p['hubungan_keluarga']   ?? '',
                $p['tempat_lahir']        ?? '',
                $p['tanggal_lahir']       ?? '',
                $p['jenis_kelamin']       ?? '',
                $p['agama']              ?? '',
                $p['pendidikan']         ?? '',
                $p['pekerjaan']          ?? '',
                $p['status_kawin']       ?? '',
                $p['golongan_darah']     ?? '',
                $p['kewarganegaraan']    ?? '',
                $p['status_tinggal']     ?? '',
                $p['alamat']             ?? '',
                $p['dusun']              ?? '',
                $p['rt']                 ?? '',
                $p['rw']                 ?? '',
                $p['nama_ayah']          ?? '',
                $p['nik_ayah']           ?? '',
                $p['nama_ibu']           ?? '',
                $p['nik_ibu']            ?? '',
                $p['no_hp']              ?? '',
                $p['email_penduduk']     ?? '',
                $p['is_dtks'] ? 'Ya' : 'Tidak',
            ], null, 'A' . $row);
            $row++;
        }

        // Freeze row pertama
        $sheet->freezePane('A2');

        // Output file
        $filename = 'data_penduduk_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}