<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePendudukTable extends Migration
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
            'nik' => [
                'type'       => 'VARCHAR',
                'constraint' => 16,
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'kartu_keluarga_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'null'       => true,
            ],
            'hubungan_keluarga' => [
                'type'       => 'ENUM',
                'constraint' => ['Kepala Keluarga', 'Istri', 'Anak', 'Famili Lain', 'Lainnya'],
                'null'       => true,
            ],
            'tempat_lahir' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'jenis_kelamin' => [
                'type'       => 'ENUM',
                'constraint' => ['Laki-laki', 'Perempuan'],
                'null'       => true,
            ],
            'agama' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
            'pendidikan' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'pekerjaan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'status_kawin' => [
                'type'       => 'ENUM',
                'constraint' => ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'],
                'null'       => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('nik');
        $this->forge->addForeignKey('kartu_keluarga_id', 'kartu_keluarga', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('penduduk');
    }

    public function down()
    {
        $this->forge->dropForeignKey('penduduk', 'penduduk_kartu_keluarga_id_foreign');
        $this->forge->dropTable('penduduk');
    }
}