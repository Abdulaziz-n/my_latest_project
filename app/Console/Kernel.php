<?php

namespace App\Console;

use App\Console\Commands\ChargeMonthlyStatisticsCommand;
use App\Console\Commands\ChargesAllCommand;
use App\Console\Commands\ChargesAllDailyCommand;
use App\Console\Commands\GiftDailyStatisticsCommand;
use App\Console\Commands\GiftsStatisticsCommand;
use App\Console\Commands\SubscriberDailyStaticsCommand;
use App\Console\Commands\SubscriberStatisticsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Usoft\Charges\Models\ChargeMonthlyStatistic;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        ChargesAllCommand::class,
        GiftsStatisticsCommand::class,
        ChargeMonthlyStatisticsCommand::class,
        SubscriberStatisticsCommand::class,

        ChargesAllDailyCommand::class,
        GiftDailyStatisticsCommand::class,
        SubscriberDailyStaticsCommand::class
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('test:run')->everyMinute();
        // $schedule->command('inspire')->hourly();
        $schedule->command('charge:all')->everyTenMinutes();
        $schedule->command('charge:daily')->everyTenMinutes();
        $schedule->command('gifts:daily')->everyTenMinutes();
        $schedule->command('subscriber:daily')->everyTenMinutes();
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
