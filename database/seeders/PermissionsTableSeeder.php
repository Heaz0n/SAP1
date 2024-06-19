<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'name' => 'Get List Users',
                'code' => 'get-list-users',
                'description' => 'Permission to get list of users',
                'created_by' => 1,
            ],
            [
                'name' => 'Read User',
                'code' => 'read-user',
                'description' => 'Permission to read user details',
                'created_by' => 1,
            ],
            [
                'name' => 'Update User',
                'code' => 'update-user',
                'description' => 'Permission to update user data',
                'created_by' => 1,
            ],
        ];

        foreach ($permissions as $permissionData) {
            // Проверяем, существует ли разрешение с данным кодом перед созданием
            $existingPermission = Permission::where('code', $permissionData['code'])->first();
            
            if (!$existingPermission) {
                Permission::create($permissionData);
            }
        }
    }
}
