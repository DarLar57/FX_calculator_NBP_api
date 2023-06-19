<?php

namespace App\Controller;

use App\Models\DbOperations;
use App\Models\Functionality\CurrencyExchangeRate;
use App\Models\Functionality\CurrencyExchange;
use App\Models\NbpApi;
use App\Models\Validate;
use App\View\Components;

class Controller {

    // getting data from NBPApi class, create CurrencyExchangeRate obj.
    // and order inserting into db
    public function createExRateObjAndInsert(): void
    {
        $api = new NbpApi;
        $db_oper = new DbOperations;

        $ExRateTableAandBFromApi = $api->getExRateTableAandBFromApi();

        foreach ($ExRateTableAandBFromApi as $singleExRateData) {
        
        //create CurrencyExchangeRate obj.
        $exRateObj = new CurrencyExchangeRate($singleExRateData);
        $db_oper->insertExRateDataToDb($exRateObj);
        }
    }

    // create CurrencyExchangeRate using relevant class objects and
    // reading from db CurrencyExchange
    public function createCurrExchangeObjAndInsert(): void
    {
        $db_oper = new DbOperations;

        $sourceCurrencyArr = unserialize($_POST['sourceCurrency']);
        $sourceMidExRate = $sourceCurrencyArr['mid_ex_rate'];
        $sourceAmount = $_POST['amount'];
        $sourceAmount = str_replace(',', '.', $sourceAmount);
        
        $targetCurrencyArr = unserialize($_POST['targetCurrency']);
        $targetMidExRate = $targetCurrencyArr['mid_ex_rate'];
        
        $midExRate = round(($targetMidExRate / $sourceMidExRate), 5);
        
        $targetAmount = $sourceAmount / $midExRate;

        $currExchangeData = [
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
      
        $currExchangeObj = new CurrencyExchange($currExchangeData);

        $db_oper->insertCurrExchangeDataToDb($currExchangeObj);
    }

    // create CurrencyExchange using relevant classes objects and
    // reading from db CurrencyExchange
    public static function createFXExchangeTable(): void
    {
        $db_oper = new DbOperations;
        $FXExchangeDataFromDb = $db_oper->readFXExchangeDataFromDb();
        
        $component = new Components();
        $FXExchangeTable = $component->createFXExchangeTable($FXExchangeDataFromDb);

        echo $FXExchangeTable;
    }

    // create CurrencyExchangeRate using relevant classes objects and
    // reading from db CurrencyExchange
    public static function createExRateTable(): void
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
    function validate($amount): ?string
    {
        return (new Validate)->validateInput($amount);
    }
}


