<?php

namespace App\Models;

use App\Models\DbOperations;

class Validate
{
    // on top of FE validation, BE checks if amount is empty or not a number
    // and provides with relevant message (it would be seen only in case
    // FE failed or hacked
    public function validateAmount($amount): ?string
    {
        $err = "";
        
        if (trim($amount) == '') {
            $err = "<b class='errorMessage'> Amount is missing! </b>";
        } else {
            self::validateSpecChar($amount) ? $err = self::validateSpecChar($amount) : null;
        } 
        
        if (!empty($err)) {
            return $this->displayErrs($err);
        } else return null;
    }

    static function validateSpecChar($prop): ?string
    {
        $pattern = '/^\d+(?:[.,]\d{1,2})?$/'; 
        if (preg_match($pattern, $prop) === 0) {
            $err = "<b class='errorMessage'>Only numbers, comma or dot</b>";
            return $err;
        }   else return null;
    }

    // errors displayed on the right of amount label
    private function displayErrs($err): ?string
    {
        $display = '';
        if (!empty($err)) {
            $display = $err;
        }
        return $display;
    }

    // validate if any NBP ex. rate is already in db to avoid double insert
    public function isCurrExRateInDb($exRateObj): bool
    {
        $db_oper = new DbOperations;
        $isExRateDataInDb = $db_oper->readSingleCurrExRateInDb($exRateObj);
        
        if ($isExRateDataInDb > 0) {
            return true;
        } else {
            return false;
        }
    }
}