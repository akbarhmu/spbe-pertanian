<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KecamatansSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => "Bantur"
            ],
            [
                'name' => 'Bululawang'
            ],
            [
                'name' => "Dampit"
            ],
            [
                'name' => 'Dau'
            ],
            [
                'name' => "Donomulyo"
            ],
            [
                'name' => 'Gondanglegi'
            ],
            [
                'name' => "Kalipare"
            ],
            [
                'name' => 'Kasembon'
            ],
            [
                'name' => "Kepanjen"
            ],
            [
                'name' => 'Kromengan'
            ],
            [
                'name' => "Lawang"
            ],
            [
                'name' => 'Ngajum'
            ],
            [
                'name' => "Ngantang"
            ],
            [
                'name' => 'Pagak'
            ],
            [
                'name' => "Pagelaran"
            ],
            [
                'name' => 'Pakis'
            ],
            [
                'name' => "Pakisaji"
            ],
            [
                'name' => 'Poncokusumo'
            ],
            [
                'name' => "Pujon"
            ],
            [
                'name' => 'Singosari'
            ],
            [
                'name' => "Sumbermanjing"
            ],
            [
                'name' => 'Sumberpucung'
            ],
            [
                'name' => "Tajinan"
            ],
            [
                'name' => 'Tumpang'
            ],
            [
                'name' => "Turen"
            ],
            [
                'name' => 'Wajak'
            ],
            [
                'name' => 'Wonosari'
            ],
            [
                'name' => "Jabung"
            ],
            [
                'name' => 'Wagir'
            ],
            [
                'name' => "Ampelgading"
            ],
            [
                'name' => 'Tirtoyudo'
            ],
            [
                'name' => "Gedangan"
            ],
            [
                'name' => "Karangploso"
            ]
        ];
        $this->db->table('kecamatans')->insertBatch($data);
    }
}
