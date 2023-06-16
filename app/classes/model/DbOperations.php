<?php

namespace App\Models;

use \App\DB;
use PDO;

class DbOperations extends DB {

    public function insertExRateDataToDb($exRateObj)
    {
        $tableName = 'exchange_rates';
    
        $query = "INSERT INTO
            $tableName (table_no, effective_date, currency, currency_code, mid_ex_rate)
                VALUES (:table_no, :effective_date, :currency, :currency_code, :mid_ex_rate)";
    
        $stmt = parent::$dbConn->prepare($query);
    
        $tableNo = $exRateObj->getTableNo();
        $effectiveDate = $exRateObj->getEffectiveDate();
        $currency = $exRateObj->getCurrency();
        $currencyCode = $exRateObj->getCurrencyCode();
        $midExRate = $exRateObj->getMidExRate();
        
        $stmt->execute([
            'table_no' => $tableNo,
            'effective_date' => $effectiveDate,
            'currency' => $currency,
            'currency_code' => $currencyCode,
            'mid_ex_rate' => $midExRate
        ]);
    }

    public static function readExRateDataFromDb()
    {
        $tableName = 'exchange_rates';

        $query = "SELECT DISTINCT * FROM $tableName";
    
        $stmt = parent::$dbConn->query($query);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getCurrencies(): array
    {
        $tableName = 'exchange_rates';

        $query = "SELECT DISTINCT * 
                    FROM $tableName
                        ORDER BY currency ASC";
        $stmt = parent::$dbConn->query($query);
        $currencies = array();
        $currencies[] = ['currency' => 'polski złoty', 'currency_code' => 'PLN', 'mid_ex_rate' => 1, 'effective_date' => date("Y-m-d"), 'table_no' => 'no table exist as PLN/PLN is 1'];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $currencies[] = ['currency' => $row['currency'], 'currency_code' => $row['currency_code'], 'mid_ex_rate' => $row['mid_ex_rate'], 'effective_date' => $row['effective_date'], 'table_no' => $row['table_no']]; 
        }
        return $currencies;
    }
}