<?php

namespace App\View;

use App\Models\DbOperations;
use App\Models\Functionality\ExchangeRatesTable;
use App\Models\Functionality\CurrencyConversion;
use App\Models\NbpApi;
use App\Controller\Controller;

class Components {

    // create CurrencyConversion using relevant class objects
    public static function createFXConversionTable($FXConversionDataFromDb)
    {
        $FXConversionTable = 
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
            
            $FXConversionTable .= "<tr>
                <td> {$FXConversionObj->getEffectiveDate()}</td>
                <td> {$FXConversionObj->getCurrency()}</td>
                <td> {$FXConversionObj->getCurrencyCode()}</td>
                <td>" . number_format($FXConversionObj->getAmount(), 2, ',', ' ') . "</td>
                <td> {$FXConversionObj->getTargetCurrency()}</td>
                <td> {$FXConversionObj->getTargetCurrencyCode()}</td>
                <td>" . number_format($FXConversionObj->getTargetAmount(), 2, ',', ' ') . "</td>
                <td> {$FXConversionObj->getMidExRate()}</td>
                <td> {$FXConversionObj->getTableNo()}</td>
                <td> {$FXConversionObj->getTargetTableNo()}</td></tr>";
        }
        $FXConversionTable .= '</tbody></table></div>';

    return $FXConversionTable;
    }

    // create ExchangeRatesTable reading from db and order inserting into db
    public function createExRateTable($ExRateDataFromDb)
    {
        $ExRateTable =
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
                
                //getting all the data from ExchangeRatesTable obj.
                //to produce table content
                $exRateObj = new ExchangeRatesTable($singleExRateData);
                
                $ExRateTable .= "<tr>
                    <td> {$exRateObj->getTableNo()}</td>
                    <td> {$exRateObj->getEffectiveDate()}</td>
                    <td> {$exRateObj->getCurrency()}</td>
                    <td> {$exRateObj->getCurrencyCode()}</td>
                    <td> {$exRateObj->getMidExRate()}</td>
                    </tr>";
            }
            $ExRateTable .= '</tbody></table>';

        return $ExRateTable;
    }

    public function getCurrencies(): array
    {
        $currencies = (new DbOperations)->getCurrencies();
        return $currencies;
    }
}



