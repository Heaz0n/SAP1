<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Models\RolesAndPermissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleAndPermissionController extends Controller
{
    public function createRoleAndPermission(Request $request)
    {
        $roleId = $request->input('role_id');
        $permissionId = $request->input('permission_id');

        $role = Role::find($roleId);
        $permission = Permission::find($permissionId);

        if ($role && $permission) {
            RolesAndPermissions::create([
                'role_id' => $roleId,
                'permission_id' => $permissionId,
                'created_by' => Auth::id()
            ]);
            return response()->json(['message' => 'Role and permission linked successfully']);
        }
        return response()->json(['message' => 'Role or Permission not found'], 404);
    }

    public function getAllRolesAndPermissions()
    {
        $rolesAndPermissions = RolesAndPermissions::all();
        return response()->json($rolesAndPermissions);
    }

    public function getRoleAndPermission($id)
    {
        $roleAndPermission = RolesAndPermissions::find($id);
        if ($roleAndPermission) {
            return response()->json($roleAndPermission);
        }
        return response()->json(['message' => 'Role and Permission link not found'], 404);
    }

    public function updateRoleAndPermission(Request $request, $id)
    {
        $roleAndPermission = RolesAndPermissions::find($id);
        if ($roleAndPermission) {
            $roleAndPermission->update([
                'role_id' => $request->input('role_id'),
                'permission_id' => $request->input('permission_id'),
                'updated_by' => Auth::id()
            ]);
            return response()->json(['message' => 'Role and permission link updated successfully']);
        }
        return response()->json(['message' => 'Role and Permission link not found'], 404);
    }

    public function deleteRoleAndPermission($id)
    {
        $roleAndPermission = RolesAndPermissions::find($id);
        if ($roleAndPermission) {
            $roleAndPermission->delete();
            return response()->json(['message' => 'Role and permission link deleted successfully']);
        }
        return response()->json(['message' => 'Role and Permission link not found'], 404);
    }
}
