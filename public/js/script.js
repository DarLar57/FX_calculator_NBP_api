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
$(document).ready(function() {
    validateCurrencySelect();
});

function validateCurrencySelect() {
    var sourceCurrLabel = $("#labelSourceCurrency");
    var targetCurrLabel = $("#labelTargetCurrency");
    var selectedCurrency = $("#sourceCurrency").val();
  
    if (selectedTwoDifferentCurrencies() && selectedCurrency !== "") {
        sourceCurrLabel.html('Currency (source) & rate vs. PLN:');
        sourceCurrLabel.css("color", "black");
        targetCurrLabel.html('Currency (target) & rate vs. PLN:');
        targetCurrLabel.css("color", "black");
        $(".form-select:not(#amount)").css("border", "3px solid #68FF2C");
        $("#amount").css("border", "none");
    } else {
        sourceCurrLabel.html('<span class="invalid">Currency pair should not be the same</span>');
        sourceCurrLabel.css("color", "red");
        targetCurrLabel.html('<span class="invalid">Currency pair should not be the same</span>');
        targetCurrLabel.css("color", "red");
        $(".form-select:not(#amount)").css("border", "3px solid red");
        $("#amount").css("border", "none");
    }
}

//Amount validate, format on top of BE validation in Validate class
function validateAmount() {
    var amountInput = $("#amount");
    var labelAmount = $("#labelAmount");
    if (amountInput.get(0).checkValidity()) {
        labelAmount.html('Amount (source):');
        amountInput.removeClass("is-invalid").addClass("is-valid").css("border", "3px solid rgb(104, 255, 44)");
    } else {
      amountInput.removeClass("is-valid").addClass("is-invalid").css("border", "3px solid red");
      labelAmount.html('<span class="invalid">Amount should be digit, comma or dot</span>');
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