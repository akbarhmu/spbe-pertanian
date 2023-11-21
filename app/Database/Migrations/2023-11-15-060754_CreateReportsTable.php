<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\I18n\Time;

class CreateReportsTable extends Migration
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
            'id_user' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => false,
            ],
            'id_kec' => [
                'type' => 'INT',
                'constraint' => 15,
                'unsigned' => true,
                'null' => false,
            ],
            'id_desa' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'null' => false,
            ],
            'id_commodity' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
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
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kec', 'mst_kec', 'id_kec', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_desa', 'mst_desa', 'id_desa', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_commodity', 'commodities', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('reports');
    }

    public function down()
    {
        $this->forge->dropTable('reports');
    }
}
