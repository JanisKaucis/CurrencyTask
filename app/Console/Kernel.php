<?php

namespace App\Console;

use App\Console\Commands\Currency\GetActualCurrencyDataForLast7DaysFromBankAPI;
use App\Console\Commands\Currency\GetActualCurrencyDataFromBankAPI;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
      GetActualCurrencyDataFromBankAPI::class,
        GetActualCurrencyDataForLast7DaysFromBankAPI::class
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:get-actual-currency-data-from-bank-a-p-i')->cron('20 15 * * *');
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
