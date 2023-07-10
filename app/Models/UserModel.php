<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users'; 
    protected $primaryKey = 'id'; 
    protected $allowedFields = ['firstname', 'lastname', 'username', 'email', 'password'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'firstname' => 'required',
        'lastname' => 'required',
        'username' => 'required|is_unique[users.username]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'The email address has already been registered.'
        ],

        'username' => [
            'is_unique' => 'The username has already been registered.'
        ]
    ];

    protected $skipValidation = false;
}
