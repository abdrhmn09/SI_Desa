<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSejarahKepemimpinanTable extends Migration
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
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'masa_jabatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->createTable('sejarah_kepemimpinan');
    }

    public function down()
    {
        $this->forge->dropTable('sejarah_kepemimpinan');
    }
}