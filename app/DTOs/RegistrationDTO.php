<?php

namespace App\DTOs;

use App\Models\User;

class RegistrationDTO
{
    public $username;
    public $email;
    public $password;
    public $birthday;

    public function __construct(User $user)
    {
        $this->username = $user->name;
        $this->email = $user->email;
        $this->password = $user->password;
        $this->birthday = $user->birthday;
    }

    public function toArray()
    {
        return [
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
            'birthday' => $this->birthday,
        ];
    }
}
