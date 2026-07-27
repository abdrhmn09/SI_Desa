<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateArtikelTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'judul'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'isi'          => ['type' => 'LONGTEXT'],
            'gambar'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'kategori'     => [
                'type'       => 'ENUM',
                'constraint' => ['Berita', 'Pengumuman', 'Agenda'],
                'default'    => 'Berita',
            ],
            'status'       => [
                'type'       => 'ENUM',
                'constraint' => ['draft', 'published'],
                'default'    => 'draft',
            ],
            'penulis'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('artikel');
    }

    public function down()
    {
        $this->forge->dropTable('artikel');
    }
}
