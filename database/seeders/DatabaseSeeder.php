<?php

use Illuminate\Database\Seeder;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\PermissionsTableSeeder;
use Database\Seeders\UsersAndRolesTableSeeder;
use Database\Seeders\RolesAndPermissionsTableSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(UsersAndRolesTableSeeder::class);
        $this->call(RolesAndPermissionsTableSeeder::class);
    }
}
