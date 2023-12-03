<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReportsView extends Migration
{
    public function up()
    {

        $this->db->query('
            create view reports_view as select  t3.nm_kec, t4.nm_desa, t1.luas, t1.bulan, t1.minggu, t2.name as nama_komoditas, t2.type,t1.created_at,t1.updated_at
            from reports t1
            cross join commodities t2 on t1.id_commodity = t2.id 
            right join mst_desa t4 on t1.id_desa = t4.id_desa
            join mst_kec t3 on t4.id_kec = t3.id_kec
            where (t1.created_at, t1.bulan, t1.id_desa) in ( select max(created_at) as created_at, bulan, id_desa  from reports group by YEAR(created_at),bulan, minggu, id_desa)
        ');
    }

    public function down()
    {
        $this->db->query('DROP VIEW IF EXISTS reports_view');
    }
}
