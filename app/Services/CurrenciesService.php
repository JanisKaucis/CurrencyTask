<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CurrenciesService
{
    /**
     * @return array
     */
    public function getTodayCurrencies(): array
    {
        /*If week day is in weekend, then it will find last week day, because bank does not show currencies in weekend
        days*/
        $data = [];
        try {
            $data['todayDate'] = Carbon::now()->nextWeekday()->previousWeekday()->format('Y-m-d');
            $todayCurrencies = DB::select('SELECT * FROM currencies WHERE date="' . $data['todayDate'] . '"');
            $data['groupedCurrencies'] = [];
            foreach ($todayCurrencies as $currency) {
                $currency = (array)$currency;
                $data['groupedCurrencies'][$currency['date']][] = $currency;
            }
        } catch (\Exception $exception) {
            $data = [];
            Log::debug('FAILED: getTodayCurrencies');
            Log::debug($exception);
        }
        return $data;
    }

    /**
     * @return array
     */
    public function getCurrencyExchangeRatesDates(): array
    {
        $data = [];
        try {
            $firstCurrencyDate = DB::select('SELECT date FROM currencies ORDER BY date ASC LIMIT 1');

            $data['first_date'] = array_column($firstCurrencyDate, 'date')[0] ?? null;
            $lastCurrencyDate = DB::select('SELECT date FROM currencies ORDER BY date DESC LIMIT 1');
            $data['last_date'] = array_column($lastCurrencyDate, 'date')[0] ?? null;
            $carbonFirstDate = Carbon::parse($data['first_date']);
            $carbonLastDate = Carbon::parse($data['last_date']);
            $differenceInDays = $carbonFirstDate->diffInWeekdays($carbonLastDate);
            if ($differenceInDays > 6) {
                $data['first_date'] = Carbon::parse($data['last_date'])->subWeekdays(6)->format('Y-m-d');
            }

        } catch (\Exception $exception) {
            $data = [];
            Log::debug('FAILED: getCurrencyExchangeRatesDates');
            Log::debug($exception);
        }
        return $data;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getFilterCurrencies(Request $request): array
    {
        $groupedCurrencies = [];
        try {
            $filterValue = $request->get('countryFilter');
            $dateFrom = $request->get('dateFrom');
            $weekendDay = Carbon::parse($dateFrom)->isWeekend();
            if ($weekendDay) {
                $dateFrom = Carbon::parse($dateFrom)->subWeekday();
            }
            $dateTo = $request->get('dateTo');
            $filteredCurrencies = DB::select('SELECT * FROM currencies WHERE country_id LIKE "' . $filterValue . '%" AND date BETWEEN "' . $dateFrom . '" AND "' . $dateTo . '" ORDER BY date');

            foreach ($filteredCurrencies as $currency) {
                $groupedCurrencies[$currency->date][] = $currency;
            }
        } catch (\Exception $exception) {
            Log::debug('FAILED: getFilterCurrencies');
            Log::debug($exception);
        }
        return $groupedCurrencies;
    }
}
