<?php

namespace App\DTOs;

use Illuminate\Support\Collection;

class RoleCollectionDTO
{
    public $roles;

    public function __construct(Collection $roles)
    {
        $this->roles = $roles->map(function ($role) {
            return new RoleDTO(
                $role->name,
                $role->description,
                $role->code,
                $role->created_by,
                $role->deleted_by
            );
        });
    }
}
