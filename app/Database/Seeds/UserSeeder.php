<?php

namespace App\Database\Seeds;

class UserSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'role_id' => 1,
                'email' => 'admin@admin.com',
                'password' => password_hash('123456', PASSWORD_BCRYPT),
                'contact_number' => '+447454263626',
                'created_at' => time(),
                'updated_at' => time()
            ],
            [
                'first_name' => 'Asim',
                'last_name' => 'Bhatti',
                'role_id' => 2,
                'email' => 'asim@tutor.com',
                'password' => password_hash('123456', PASSWORD_BCRYPT),
                'contact_number' => '+447454263626',
                'created_at' => time(),
                'updated_at' => time()
            ],
            [
                'first_name' => 'Mehdi',
                'last_name' => 'Hassan',
                'role_id' => 2,
                'email' => 'mehdi@tutor.com',
                'password' => password_hash('123456', PASSWORD_BCRYPT),
                'contact_number' => '+447454263626',
                'created_at' => time(),
                'updated_at' => time()
            ]
         ];

         $this->db->table('users')->insertBatch($data);
    }
}