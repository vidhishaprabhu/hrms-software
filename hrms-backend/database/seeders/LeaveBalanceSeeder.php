<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\LeaveBalance;
use Illuminate\Database\Seeder;

class LeaveBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee = Employee::first();
        LeaveBalance::create([
            'employee_id' => $employee->id,
            'bereavement_leave' => 5,
            'annual_leave' => 0,
            'restricted_holiday' => 3,
            'work_from_home' => 5
        ]);

    }
}
