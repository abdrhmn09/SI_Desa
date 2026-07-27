<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;

class ArtikelController extends BaseController
{
    protected ArtikelModel $artikelModel;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel();
    }

    public function index()
    {
        $kategori = $this->request->getGet('kategori');
        $cari     = $this->request->getGet('cari');

        $q = $this->artikelModel->orderBy('created_at', 'DESC');
        if ($kategori) $q->where('kategori', $kategori);
        if ($cari)     $q->like('judul', $cari);

        return view('artikel/index', [
            'title'    => 'Manajemen Artikel & Berita',
            'artikel'  => $q->findAll(),
            'kategori' => $kategori,
            'cari'     => $cari,
        ]);
    }

    public function create()
    {
        return view('artikel/create', [
            'title'      => 'Tambah Artikel',
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function store()
    {
        $rules = [
            'judul'    => 'required|max_length[255]',
            'isi'      => 'required',
            'kategori' => 'required|in_list[Berita,Pengumuman,Agenda]',
            'status'   => 'required|in_list[draft,published]',
            'gambar'   => 'permit_empty|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar,3072]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $namaGambar = null;
        $gambar = $this->request->getFile('gambar');
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $namaGambar = $gambar->getRandomName();
            $gambar->move(FCPATH . 'uploads/artikel', $namaGambar);
        }

        $judul = $this->request->getPost('judul');
        $this->artikelModel->save([
            'judul'    => $judul,
            'slug'     => $this->artikelModel->makeSlug($judul),
            'isi'      => $this->request->getPost('isi'),
            'gambar'   => $namaGambar,
            'kategori' => $this->request->getPost('kategori'),
            'status'   => $this->request->getPost('status'),
            'penulis'  => session()->get('username'),
        ]);

        return redirect()->to('/artikel')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function show($id)
    {
        $artikel = $this->artikelModel->find($id);
        if (!$artikel) throw new \CodeIgniter\Exceptions\PageNotFoundException();

        return view('artikel/show', ['title' => $artikel['judul'], 'artikel' => $artikel]);
    }

    public function edit($id)
    {
        $artikel = $this->artikelModel->find($id);
        if (!$artikel) throw new \CodeIgniter\Exceptions\PageNotFoundException();

        return view('artikel/edit', [
            'title'      => 'Edit Artikel',
            'artikel'    => $artikel,
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function update($id)
    {
        $artikel = $this->artikelModel->find($id);
        if (!$artikel) throw new \CodeIgniter\Exceptions\PageNotFoundException();

        $rules = [
            'judul'    => 'required|max_length[255]',
            'isi'      => 'required',
            'kategori' => 'required|in_list[Berita,Pengumuman,Agenda]',
            'status'   => 'required|in_list[draft,published]',
            'gambar'   => 'permit_empty|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar,3072]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $namaGambar = $artikel['gambar'];
        $gambar = $this->request->getFile('gambar');
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            if ($namaGambar && file_exists(FCPATH . 'uploads/artikel/' . $namaGambar)) {
                unlink(FCPATH . 'uploads/artikel/' . $namaGambar);
            }
            $namaGambar = $gambar->getRandomName();
            $gambar->move(FCPATH . 'uploads/artikel', $namaGambar);
        }

        $judul = $this->request->getPost('judul');
        $this->artikelModel->update($id, [
            'judul'    => $judul,
            'slug'     => $this->artikelModel->makeSlug($judul, $id),
            'isi'      => $this->request->getPost('isi'),
            'gambar'   => $namaGambar,
            'kategori' => $this->request->getPost('kategori'),
            'status'   => $this->request->getPost('status'),
            'penulis'  => session()->get('username'),
        ]);

        return redirect()->to('/artikel')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function delete($id)
    {
        $artikel = $this->artikelModel->find($id);
        if (!$artikel) throw new \CodeIgniter\Exceptions\PageNotFoundException();

        if (!empty($artikel['gambar']) && file_exists(FCPATH . 'uploads/artikel/' . $artikel['gambar'])) {
            unlink(FCPATH . 'uploads/artikel/' . $artikel['gambar']);
        }

        $this->artikelModel->delete($id);
        return redirect()->to('/artikel')->with('success', 'Artikel berhasil dihapus.');
    }
}
