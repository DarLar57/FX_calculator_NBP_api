<?php

namespace App\Models;

abstract class Currency
{
    public string $currency;
    public string $currencyCode;

    /* repeated variables in other 2 main classes 
    (CurrencyConversion and CurrencyConversion) are not included although
    are currently reusable, bacause of future possibility to extend the project usability 
    for other tables (e.g. C etc.) and type of transactions */

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }
}