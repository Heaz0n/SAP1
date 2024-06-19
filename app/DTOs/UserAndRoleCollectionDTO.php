<?php

namespace App\DTOs;

use Illuminate\Support\Collection;

class UserAndRoleCollectionDTO
{
    public $userAndRoles;

    public function __construct(Collection $userAndRoles)
    {
        $this->userAndRoles = $userAndRoles->map(function ($userAndRole) {
            return new UserAndRoleDTO(
                $userAndRole->role_id,
                $userAndRole->user_id,
                $userAndRole->created_by,
                $userAndRole->deleted_by
            );
        });
    }
}
