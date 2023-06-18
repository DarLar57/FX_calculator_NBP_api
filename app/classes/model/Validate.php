<?php

namespace App\Models;

class Validate
{
    // on top of FE validation, BE checks if amount is empty or not a number
    // and provides with relevant message (it would be seen only in case
    // FE failed or hacked
    public function validateInput($amount): ?string
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
}