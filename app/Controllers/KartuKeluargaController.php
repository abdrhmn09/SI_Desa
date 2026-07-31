<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KartuKeluargaModel;
use App\Models\PendudukModel;

class KartuKeluargaController extends BaseController
{
    protected KartuKeluargaModel $kkModel;
    protected PendudukModel $pendudukModel;

    public function __construct()
    {
        $this->kkModel       = new KartuKeluargaModel();
        $this->pendudukModel = new PendudukModel();
    }

    public function index()
    {
        $kartuKeluarga = $this->kkModel
            ->select('kartu_keluarga.*, penduduk.nama_lengkap as nama_kepala, 
                      COUNT(anggota.id) as jumlah_anggota')
            ->join('penduduk', 'penduduk.id = kartu_keluarga.kepala_keluarga_id', 'left')
            ->join('penduduk as anggota', 'anggota.kartu_keluarga_id = kartu_keluarga.id', 'left')
            ->groupBy('kartu_keluarga.id')
            ->orderBy('kartu_keluarga.no_kk', 'ASC')
            ->findAll();

        return view('kartu_keluarga/index', [
            'kartuKeluarga' => $kartuKeluarga,
            'title'         => 'Manajemen Kartu Keluarga',
        ]);
    }

    public function create()
    {
        return view('kartu_keluarga/create', [
            'penduduk'   => $this->pendudukModel->orderBy('nama_lengkap', 'ASC')->findAll(),
            'validation' => \Config\Services::validation(),
            'title'      => 'Tambah Kartu Keluarga',
        ]);
    }

    public function store()
    {
        $rules = [
            'no_kk'              => 'required|max_length[20]|is_unique[kartu_keluarga.no_kk]',
            'kepala_keluarga_id' => 'permit_empty|integer',
            'rt'                 => 'permit_empty|max_length[3]',
            'rw'                 => 'permit_empty|max_length[3]',
            'tanggal_dikeluarkan' => 'permit_empty|valid_date',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kkModel->save([
            'no_kk'              => $this->request->getPost('no_kk'),
            'kepala_keluarga_id' => $this->request->getPost('kepala_keluarga_id') ?: null,
            'alamat'             => $this->request->getPost('alamat'),
            'dusun'              => $this->request->getPost('dusun'),
            'rt'                 => $this->request->getPost('rt'),
            'rw'                 => $this->request->getPost('rw'),
            'tanggal_dikeluarkan' => $this->request->getPost('tanggal_dikeluarkan') ?: null,
        ]);

        return redirect()->to('/kartu-keluarga')->with('success', 'Kartu Keluarga berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kk = $this->kkModel->find($id);
        if (! $kk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('KK tidak ditemukan.');
        }

        return view('kartu_keluarga/edit', [
            'kk'         => $kk,
            'penduduk'   => $this->pendudukModel->orderBy('nama_lengkap', 'ASC')->findAll(),
            'validation' => \Config\Services::validation(),
            'title'      => 'Edit Kartu Keluarga',
        ]);
    }

    public function update($id)
    {
        $kk = $this->kkModel->find($id);
        if (! $kk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('KK tidak ditemukan.');
        }

        $rules = [
            'no_kk'              => "required|max_length[20]|is_unique[kartu_keluarga.no_kk,id,{$id}]",
            'kepala_keluarga_id' => 'permit_empty|integer',
            'rt'                 => 'permit_empty|max_length[3]',
            'rw'                 => 'permit_empty|max_length[3]',
            'tanggal_dikeluarkan' => 'permit_empty|valid_date',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kkModel->update($id, [
            'no_kk'              => $this->request->getPost('no_kk'),
            'kepala_keluarga_id' => $this->request->getPost('kepala_keluarga_id') ?: null,
            'alamat'             => $this->request->getPost('alamat'),
            'dusun'              => $this->request->getPost('dusun'),
            'rt'                 => $this->request->getPost('rt'),
            'rw'                 => $this->request->getPost('rw'),
            'tanggal_dikeluarkan' => $this->request->getPost('tanggal_dikeluarkan') ?: null,
        ]);

        return redirect()->to('/kartu-keluarga')->with('success', 'Kartu Keluarga berhasil diperbarui.');
    }

    public function delete($id)
    {
        $kk = $this->kkModel->find($id);
        if (! $kk) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('KK tidak ditemukan.');
        }

        $jumlahAnggota = $this->pendudukModel->where('kartu_keluarga_id', $id)->countAllResults();
        if ($jumlahAnggota > 0) {
            return redirect()->to('/kartu-keluarga')
                ->with('error', "KK tidak dapat dihapus karena masih memiliki {$jumlahAnggota} anggota. Pindahkan atau hapus anggota terlebih dahulu.");
        }

        $this->kkModel->delete($id);
        return redirect()->to('/kartu-keluarga')->with('success', 'Kartu Keluarga berhasil dihapus.');
    }
}
