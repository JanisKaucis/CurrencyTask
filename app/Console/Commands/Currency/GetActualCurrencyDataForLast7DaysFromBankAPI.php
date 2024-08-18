<?php

namespace App\Console\Commands\Currency;

use App\Traits\CurrencyExchange;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GetActualCurrencyDataForLast7DaysFromBankAPI extends Command
{
    use CurrencyExchange;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-actual-currency-data-for-last-7-days-from-bank-a-p-i';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command gets actual data about all currency exchange rates for EUR to other currencies
    for last 7 days';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $last7Workdays = $this->getLast7Workdays();
        $baseBankUrl = env('BANK_XML_BASE_URL', 'https://www.bank.lv/vk/ecb.xml');

        foreach ($last7Workdays as $date) {
            $retValue = $this->download_page($baseBankUrl.'?date=' . $date);
            $array = $this->XmlToArray($retValue);
            $this->saveCurrencies($array);
        }

    }

    /**
     * @return array
     */
    public function getLast7Workdays(): array
    {
        $days = [];
        for ($x = 6; $x >= 0; $x--) {
            $days[] =Carbon::now()->subWeekdays($x)->startOfDay()->format('Ymd') . 'T000000';
        }
        return $days;
    }
}
