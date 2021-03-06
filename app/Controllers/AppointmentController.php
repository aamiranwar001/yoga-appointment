<?php

namespace App\Controllers;

use App\Models\AppointmentModel;
use App\Models\RoleModel;
use App\Models\UserModel;

class AppointmentController extends BaseController
{

    //  if user already logged in - redirect to calndar page
    public function index()
    {
        if ($this->session->isLoggedIn) {
            return view('customer/index');
        }

        return redirect()->route('login');
    }

    //  if user already logged in - show page to create new appointment
    public function create()
    {
        if (!$this->session->isLoggedIn) {
            return redirect()->route('login');
        }

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


    // getting list of all saved appointments against user_id and User_role (Admin will get all appointments)
    public function getAppointments()
    {
        $startDate = strtotime($this->request->getGet('start_date'));
        $endDate = strtotime($this->request->getGet('end_date'));
        $operatorID = (int)$this->request->getGet('operator_id');
        $operatorKey = $this->request->getGet('operator_key');

        $appointmentModel = new AppointmentModel();

        if($operatorKey == 'admin'){
            $result = $appointmentModel
            ->where('date >=', $startDate)
            ->where('date <=', $endDate)
            ->get()
            ->getResult();
        }
        else{
            $result = $appointmentModel
                ->where('date >=', $startDate)
                ->where('date <=', $endDate)
                ->where($operatorKey, $operatorID)
                ->get()
                ->getResult();
        }
                
        return json_encode($result);
    }

    // book new aapointment and store it into database.
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
                //echo 'The tutor is not available for the selected time slot.'; die();
                return redirect()->back()->with('error_message', 'The tutor is not available for the selected time slot.');
            }

            if (!$appointmentModel->save($data)) {
                //echo 'Error! '. json_encode($appointmentModel->errors()); die();
                return redirect()->back()->withInput()->with('errors', $appointmentModel->errors());
            }

            //echo 'Appointment has been created successfully. '; die();
            return redirect()->back()->with('success', 'Appointment has been created successfully. :)');

        } catch (\ReflectionException $e) {
            //echo $e->getMessage();
            return redirect()->back()->withInput()->with('errors', $e->getMessage());
        }
    }

    // approve or reject an appointment
    public function updateStatus() {
        $appointmentId = $this->request->getPost('appointment_id');
        $status = $this->request->getPost('status');

        $appointmentModel = new AppointmentModel();
        $result = $appointmentModel->update($appointmentId, ['status' => $status]);
        if ($result) {
            return $this->response->setStatusCode(200)->setJSON(['id'=> $appointmentId, 'status' => $status, 'message' => 'Status updated successfully.']);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Internal server error, please try later.']);
        }
    }

    // check if Tutor is available in given time-slot
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