<?php

namespace App\DTOs;

use Illuminate\Support\Collection;
use App\DTOs\PermissionDTO;
use App\Models\Permission;

class PermissionCollectionsDTO
{
    public $permissions;
    public function __construct($permissions)
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
}