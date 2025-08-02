<?php

namespace App\Actions\Auth;

use App\Models\User;

class RegisterUser
{
    public function execute(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
