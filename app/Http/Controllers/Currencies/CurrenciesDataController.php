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
    public function latestCurrencies(): \Illuminate\Http\JsonResponse
    {
        $data = $this->service->getLatestCurrencies();

        if (empty($data) || empty($data['groupedCurrencies'])) {
            return response()->json([
                'error' => true,
                'message' => 'No data'
            ]);
        }
        return response()->json([
            'latestCurrencies' => $data['groupedCurrencies'],
            'latestDate' => $data['latestDate'],
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function currencyExchangeRatesDates(): \Illuminate\Http\JsonResponse
    {
        $data = $this->service->getCurrencyExchangeRatesDates();
        if (empty($data)) {
            return response()->json([
                'error' => true,
                'message' => 'No data'
            ]);
        }
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
        $data = $this->service->getFilterCurrencies($request);
        if (empty($data)) {
            return response()->json([
                'error' => true,
                'message' => 'No data'
            ]);
        }
        return response()->json([
            'filteredCurrencies' => $data
        ]);
    }
}
