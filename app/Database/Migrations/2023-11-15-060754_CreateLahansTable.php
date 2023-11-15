<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\I18n\Time;

class CreateLahansTable extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => false,
            ],
            'desa_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => false,
            ],
            'bulan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'minggu' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => false,
            ],
            'tipe_komoditas' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'luas' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => false,
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
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('desa_id', 'mst_desa', 'id_desa', 'CASCADE', 'CASCADE');
        $this->forge->createTable('lahans');
    }

    public function down()
    {
        $this->forge->dropTable('lahans');
    }
}
