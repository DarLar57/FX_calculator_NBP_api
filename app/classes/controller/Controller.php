<?php

namespace App\Controller;

use App\DB;
use App\Models\DbOperations;
use App\Models\ExchangeRatesTable;
use App\Models\NbpApi;

//use \App\DB;

class Controller {

    public static function createExRateObj()
    {
        $api = new NbpApi;
        $db_oper = new DbOperations;

        $ExRateTableAandBFromApi = $api->getExRateTableAandBFromApi();

        foreach ($ExRateTableAandBFromApi as $singleExRateData) {
                
        $exRateObj = new ExchangeRatesTable($singleExRateData);
        $db_oper->insertExRateDataToDb($exRateObj);
        }
    }

    public static function createExRateTable()
    {
        $db_oper = new DbOperations;

        $ExRateDataFromDb = $db_oper->readExRateDataFromDb();
  
        echo '<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 order-xl-first order-lg-first     order-last order-sm-last order-md-last ">
        <table id="table_employees" class="table table-striped table-hover m-3 p-2">
        <tr>
            <td>Table name</td>
            <td>Date of Ex. Rate setting</td>
            <td>Full currency name</td>
            <td>Currency code</td>
            <td>Exchange rate</td>
        </tr>';

        foreach ($ExRateDataFromDb as $singleExRateData) {
                
            $exRateObj = new ExchangeRatesTable($singleExRateData);
            echo "<tr>
                <td> {$exRateObj->getTableNo()}</td>
                <td> {$exRateObj->getEffectiveDate()}</td>
                <td> {$exRateObj->getCurrency()}</td>
                <td> {$exRateObj->getCurrencyCode()}</td>
                <td> {$exRateObj->getMidExRate()}</td>
                </tr>";
        }
        echo '</table></div>';
    }
    
    public function getCurrencies(): array
    {
        $currencies = (new DbOperations)->getCurrencies();
        return $currencies;
    }
}



