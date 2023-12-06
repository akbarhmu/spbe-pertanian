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
                "image" => "/assets/images/commodities/padi.jpg",
                "type" => "Sawah",
                "mandatory" => true
            ],
            [
                "name" => "Padi",
                "image" => "/assets/images/commodities/padi.jpg",
                "type" => "Tegal",
                "mandatory" => true
            ],
            [
                "name" => "Jagung",
                "image" => "/assets/images/commodities/jagung.jpg",
                "type" => "Sawah",
                "mandatory" => true
            ],
            [
                "name" => "Jagung",
                "image" => "/assets/images/commodities/jagung.jpg",
                "type" => "Tegal",
                "mandatory" => true
            ],
            [
                "name" => "Kedelai",
                "image" => "/assets/images/commodities/kedelai.jpg",
                "type" => "Sawah",
                "mandatory" => true
            ],
            [
                "name" => "Kedelai",
                "image" => "/assets/images/commodities/kedelai.jpg",
                "type" => "Tegal",
                "mandatory" => true
            ],
        ];

        $this->db->table('commodities')->insertBatch($data);
    }
}
