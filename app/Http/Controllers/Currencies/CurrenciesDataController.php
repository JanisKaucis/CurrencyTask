<?php

namespace App\Http\Controllers\Currencies;

use Carbon\Carbon;
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

    public function getCurrencyDatesExchangeRates()
    {
        $firstCurrencyDate = DB::table('currencies')->where('date', $todayDate)->get();
    }
}
