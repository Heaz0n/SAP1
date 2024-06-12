<?php

namespace App\DTOs;

class UserDTO
{
    public $id;
    public $username;
    public $email;
    public $birthday;
    public $created_at;
    public $updated_at;

    public function __construct($user)
    {
        $this->id = $user->id;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->birthday = $user->birthday;
        $this->created_at = $user->created_at;
        $this->updated_at = $user->updated_at;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'birthday' => $this->birthday,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
