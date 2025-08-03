<?php

namespace Database\Seeders;

use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class LeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee = Employee::first();

            if ($employee) {
            Leave::create([
            'employee_id' => $employee->id, 
            'leave_type' => 'sick',
            'start_date' => now(),
            'end_date' => now()->addDays(2),
            'reason' => 'Fever and cold',
            'status' => 'approved',
            ]);
        }
    }
}
