<?php

namespace App\Console;

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
            $thresholdDate = Carbon::now()->subMinutes(5);   //5 mins before now
            Log::where('created_at', '<', $thresholdDate)->delete(); //created_at before now
            Log::info('Cleaned records.'); //add cleanup log into logs
        })->everyFiveMinutes(); //do this every 5 mins
    }
    

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
    }
}
