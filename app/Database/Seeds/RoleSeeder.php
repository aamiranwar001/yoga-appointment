<?php

namespace App\Database\Seeds;

class RoleSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'admin'],
            ['name' => 'tutor'],
            ['name' => 'customer']
        ];

        $this->db->table('roles')->insertBatch($data);
    }
}