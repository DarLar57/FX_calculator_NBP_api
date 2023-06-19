<?php

namespace App\Models;

use Exception;

class NbpApi
{
    // get exchange rates tables (A and B) via NBP API and ultimately to create Obj. instances (CurrencyExchangeRate class)
    public function getExRateTableAandBFromApi(): array {
         
        $allDataToCreateCurrExObjs = [];
        
        try {
            $urlTableA = 'http://api.nbp.pl/api/exchangerates/tables/a';
            $urlTableB = 'http://api.nbp.pl/api/exchangerates/tables/b';
            
            // Fetch data from Table A
            $dataFromTableA = file_get_contents($urlTableA);
            $dataFromTableA = json_decode($dataFromTableA, true);
            
            if ($dataFromTableA) {
                $allDataToCreateCurrExObjs = $this->processTableData($dataFromTableA, $allDataToCreateCurrExObjs);
            }
            
            // Fetch data from Table B
            $dataFromTableB = file_get_contents($urlTableB);
            $dataFromTableB = json_decode($dataFromTableB, true);
            
            if ($dataFromTableB) {
                $allDataToCreateCurrExObjs = $this->processTableData($dataFromTableB, $allDataToCreateCurrExObjs);
            }
            
            if (empty($allDataToCreateCurrExObjs)) {
                throw new Exception('Failed to retrieve data from the NBP API.');
            }
            
            return $allDataToCreateCurrExObjs;
        } catch (Exception $e) {
            $errorMessage = 'An error occurred while fetching exchange rate data: ' . $e->getMessage();
            error_log($errorMessage); // Log error message
            throw $e;
        }
    }

    // Process table data and add it to $dataToCreateExRateObjects array
    private function processTableData($tableData, $dataToCreateExRateObjects) {
        $tableNo = $tableData[0]['no'];
        $effectiveDate = date('Y-m-d', strtotime($tableData[0]['effectiveDate']));
        
        foreach ($tableData[0]['rates'] as $rate) {
            $currency = $rate['currency'];
            $currencyCode = $rate['code'];
            $midExRate = $rate['mid'];
            
            $dataToCreateExRateObjects[] = [
                'table_no' => $tableNo,
                'effective_date' => $effectiveDate,
                'currency' => $currency,
                'currency_code' => $currencyCode,
                'mid_ex_rate' => $midExRate
            ];
        }
        
        return $dataToCreateExRateObjects;
    } 
}

