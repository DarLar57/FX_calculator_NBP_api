<?php

use App\Controller\Controller;

require __DIR__ . '/../vendor/autoload.php';

$controller = new Controller();

$currencies = $controller->getCurrencies();

isset($_POST['submit']) ? $controller->createCurrConversionObjAndInsert() : null;