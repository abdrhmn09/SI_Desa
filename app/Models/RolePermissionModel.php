<?php

namespace App\Models;

use CodeIgniter\Model;

class RolePermissionModel extends Model
{
    protected $table            = 'role_permissions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    /**
     * Tabel pivot ini hanya punya created_at (tidak ada updated_at),
     * jadi useTimestamps dinonaktifkan dan createdField di-set manual.
     * created_at ditambahkan ke allowedFields agar bisa disave via model.
     */
    protected $useTimestamps = false;

    protected $allowedFields = [
        'role_id',
        'permission_id',
        'created_at', // diisi manual karena useTimestamps = false
    ];

    // ------------------------------------------------------------------
    // Query Helpers
    // ------------------------------------------------------------------

    /**
     * Ganti semua permission untuk sebuah role secara atomik.
     *
     * Proses: hapus semua permission lama milik role tersebut,
     * lalu insert ulang dengan daftar permission baru.
     * Dibungkus transaksi agar tidak ada kondisi setengah-tersimpan.
     *
     * @param  int   $roleId
     * @param  array $permissionIds  Array of permission ID yang dipilih
     * @return bool  true jika berhasil, false jika transaksi gagal
     */
    public function replacePermissions(int $roleId, array $permissionIds): bool
    {
        $db = $this->db;
        $db->transStart();

        try {
            // 1. Hapus semua permission lama untuk role ini
            $db->table('role_permissions')
                ->where('role_id', $roleId)
                ->delete();

            // 2. Insert permission baru (jika ada yang dipilih)
            if (! empty($permissionIds)) {
                $now  = date('Y-m-d H:i:s');
                $rows = [];

                foreach ($permissionIds as $permissionId) {
                    $rows[] = [
                        'role_id'       => $roleId,
                        'permission_id' => (int) $permissionId,
                        'created_at'    => $now,
                    ];
                }

                $db->table('role_permissions')->insertBatch($rows);
            }

            $db->transComplete();
        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', '[RolePermissionModel::replacePermissions] ' . $e->getMessage());
            return false;
        }

        return $db->transStatus();
    }
}