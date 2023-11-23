<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMandatoryColumnToCommoditiesTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('commodities', [
            'mandatory' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'after' => 'name'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('commodities', 'mandatory');
    }
}
