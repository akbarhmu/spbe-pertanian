<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJustifikasiColumnToReportsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('reports', [
            'justifikasi' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'luas'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('reports', 'justifikasi');
    }
}
