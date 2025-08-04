<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Holiday::create([
        'title' => 'Independence Day',
        'holiday_date' => '2025-08-15',
        'description' => 'National Holiday',
    ]);

        Holiday::create([
        'title' => 'Gandhi Jayanti',
        'holiday_date' => '2025-10-02',
        'description' => 'National Holiday',
    ]);
    }
}
