<?php

namespace App\Controller;

use App\DB;
use App\Models\DbOperations;
use App\Models\ExchangeRatesTable;
use App\Models\CurrencyConversion;
use App\Models\NbpApi;

//use \App\DB;

class Controller {

    public static function createExRateObjAndInsert()
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
  
        echo 
        '<div class="col-md-7 ms-3 table-container">
        <label id="fx-table-label">NBP FX Exchange table A&B versus PLN</label>

            <input id="inputFilter" type="text" class="form-control mb-3" placeholder="Search for text in any column (e.g. rate, date, currency, table name)">
       
        <table id="table_fx_rates" class="table table-striped table-hover m-4 p-2">
        <tr>
            <td>Table name</td>
            <td>Date of Ex. Rate</td>
            <td>Full currency name</td>
            <td>Currency code</td>
            <td>Exchange rate</td>
        </tr>
        <tbody id="table_report">';

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
        echo '</tbody></table>';
    }

    public static function createCurrConversionObjAndInsert()
    {
        $db_oper = new DbOperations;
        
        $tableNo = $args['table_no'];
        $effectiveDate = $args['effective_date'];
        $currency = $args['currency'];
        $currencyCode = $args['currency_code'];
        $midExRate = $args['mid_ex_rate'];
        $amount = $args['amount'];
        $targetCurrency = $args['target_currency'];
        $targetCurrencyCode = $args['target_currency_code'];
        $targetAmount = $args['target_amount'];

        $_POST['amount'];
        $_POST['sourceCurrency'];
        $_POST['targetCurrency'];

        $currConversionData = [];
                
        $currConversionObj = new CurrencyConversion($currConversionData);
        $db_oper->insertExRateDataToDb($currConversionObj);
        
    }
    public static function createFXConversionTable() // TO DO
    {
        $db_oper = new DbOperations;

        $ExRateDataFromDb = $db_oper->readExRateDataFromDb();
  
        echo 
        '<div class="col-md-4">
            <input id="inputFilter" type="text" class="form-control mb-3" placeholder="Search for text in any column (e.g. rate, date, currency, table name)">
        </div>
        <caption>NBP FX Exchange table A&B versus PLN</caption>
            <div class="col-xl-4 col-lg-4 col-md-8 col-sm-8 col-8 order-xl-first order-lg-first order-last order-sm-last order-md-last ">
        <table id="table_fx_converter" class="table table-striped table-hover m-3 p-2">
        <tr>
            <td>Table name</td>
            <td>Date of Ex. Rate setting</td>
            <td>Full currency name</td>
            <td>Currency code</td>
            <td>Exchange rate</td>
        </tr>
        <tbody id="table_report">';

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
        echo '</tbody></table></div>';
    }

    public function getCurrencies(): array
    {
        $currencies = (new DbOperations)->getCurrencies();
        return $currencies;
    }
}



