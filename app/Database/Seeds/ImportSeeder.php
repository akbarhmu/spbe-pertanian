<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ImportSeeder extends Seeder
{
    public function run()
    {


        $sqlKecFile = APPPATH . 'Database/Seeds/mst_kec.sql';

        $kecSql = file_get_contents($sqlKecFile);


        $this->db->query($kecSql);

        $sqlDesaFile = APPPATH . 'Database/Seeds/mst_desa.sql';

        $desaSql = file_get_contents($sqlDesaFile);


        $this->db->query($desaSql);
    }
}
