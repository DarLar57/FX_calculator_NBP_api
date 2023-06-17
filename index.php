<?php

require __DIR__ . '/app/initializing.php'; 
require __DIR__ . '/app/templates/common/header.php'; 

?>

<div id="form_container">

    <div class="row ms-2">
        <div class="col-md-3 me-4">
        <form class="row g-3 was-validated" id="formConvertFX" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <div class="mb-3">
            <label class="form-label" for="amount" >Amount (source):</label>
            <input type="text" class="form-control" id="amount" name="amount" value="<?= $_POST['amount'] ?? ''; ?>" required pattern="^\d+(.\d{1,2})?$" >
            <label id="labelSourceCurrency" for="sourceCurrency">Currency (source) & rate vs. PLN:</label>
            <select class="form-select" id="sourceCurrency" name="sourceCurrency"  onchange="validateCurrencySelect()" onclick="validateCurrencySelect()" required>

<?php foreach($currencies as $curr) { ?>

            <option value= "<?php echo htmlspecialchars(serialize($curr)); ?>">
            <?= $curr['currency'] . " (" . $curr['currency_code']. ") - (" . $curr['mid_ex_rate']. ")"; ?>
            </option>

<?php }; ?>
            </select>
            <label id="labelTargetCurrency" for="targetCurrency">Currency (target) & rate vs. PLN:</label>
            <select class="form-select" id="targetCurrency" name="targetCurrency"  onchange="validateCurrencySelect()" onclick="validateCurrencySelect()" required>

<?php foreach($currencies as $curr) { ?>

            <option value= "<?php echo htmlspecialchars(serialize($curr)); ?>">
            <?= $curr['currency'] . " (" . $curr['currency_code']. ") - (" . $curr['mid_ex_rate']. ")"; ?>
            </option>

<?php }; ?>
                 
            </select>  
        <button class="btn btn-warning" for="formConvertFX" id="submit" name="submit" type="submit" >Convert</button>
        <button class="btn btn-info" id="" name="" type="" ><a href=\conversion_result.php>Executed FX</button></a>

        </form>

            </div>
            <div id="NBPRatesBtn">

            </div>
        </div>
        <div row class="col-md-7">
            <div class="row">
                
        <form id="NBPRatesForm" method="POST">
        <button class="btn btn-primary" id="NBPRatesBtn" name="NBPRatesBtn" for="NBPRatesForm" onclick="">Get NBP FX rates</button>
        </form>
        </div>
<?php

$controller->createExRateTable();

?>
</div>
</div>

    </div></div>
<?php

require __DIR__ . '/app/templates/common/footer.php'; 

?>

</body>
</html>

<?php

if (isset($_POST['NBPRatesBtn'])) {
    $controller->createExRateObjAndInsert();
    header('Location: index.php');
}

?>