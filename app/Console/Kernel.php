<?php

namespace App\Console;

use App\Constants\EnvVariables;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use VIITech\Helpers\GlobalHelpers;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // cleanup telescope
        if (env(EnvVariables::TELESCOPE_ENABLED) == true) {
            $schedule->command('telescope:prune')->daily();
        }

        // Database Backup
        if (GlobalHelpers::isProductionEnv()) {
            $schedule->command('backup:clean')->daily()->at('03:00');
            $schedule->command('backup:run --only-db')->daily()->at('03:30');
            $schedule->command('backup:monitor')->daily()->at('03:15');
        }

        // change session status
        $schedule->command('session:status')->daily()->at('00:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
