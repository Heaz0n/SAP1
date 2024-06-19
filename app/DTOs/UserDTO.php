<?php

namespace App\DTOs;

class UserDTO
{
    public $id;
    public $username;
    public $email;
    public $birthday;
    public $createdAt;
    public $updatedAt;
    public $roles;
    public $permissions;

    public function __construct($user, $roles = [], $permissions = [])
    {
        $this->id = $user->id;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->birthday = $user->birthday;
        $this->createdAt = $user->created_at;
        $this->updatedAt = $user->updated_at;
        $this->roles = $roles;
        $this->permissions = $permissions;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'birthday' => $this->birthday,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'roles' => $this->roles,
            'permissions' => $this->permissions,
        ];
    }
}
