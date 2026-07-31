<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKartuKeluargaTable extends Migration
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
            'no_kk' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'kepala_keluarga_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'null'       => true, // FK belum di-set, hindari circular dependency
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'dusun' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'rt' => [
                'type'       => 'VARCHAR',
                'constraint' => 3,
                'null'       => true,
            ],
            'rw' => [
                'type'       => 'VARCHAR',
                'constraint' => 3,
                'null'       => true,
            ],
            'tanggal_dikeluarkan' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('no_kk');
        $this->forge->createTable('kartu_keluarga');
    }

    public function down()
    {
        $this->forge->dropTable('kartu_keluarga');
    }
}