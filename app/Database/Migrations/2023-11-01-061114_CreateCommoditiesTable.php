<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\I18n\Time;

class CreateCommoditiesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['Sawah', 'Tegal'],
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new Time('now', 'Asia/Jakarta', 'id_ID'),
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => new Time('now', 'Asia/Jakarta', 'id_ID'),
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('commodities');
    }

    public function down()
    {
        $this->forge->dropTable('commodities');
    }
}
