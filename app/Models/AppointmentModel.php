<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table = 'appointments';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    // this happens first, model removes all other fields from input data
    protected $allowedFields = [
        'tutor_id', 'student_id', 'title', 'description', 'date',
        'time_slot', 'status'
    ];

    /**
     * Hashes the password after field validation and before insert/update
     * @param array $data
     * @return array
     */
   

    public function getAppointmentRules()
    {
        return [
            'title'=>'required|alpha_space|min_length[2]',
            'tutor_id' => 'required',
            'date' => 'required',
            'time_slot'	=> 'required',
            'status' => 'required'
        ];
    }
}