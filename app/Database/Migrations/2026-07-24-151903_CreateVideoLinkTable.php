<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVideoLinkTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'judul'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'deskripsi'   => ['type' => 'TEXT', 'null' => true],
            'url_video'   => ['type' => 'VARCHAR', 'constraint' => 500],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('video_link');
    }

    public function down()
    {
        $this->forge->dropTable('video_link');
    }
}
