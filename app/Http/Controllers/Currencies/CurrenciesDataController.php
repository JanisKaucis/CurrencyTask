<?php
namespace App\Http\Controllers\Currencies;

class CurrenciesDataController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPopupText(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'popupText' => 'Hello, this is a popup XDXD'
        ]);
    }
}
