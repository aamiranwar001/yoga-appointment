<?php

namespace App\Database\Seeds;

class UserSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data = [
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'role_id' => 1,
            'email' => 'admin@admin.com',
            'password' => '123456',
            'contact_number' => password_hash('123456', PASSWORD_BCRYPT),
            'created_at' => time(),
            'updated_at' => time()
         ];

         $this->db->table('users')->insert($data);
    }
}