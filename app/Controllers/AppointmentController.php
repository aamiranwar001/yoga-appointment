<?php

namespace App\Controllers;

use App\Models\AppointmentModel;
use App\Models\RoleModel;
use App\Models\UserModel;

class AppointmentController extends BaseController
{
    public function index()
    {
        return view('customer/index');
    }

    public function create()
    {
        // Create role model object
        $roleModel = new RoleModel();

        // get tutor role from roles table
        $role = $roleModel->where('name', 'tutor')->first();

        // Create user model object
        $userModel = new UserModel();

        // get all tutors from users table with role id
        $tutors = $userModel->where('role_id', $role['id'])->get();

        // return view with all tutors
        return view('customer/newAppointment', ['tutors' => $tutors->getResult()]);
    }

    public function store()
    {
        $appointmentModel = new AppointmentModel();
        $rules = $appointmentModel->getRules();
        $appointmentModel->setValidationRules($rules);

        $tutorId = $this->request->getPost('tutor_id');
        $date = $this->request->getPost('date');
        $timeSlot = $this->request->getPost('time_slot');

        try {
            $data = [
                'title' => $this->request->getPost('title'),
                'tutor_id' => $tutorId,
                'student_id' => session('userData')['id'],
                'description' => $this->request->getPost('description'),
                'date' => strtotime($date),
                'time_slot' => $timeSlot,
                'status' => 'pending'
            ];

            if (! $this->isTutorAvailable($tutorId, $date, $timeSlot)) {
                return redirect()->back()->with('error_message', 'The tutor is not available for the selected time slot.');
            }

            if (!$appointmentModel->save($data)) {
                return redirect()->back()->withInput()->with('errors', $appointmentModel->errors());
            }

            return redirect()->route('newAppointment')->with('success', 'Appointment has been created successfully. :)');

        } catch (\ReflectionException $e) {
            return redirect()->back()->withInput()->with('errors', $e->getMessage());
        }
    }

    private function isTutorAvailable($tutorId, $date, $timeSlot)
    {
        $appointmentModel = new AppointmentModel();
        $appointment = $appointmentModel
            ->where('tutor_id', $tutorId)
            ->where('date', strtotime($date))
            ->where('time_slot', $timeSlot)
            ->first();

        return $appointment == null ? true : false;
    }
}