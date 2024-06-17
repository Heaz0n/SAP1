<?php

namespace App\DTOs;

class RegistrationDTO
{
    public $username;
    public $email;
    public $password;
    public $birthday;

    public function __construct($username, $email, $password, $birthday)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->birthday = $birthday;
    }

    public function toArray()
    {
        return [
            'username' => $this->username,
            'email' => $this->email,
            'birthday' => $this->birthday,
        ];
    }
}
