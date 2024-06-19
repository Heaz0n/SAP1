<?php

namespace App\DTOs;

use Illuminate\Support\Collection;
use App\DTOs\UserDTO;
use App\Models\User;

class UserCollectionDTO
{
    public $users;

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
}
