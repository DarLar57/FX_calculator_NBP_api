<?php

require __DIR__ . '/app/initializing.php'; 
/*use App\DB;
use App\Models\DbOperations;
use App\Models\NbpApi;
use App\Controller\Controller;


require __DIR__ . '/app/classes/DB.php'; 
require __DIR__ . '/app/classes/model/DbOperations.php'; 
require __DIR__ . '/app/classes/model/ExchangeRatesTable.php'; 
require __DIR__ . '/app/classes/model/NbpApi.php'; 
require __DIR__ . '/app/classes/controller/Controller.php'; 
*/

$colsArr = $controller->getCurrencies();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"/>
    <link rel="stylesheet" href="app/public/css/style.css" type="text/css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="/js/script.js"></script>
    <title>Currency converter</title>
</head>
<body>
    <div class="container">
        <h1>Currency converter</h1>
        
        <form method="POST" action="inc/convert.php">
            <div class="mb-3">
                <label for="amount" class="form-label">Amount:</label>
                <input type="number" step="any" class="form-control" id="amount" name="amount" required>
            </div>
            
            <div class="mb-3">
                <label for="sourceCurrency" class="form-label">Source currency:</label>
                <select class="form-select" id="sourceCurrency" name="sourceCurrency" required>
                <?php
foreach($colsArr as $item) { ?>

<option type="radio" value=<?= '"' . $item . '"'; ?>><?= $item; ?></option>

<?php }; ?>
                  
                </select>
            </div>
            
            <div class="mb-3">
                <label for="targetCurrency" class="form-label">Target currency:</label>
                <select class="form-select" id="targetCurrency" name="targetCurrency" required>

                <?php
foreach($colsArr as $item) { ?>

<option type="radio" value=<?= '"' . $item . '"'; ?>><?= $item; ?></option>

<?php }; ?>
                 
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Convert</button>
        </form>
    </div>
    <div>
    <?php

//$controller->createExRateObj();
$controller->createExRateTable();

?>
    </div>
   </body>
</html>