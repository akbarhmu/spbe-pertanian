<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ImportDesa extends Migration
{
    public function up()
    {
        $sqlDesaFile = APPPATH . 'Database/Migrations/desa.sql';

        $desaSql = file_get_contents($sqlDesaFile);


        $this->db->query($desaSql);
    }

    public function down()
    {
        $this->forge->dropTable('mst_desa');
    }
}
