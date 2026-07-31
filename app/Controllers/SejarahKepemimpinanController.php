<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SejarahKepemimpinanModel;

class SejarahKepemimpinanController extends BaseController
{
    protected SejarahKepemimpinanModel $sejarahModel;

    public function __construct()
    {
        $this->sejarahModel = new SejarahKepemimpinanModel();

        // Hak akses admin: sama seperti pengecekan $hasPermission() di layout admin.php,
        // jadi menyembunyikan menu di sidebar saja TIDAK cukup — modul ini juga dikunci
        // di sisi controller supaya tidak bisa diakses langsung lewat URL oleh pengguna
        // yang login tapi tidak punya izin 'kelola_sejarah'.
        $roleId      = session()->get('role_id');
        $permissions = $roleId ? (new \App\Models\RoleModel())->getPermissions($roleId) : [];
        $diizinkan   = in_array('akses_semua_modul', $permissions) || in_array('kelola_artikel', $permissions);

        if (!$diizinkan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Anda tidak memiliki akses ke modul Sejarah Kepemimpinan.');
        }
    }

    public function index()
    {
        return view('sejarah/index', [
            'title'   => 'Manajemen Sejarah Kepemimpinan',
            'sejarah' => $this->sejarahModel->orderBy('id', 'ASC')->findAll(),
        ]);
    }

    public function create()
    {
        return view('sejarah/create', [
            'title'      => 'Tambah Sejarah Kepemimpinan',
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function store()
    {
        $rules = [
            'nama'         => 'required|max_length[255]',
            'masa_jabatan' => 'required|max_length[100]',
            'keterangan'   => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->sejarahModel->save([
            'nama'         => $this->request->getPost('nama'),
            'masa_jabatan' => $this->request->getPost('masa_jabatan'),
            'keterangan'   => $this->request->getPost('keterangan'),
        ]);

        return redirect()->to('/sejarah')->with('success', 'Data sejarah kepemimpinan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $sejarah = $this->sejarahModel->find($id);
        if (!$sejarah) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return view('sejarah/show', ['title' => $sejarah['nama'], 'sejarah' => $sejarah]);
    }

    public function edit($id)
    {
        $sejarah = $this->sejarahModel->find($id);
        if (!$sejarah) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return view('sejarah/edit', [
            'title'      => 'Edit Sejarah Kepemimpinan',
            'sejarah'    => $sejarah,
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function update($id)
    {
        $sejarah = $this->sejarahModel->find($id);
        if (!$sejarah) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $rules = [
            'nama'         => 'required|max_length[255]',
            'masa_jabatan' => 'required|max_length[100]',
            'keterangan'   => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->sejarahModel->update($id, [
            'nama'         => $this->request->getPost('nama'),
            'masa_jabatan' => $this->request->getPost('masa_jabatan'),
            'keterangan'   => $this->request->getPost('keterangan'),
        ]);

        return redirect()->to('/sejarah')->with('success', 'Data sejarah kepemimpinan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $sejarah = $this->sejarahModel->find($id);
        if (!$sejarah) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $this->sejarahModel->delete($id);
        return redirect()->to('/sejarah')->with('success', 'Data sejarah kepemimpinan berhasil dihapus.');
    }
}