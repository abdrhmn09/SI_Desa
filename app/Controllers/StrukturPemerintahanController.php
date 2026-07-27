<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StrukturPemerintahanModel;

class StrukturPemerintahanController extends BaseController
{
    protected StrukturPemerintahanModel $strukturModel;

    public function __construct()
    {
        $this->strukturModel = new StrukturPemerintahanModel();
    }

    public function index()
    {
        $data['struktur'] = $this->strukturModel->findAll();
        $data['title'] = 'Struktur Pemerintahan';

        return view('pemerintahan/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Pejabat / Jabatan';
        $data['validation'] = \Config\Services::validation();

        return view('pemerintahan/create', $data);
    }

    public function store()
    {
        $rules = [
            'nama_jabatan' => 'required|max_length[100]',
            'nama_pejabat' => 'required|max_length[100]',
            'tahun'        => 'required|max_length[20]',
            'foto'         => 'permit_empty|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $namaFoto = null;
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && ! $foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/pejabat', $namaFoto);
        }

        $this->strukturModel->save([
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'nama_pejabat' => $this->request->getPost('nama_pejabat'),
            'tahun'        => $this->request->getPost('tahun'),
            'foto'         => $namaFoto,
        ]);

        return redirect()->to('/pemerintahan')->with('success', 'Data pejabat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data['pejabat'] = $this->strukturModel->find($id);

        if (! $data['pejabat']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan.');
        }

        $data['title'] = 'Edit Pejabat / Jabatan';
        $data['validation'] = \Config\Services::validation();

        return view('pemerintahan/edit', $data);
    }

    public function update($id)
    {
        $pejabat = $this->strukturModel->find($id);
        if (! $pejabat) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan.');
        }

        $rules = [
            'nama_jabatan' => 'required|max_length[100]',
            'nama_pejabat' => 'required|max_length[100]',
            'tahun'        => 'required|max_length[20]',
            'foto'         => 'permit_empty|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]|max_size[foto,2048]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $namaFoto = $pejabat['foto'];
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && ! $foto->hasMoved()) {
            // hapus foto lama jika ada
            if ($namaFoto && file_exists(FCPATH . 'uploads/pejabat/' . $namaFoto)) {
                unlink(FCPATH . 'uploads/pejabat/' . $namaFoto);
            }
            $namaFoto = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/pejabat', $namaFoto);
        }

        $this->strukturModel->save([
            'id'           => $id,
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'nama_pejabat' => $this->request->getPost('nama_pejabat'),
            'tahun'        => $this->request->getPost('tahun'),
            'foto'         => $namaFoto,
        ]);

        return redirect()->to('/pemerintahan')->with('success', 'Data pejabat berhasil diperbarui.');
    }

    public function delete($id)
    {
        $pejabat = $this->strukturModel->find($id);
        if (! $pejabat) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan.');
        }

        if (!empty($pejabat['foto']) && file_exists(FCPATH . 'uploads/pejabat/' . $pejabat['foto'])) {
            unlink(FCPATH . 'uploads/pejabat/' . $pejabat['foto']);
        }

        $this->strukturModel->delete($id);

        return redirect()->to('/pemerintahan')->with('success', 'Data pejabat berhasil dihapus.');
    }
}
