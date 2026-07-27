<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStrukturPemerintahanTable extends Migration
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
            'nama_jabatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'nama_pejabat' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tahun' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('struktur_pemerintahan');
    }

    public function down()
    {
        $this->forge->dropTable('struktur_pemerintahan');
    }
}
