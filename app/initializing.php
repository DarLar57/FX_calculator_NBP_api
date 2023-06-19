<?php

use App\Controller\Controller;

require __DIR__ . '/../vendor/autoload.php';

$controller = new Controller();

$currencies = $controller->getCurrencies();

$errs = "";

//'Convert' btn clicked ? CurrencyExchange obj. is created & FX deals table is listed
isset($_POST['submit']) && empty($errs = $controller->validateAmount($_POST['amount'])) ?
    $controller->createCurrExObjAndInsert() : null;

// 'Get NBP FX rates' btn is clicked ? NBP API fn is called and FX tables are input in db
if (isset($_POST['NBPRatesBtn'])) {
    $controller->createCurrExRateObjAndInsert();
}

// submit btn to delete all NBP FX rates' from db
if (isset($_POST['NBPRatesBtnDel'])) {
    $controller->deleteCurrExRateFromDb();
}