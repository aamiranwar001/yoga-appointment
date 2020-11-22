<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    // this runs after field validation
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    // this happens first, model removes all other fields from input data
    protected $allowedFields = [
        'first_name', 'last_name', 'role_id', 'email', 'password',
        'password_confirm', 'contact_number', 'address', 'active'
    ];

    /**
     * Hashes the password after field validation and before insert/update
     * @param array $data
     * @return array
     */
    protected function hashPassword(array $data)
    {
        if (! isset($data['data']['password'])) return $data;

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        unset($data['data']['password_confirm']);

        return $data;
    }

    public function getLoginRules()
    {
        return [
            'email'		=> 'required|valid_email',
            'password' 	=> 'required'
        ];
    }

    public function getRegistrationRules()
    {
        return [
            'first_name' => 'required|alpha_space|min_length[2]',
            'last_name' => 'required|alpha_space|min_length[2]',
            'email'	=> 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[5]',
            'password_confirm' => 'matches[password]',
            'contact_number' => 'required'
        ];
    }
}