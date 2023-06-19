<?php

namespace App\View;

use App\Models\DbOperations;
use App\Models\Functionality\CurrencyExchangeRate;
use App\Models\Functionality\CurrencyExchange;

class Components {

    // create CurrencyExchange using relevant class objects
    public static function createFXExchangeTable($FXExchangeDataFromDb): string
    {
        $FXExchangeTable = 
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

        foreach ($FXExchangeDataFromDb as $singleFXExchangeDataFromDb) {
                
            $FXExchangeObj = new CurrencyExchange($singleFXExchangeDataFromDb);
            
            $FXExchangeTable .= "<tr>
                <td> {$FXExchangeObj->getEffectiveDate()}</td>
                <td> {$FXExchangeObj->getCurrency()}</td>
                <td> {$FXExchangeObj->getCurrencyCode()}</td>
                <td>" . number_format($FXExchangeObj->getAmount(), 2, ',', ' ') . "</td>
                <td> {$FXExchangeObj->getTargetCurrency()}</td>
                <td> {$FXExchangeObj->getTargetCurrencyCode()}</td>
                <td>" . number_format($FXExchangeObj->getTargetAmount(), 2, ',', ' ') . "</td>
                <td> {$FXExchangeObj->getMidExRate()}</td>
                <td> {$FXExchangeObj->getTableNo()}</td>
                <td> {$FXExchangeObj->getTargetTableNo()}</td></tr>";
        }

        $FXExchangeTable .= '</tbody></table></div>';

    return $FXExchangeTable;
    }

    // create CurrencyExchangeRate reading from db and order inserting into db
    public function createExRateTable($ExRateDataFromDb): string
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
                
                //getting all the data from CurrencyExchangeRate obj.
                //to produce table content
                $exRateObj = new CurrencyExchangeRate($singleExRateData);
                
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
}



