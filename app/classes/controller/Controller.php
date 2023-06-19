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
    // and order inserting into db createExRateObjAndInsert
    public function createCurrExRateObjAndInsert(): void
    {
        $api = new NbpApi;
        $db_oper = new DbOperations;

        $ExRateTableAandBFromApi = $api->getExRateTableAandBFromApi();

        foreach ($ExRateTableAandBFromApi as $singleExRateData) {
        
            //create CurrencyExchangeRate obj.
            $exRateObj = new CurrencyExchangeRate($singleExRateData);
        
            // validate all NBP ex. rates before input in db to avoid double insert
            if (!((new Validate)->isCurrExRateInDb($exRateObj))) {
                $db_oper->insertExRateDataToDb($exRateObj);
            }
        }
    }

    // create CurrencyExchangeRate using relevant class objects and
    // reading from db CurrencyExchange
    public function createCurrExObjAndInsert(): void
    {
        $db_oper = new DbOperations;

        $currExchangeObj = new CurrencyExchange();

        $db_oper->insertCurrExDataToDb($currExchangeObj);
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

    function validateAmount($amount): ?string
    {
        return (new Validate)->validateAmount($amount);
    }

    // request to delete all NBP curr. ex. rates from db
    function deleteCurrExRateFromDb(): void
    {
        $db_oper = new DbOperations;
        $db_oper->deleteCurrExRateFromDb();
    }
}


