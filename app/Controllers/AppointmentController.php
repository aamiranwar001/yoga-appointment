<?php

namespace App\Controllers;

class AppointmentController extends BaseController
{
    public function index()
    {
        return view('customer/index');
    }

    public function CheckTutorAvailability($date, $tutorId)
    {
    }

    public function create()
    {
        return view('customer/newAppointment');
    }

    public function createAppointment()
    {
        $appointmentModel = new AppointmentModel();
        $rules = $appointmentModel->getRegistrationRules();
        $appointmentModel->setValidationRules($rules);

        if (! $appointmentModel->save($this->request->getPost()))
        {
            return redirect()->back()->withInput()->with('errors', $appointmentModel->errors());
        }

        return redirect()->to('newAppointment')->with('success', 'Successfully registered. Please login to continue :)');
    }
}