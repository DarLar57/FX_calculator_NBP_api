<?php

namespace App\Models;
use Exception;

class NbpApi
{
    // get exchange rates tables (A and B) via NBP API and ultimately to create Obj. instances (CurrencyExchangeRate class)
    public function getExRateTableAandBFromApi(): array {
        try {
            $urlTableA = 'http://api.nbp.pl/api/exchangerates/tables/a';
            $allDataFromTableA = file_get_contents($urlTableA);
            
            $urlTableB = 'http://api.nbp.pl/api/exchangerates/tables/b';
            $allDataFromTableB = file_get_contents($urlTableB);
            
            $allDataFromTableA = json_decode($allDataFromTableA, true);
            $allDataFromTableB = json_decode($allDataFromTableB, true);
            
            if (!$allDataFromTableA || !$allDataFromTableB) {
                throw new Exception('Failed to retrieve data from the NBP API.');
            }
            
            //array with all exchange rates tables (A and B) raw data
            $allDataFromTwoTables = array_merge($allDataFromTableA, $allDataFromTableB);
            
            // to keep all data from table A and B (returned from the below iteration)
            $dataToCreateExRateObjects = [];
            $i = 0;
            
            // array with table A and B data among others to record table ref. and date (indicated just once per each table) for each currency
            for ($j = 0; $j <= 1; $j++) {
                $tableNo = $allDataFromTwoTables[$j]['no'];
                $effectiveDate = date('Y-m-d', strtotime($allDataFromTwoTables[$j]['effectiveDate']));
                
                foreach ($allDataFromTwoTables[$j]['rates'] as $rate) {
                    $currency = $rate['currency'];
                    $currencyCode = $rate['code'];
                    $midExRate = $rate['mid'];
                    
                    $dataToCreateExRateObjects[$i]['table_no'] = $tableNo;
                    $dataToCreateExRateObjects[$i]['effective_date'] = $effectiveDate;
                    $dataToCreateExRateObjects[$i]['currency'] = $currency;
                    $dataToCreateExRateObjects[$i]['currency_code'] = $currencyCode;
                    $dataToCreateExRateObjects[$i]['mid_ex_rate'] = $midExRate;
                    $i++;
                }
            }
            
            return $dataToCreateExRateObjects;
        } catch (Exception $e) {
            $errorMessage = 'An error while fetching exchange rate data: ' . $e->getMessage();
            error_log($errorMessage); // Log error message
            throw $e;
        }
    } 
}