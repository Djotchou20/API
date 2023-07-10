<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Signup extends Controller
{
    public function index()
    {
        helper(['form', 'url']);
        return view('signup_form');
    }

    public function processSignup()
    {
        
        $userModel = new UserModel();

        $firstname = $this->request->getPost('firstname');
        $lastname = $this->request->getPost('lastname');
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $c_password = $this->request->getPost('c_password');

        $validationRules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => 'required|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required',
        ];

        $validationMessages = [
            'email' => [
                'is_unique' => 'The email address has already been registered.'
            ],

            'username' => [
                'is_unique' => 'The username has already been registered.'
            ]
        ];

        $skipValidation = false;

        if ($password !== $c_password) {
            return redirect()->back()->with('error', 'Passwords do not match');
        }

        // Create an array with the user data
        $userData = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'c_password' => password_hash($c_password, PASSWORD_DEFAULT),
        ];

        // Insert the user data into the database
        $userModel->insert($userData);
        
        return redirect()->to('success', $userData);
    }
}
