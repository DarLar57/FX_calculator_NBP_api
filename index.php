<?php

require __DIR__ . '/app/initializing.php'; 
require __DIR__ . '/app/templates/common/header.php'; 

$currencies = $controller->getCurrencies();


?>

<header class="container text-center bg-primary text-white pb-3 p-2 fs-3">
    FX converter with NBP tables (API)
</header>
<div id="form_container">
    <div class="row">
        <div class="col-md-3 me-5">
        <form id="item_list" class="row g-3 was-validated" method="POST" action="">
            <div class="mb-3">
            <label class="form-label" for="amount" >Amount:</label>
            <input type="number" step="any" class="form-control" id="amount" name="amount" pattern="([1-9]+)|([1-9][0-9]+)|([0-9]+[\.]{1}[0-9]{1,2})|([\.]{1}[0-9]{1,2})" required>
            <label class="form-label" for="sourceCurrency">Source currency:</label>
            <select class="form-select" id="sourceCurrency" name="sourceCurrency" required>

<?php foreach($currencies as $curr) { ?>

            <option value= <?= json_encode($curr); ?>>
            <?= $curr['currency'] . " (" . $curr['currency_code']. ") - (" . $curr['mid_ex_rate']. ")"; ?>
            </option>

<?php }; ?>
            </select>
            <label class="form-label" for="targetCurrency">Target currency:</label>
            <select class="form-select" id="targetCurrency" name="targetCurrency" required>

<?php foreach($currencies as $curr) { ?>

            <option value= <?= json_encode($curr); ?>>
            <?= $curr['currency'] . " (" . $curr['currency_code']. ") - (" . $curr['mid_ex_rate']. ")"; ?>
            </option>

<?php }; ?>
                 
            </select>  
        <button class="btn btn-primary" type="submit">Convert</button>
        </form>
            </div>
        </div>
<?php

//$controller->createExRateObjAndInsert();
$controller->createExRateTable();
//isset($_POST['submit']) ? $controller->createCurrConversionObjAndInsert() : null;

?>
</div>
    </div>
<?php

require __DIR__ . '/app/templates/common/footer.php'; 

?>

</body>
</html>