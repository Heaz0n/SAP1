<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\UsersAndRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAndRoleController extends Controller
{
    public function create(Request $request)
    {
        $userId = $request->input('user_id');
        $roleId = $request->input('role_id');

        $user = User::find($userId);
        $role = Role::find($roleId);

        if ($user && $role) {
            UsersAndRoles::create([
                'user_id' => $userId,
                'role_id' => $roleId,
                'created_by' => Auth::id()
            ]);
            return response()->json(['message' => 'User and role linked successfully']);
        }
        return response()->json(['message' => 'User or Role not found'], 404);
    }

    public function getAll()
    {
        $usersAndRoles = UsersAndRoles::all();
        return response()->json($usersAndRoles);
    }

    public function get($id)
    {
        $userAndRole = UsersAndRoles::find($id);
        if ($userAndRole) {
            return response()->json($userAndRole);
        }
        return response()->json(['message' => 'User and Role link not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $userAndRole = UsersAndRoles::find($id);
        if ($userAndRole) {
            $userAndRole->update([
                'user_id' => $request->input('user_id'),
                'role_id' => $request->input('role_id'),
                'updated_by' => Auth::id()
            ]);
            return response()->json(['message' => 'User and role link updated successfully']);
        }
        return response()->json(['message' => 'User and Role link not found'], 404);
    }

    public function delete($id)
    {
        $userAndRole = UsersAndRoles::find($id);
        if ($userAndRole) {
            $userAndRole->delete();
            return response()->json(['message' => 'User and role link deleted successfully']);
        }
        return response()->json(['message' => 'User and Role link not found'], 404);
    }
}
