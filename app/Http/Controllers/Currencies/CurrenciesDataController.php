<?php

namespace App\Http\Controllers\Currencies;

use App\Services\CurrenciesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CurrenciesDataController
{
    private CurrenciesService $service;

    public function __construct(CurrenciesService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function todayCurrencies(): \Illuminate\Http\JsonResponse
    {
        $data = $this->service->getTodayCurrencies();

        return response()->json([
            'todayCurrencies' => $data['groupedCurrencies'],
            'todayDate' => $data['todayDate']
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function currencyExchangeRatesDates(): \Illuminate\Http\JsonResponse
    {
        $data = $this->service->getCurrencyExchangeRatesDates();

        return response()->json([
            'firstDate' => $data['first_date'],
            'lastDate' => $data['last_date']
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterCurrencies(Request $request): \Illuminate\Http\JsonResponse
    {
        $groupedCurrencies = $this->service->getFilterCurrencies($request);
        return response()->json([
            'filteredCurrencies' => $groupedCurrencies
        ]);
    }
}
