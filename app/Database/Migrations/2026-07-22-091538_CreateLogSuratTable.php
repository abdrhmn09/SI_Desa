<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLogSuratTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'penduduk_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'jenis_surat_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'nomor_surat' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            // DITAMBAHKAN: Menyimpan data yang diisi penduduk (JSON format)
            'data_isian' => [
                'type'       => 'TEXT', 
                'null'       => true,
            ],
            // DITAMBAHKAN: Status persetujuan
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Menunggu', 'Disetujui', 'Ditolak'],
                'default'    => 'Menunggu',
            ],
            // DITAMBAHKAN: ID User (Admin/Kades) yang ACC
            'ditandatangani_oleh' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'null'       => true,
            ],
            'tanggal_cetak' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'keterangan' => [
                'type' => 'TEXT', // Bisa dipakai untuk catatan penolakan
                'null' => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('penduduk_id', 'penduduk', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('jenis_surat_id', 'jenis_surat', 'id', 'CASCADE', 'RESTRICT');
        // Opsional: addForeignKey untuk ditandatangani_oleh ke tabel users
        
        $this->forge->createTable('log_surat');
    }

    public function down()
    {
        $this->forge->dropForeignKey('log_surat', 'log_surat_penduduk_id_foreign');
        $this->forge->dropForeignKey('log_surat', 'log_surat_jenis_surat_id_foreign');
        $this->forge->dropTable('log_surat');
    }
}