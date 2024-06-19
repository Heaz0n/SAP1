<?php

namespace App\DTOs;

use Illuminate\Support\Collection;

class UserCollectionDTO
{
    protected $users;

    public function __construct(Collection $users)
    {
        $this->users = $users->map(function ($user) {
            return new UserDTO(
                $user,
                $user->roles()->get(),
                $user->permissions()
            );
        });
    }

    public function getUsers()
    {
        return $this->users;
    }
}