<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StrukturPemerintahanSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $tahun = '2026'; // Anda dapat menyesuaikan tahun ini sesuai kebutuhan

        $data = [
            // --- Tabel 1: Aparatur Gampong ---
            [
                'nama_pejabat' => 'MARHADI',
                'nama_jabatan' => 'Keuchik',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'SAIFUDDIN',
                'nama_jabatan' => 'Keurani Gampong',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'MASRIZAL',
                'nama_jabatan' => 'Kaur Keuangan',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'ASRIZAL',
                'nama_jabatan' => 'Kaur Umum',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'TAUFIK',
                'nama_jabatan' => 'Kasi Pemerintahan',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'ISKANDAR',
                'nama_jabatan' => 'Kasi Pembangunan',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'DEDI MISWAR',
                'nama_jabatan' => 'Peutua Duson',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'M. KHADAFI',
                'nama_jabatan' => 'Peutua Duson',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'HAMDANI',
                'nama_jabatan' => 'Peutua Duson',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'SUDIRMAN',
                'nama_jabatan' => 'Ketua Tuha Lapan',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'DWIZA MELIANA RAHMAWATI',
                'nama_jabatan' => 'Ketua PKK',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'FAJRINUR',
                'nama_jabatan' => 'Operator',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'ISMAIL',
                'nama_jabatan' => 'Ketua Pemuda',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'ISMAIL',
                'nama_jabatan' => 'Ketua Karang Taruna',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'HARTINI',
                'nama_jabatan' => 'KPMD',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'FITRIANA',
                'nama_jabatan' => 'Ketua Kader Pos Yandu',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'RISTANIA',
                'nama_jabatan' => 'Ketua pos KB',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],

            // --- Tabel 7: Daftar Anggota Tuha Peut Gampong Blang Kubu ---
            [
                'nama_pejabat' => 'JAKFAR YUSUF',
                'nama_jabatan' => 'Peutuha Tuha Peut',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'M. YASIN ISMAIL',
                'nama_jabatan' => 'Wakil Petua Tuha Peut',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'ANWAR IBRAHIM',
                'nama_jabatan' => 'Keurani Tuha Peut',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'M. HATTA H. IBR',
                'nama_jabatan' => 'Anggota Tuha Peut',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'ABU BAKAR H. IBR',
                'nama_jabatan' => 'Anggota Tuha Peut',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'A.HAMID',
                'nama_jabatan' => 'Anggota Tuha Peut',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'NAZAR SALEH AJI',
                'nama_jabatan' => 'Anggota Tuha Peut',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'SYAHRUL BASRI',
                'nama_jabatan' => 'Anggota Tuha Peut',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_pejabat' => 'AZHARI IBRAHIM',
                'nama_jabatan' => 'Anggota Tuha Peut',
                'tahun'        => $tahun,
                'created_at'   => $now,
                'updated_at'   => $now,
            ]
        ];

        // Insert batch ke tabel struktur_pemerintahan
        $this->db->table('struktur_pemerintahan')->insertBatch($data);
    }
}