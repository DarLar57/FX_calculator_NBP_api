<?php

namespace App\Models;

class NbpApi
{
    // get exchange rates tables (A and B) via NBP API and ultimately to create Obj. instances (ExchangeRatesTable class)
    public function getExRateTableAandBFromApi(): array {
        $urlTableA = 'http://api.nbp.pl/api/exchangerates/tables/a';
        $allDataFromTableA = file_get_contents($urlTableA);
        $urlTableB = 'http://api.nbp.pl/api/exchangerates/tables/b';
        $allDataFromTableB = file_get_contents($urlTableB);
        
        //array with all exchange rates tables (A and B) raw data
        $allDataFromTwoTables = array_merge(
            json_decode($allDataFromTableA, true),
            json_decode($allDataFromTableB, true)
        );
        
        $i = 0;

        // to keep all data from table A and B (returned from the below iteration)
        $dataToCreateExRateObjects = array();

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
        } return $dataToCreateExRateObjects;
    } 
}