<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GaleriModel;

class GaleriController extends BaseController
{
    protected GaleriModel $galeriModel;

    public function __construct()
    {
        $this->galeriModel = new GaleriModel();
    }

    public function index()
    {
        return view('galeri/index', [
            'title'  => 'Manajemen Galeri Foto',
            'galeri' => $this->galeriModel->orderBy('created_at', 'DESC')->findAll(),
        ]);
    }

    public function create()
    {
        return view('galeri/create', [
            'title'      => 'Upload Foto Galeri',
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function store()
    {
        $rules = [
            'judul'      => 'required|max_length[255]',
            'file_gambar' => 'uploaded[file_gambar]|is_image[file_gambar]|mime_in[file_gambar,image/jpg,image/jpeg,image/png,image/webp]|max_size[file_gambar,5120]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file_gambar');
        $namaFile = $file->getRandomName();
        $file->move(FCPATH . 'uploads/galeri', $namaFile);

        $this->galeriModel->save([
            'judul'       => $this->request->getPost('judul'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'file_gambar' => $namaFile,
        ]);

        return redirect()->to('/galeri')->with('success', 'Foto berhasil diupload.');
    }

    public function edit($id)
    {
        $foto = $this->galeriModel->find($id);
        if (!$foto) throw new \CodeIgniter\Exceptions\PageNotFoundException();

        return view('galeri/edit', [
            'title'      => 'Edit Foto Galeri',
            'foto'       => $foto,
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function update($id)
    {
        $foto = $this->galeriModel->find($id);
        if (!$foto) throw new \CodeIgniter\Exceptions\PageNotFoundException();

        $rules = [
            'judul'       => 'required|max_length[255]',
            'file_gambar' => 'permit_empty|is_image[file_gambar]|mime_in[file_gambar,image/jpg,image/jpeg,image/png,image/webp]|max_size[file_gambar,5120]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $namaFile = $foto['file_gambar'];
        $file = $this->request->getFile('file_gambar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            if (file_exists(FCPATH . 'uploads/galeri/' . $namaFile)) unlink(FCPATH . 'uploads/galeri/' . $namaFile);
            $namaFile = $file->getRandomName();
            $file->move(FCPATH . 'uploads/galeri', $namaFile);
        }

        $this->galeriModel->update($id, [
            'judul'       => $this->request->getPost('judul'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'file_gambar' => $namaFile,
        ]);

        return redirect()->to('/galeri')->with('success', 'Foto berhasil diperbarui.');
    }

    public function delete($id)
    {
        $foto = $this->galeriModel->find($id);
        if (!$foto) throw new \CodeIgniter\Exceptions\PageNotFoundException();

        if (file_exists(FCPATH . 'uploads/galeri/' . $foto['file_gambar'])) {
            unlink(FCPATH . 'uploads/galeri/' . $foto['file_gambar']);
        }

        $this->galeriModel->delete($id);
        return redirect()->to('/galeri')->with('success', 'Foto berhasil dihapus.');
    }
}
