<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PermissionController extends Controller
{
    public function getAllPermissions()
    {
        $permissions = Permission::all();
        return response()->json($permissions);
    }

    public function getPermission($id)
    {
        $permission = Permission::find($id);
        if ($permission) {
            return response()->json($permission);
        }
        return response()->json(['message' => 'Permission not found'], 404);
    }

    public function createPermission(CreatePermissionRequest $request)
    {
        $permissionDTO = $request->createDTO();
        $permission = Permission::create([
            'name' => $permissionDTO->name,
            'description' => $permissionDTO->description,
            'code' => $permissionDTO->code,
            'created_by' => Auth::id()
        ]);
        return response()->json($permission, 201);
    }

    public function updatePermission(UpdatePermissionRequest $request, $id)
    {
        $permission = Permission::find($id);
        if ($permission) {
            $permissionDTO = $request->createDTO();
            $permission->update([
                'name' => $permissionDTO->name,
                'description' => $permissionDTO->description,
                'code' => $permissionDTO->code,
                'updated_by' => Auth::id()
            ]);
            return response()->json($permission);
        }
        return response()->json(['message' => 'Permission not found'], 404);
    }

    public function deletePermission($id)
    {
        $permission = Permission::find($id);
        if ($permission) {
            $permission->delete();
            return response()->json(['message' => 'Permission deleted successfully']);
        }
        return response()->json(['message' => 'Permission not found'], 404);
    }

    public function softDeletePermission($id)
    {
        $permission = Permission::find($id);
        if ($permission) {
            $permission->delete();
            return response()->json(['message' => 'Permission soft deleted successfully']);
        }
        return response()->json(['message' => 'Permission not found'], 404);
    }

    public function restorePermission($id)
    {
        $permission = Permission::withTrashed()->find($id);
        if ($permission) {
            $permission->restore();
            return response()->json(['message' => 'Permission restored successfully']);
        }
        return response()->json(['message' => 'Permission not found'], 404);
    }
}
