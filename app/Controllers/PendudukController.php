<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PendudukModel;
use App\Models\KartuKeluargaModel;

class PendudukController extends BaseController
{
    protected PendudukModel $pendudukModel;
    protected KartuKeluargaModel $kartuKeluargaModel;

    public function __construct()
    {
        $this->pendudukModel      = new PendudukModel();
        $this->kartuKeluargaModel = new KartuKeluargaModel();
    }

    /**
     * Menampilkan semua data penduduk, join dengan kartu_keluarga
     * untuk menampilkan No KK.
     */
    public function index()
    {
        $cari        = $this->request->getGet('cari');
        $filterJK    = $this->request->getGet('jk');
        $filterHub   = $this->request->getGet('hubungan');

        $builder = $this->pendudukModel
            ->select('penduduk.*, kartu_keluarga.no_kk, kartu_keluarga.rt, kartu_keluarga.rw')
            ->join('kartu_keluarga', 'kartu_keluarga.id = penduduk.kartu_keluarga_id', 'left');

        if ($cari) {
            $builder->groupStart()
                    ->like('penduduk.nik', $cari)
                    ->orLike('penduduk.nama_lengkap', $cari)
                    ->groupEnd();
        }
        if ($filterJK)  { $builder->where('penduduk.jenis_kelamin', $filterJK); }
        if ($filterHub) { $builder->where('penduduk.hubungan_keluarga', $filterHub); }

        $data['penduduk']       = $builder->orderBy('penduduk.nama_lengkap', 'ASC')->findAll();
        $data['cari']           = $cari;
        $data['filterJK']       = $filterJK;
        $data['filterHubungan'] = $filterHub;
        $data['title']          = 'Data Kependudukan';

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
            ->select('penduduk.*, kartu_keluarga.no_kk, kartu_keluarga.rt, kartu_keluarga.rw, kartu_keluarga.alamat as alamat_kk')
            ->join('kartu_keluarga', 'kartu_keluarga.id = penduduk.kartu_keluarga_id', 'left')
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
    public function delete($id)
    {
        $penduduk = $this->pendudukModel->find($id);

        if (! $penduduk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data penduduk tidak ditemukan.');
        }

        // Cegah hapus jika masih menjadi kepala keluarga pada KK manapun
        $isKepalaKK = $this->kartuKeluargaModel
            ->where('kepala_keluarga_id', $id)
            ->countAllResults();

        if ($isKepalaKK > 0) {
            return redirect()->to('/penduduk')
                ->with('error', 'Data penduduk tidak dapat dihapus karena masih tercatat sebagai Kepala Keluarga. Ubah kepala keluarga terlebih dahulu.');
        }

        $this->pendudukModel->delete($id);

        return redirect()->to('/penduduk')->with('success', 'Data penduduk berhasil dihapus.');
    }
}