<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ImportKecamatan extends Migration
{
    public function up()
    {
        $query = 'DROP TABLE IF EXISTS mst_kec';
        $this->db->query($query);

        $sqlKecFile = APPPATH . 'Database/Migrations/kec.sql';

        $kecSql = file_get_contents($sqlKecFile);


        $this->db->query($kecSql);
    }

    public function down()
    {
        $this->forge->dropTable('mst_kec');
    }
}
