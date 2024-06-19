<?php

namespace App\DTOs;

use Illuminate\Support\Collection;

class RoleAndPermissionCollectionDTO
{
    public $roleAndPermissions;

    public function __construct(Collection $roleAndPermissions)
    {
        $this->roleAndPermissions = $roleAndPermissions->map(function ($roleAndPermission) {
            return new RoleAndPermissionDTO(
                $roleAndPermission->role_id,
                $roleAndPermission->permission_id,
                $roleAndPermission->created_by,
                $roleAndPermission->deleted_by
            );
        });
    }
}
