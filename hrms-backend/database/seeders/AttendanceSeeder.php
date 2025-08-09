<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            Attendance::create([
                'attendance_date' => Carbon::now()->subDays($i)->toDateString(),
                'check_in' => Carbon::now()->subDays($i)->setTime(9, rand(0, 59)),
                'check_out' => Carbon::now()->subDays($i)->setTime(17, rand(0, 59)),
                'status' => ['Present', 'Absent', 'Late'][rand(0, 2)],
            ]);
        }
    }
}
