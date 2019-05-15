<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Artisan;

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
        $command_params = [];

        $dataSchedule = get_schedule();

        foreach ($dataSchedule as $key => $value) {
            if($value->backup_type == 1)
            {
                $command_backup = 'backup:run';
                if($value->recurring == 1)
                {
                    $schedule->command($command_backup)->dailyAt($value->time);;
                }elseif ($value->recurring == 2) {
                    $schedule->command($command_backup)->weeklyOn(1, $value->time);

                }elseif ($value->recurring == 3) {
                    $schedule->command($command_backup)->monthlyOn(4, $value->time);
                }elseif ($value->recurring == 4) {
                    $schedule->command($command_backup)->monthlyOn($value->date, '23.59');
                }
            }elseif ($value->backup_type == 2) {
                $command_backup = 'backup:run --only-db';
                $command_params['--only-db']= true;
                if($value->recurring == 1)
                {
                    $schedule->command($command_backup)->dailyAt($value->time);;
                }elseif ($value->recurring == 2) {
                    $schedule->command($command_backup)->weeklyOn(1, $value->time);

                }elseif ($value->recurring == 3) {
                    $schedule->command($command_backup)->monthlyOn(4, $value->time);
                }elseif ($value->recurring == 4) {
                    $schedule->command($command_backup)->monthlyOn($value->date, '23.59');
                }
            }elseif ($value->backup_type == 3) {
                $command_backup = 'backup:run --only-files';
                $command_params['--only-files'] = true;
                if($value->recurring == 1)
                {
                    $schedule->command($command_backup)->dailyAt($value->time);;
                }elseif ($value->recurring == 2) {
                    $schedule->command($command_backup)->weeklyOn(1, $value->time);

                }elseif ($value->recurring == 3) {
                    $schedule->command($command_backup)->monthlyOn(4, $value->time);
                }elseif ($value->recurring == 4) {
                    $schedule->command($command_backup)->monthlyOn($value->date, '23.59');
                }
            }
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
