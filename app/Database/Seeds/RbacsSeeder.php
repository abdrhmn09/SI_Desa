<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RbacsSeeder extends Seeder
{
    public function run()
    {
        // ---------------------------------------------------------
        // 1. Insert Roles
        // ---------------------------------------------------------
        $roles = [
            ['nama_role' => 'Administrator', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_role' => 'Operator',      'created_at' => date('Y-m-d H:i:s')],
            ['nama_role' => 'Redaksi',       'created_at' => date('Y-m-d H:i:s')],
            ['nama_role' => 'Kepala Dusun',  'created_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('roles')->insertBatch($roles);

        // ---------------------------------------------------------
        // 2. Insert Permissions
        // ---------------------------------------------------------
        $permissions = [
            'akses_pengaturan_aplikasi',
            'manajemen_pengguna',
            'lihat_log',
            'akses_semua_modul',
            'kelola_kependudukan',
            'kelola_surat',
            'lihat_statistik',
            'kelola_bansos',
            'kelola_artikel',
            'kelola_galeri',
            'moderasi_komentar',
            'kelola_warga_lokal',
        ];

        $dataPermissions = [];
        foreach ($permissions as $permission) {
            $dataPermissions[] = [
                'nama_permission' => $permission,
                'created_at'      => date('Y-m-d H:i:s'),
            ];
        }

        $this->db->table('permissions')->insertBatch($dataPermissions);

        // ---------------------------------------------------------
        // 3. Ambil ulang ID role & permission yang baru diinsert
        //    (supaya insert ke role_permissions tidak hardcode ID)
        // ---------------------------------------------------------
        $roleRows = $this->db->table('roles')->get()->getResultArray();
        $permissionRows = $this->db->table('permissions')->get()->getResultArray();

        // Mapping nama => id, biar gampang dipanggil di bawah
        $roleId = array_column($roleRows, 'id', 'nama_role');
        $permissionId = array_column($permissionRows, 'id', 'nama_permission');

        // ---------------------------------------------------------
        // 4. Matriks Role => Permission
        // ---------------------------------------------------------
        $matriks = [
            'Administrator' => [
                'akses_pengaturan_aplikasi',
                'manajemen_pengguna',
                'lihat_log',
                'akses_semua_modul',
                'kelola_kependudukan',
                'kelola_surat',
                'lihat_statistik',
                'kelola_bansos',
                'kelola_artikel',
                'kelola_galeri',
                'moderasi_komentar',
                'kelola_warga_lokal',
            ],
            'Operator' => [
                'kelola_kependudukan',
                'kelola_surat',
                'lihat_statistik',
                'kelola_bansos',
            ],
            'Redaksi' => [
                'kelola_artikel',
                'kelola_galeri',
                'moderasi_komentar',
            ],
            'Kepala Dusun' => [
                'kelola_warga_lokal',
            ],
        ];

        // ---------------------------------------------------------
        // 5. Insert ke role_permissions berdasarkan matriks di atas
        // ---------------------------------------------------------
        $dataRolePermissions = [];

        foreach ($matriks as $namaRole => $daftarPermission) {
            foreach ($daftarPermission as $namaPermission) {
                $dataRolePermissions[] = [
                    'role_id'       => $roleId[$namaRole],
                    'permission_id' => $permissionId[$namaPermission],
                    'created_at'    => date('Y-m-d H:i:s'),
                ];
            }
        }

        $this->db->table('role_permissions')->insertBatch($dataRolePermissions);
    }
}