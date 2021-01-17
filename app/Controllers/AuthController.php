<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    // go to login page, if already not logged in (for customer)
    public function login()
    {
        if ($this->session->isLoggedIn) {
            return redirect()->route('home');
        }

        return view('auth/login');
    }


    // go to signup page (for customer)
    public function register()
    {
        if ($this->session->isLoggedIn) {
            return redirect()->route('home');
        }

        return view('auth/register');
    }

    // go to SignUp page for admin (Admin can create both customer and tutor accounts)
    public function registration()
    {
        if ($this->session->isLoggedIn) {
            return view('tutor/register');
        }

        return redirect()->to('login');
    }

    // when user try to get logged-in
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


    // when user try to create new account (for customer)
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

    // when user try to create new account (for admin)
    public function attemptRegisterUser()
    {
        $userModel = new UserModel();
        $rules = $userModel->getRegistrationRules();
        $userModel->setValidationRules($rules);

        if (! $userModel->save($this->request->getPost()))
        {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }

        return redirect()->back()->with('success', 'Successfully registered. Please login to continue :)');
    }


    // when user try to Logout
    public function logout()
    {
        $this->session->remove(['isLoggedIn', 'userData']);

        return redirect()->route('home');
    }
}