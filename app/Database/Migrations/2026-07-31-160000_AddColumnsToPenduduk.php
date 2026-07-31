<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnsToPenduduk extends Migration
{
    public function up()
    {
        // Golongan darah & kewarganegaraan
        $this->forge->addColumn('penduduk', [
            'golongan_darah' => [
                'type'       => 'ENUM',
                'constraint' => ['A', 'B', 'AB', 'O', 'Tidak Tahu'],
                'null'       => true,
                'after'      => 'status_kawin',
            ],
            'kewarganegaraan' => [
                'type'       => 'ENUM',
                'constraint' => ['WNI', 'WNA'],
                'default'    => 'WNI',
                'null'       => true,
                'after'      => 'golongan_darah',
            ],
            'status_tinggal' => [
                'type'       => 'ENUM',
                'constraint' => ['Tetap', 'Kontrak', 'Kos', 'Domisili Sementara'],
                'null'       => true,
                'after'      => 'kewarganegaraan',
            ],

            // Data orang tua
            'nik_ayah' => [
                'type'       => 'VARCHAR',
                'constraint' => 16,
                'null'       => true,
                'after'      => 'status_tinggal',
            ],
            'nama_ayah' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'nik_ayah',
            ],
            'nik_ibu' => [
                'type'       => 'VARCHAR',
                'constraint' => 16,
                'null'       => true,
                'after'      => 'nama_ayah',
            ],
            'nama_ibu' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'nik_ibu',
            ],

            // Data kontak
            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
                'null'       => true,
                'after'      => 'nama_ibu',
            ],
            'email_penduduk' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'no_hp',
            ],

            // Status DTKS/Bansos
            'is_dtks' => [
                'type'    => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null'    => false,
                'after'   => 'email_penduduk',
            ],

            // Flag verifikasi admin
            'is_verified' => [
                'type'    => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'null'    => false,
                'after'   => 'is_dtks',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('penduduk', [
            'golongan_darah',
            'kewarganegaraan',
            'status_tinggal',
            'nik_ayah',
            'nama_ayah',
            'nik_ibu',
            'nama_ibu',
            'no_hp',
            'email_penduduk',
            'is_dtks',
            'is_verified',
        ]);
    }
}
