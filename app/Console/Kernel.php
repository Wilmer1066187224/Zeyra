<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
       // Ejecuta el backup todos los días a las 12:00 AM
    $schedule->command('backup:run')->dailyAt('05:00')->appendOutputTo(storage_path('logs/backup.log'));

    // Opcional: para probarlo más rápido, puedes usar cada minuto:
    // $schedule->command('backup:run')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
