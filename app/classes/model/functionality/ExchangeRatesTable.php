<?php

namespace App\Models\Functionality;
use App\Models\Currency;

class ExchangeRatesTable extends Currency
{
    public string $tableNo;  //table ref. for source curr.
    public string $effectiveDate; //table ref. for source curr.
    public float $midExRate; //mid ex. rate vs. PLN from NBP 

    public function __construct($args=[])
    {
        $this->tableNo = $args['table_no'];
        $this->effectiveDate = $args['effective_date'];
        $this->currency = $args['currency'];
        $this->currencyCode = $args['currency_code'];
        $this->midExRate = $args['mid_ex_rate'];
    }
    
    /* below getters for above variables (getters for curr. names and codes)
    are in parent abstact class - Currency */ 
    public function getTableNo(): string
    {
        return $this->tableNo;
    }

    public function getEffectiveDate(): string
    {
        return $this->effectiveDate;
    }

    public function getMidExRate(): float
    {
        return $this->midExRate;
    }
}