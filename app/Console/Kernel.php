<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {   
        $command_backup = 'backup:run';

        if(get_setting('backup_type') == 1)
        {
            $command_backup = 'backup:run';
        }
        if(get_setting('backup_type') == 2)
        {
            $command_backup = 'backup:run --only-db';
        }
        if(get_setting('backup_type') == 3)
        {
            $command_backup = 'backup:run --only-files';
        }

        switch (get_setting('schedule')) {
            case 1:
                $schedule->command()->everyMinute();;
                break;
            case 2:
                $schedule->command('backup:run --only-db')->hourly();;
                break;
            case 3:
                $schedule->command('backup:run --only-db')->daily();;
                break;
            case 4:
                $schedule->command('backup:run --only-db')->weekly();;
                break;
            case 5:
                $schedule->command('backup:run --only-db')->monthly();;
                break;
            default:
                # code...
                break;
        }
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
