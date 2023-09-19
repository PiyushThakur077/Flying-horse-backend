<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['id' => 1, 'name' => 'Yoges', 'email' => 'iyogesharma@gmail.com', 'password' => bcrypt('secret')],
            ['id' => 2, 'name' => 'Piyush Thakur', 'email' => 'PiyushThakur077@gmail.com', 'password' => bcrypt('secret')],
            ['id' => 3, 'name' => 'Purjit', 'email' => 'purjit@gmail.com', 'password' => bcrypt('secret')],
            ['id' => 4, 'name' => 'Amit Rana', 'email' => 'amit.rana@gmail.com', 'password' => bcrypt('secret')],
            ['id' => 5, 'name' => 'Test User 1', 'email' => 'testuser1@gmail.com', 'password' => bcrypt('secret')],
            ['id' => 6, 'name' => 'Test user 2', 'email' => 'testuser2@gmail.com', 'password' => bcrypt('secret')],
        ];


        foreach ( $statuses as $status ){
            User::updateOrCreate(['id' => $status ],$status);
        }
    }
}
