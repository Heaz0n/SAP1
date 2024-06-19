<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsTableSeeder extends Seeder
{
    public function run()
    {
        // Пример создания связи роли с разрешением
        $role1 = Role::where('code', 'admin')->first(); // Ищем роль администратора
        $permission1 = Permission::where('code', 'get-list-users')->first(); // Ищем разрешение на получение списка пользователей

        if ($role1 && $permission1) {
            $role1->permissions()->attach($permission1->id);
        }

        $role2 = Role::where('code', 'user')->first(); // Ищем роль пользователя
        $permission2 = Permission::where('code', 'read-user')->first(); // Ищем разрешение на чтение данных пользователя

        if ($role2 && $permission2) {
            $role2->permissions()->attach($permission2->id);
        }
    }
}
