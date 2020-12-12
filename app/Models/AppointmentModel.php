<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table = 'appointments';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $dateFormat = 'int';

    protected $allowedFields = ['id', 'tutor_id', 'student_id', 'title', 'description', 'date', 'time_slot', 'status'];

    public function getAppointmentRules()
    {
        return [
            'tutor_id' => 'required',
            'student_id' => '',
            'title' => 'required|alpha_space|min_length[2]',
            'description' => '',
            'date' => 'required',
            'time_slot' => 'required',
        ];
    }
}