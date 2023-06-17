<?php

require __DIR__ . '/app/initializing.php'; 
require __DIR__ . '/app/templates/common/header.php'; 

?>

<div id="form_container">

    <div class="row ms-2">
        <div class="col-md-3 me-5">
        <form class="row g-3 was-validated" id="formConvertFX" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <div class="mb-3">
            <label class="form-label" for="amount" >Amount (source):</label>
            <input type="number" class="form-control" id="amount" name="amount" value="<?= $_POST['amount'] ?? ''; ?>" required pattern="([1-9]+)|([1-9][0-9]+)|([0-9]+[\.]{1}[0-9]{1,2})|([\.]{1}[0-9]{1,2})" >
            <label class="form-label" for="sourceCurrency">Currency (source) & rate vs. PLN:</label>
            <select class="form-select" id="sourceCurrency" name="sourceCurrency" required>

<?php foreach($currencies as $curr) { ?>

            <option value= "<?php echo htmlspecialchars(serialize($curr)); ?>">
            <?= $curr['currency'] . " (" . $curr['currency_code']. ") - (" . $curr['mid_ex_rate']. ")"; ?>
            </option>

<?php }; ?>
            </select>
            <label class="form-label" for="targetCurrency">Currency (target) & rate vs. PLN:</label>
            <select class="form-select" id="targetCurrency" name="targetCurrency" required>

<?php foreach($currencies as $curr) { ?>

            <option value= "<?php echo htmlspecialchars(serialize($curr)); ?>">
            <?= $curr['currency'] . " (" . $curr['currency_code']. ") - (" . $curr['mid_ex_rate']. ")"; ?>
            </option>

<?php }; ?>
                 
            </select>  
        <button class="btn btn-primary" id="submit" name="submit" type="submit" >Convert</button>
        </form>
            </div>
        </div>
<?php

//$controller->createExRateObjAndInsert();
$controller->createExRateTable();


?>
</div>
    </div>
<?php

require __DIR__ . '/app/templates/common/footer.php'; 

?>

</body>
</html>