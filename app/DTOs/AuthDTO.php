<?php

namespace App\DTOs;

class AuthDTO
{
    public $username;
    public $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function toArray()
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
        ];
    }
}
