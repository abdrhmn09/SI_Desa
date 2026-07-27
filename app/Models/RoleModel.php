<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table            = 'roles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'nama_role',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ------------------------------------------------------------------
    // Query Helpers
    // ------------------------------------------------------------------

    /**
     * Ambil semua role beserta jumlah permission yang dimiliki masing-masing.
     * Digunakan untuk halaman daftar role di panel admin.
     *
     * @return array
     */
    public function getWithPermissionCount(): array
    {
        return $this->db->table('roles')
            ->select('roles.id, roles.nama_role, roles.created_at,
                      COUNT(role_permissions.id) AS jumlah_permission')
            ->join('role_permissions', 'role_permissions.role_id = roles.id', 'left')
            ->groupBy('roles.id')
            ->orderBy('roles.id', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Ambil semua permission yang dimiliki oleh sebuah role.
     * Digunakan untuk halaman edit role (menampilkan checkbox permission).
     *
     * @param  int   $roleId
     * @return array Array berisi nama_permission yang aktif untuk role ini
     */
    public function getPermissions(int $roleId): array
    {
        $rows = $this->db->table('role_permissions')
            ->select('permissions.id, permissions.nama_permission')
            ->join('permissions', 'permissions.id = role_permissions.permission_id')
            ->where('role_permissions.role_id', $roleId)
            ->get()
            ->getResultArray();

        // Kembalikan sebagai array id => nama_permission agar mudah di-loop di view
        return array_column($rows, 'nama_permission', 'id');
    }
}