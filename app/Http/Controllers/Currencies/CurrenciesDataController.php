<?php

namespace App\Http\Controllers\Currencies;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CurrenciesDataController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTodayCurrencies(): \Illuminate\Http\JsonResponse
    {
        $todayDate = Carbon::now()->subWeekdays()->format('Y-m-d');
        $todayCurrencies = DB::select('SELECT * FROM currencies WHERE date="' . $todayDate . '"');

        return response()->json([
            'todayCurrencies' => $todayCurrencies
        ]);
    }
    public function getAllCurrencies()
    {
        $allCurrencies = DB::select('SELECT * FROM currencies');
        $groupedCurrencies = [];
        foreach ($allCurrencies as $currency) {
            $groupedCurrencies[$currency->date][] = $currency;
        }

        return response()->json([
            'allCurrencies' => $groupedCurrencies
        ]);
    }
    public function getFilteredCurrencies(): \Illuminate\Http\JsonResponse
    {
        $filteredCurrencies = DB::select('SELECT * FROM currencies WHERE date BETWEEN ' . $dateFrom . ' AND '.$dateTo.'');
        return response()->json([
            'filteredCurrencies' => $filteredCurrencies
        ]);
    }
    public function getCurrencyDatesExchangeRates()
    {
        $data = [];
        $firstCurrencyDate = DB::select( 'SELECT date FROM currencies ORDER BY date ASC LIMIT 1');
        $data['first_date'] = array_column($firstCurrencyDate, 'date')[0] ?? null;
        $lastCurrencyDate = DB::select( 'SELECT date FROM currencies ORDER BY date DESC LIMIT 1');
        $data['last_date'] = array_column($lastCurrencyDate, 'date')[0] ?? null;

        return response()->json([
            'firstDate' => $data['first_date'],
            'lastDate' => $data['last_date']
        ]);
    }

    public function filterCurrencies(Request $request)
    {
        $filterValue = $request->get('countryFilter');
        $dateFrom = $request->get('dateFrom');
        $dateTo = $request->get('dateTo');
        Log::debug($filterValue);
        Log::debug($dateFrom);
        Log::debug($dateTo);
        $filteredCurrencies = DB::select('SELECT * FROM currencies WHERE country_id LIKE "' . $filterValue . '%" AND date BETWEEN "' . $dateFrom . '" AND "'.$dateTo.'"');
        $groupedCurrencies = [];
        foreach ($filteredCurrencies as $currency) {
            $groupedCurrencies[$currency->date][] = $currency;
        }

        return response()->json([
            'filteredCurrencies' => $groupedCurrencies
        ]);
    }
}
