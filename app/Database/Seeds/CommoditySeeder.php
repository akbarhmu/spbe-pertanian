<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CommoditySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                "name" => "Padi",
                "type" => "Sawah",
                "mandatory" => true
            ],
            [
                "name" => "Padi",
                "type" => "Tegal",
                "mandatory" => true
            ],
            [
                "name" => "Jagung",
                "type" => "Sawah",
                "mandatory" => true
            ],
            [
                "name" => "Jagung",
                "type" => "Tegal",
                "mandatory" => true
            ],
            [
                "name" => "Kedelai",
                "type" => "Sawah",
                "mandatory" => true
            ],
            [
                "name" => "Kedelai",
                "type" => "Tegal",
                "mandatory" => true
            ],
        ];

        $this->db->table('commodities')->insertBatch($data);
    }
}
