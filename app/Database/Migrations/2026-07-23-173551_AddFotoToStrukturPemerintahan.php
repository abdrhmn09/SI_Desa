<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoToStrukturPemerintahan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('struktur_pemerintahan', [
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('struktur_pemerintahan', 'foto');
    }
}
