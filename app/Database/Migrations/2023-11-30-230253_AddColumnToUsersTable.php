<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'verified_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'after' => 'password',
                'default' => null
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'verified_at');
    }
}
