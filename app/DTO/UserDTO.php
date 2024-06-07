<?php
namespace App\DTO;

class UserDTO {

    public $id;
    public $username;
    public $email;
    public $dateOfBirth;
    public $createdAt;

    public function __construct($id, $username, $email, $dateOfBirth, $createdAt) 
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->dateOfBirth = $dateOfBirth;
        $this->createdAt = $createdAt;
    }
}