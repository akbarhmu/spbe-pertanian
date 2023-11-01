<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ImportDesa extends Migration
{
    public function up()
    {
        $query = 'DROP TABLE IF EXISTS mst_desa';
        $this->db->query($query);
        $sqlDesaFile = APPPATH . 'Database/Migrations/desa.sql';

        $desaSql = file_get_contents($sqlDesaFile);


        $this->db->query($desaSql);
        $query = 'ALTER TABLE mst_desa
          ADD CONSTRAINT fk_desa_kec
          FOREIGN KEY (id_kec) REFERENCES mst_kec(id_kec)
          ON DELETE CASCADE ON UPDATE CASCADE';
        $this->db->query($query);
    }

    public function down()
    {
        $this->forge->dropTable('mst_desa');
    }
}
