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

            $currenciesValues = $this->getCurrenciesValues($array);
            if (empty($currenciesValues)) {
                return;
            }
            DB::insert("INSERT INTO currencies (Country_id,Rate, Date) VALUES ".$currenciesValues.";");
        } catch (\Exception $exception) {
            Log::debug('FAILED: saveCurrencies');
            Log::debug($exception);
        }
    }

    /**
     * @param $array
     * @return string
     */
    public function getCurrenciesValues($array): string
    {
        $currenciesValues = '';
        $date = $this->getDate($array);
        $existingDates = DB::select("SELECT DISTINCT date FROM currencies");
        $existingDates = array_column($existingDates,'date');

        $currencies = $array['Currencies']['Currency'];
        if (in_array($date, $existingDates) || !$currencies) {
            return $currenciesValues;
        }
        $currenciesCount = count($currencies);
        $i = 0;
        foreach ($currencies as $key => $currency) {
            $currenciesValues .= "('". $currency['ID']."','". $currency['Rate']."','". $date.
                (++$i === $currenciesCount ? "')" : "'),");
        }

        return $currenciesValues;
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
