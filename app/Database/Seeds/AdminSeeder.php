<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id_kec' => '3507160',
            'name' => 'Admin',
            'role' => 'admin',
            'email' => 'admin@gmail.com',
            'phone_number' => '081234567890',
            'password' => password_hash('admin', PASSWORD_DEFAULT),
            'verified_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('users')->insert($data);
    }
}
