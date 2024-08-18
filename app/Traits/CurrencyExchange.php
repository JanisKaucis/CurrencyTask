<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait CurrencyExchange
{
    /**
     * @param $path
     * @return bool|string
     */
    function download_page($path): bool|string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $retValue = curl_exec($ch);
        curl_close($ch);

        return $retValue;
    }
    /**
     * @param $retValue
     * @return array
     */
    public function XmlToArray($retValue): array
    {
        $xml = simplexml_load_string($retValue, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        return json_decode($json, TRUE);
    }
    /**
     * @param $array
     * @return void
     */
    public function saveCurrencies($array): void
    {
        try {
            $currenciesArray = $this->getCurrenciesArray($array);
            DB::table('currencies')->insert($currenciesArray);

        } catch (\Exception $exception) {
            Log::debug('FAILED: saveCurrencies');
            Log::debug($exception);
        }
    }
    /**
     * @param $array
     * @return array
     */
    public function getCurrenciesArray($array): array
    {
        $currenciesArray = [];
        $date = $this->getDate($array);
        $existingDates = DB::table('currencies')->distinct()->pluck('date')->toArray();
        $currencies = $array['Currencies']['Currency'];
        if (in_array($date, $existingDates) || !$currencies) {
            return;
        }
        foreach ($currencies as $currency) {
            $currenciesArray[] = [
                'country_id' => $currency['ID'],
                'rate' => $currency['Rate'],
                'date' => $date
            ];
        }

        return $currenciesArray;
    }
    /**
     * @param $array
     * @return string
     */
    public function getDate($array): string
    {
        $dateString = $array['Date'];
        $dateArray = str_split($dateString, 2);
        return Carbon::create($dateArray[0] . $dateArray[1], $dateArray[2], $dateArray[3])->format('Y-m-d');
    }
}
