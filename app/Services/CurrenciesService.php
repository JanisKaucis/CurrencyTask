<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CurrenciesService
{
    /**
     * @return array
     */
    public function getTodayCurrencies(): array
    {

        $data['todayDate'] = Carbon::now()->subWeekdays()->format('Y-m-d');
        $todayCurrencies = DB::select('SELECT * FROM currencies WHERE date="' . $data['todayDate'] . '"');
        $data['groupedCurrencies'] = [];
        foreach ($todayCurrencies as $currency) {
            $currency = (array)$currency;
            $data['groupedCurrencies'][$currency['date']][] = $currency;
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getCurrencyExchangeRatesDates(): array
    {
        $data = [];
        $firstCurrencyDate = DB::select('SELECT date FROM currencies ORDER BY date ASC LIMIT 1');
        $data['first_date'] = array_column($firstCurrencyDate, 'date')[0] ?? null;
        $lastCurrencyDate = DB::select('SELECT date FROM currencies ORDER BY date DESC LIMIT 1');
        $data['last_date'] = array_column($lastCurrencyDate, 'date')[0] ?? null;

        return $data;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getFilterCurrencies(Request $request): array
    {
        $filterValue = $request->get('countryFilter');
        $dateFrom = $request->get('dateFrom');
        $dateTo = $request->get('dateTo');
        $filteredCurrencies = DB::select('SELECT * FROM currencies WHERE country_id LIKE "' . $filterValue . '%" AND date BETWEEN "' . $dateFrom . '" AND "' . $dateTo . '"');
        $groupedCurrencies = [];
        foreach ($filteredCurrencies as $currency) {
            $groupedCurrencies[$currency->date][] = $currency;
        }

        return $groupedCurrencies;
    }
}
