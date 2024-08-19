<?php

namespace App\Console\Commands\Currency;

use App\Traits\CurrencyExchange;
use Illuminate\Console\Command;

class GetActualCurrencyDataFromBankAPI extends Command
{
    use CurrencyExchange;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-actual-currency-data-from-bank-a-p-i';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command gets actual data about all currency exchange rates for EUR to other
    currencies for current day.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $baseBankUrl = env('BANK_XML_BASE_URL', 'https://www.bank.lv/vk/ecb.xml');
        $retValue = $this->download_page($baseBankUrl);
        $array = $this->XmlToArray($retValue);
        $this->saveCurrencies($array);
    }
}
