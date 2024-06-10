<?php
namespace App\DTO;

class RegisterDTO {

    public string $username;
    public string $email;
    public string $password;
    public string $birthday;

    public function __construct($username, $password, $email, $birthday) 
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->birthday = $birthday;
    }
}