<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@flyinghorse.com',
            'password' => bcrypt('1Giga_2023'),
            'role' => 'admin',
        ]);
    }
}
