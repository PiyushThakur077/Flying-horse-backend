<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['id' => 1, 'status' => 'Available', 'active' => 1],
            ['id' => 2, 'status' => 'May Be Available', 'active' => 1],
            ['id' => 3, 'status' => 'Unavailable', 'active' => 1],
            ['id' => 4, 'status' => 'Do Not Disturb', 'active' => 1],
        ];


        foreach ( $statuses as $status ){
            Status::updateOrCreate(['id' => $status ],$status);
        }
    }
}
