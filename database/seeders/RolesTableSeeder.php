<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'Admin',
                'description' => 'Administrator role',
                'code' => 'admin',
                'created_by' => 1, // Здесь предполагается, что пользователь с id=1 существует в системе
            ],
            [
                'name' => 'User',
                'description' => 'Regular user role',
                'code' => 'user',
                'created_by' => 1,
            ],
            [
                'name' => 'Guest',
                'description' => 'Guest role',
                'code' => 'guest',
                'created_by' => 1,
            ],
        ];

        foreach ($roles as $roleData) {
            // Проверяем, существует ли роль с данным кодом перед созданием
            $existingRole = Role::where('code', $roleData['code'])->first();
            
            if (!$existingRole) {
                Role::create($roleData);
            }
        }
    }
}
