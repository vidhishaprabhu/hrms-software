<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 11; $i++) {
            Employee::create([
                'employee_id' => 'EMP' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'first_name' => 'First' . $i,
                'last_name' => 'Last' . $i,
                'email' => 'employee' . $i . '@company.com',
                'phone_number' => '1234567890',
                'department' => 'IT',
                'designation' => 'Developer',
                'date_of_joining' => now()->subDays($i * 10),
                'gender' => $i % 2 == 0 ? 'Male' : 'Female',
                'status' => 'Active',
            ]);
        }
    }
}
