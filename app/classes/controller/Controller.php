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

    public function createExRateTable()
    {
        $db_oper = new DbOperations;

        $ExRateDataFromDb = $db_oper->readExRateDataFromDb();
  
        echo 
        '<div class="col-md-12 table-container">
        <div id="sticky">
        <label id="fx-table-label">NBP FX Exchange table A&B versus PLN</label>

            <input id="inputFilter" type="text" class="form-control mb-3" placeholder="Search for text in table">
        </div>
        <table id="table_fx_rates" class="table table-striped table-hover m-2 p-1">
        <thead>
        <tr>
            <td>Table name</td>
            <td>FX table date</td>
            <td>Currency</td>
            <td>Code</td>
            <td>Exchange rate</td>
        </tr>
        </thead>
       
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
    
    public function createCurrConversionObjAndInsert()
    {
        $db_oper = new DbOperations;

        $sourceCurrencyArr = unserialize($_POST['sourceCurrency']);
        $targetCurrencyArr = unserialize($_POST['targetCurrency']);

        $tableNo = $sourceCurrencyArr['table_no'];
        $targetTableNo = $targetCurrencyArr['table_no'];
        $effectiveDate = $sourceCurrencyArr['effective_date'];
        $sourceCurrency = $sourceCurrencyArr['currency'];
        $sourceCurrencyCode = $sourceCurrencyArr['currency_code'];
        $sourceMidExRate = $sourceCurrencyArr['mid_ex_rate'];
        $sourceAmount = $_POST['amount'];
        $targetCurrency = $targetCurrencyArr['currency'];
        $targetCurrencyCode = $targetCurrencyArr['currency_code'];
        $targetMidExRate = $targetCurrencyArr['mid_ex_rate'];
        $midExRate = round(($targetMidExRate / $sourceMidExRate),5);
        $targetAmount = $sourceAmount / $midExRate;

        $currConversionData = [
            'table_no' => $tableNo,
            'target_table_no' => $targetTableNo,
            'effective_date' => $effectiveDate,
            'currency' => $sourceCurrency,
            'currency_code' => $sourceCurrencyCode,
            'mid_ex_rate' => $midExRate,
            'amount' => $sourceAmount,
            'target_currency' => $targetCurrency,
            'target_currency_code' => $targetCurrencyCode,
            'target_amount' => $targetAmount
        ];
      
        $currConversionObj = new CurrencyConversion($currConversionData);
        $db_oper->insertCurrConversionDataToDb($currConversionObj);
    }
    // table with FX conversions executed
    public static function createFXConversionTable()
    {
        $db_oper = new DbOperations;

        $FXConversionDataFromDb = $db_oper->readFXConversionDataFromDb();
  
        echo 
        '<div class="col-md-11 m-2 table-container">
            <input id="inputFilter" type="text" class="form-control mb-3" placeholder="Search for text in table">
        
        <label id="fx-table-label">FX conversion using NBP FX rates</label>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-7 col-7 order-xl-first order-lg-first order-last order-sm-last order-md-last ">
        <table id="table_fx_converter" class="table table-striped table-hover m-2 p-1">
        <thead>
        <tr>
            <td>FX table date</td>
            <td>Currency (source)</td>
            <td>Code (source)</td>
            <td>Amount (source)</td>
            <td>Currency (target)</td>
            <td>Code (target)</td>
            <td>Amount (target)</td>
            <td>Exchange rate</td>
            <td>Table name (source)</td>
            <td>Table name (target)</td>
        </tr>
        </thead>
        <tbody id="table_report">';

        foreach ($FXConversionDataFromDb as $singleFXConversionDataFromDb) {
                
            $FXConversionObj = new CurrencyConversion($singleFXConversionDataFromDb);
            echo "<tr>
                <td> {$FXConversionObj->getEffectiveDate()}</td>
                <td> {$FXConversionObj->getCurrency()}</td>
                <td> {$FXConversionObj->getCurrencyCode()}</td>
                <td>" . number_format($FXConversionObj->getAmount(), 2, ',', ' ') . "</td>
                <td> {$FXConversionObj->getTargetCurrency()}</td>
                <td> {$FXConversionObj->getTargetCurrencyCode()}</td>
                <td>" . number_format($FXConversionObj->getTargetAmount(), 2, ',', ' ') . "</td>
                <td> {$FXConversionObj->getMidExRate()}</td>
                <td> {$FXConversionObj->getTableNo()}</td>
                <td> {$FXConversionObj->getTargetTableNo()}</td>
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



