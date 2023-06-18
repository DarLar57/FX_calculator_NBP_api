<?php

use App\Controller\Controller;

require __DIR__ . '/../vendor/autoload.php';

$controller = new Controller();

$currencies = $controller->getCurrencies();

$errs = "";

// once FX conversion is submitted, CurrencyConversion class obj. is created
// and table with FX deals is listed
isset($_POST['submit']) && empty($errs = $controller->validate($_POST['amount'])) ?
    $controller->createCurrConversionObjAndInsert() : null;