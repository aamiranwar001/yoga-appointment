<?php

namespace App\Database\Seeds;

class AppSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $this->call('RoleSeeder');
        $this->call('UserSeeder');
    }
}