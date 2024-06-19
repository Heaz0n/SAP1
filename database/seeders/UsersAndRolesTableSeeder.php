<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UsersAndRolesTableSeeder extends Seeder
{
    public function run()
    {
        // Пример создания связи пользователя с ролью
        $user1 = User::find(1); // Предположим, что пользователь с id=1 существует
        $role1 = Role::where('code', 'admin')->first(); // Ищем роль администратора

        if ($user1 && $role1) {
            $user1->roles()->attach($role1->id);
        }

        $user2 = User::find(2); // Предположим, что пользователь с id=2 существует
        $role2 = Role::where('code', 'user')->first(); // Ищем роль пользователя

        if ($user2 && $role2) {
            $user2->roles()->attach($role2->id);
        }
    }
}
