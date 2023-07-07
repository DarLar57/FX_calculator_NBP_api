<?php

require __DIR__ . '/app/initializing.php'; 
require __DIR__ . '/app/view/header.php'; 

?>

    <div class="row justify-content-center m-1">

<?php

if (!empty($controller)) {
    $controller->createFXExchangeTable();
}

?>

    </div>
</div>
<div class="col-md-1 m-4">
    <button class="btn btn-warning" id="submit" name="submit" type="submit" ><a href=index.php>Converter</button>
</div>
<?php

require __DIR__ . '/app/view/footer.php'; 

?>

</body>
</html>