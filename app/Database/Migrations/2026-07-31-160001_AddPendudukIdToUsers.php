<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPendudukIdToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'penduduk_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
                'after'      => 'wilayah_id',
            ],
        ]);

        // Tambahkan foreign key (soft — karena penduduk bisa null untuk admin)
        $this->db->query('ALTER TABLE users ADD CONSTRAINT fk_users_penduduk
            FOREIGN KEY (penduduk_id) REFERENCES penduduk(id) ON DELETE SET NULL ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE users DROP FOREIGN KEY fk_users_penduduk');
        $this->forge->dropColumn('users', 'penduduk_id');
    }
}
