<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\PermissionModel;
use App\Models\RolePermissionModel;

class RoleController extends BaseController
{
    protected RoleModel $roleModel;
    protected PermissionModel $permissionModel;
    protected RolePermissionModel $rolePermissionModel;

    public function __construct()
    {
        $this->roleModel = new RoleModel();
        $this->permissionModel = new PermissionModel();
        $this->rolePermissionModel = new RolePermissionModel();
    }

    /**
     * Menampilkan daftar role beserta jumlah permission
     */
    public function index()
    {
        $data['roles'] = $this->roleModel->getWithPermissionCount();
        $data['title'] = 'Manajemen Role';

        return view('role/index', $data);
    }

    /**
     * Menampilkan form edit permissions untuk suatu role
     */
    public function edit($id)
    {
        $data['role'] = $this->roleModel->find($id);

        if (! $data['role']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data role tidak ditemukan.');
        }

        $data['permissions'] = $this->permissionModel->getForRole($id);
        $data['title'] = 'Edit Role & Permissions';

        return view('role/edit', $data);
    }

    /**
     * Menyimpan permissions baru untuk suatu role (atomik)
     */
    public function updatePermissions($id)
    {
        $role = $this->roleModel->find($id);
        if (! $role) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data role tidak ditemukan.');
        }

        $permissionIds = $this->request->getPost('permissions') ?? [];

        if ($this->rolePermissionModel->replacePermissions($id, $permissionIds)) {
            return redirect()->to('/role')->with('success', 'Permissions untuk role berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui permissions.');
        }
    }
}
