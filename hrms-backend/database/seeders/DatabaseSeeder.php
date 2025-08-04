<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\LeaveSeeder;
use Database\Seeders\EmployeeSeeder;
use Database\Seeders\AttendanceSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
        EmployeeSeeder::class,
        LeaveSeeder::class, 
        AttendanceSeeder::class
    ]);
    }
}
