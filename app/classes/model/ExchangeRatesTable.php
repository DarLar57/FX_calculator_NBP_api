<?php

namespace App\Models;

class ExchangeRatesTable {

    
    public $tableNo;
    public $effectiveDate;
    public $currency;
    public $currencyCode;
    public $midExRate;

    public function __construct($args=[])
    {
        $this->tableNo = $args['table_no'];
        $this->effectiveDate = $args['effective_date'];
        $this->currency = $args['currency'];
        $this->currencyCode = $args['currency_code'];
        $this->midExRate = $args['mid_ex_rate'];
    }
    
    public function getTableNo()
    {
        return $this->tableNo;
    }

    public function getEffectiveDate()
    {
        return $this->effectiveDate;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    public function getMidExRate()
    {
        return $this->midExRate;
    }
}