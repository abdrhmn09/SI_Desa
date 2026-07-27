<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolePermissionsTable extends Migration
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
            'role_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'permission_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('role_id', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('permission_id', 'permissions', 'id', 'CASCADE', 'CASCADE');

        // Cegah kombinasi role+permission yang duplikat
        $this->forge->addUniqueKey(['role_id', 'permission_id']);

        $this->forge->createTable('role_permissions');
    }

    public function down()
    {
        $this->forge->dropForeignKey('role_permissions', 'role_permissions_role_id_foreign');
        $this->forge->dropForeignKey('role_permissions', 'role_permissions_permission_id_foreign');
        $this->forge->dropTable('role_permissions');
    }
}