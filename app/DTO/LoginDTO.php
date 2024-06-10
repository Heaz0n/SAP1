<?php
namespace App\DTO;

class LoginDTO {
    public string $username;
    public string $password;

    public function __construct($username, $password) 
    {   
        $this->username = $username;
        $this->password = $password;
    }
}