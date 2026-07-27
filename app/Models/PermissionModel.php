<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionModel extends Model
{
    protected $table            = 'permissions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'nama_permission',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ------------------------------------------------------------------
    // Query Helpers
    // ------------------------------------------------------------------

    /**
     * Ambil semua permission dengan flag `is_checked` berdasarkan role tertentu.
     *
     * Digunakan di form edit role untuk me-render checkbox:
     * permission yang sudah dimiliki role akan punya is_checked = 1,
     * yang belum dimiliki akan punya is_checked = 0.
     *
     * @param  int   $roleId
     * @return array
     */
    public function getForRole(int $roleId): array
    {
        return $this->db->table('permissions')
            ->select('permissions.id,
                      permissions.nama_permission,
                      (SELECT COUNT(*) FROM role_permissions
                       WHERE role_permissions.role_id = ' . (int) $roleId . '
                       AND role_permissions.permission_id = permissions.id
                      ) AS aktif')
            ->orderBy('permissions.nama_permission', 'ASC')
            ->get()
            ->getResultArray();
    }
}