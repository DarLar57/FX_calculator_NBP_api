<?php

namespace App\Models;

use \App\DB;
use PDO;

class DbOperations extends DB
{
    // insert ExchangeRatesTable obj. to db 'exchange_rates' table
    public function insertExRateDataToDb($exRateObj): void
    {
        $tableName = 'exchange_rates';
    
        $query = "INSERT INTO
            $tableName (table_no, effective_date, currency, currency_code, mid_ex_rate)
                VALUES (:table_no, :effective_date, :currency, :currency_code, :mid_ex_rate)";
    
        $stmt = parent::$dbConn->prepare($query);
            
        $stmt->execute([
            'table_no' => $exRateObj->getTableNo(),
            'effective_date' => $exRateObj->getEffectiveDate(),
            'currency' => $exRateObj->getCurrency(),
            'currency_code' => $exRateObj->getCurrencyCode(),
            'mid_ex_rate' => $exRateObj->getMidExRate()
        ]);
    }

    // read all data from db 'exchange_rates' table
    public function readExRateDataFromDb(): array
    {
        $tableName = 'exchange_rates';

        $query = "SELECT DISTINCT * FROM $tableName";
    
        $stmt = parent::$dbConn->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    // read distinct data from db 'exchange_rates' table to use for
    // dynamic selection in the form
    public function getCurrencies(): array
    {
        $tableName = 'exchange_rates';

        $query = "SELECT DISTINCT 
            currency,
            currency_code,
            mid_ex_rate,
            effective_date,
            table_no
                FROM $tableName
                    ORDER BY currency ASC";

        $stmt = parent::$dbConn->query($query);

        // array to retrive all relevant data in the selection form plus PLN
        // data that are not included in NBP table

        $currencies[] = [
            'currency' => 'polski złoty',
            'currency_code' => 'PLN',
            'mid_ex_rate' => 1,
            'effective_date' => date("Y-m-d"),
            'table_no' => 'n/a as PLN/PLN is 1'
        ];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $currencies[] = [
                'currency' => $row['currency'],
                'currency_code' => $row['currency_code'],
                'mid_ex_rate' => $row['mid_ex_rate'],
                'effective_date' => $row['effective_date'],
                'table_no' => $row['table_no']
            ]; 
        }
        return $currencies;
    }

    // insert CurrencyConversion obj. to db 'currency_conversions' table
    public function insertCurrConversionDataToDb($currConversionObj): void
    {
        $tableName = 'currency_conversions';
    
        $query = "INSERT INTO
            $tableName (
                table_no,
                target_table_no,
                effective_date,
                currency,
                currency_code,
                mid_ex_rate,
                amount,
                target_currency,
                target_currency_code,
                target_amount)
                    VALUES (
                        :table_no,
                        :target_table_no,
                        :effective_date,
                        :currency,
                        :currency_code,
                        :mid_ex_rate,
                        :amount,
                        :target_currency,
                        :target_currency_code,
                        :target_amount)";
    
        $stmt = parent::$dbConn->prepare($query);
    
        $stmt->execute([
            'table_no' => $currConversionObj->getTableNo(),
            'target_table_no' => $currConversionObj->getTargetTableNo(),
            'effective_date' => $currConversionObj->getEffectiveDate(),
            'currency' => $currConversionObj->getCurrency(),
            'currency_code' => $currConversionObj->getCurrencyCode(),
            'mid_ex_rate' => $currConversionObj->getMidExRate(),
            'amount' => $currConversionObj->getAmount(),
            'target_currency' => $currConversionObj->getTargetCurrency(),
            'target_currency_code' => $currConversionObj->getTargetCurrencyCode(),
            'target_amount' => $currConversionObj->getTargetAmount()
        ]);
        // redirect to the site with all conversion results
        header('Location: conversion_result.php');
    } 

    // read all data from db 'currency_conversions' table
    public function readFXConversionDataFromDb(): array
    {
        $tableName = 'currency_conversions';

        $query = "SELECT * FROM $tableName";
    
        $stmt = parent::$dbConn->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}