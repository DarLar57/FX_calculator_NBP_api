<?php

namespace App\Models;

class NbpApi
{
    public function __construct() {

    }

    public function getExRateTableAandBFromApi(): array {
        $urlTableA = 'http://api.nbp.pl/api/exchangerates/tables/a';
        $allDataFromTableA = file_get_contents($urlTableA);
        $urlTableB = 'http://api.nbp.pl/api/exchangerates/tables/b';
        $allDataFromTableB = file_get_contents($urlTableB);
        
        $allDataFromTwoTables = array_merge(
            json_decode($allDataFromTableA, true),
            json_decode($allDataFromTableB, true)
        );
        
        $i = 0;
        $dataToCreateExRateObjects = array();

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