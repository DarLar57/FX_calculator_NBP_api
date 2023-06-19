<?php

namespace App\Models\Functionality;
use App\Models\Currency;

class CurrencyExchange extends Currency
{
    public string $tableNo; //table ref. for source curr.
    public string $targetTableNo; //table ref. for target curr.
    public string $effectiveDate; //table ref. for source curr.
    public float $midExRate; //mid ex. rate vs. PLN from NBP 
    public float $amount; //source amount
    public string $targetCurrency; //target curr.
    public string $targetCurrencyCode; //target curr. code
    public float $targetAmount; //target amount

    public function __construct($args=[])
    {
        $this->tableNo = $args['table_no'];
        $this->targetTableNo = $args['target_table_no'];
        $this->effectiveDate = $args['effective_date'];
        $this->currency = $args['currency'];
        $this->currencyCode = $args['currency_code'];
        $this->midExRate = $args['mid_ex_rate'];
        $this->amount = $args['amount'];
        $this->targetCurrency = $args['target_currency'];
        $this->targetCurrencyCode = $args['target_currency_code'];
        $this->targetAmount = $args['target_amount'];
    }

    /* below getters for above variables (getters for curr. names and codes)
    are in parent abstact class - Currency */ 
    public function getTableNo(): string
    {
        return $this->tableNo;
    }

    public function getTargetTableNo(): string
    {
        return $this->targetTableNo;
    }

    public function getEffectiveDate(): string
    {
        return $this->effectiveDate;
    }

    public function getMidExRate(): float
    {
        return $this->midExRate;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
    public function getTargetCurrency(): string
    {
        return $this->targetCurrency;
    }

    public function getTargetCurrencyCode(): string
    {
        return $this->targetCurrencyCode;
    }

    public function getTargetAmount(): float
    {
        return $this->targetAmount;
    }
}