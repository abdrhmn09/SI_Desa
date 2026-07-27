<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOtpToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'otp_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 6,
                'null'       => true,
                'after'      => 'is_active',
            ],
            'otp_expires_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'otp_code',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['otp_code', 'otp_expires_at']);
    }
}
