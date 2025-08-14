<?php

namespace App\Console;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
        DB::table('leave_balances')->increment('annual_leave', 1);
        })->monthlyOn(1,'00:00');

        // Every month — reset Work From Home to 5
        $schedule->call(function () {
        DB::table('leave_balances')->update(['work_from_home' => 5]);
        })->monthlyOn(1, '00:05');

        // Every year — reset Bereavement Leave to 5
        $schedule->call(function () {
        DB::table('leave_balances')->update(['bereavement_leave' => 5]);
        })->yearlyOn(1, 1, '00:10');
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
