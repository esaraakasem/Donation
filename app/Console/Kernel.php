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
        Commands\DonationCron::class,
        Commands\DonationOneMonthCron::class,
        Commands\DonationOneWeekCron::class,
        Commands\DonationThreeMinutesCron::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('donate:cron')
                 ->quarterly();
        $schedule->command('donateEveryOneWeek:cron')
                 ->weekly();
        $schedule->command('donateEveryOneMonth:cron')
                 ->monthly();
        $schedule->command('donateEveryThreeMinutes:cron')
                 ->everyFiveMinutes();
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
