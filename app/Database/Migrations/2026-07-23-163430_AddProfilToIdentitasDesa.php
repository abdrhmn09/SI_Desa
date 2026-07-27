<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProfilToIdentitasDesa extends Migration
{
    public function up()
    {
        $fields = [
            'sejarah'    => ['type' => 'TEXT', 'null' => true],
            'visi_misi'  => ['type' => 'TEXT', 'null' => true],
            'geografis'  => ['type' => 'TEXT', 'null' => true],
            'demografi'  => ['type' => 'TEXT', 'null' => true],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'telepon'    => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'facebook'   => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'instagram'  => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'youtube'    => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'twitter'    => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'embed_peta' => ['type' => 'TEXT', 'null' => true],
        ];
        
        $this->forge->addColumn('identitas_desa', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('identitas_desa', [
            'sejarah', 'visi_misi', 'geografis', 'demografi',
            'email', 'telepon', 'facebook', 'instagram', 'youtube', 'twitter', 'embed_peta'
        ]);
    }
}
