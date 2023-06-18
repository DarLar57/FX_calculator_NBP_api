<?php

namespace App\Controller;

use App\Models\DbOperations;
use App\Models\Functionality\ExchangeRatesTable;
use App\Models\Functionality\CurrencyConversion;
use App\Models\NbpApi;
use App\View\Components;

class Controller {

    // getting data from NBPApi class, create ExchangeRatesTable obj.
    // and order inserting into db
    public function createExRateObjAndInsert(): void
    {
        $api = new NbpApi;
        $db_oper = new DbOperations;

        $ExRateTableAandBFromApi = $api->getExRateTableAandBFromApi();

        foreach ($ExRateTableAandBFromApi as $singleExRateData) {
        
        //create ExchangeRatesTable obj.
        $exRateObj = new ExchangeRatesTable($singleExRateData);
        $db_oper->insertExRateDataToDb($exRateObj);
        }
    }

    // create ExchangeRatesTable using relevant class objects and
    // reading from db CurrencyConversion
    public function createCurrConversionObjAndInsert()
    {
        $db_oper = new DbOperations;

        $sourceCurrencyArr = unserialize($_POST['sourceCurrency']);
        $sourceMidExRate = $sourceCurrencyArr['mid_ex_rate'];
        $sourceAmount = $_POST['amount'];
        
        $targetCurrencyArr = unserialize($_POST['targetCurrency']);
        $targetMidExRate = $targetCurrencyArr['mid_ex_rate'];
        
        $midExRate = round(($targetMidExRate / $sourceMidExRate), 5);
        
        $targetAmount = $sourceAmount / $midExRate;

        $currConversionData = [
            'table_no' => $sourceCurrencyArr['table_no'],
            'target_table_no' => $targetCurrencyArr['table_no'],
            'effective_date' => $sourceCurrencyArr['effective_date'],
            'currency' => $sourceCurrencyArr['currency'],
            'currency_code' => $sourceCurrencyArr['currency_code'],
            'mid_ex_rate' => $midExRate,
            'amount' => $sourceAmount,
            'target_currency' => $targetCurrencyArr['currency'],
            'target_currency_code' => $targetCurrencyArr['currency_code'],
            'target_amount' => $targetAmount
        ];
      
        $currConversionObj = new CurrencyConversion($currConversionData);

        $db_oper->insertCurrConversionDataToDb($currConversionObj);
    }

    // create CurrencyConversion using relevant classes objects and
    // reading from db CurrencyConversion
    public static function createFXConversionTable()
    {
        $db_oper = new DbOperations;
        $FXConversionDataFromDb = $db_oper->readFXConversionDataFromDb();
        
        $component = new Components();
        $FXConversionTable = $component->createFXConversionTable($FXConversionDataFromDb);

        echo $FXConversionTable;
    }

    // create ExchangeRatesTable using relevant classes objects and
    // reading from db CurrencyConversion
    public static function createExRateTable()
    {
        $db_oper = new DbOperations;
        $ExRateDataFromDb = $db_oper->readExRateDataFromDb();
            
        $component = new Components();
        $ExRateTable = $component->createExRateTable($ExRateDataFromDb);
    
        echo $ExRateTable;
    }
    // get all currencies
    public function getCurrencies(): array
    {
        $currencies = (new DbOperations)->getCurrencies();
        return $currencies;
    }
}



