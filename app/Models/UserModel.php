<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'username',
        'email',
        'password',
        'role_id',
        'wilayah_id',
        'penduduk_id',
        'is_active',
        'otp_code',
        'otp_expires_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ------------------------------------------------------------------
    // Callbacks: hash password otomatis sebelum insert/update
    // Tidak perlu memanggil password_hash() di controller lagi.
    // ------------------------------------------------------------------
    protected $beforeInsert = ['hashPasswordOnInsert'];
    protected $beforeUpdate = ['hashPasswordOnUpdate'];

    /**
     * Hash password sebelum INSERT.
     * Selalu di-hash karena user baru wajib punya password.
     */
    protected function hashPasswordOnInsert(array $data): array
    {
        if (! empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }

    /**
     * Hash password sebelum UPDATE.
     * Hanya hash jika field password tidak kosong — memungkinkan
     * update data profil (username, email, role) tanpa mengubah password.
     */
    protected function hashPasswordOnUpdate(array $data): array
    {
        if (empty($data['data']['password'])) {
            // Buang key password agar tidak meng-overwrite dengan nilai kosong
            unset($data['data']['password']);
        } else {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }

    // ------------------------------------------------------------------
    // Query Helpers
    // ------------------------------------------------------------------

    /**
     * Ambil semua user beserta nama role-nya.
     * Digunakan oleh admin untuk halaman daftar pengguna.
     *
     * @return array
     */
    public function getAllWithRole(): array
    {
        return $this->db->table('users')
            ->select('users.id, users.username, users.email,
                      users.is_active, users.wilayah_id, users.created_at,
                      roles.nama_role')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->orderBy('users.username', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Ambil satu user beserta nama role-nya.
     * Digunakan oleh admin untuk halaman edit pengguna.
     *
     * @param  int        $id
     * @return array|null null jika tidak ditemukan
     */
    public function findWithRole(int $id): ?array
    {
        $result = $this->db->table('users')
            ->select('users.*, roles.nama_role')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->where('users.id', $id)
            ->get()
            ->getRowArray();

        return $result ?: null;
    }

    // ------------------------------------------------------------------
    // Permission Check
    // ------------------------------------------------------------------

    /**
     * Cek apakah user memiliki permission tertentu.
     *
     * Dioptimasi dari 2 query (find user + cek permission) menjadi
     * single JOIN query: users → role_permissions → permissions.
     *
     * @param  int    $userId
     * @param  string $permissionName  Nama permission, misal: 'kelola_surat'
     * @return bool
     */
    public function hasPermission(int $userId, string $permissionName): bool
    {
        $result = $this->db->table('users')
            ->select('permissions.nama_permission')
            ->join('role_permissions', 'role_permissions.role_id = users.role_id', 'inner')
            ->join('permissions', 'permissions.id = role_permissions.permission_id', 'inner')
            ->where('users.id', $userId)
            ->where('users.role_id IS NOT NULL', null, false)
            ->where('permissions.nama_permission', $permissionName)
            ->get()
            ->getRow();

        return $result !== null;
    }

    // ------------------------------------------------------------------
    // OTP Helpers (Lupa Password)
    // ------------------------------------------------------------------

    /**
     * Cari user berdasarkan alamat email.
     *
     * @param  string     $email
     * @return array|null
     */
    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first() ?: null;
    }

    /**
     * Simpan kode OTP dan waktu kedaluwarsa (15 menit dari sekarang) ke user.
     *
     * @param int    $userId
     * @param string $otp    Kode 6 digit
     */
    public function setOtp(int $userId, string $otp): void
    {
        $this->update($userId, [
            'otp_code'       => $otp,
            'otp_expires_at' => date('Y-m-d H:i:s', strtotime('+15 minutes')),
        ]);
    }

    /**
     * Hapus kode OTP setelah berhasil digunakan atau kedaluwarsa.
     *
     * @param int $userId
     */
    public function clearOtp(int $userId): void
    {
        $this->update($userId, [
            'otp_code'       => null,
            'otp_expires_at' => null,
        ]);
    }
}