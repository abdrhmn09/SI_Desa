<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SejarahKepemimpinanSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            [
                'nama'         => 'Panglima Meurdu Areh',
                'masa_jabatan' => '1807 - 1863', //[cite: 2]
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama'         => 'Nyak Muda Itam',
                'masa_jabatan' => '1863 - 1887', //[cite: 2]
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama'         => 'Panglima Merdu Idi',
                'masa_jabatan' => '1887 - 1926', //[cite: 2]
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama'         => 'Panglima Aseh',
                'masa_jabatan' => '1927 - 1935', //[cite: 2]
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama'         => 'Keuchik Hamzah Nyak Muda',
                'masa_jabatan' => '1936 - 1948', //[cite: 2]
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama'         => 'Panglima Aseh',
                'masa_jabatan' => '1948 - 1953', //[cite: 2]
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama'         => 'Keuchiek Usman Hamzah',
                'masa_jabatan' => '1945 - 1972', //[cite: 2]
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama'         => 'Keuchiek Amanaf sarong',
                'masa_jabatan' => '1972 - 1994', //[cite: 2]
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama'         => 'Keuchiek Nurdin Hamzah',
                'masa_jabatan' => '1995 - 2002', //[cite: 2]
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama'         => 'M. Hatta H. Ibr',
                'masa_jabatan' => '2003 - 2005', //[cite: 2]
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama'         => 'M. Nasir H. Idris',
                'masa_jabatan' => '2006 - 2011', //[cite: 2]
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama'         => 'Khairuddin. Ab',
                'masa_jabatan' => '2011 - 2017', //[cite: 2]
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama'         => 'Syahrul Gunawan',
                'masa_jabatan' => '2017 - 2023', //[cite: 2]
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama'         => 'Marhadi',
                'masa_jabatan' => '2023 - Sekarang', //[cite: 2]
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ];

        // Kosongkan tabel sebelum diisi (Opsional)
        // $this->db->table('sejarah_kepemimpinan')->truncate();

        // Insert Batch
        $this->db->table('sejarah_kepemimpinan')->insertBatch($data);
    }
}