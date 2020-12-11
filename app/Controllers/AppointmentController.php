<?php

namespace App\Controllers;

class AppointmentController extends BaseController
{
    public function index()
    {
        return view('customer/index');
    }

    public function create()
    {
        return view('customer/newAppointment');
    }
}