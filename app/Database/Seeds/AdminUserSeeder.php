<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\RoleModel;
use App\Models\UserModel;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $roleModel = new RoleModel();
        $userModel = new UserModel();

        // Cari role Administrator
        $adminRole = $roleModel->where('nama_role', 'Administrator')->first();

        if (! $adminRole) {
            echo "Role Administrator tidak ditemukan! Harap jalankan RbacsSeeder terlebih dahulu.\n";
            return;
        }

        // Cek apakah admin sudah ada
        $existingAdmin = $userModel->where('username', 'admin')->first();

        if (! $existingAdmin) {
            // Karena kita menggunakan Model (UserModel), password_hash() 
            // otomatis dijalankan oleh callback beforeInsert di UserModel.
            $userModel->insert([
                'username'  => 'admin',
                'email'     => 'admin@desa.id',
                'password'  => 'admin123', // Akan di-hash otomatis
                'role_id'   => $adminRole['id'],
                'is_active' => 1,
            ]);

            echo "User admin berhasil dibuat (username: admin, password: admin123).\n";
        } else {
            echo "User admin sudah ada di database.\n";
        }
    }
}
