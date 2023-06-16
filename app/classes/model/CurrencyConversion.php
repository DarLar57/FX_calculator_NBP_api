<?php

namespace App\Models;

class CurrencyConversion {

    public $tableNo;
    public $effectiveDate;
    public $currency;
    public $currencyCode;
    public $midExRate;
    public $amount;
    public $targetCurrency;
    public $targetCurrencyCode;
    public $targetAmount;

    public function __construct($args=[])
    {
        $this->tableNo = $args['table_no'];
        $this->effectiveDate = $args['effective_date'];
        $this->currency = $args['currency'];
        $this->currencyCode = $args['currency_code'];
        $this->midExRate = $args['mid_ex_rate'];
        $this->amount = $args['amount'];
        $this->targetCurrency = $args['target_currency'];
        $this->targetCurrencyCode = $args['target_currency_code'];
        $this->targetAmount = $args['target_amount'];
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

    public function getAmount()
    {
        return $this->amount;
    }
    public function getTargetCurrency()
    {
        return $this->targetCurrency;
    }

    public function getTargetCurrencyCode()
    {
        return $this->targetCurrencyCode;
    }

    public function getTargetAmount()
    {
        return $this->targetAmount;
    }
}