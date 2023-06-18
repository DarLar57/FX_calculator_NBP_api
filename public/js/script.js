//searching any string from the tables 
$(document).ready(function(){
    $("#inputFilter").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#table_report tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

//check if two Currency pair is not the same
function selectedTwoDifferentCurrencies() {
    var sourceCurr = document.getElementById("sourceCurrency");
    var targetCurr = document.getElementById("targetCurrency");
    return (sourceCurr.value != targetCurr.value)
}

//currency pair -> validate, format and create error messages before
//separate BE validation in Validate class
function validateCurrencySelect() {
  var sourceCurr = $("#sourceCurrency");
  var targetCurr = $("#targetCurrency");
  var sourceCurrLabel = $("#labelSourceCurrency");
  var targetCurrLabel = $("#labelTargetCurrency");

  if (selectedTwoDifferentCurrencies()) {
      sourceCurrLabel.html('Currency (source) & rate vs. PLN:');
      sourceCurrLabel.css("color", "black");
      targetCurrLabel.html('Currency (target) & rate vs. PLN:');
      targetCurrLabel.css("color", "black");
      $(".form-select").css("border", "5px solid #68FF2C");
      $("#amount").css("border", "5px solid #68FF2C");
  } else {
      sourceCurrLabel.html('<span class="invalid">Currency pair should not be the same</span>');
      sourceCurrLabel.css("color", "red");
      targetCurrLabel.html('<span class="invalid">Currency pair should not be the same</span>');
      targetCurrLabel.css("color", "red");
      $(".form-select").css("border", "5px solid red");
      $("#amount").css("border", "5px solid red");

  }
}
// ev. listener to prevent form submit if curr. pair are the same
$(document).ready(function() {
    $('#formConvertFX').submit(function(event) {
        if (!selectedTwoDifferentCurrencies()) {
            event.preventDefault();
          } 
    });
});