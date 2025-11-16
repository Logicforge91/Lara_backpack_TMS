<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\GenerateMonthlyReports::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // Run your command every month on 25th at midnight
        $schedule->command('releases:move-released')->hourly();
        $schedule->command('tasks:generate-monthly-reports')->monthlyOn(25, '00:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
