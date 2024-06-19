<?php

namespace App\DTOs;

use Illuminate\Support\Collection;

class PermissionCollectionDTO
{
    protected $permissions;

    public function __construct(Collection $permissions)
    {
        $this->permissions = $permissions->map(function ($permission) {
            return new PermissionDTO(
                $permission->name,
                $permission->description,
                $permission->code,
                $permission->created_by,
                $permission->deleted_by
            );
        });
    }

    public function getPermissions()
    {
        return $this->permissions;
    }
}