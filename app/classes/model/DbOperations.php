<?php

namespace App\Models;

use \App\DB;
use PDO;
use PDOException;

class DbOperations extends DB
{
    /********************************************************
    / Operations on CurrencyExchangeRate (NBP Tables)
    /********************************************************/
    
    // insert CurrencyExchangeRate obj. to db 'exchange_rates' table
    public function insertExRateDataToDb($exRateObj): void
    {
        try {
            $tableName = 'exchange_rates';
    
            $query = "INSERT INTO
                $tableName (
                    table_no,
                    effective_date,
                    currency,
                    currency_code,
                    mid_ex_rate
                    )
                    VALUES (
                        :table_no,
                        :effective_date,
                        :currency,
                        :currency_code,
                        :mid_ex_rate
                        )";
        
            $stmt = parent::$dbConn->prepare($query);
                    
            $stmt->execute([
                'table_no' => $exRateObj->getTableNo(),
                'effective_date' => $exRateObj->getEffectiveDate(),
                'currency' => $exRateObj->getCurrency(),
                'currency_code' => $exRateObj->getCurrencyCode(),
                'mid_ex_rate' => $exRateObj->getMidExRate()
            ]);
        } catch (PDOException $e) {
            $errorMessage = 'Error while sql operation: ' . $e->getMessage();
            error_log($errorMessage); 
            throw $e;
        }
    }

    // read all data from db 'exchange_rates' table
    public function readExRateDataFromDb(): array
    {
        try {
            $tableName = 'exchange_rates';
    
            $query = "SELECT DISTINCT * FROM $tableName";
        
            $stmt = parent::$dbConn->query($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;

        } catch (PDOException $e) {
            $errorMessage = 'Error while sql operation: ' . $e->getMessage();
            error_log($errorMessage); 
            throw $e;
        }
    }

    // read distinct data from db 'exchange_rates' table to use for
    // dynamic selection in the form
    public function getCurrencies(): array
    {
        try {
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

        } catch (PDOException $e) {
            $errorMessage = 'Error while sql operation: ' . $e->getMessage();
            error_log($errorMessage); 
            throw $e;
        }
    }

    // checking selected ex. rate in db to avoid double insert
    public function readSingleCurrExRateInDb($exRateObj) 
    {
        try {
            $currencyCode = $exRateObj->getCurrencyCode();
            $currencyTableNo = $exRateObj->getTableNo();
            $sql = "SELECT * FROM exchange_rates WHERE currency_code='$currencyCode' and table_no     ='$currencyTableNo'";
        
            $stmt = parent::$dbConn->query($sql);
            $stmt->fetchAll(PDO::FETCH_ASSOC);
            $rowCount = $stmt->rowCount();
                
            return $rowCount;
        } catch (PDOException $e) {
            $errorMessage = 'Error while sql operation: ' . $e->getMessage();
            error_log($errorMessage); 
            throw $e;
        }
    }

    // delete all NBP curr. ex. rates from db
    function deleteCurrExRateFromDb(): void 
    {
        try {
            $sql = "DELETE FROM exchange_rates";
            parent::$dbConn->query($sql);
        } catch (PDOException $e) {
            $errorMessage = 'Error while sql operation: ' . $e->getMessage();
            error_log($errorMessage); 
            throw $e;
        }
    }

    /********************************************************
    / Operations on CurrencyExchange (Calculator/Transaction)
    /********************************************************/
    
    // insert CurrencyExchange obj. to db 'currency_conversions' table
    public function insertCurrExDataToDb($currExchangeObj): void
    {
        try {
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
                    target_amount
                    )
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
                'table_no' => $currExchangeObj->getTableNo(),
                'target_table_no' => $currExchangeObj->getTargetTableNo(),
                'effective_date' => $currExchangeObj->getEffectiveDate(),
                'currency' => $currExchangeObj->getCurrency(),
                'currency_code' => $currExchangeObj->getCurrencyCode(),
                'mid_ex_rate' => $currExchangeObj->getMidExRate(),
                'amount' => $currExchangeObj->getAmount(),
                'target_currency' => $currExchangeObj->getTargetCurrency(),
                'target_currency_code' => $currExchangeObj->getTargetCurrencyCode(),
                'target_amount' => $currExchangeObj->getTargetAmount()
            ]);
            // redirect to the site with all conversion results
            header('Location: conversion_result.php');
        
        } catch (PDOException $e) {
            $errorMessage = 'Error while sql operation: ' . $e->getMessage();
            error_log($errorMessage); 
            throw $e;
        }
    } 

    // read all data from db 'currency_conversions' table
    public function readFXExchangeDataFromDb(): array
    {
        try {
            $tableName = 'currency_conversions';

            $query = "SELECT * FROM $tableName";
    
            $stmt = parent::$dbConn->query($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            $errorMessage = 'Error while sql operation: ' . $e->getMessage();
            error_log($errorMessage); 
            throw $e;
        }
    }
}

