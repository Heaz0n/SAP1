<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravel\Passport\ClientRepository;

class PassportClientSeeder extends Seeder
{
    public function run()
    {
        $clientRepository = new ClientRepository();

        // Пример создания клиентского приложения
        $clientRepository->create(
            null, // user_id
            'My Client Name', // name
            'http://localhost/auth/callback' // redirect
        );
    }
}
