<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJenisSuratTable extends Migration
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
            'kode_surat' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'nama_surat' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'template_surat' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'form_fields' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('kode_surat');
        $this->forge->createTable('jenis_surat');
    }

    public function down()
    {
        $this->forge->dropTable('jenis_surat');
    }
}