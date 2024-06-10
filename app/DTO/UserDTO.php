<?php

namespace App\DTO;

class UserDTO
{
    public int $id;
    public string $username;
    public string $email;
    public string $birthday;
    public string $created_at;
    public string $updated_at;

    public function __construct(int $id, string $username, string $email, string $birthday, string $created_at, string $updated_at)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->birthday = $birthday;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
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