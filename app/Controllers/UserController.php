<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;

class UserController extends BaseController
{
    protected UserModel $userModel;
    protected RoleModel $roleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    /**
     * Menampilkan daftar pengguna (admin area)
     */
    public function index()
    {
        $data['users'] = $this->userModel->getAllWithRole();
        $data['title'] = 'Manajemen Pengguna';

        return view('pengguna/index', $data);
    }

    /**
     * Menampilkan form pembuatan akun pengguna
     */
    public function create()
    {
        $data['title'] = 'Tambah Pengguna';
        $data['roles'] = $this->roleModel->findAll();
        $data['validation'] = \Config\Services::validation();

        return view('pengguna/create', $data);
    }

    /**
     * Menyimpan data akun pengguna baru
     */
    public function store()
    {
        $rules = [
            'username'   => 'required|min_length[3]|is_unique[users.username]',
            'email'      => 'permit_empty|valid_email',
            'password'   => 'required|min_length[6]',
            'role_id'    => 'permit_empty|integer',
            'wilayah_id' => 'permit_empty|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->save([
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'password'   => $this->request->getPost('password'), // Di-hash oleh model
            'role_id'    => $this->request->getPost('role_id') ?: null,
            'wilayah_id' => $this->request->getPost('wilayah_id') ?: null,
            'is_active'  => 1,
        ]);

        return redirect()->to('/pengguna')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit pengguna
     */
    public function edit($id)
    {
        $data['user'] = $this->userModel->findWithRole($id);

        if (! $data['user']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data pengguna tidak ditemukan.');
        }

        $data['title'] = 'Edit Pengguna';
        $data['roles'] = $this->roleModel->findAll();
        $data['validation'] = \Config\Services::validation();

        return view('pengguna/edit', $data);
    }

    /**
     * Memperbarui data pengguna
     */
    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (! $user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data pengguna tidak ditemukan.');
        }

        $rules = [
            'username'   => "required|min_length[3]|is_unique[users.username,id,{$id}]",
            'email'      => 'permit_empty|valid_email',
            'password'   => 'permit_empty|min_length[6]',
            'role_id'    => 'permit_empty|integer',
            'wilayah_id' => 'permit_empty|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $saveData = [
            'id'         => $id,
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'role_id'    => $this->request->getPost('role_id') ?: null,
            'wilayah_id' => $this->request->getPost('wilayah_id') ?: null,
        ];

        $password = $this->request->getPost('password');
        if (! empty($password)) {
            $saveData['password'] = $password;
        }

        $this->userModel->save($saveData);

        return redirect()->to('/pengguna')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Toggle status aktif/nonaktif akun
     */
    public function toggleActive($id)
    {
        $user = $this->userModel->find($id);
        if (! $user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data pengguna tidak ditemukan.');
        }

        if ($user['id'] == session()->get('user_id')) {
            return redirect()->to('/pengguna')->with('error', 'Anda tidak bisa menonaktifkan akun sendiri.');
        }

        $this->userModel->save([
            'id' => $id,
            'is_active' => $user['is_active'] ? 0 : 1,
        ]);

        return redirect()->to('/pengguna')->with('success', 'Status pengguna berhasil diubah.');
    }

    /**
     * Menghapus pengguna
     */
    public function delete($id)
    {
        $user = $this->userModel->find($id);
        if (! $user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data pengguna tidak ditemukan.');
        }

        if ($user['id'] == session()->get('user_id')) {
            return redirect()->to('/pengguna')->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $this->userModel->delete($id);

        return redirect()->to('/pengguna')->with('success', 'Data pengguna berhasil dihapus.');
    }
}
