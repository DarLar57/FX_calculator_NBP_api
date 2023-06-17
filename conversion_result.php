<?php

require __DIR__ . '/app/initializing.php'; 
require __DIR__ . '/app/templates/common/header.php'; 

?>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-8">
      <table class="table table-bordered">
<?= $controller->createFXConversionTable(); ?>
      </table>
    </div>
  </div>
</div>

<?php

require __DIR__ . '/app/templates/common/footer.php'; 

?>

</body>
</html>