<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function getAllRoles()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    public function getRole($id)
    {
        $role = Role::find($id);
        if ($role) {
            return response()->json($role);
        }
        return response()->json(['message' => 'Role not found'], 404);
    }

    public function createRole(CreateRoleRequest $request)
    {
        $roleDTO = $request->createDTO();
        $role = Role::create([
            'name' => $roleDTO->name,
            'description' => $roleDTO->description,
            'code' => $roleDTO->code,
            'created_by' => Auth::id()
        ]);
        return response()->json($role, 201);
    }

    public function updateRole(UpdateRoleRequest $request, $id)
    {
        $role = Role::find($id);
        if ($role) {
            $roleDTO = $request->createDTO();
            $role->update([
                'name' => $roleDTO->name,
                'description' => $roleDTO->description,
                'code' => $roleDTO->code,
                'updated_by' => Auth::id()
            ]);
            return response()->json($role);
        }
        return response()->json(['message' => 'Role not found'], 404);
    }

    public function deleteRole($id)
    {
        $role = Role::find($id);
        if ($role) {
            $role->delete();
            return response()->json(['message' => 'Role deleted successfully']);
        }
        return response()->json(['message' => 'Role not found'], 404);
    }

    public function softDeleteRole($id)
    {
        $role = Role::find($id);
        if ($role) {
            $role->delete();
            return response()->json(['message' => 'Role soft deleted successfully']);
        }
        return response()->json(['message' => 'Role not found'], 404);
    }

    public function restoreRole($id)
    {
        $role = Role::withTrashed()->find($id);
        if ($role) {
            $role->restore();
            return response()->json(['message' => 'Role restored successfully']);
        }
        return response()->json(['message' => 'Role not found'], 404);
    }
}
