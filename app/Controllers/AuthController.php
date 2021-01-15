<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        if ($this->session->isLoggedIn) {
            return redirect()->route('home');
        }

        return view('auth/login');
    }

    public function register()
    {
        if ($this->session->isLoggedIn) {
            return redirect()->route('home');
        }

        return view('auth/register');
    }

    public function attemptLogin()
    {
        $userModel = new UserModel();
        $rules = $userModel->getLoginRules();

        if (! $this->validate($rules))
        {
            return redirect()->to('login')
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userModel->select('users.id, users.first_name, users.last_name, users.role_id, users.email, users.password, users.contact_number, users.address, users.active, users.deleted_at, r.id AS role_pk, r.name AS role_name');
        $userModel->join('roles AS r', 'r.id = users.role_id', 'inner');
        $userModel->where('email', $this->request->getPost('email'));
        $user = $userModel->first();

        if (is_null($user) || ! password_verify($this->request->getPost('password'), $user['password']))
        {
            return redirect()->route('login')->withInput()->with('errors', 'Username or password is incorrect.');
        }

        $this->session->set('isLoggedIn', true);
        $this->session->set('userData', [
            'id' => $user['id'],
            'name' => $user['first_name'] . ' ' . $user['last_name'],
            'email' => $user['email'],
            'role' => $user['role_name']
        ]);

        if ($this->session->has('redirect'))
        {
            $redirect = $this->session->get('redirect');
            $this->session->remove('redirect');
            return redirect()->to((string)$redirect);
        }
        else
        {
            return redirect()->route('home');
        }
    }

    public function attemptRegister()
    {
        $userModel = new UserModel();
        $rules = $userModel->getRegistrationRules();
        $userModel->setValidationRules($rules);

        if (! $userModel->save($this->request->getPost()))
        {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }

        return redirect()->to('login')->with('success', 'Successfully registered. Please login to continue :)');
    }

    public function logout()
    {
        $this->session->remove(['isLoggedIn', 'userData']);

        return redirect()->route('home');
    }
}