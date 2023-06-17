//searching any string (input in the form ) from the table 
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

//validate currency pair
function validateCurrencySelect() {
  
  var sourceCurr = document.getElementById("sourceCurrency");
  var targetCurr = document.getElementById("targetCurrency");
  

    if (selectedTwoDifferentCurrencies()) {
        sourceCurrLabel.textContent = 'Currency (source) & rate vs. PLN:';
        sourceCurrLabel.style.color = 'black';var sourceCurrLabel = document.getElementById("labelSourceCurrency");
  var targetCurrLabel = document.getElementById("labelTargetCurrency");
        targetCurrLabel.textContent = 'Currency (target) & rate vs. PLN:';
        targetCurrLabel.style.color = 'black';
    } else {
        sourceCurrLabel.textContent = 'Currency pair should not be the same';
        sourceCurrLabel.style.color = 'red';
        sourceCurr.style.backgroundColor = "red";
        targetCurrLabel.textContent = 'Currency pair should not be the same';
        targetCurrLabel.style.color = 'red';
        targetCurr.style.backgroundColor = "red";
    }
}

// For new / updated employee to prevent form submit if pasel invalid
$(document).ready(function() {
  $('#formConvertFX').submit(function(event) {
    if (!selectedTwoDifferentCurrencies()) {
      event.preventDefault();
      var sourceCurr = document.getElementById("sourceCurrency");
      var targetCurr = document.getElementById("targetCurrency");
      var sourceCurrLabel = document.getElementById("labelSourceCurrency");
      var targetCurrLabel = document.getElementById("labelTargetCurrency");
      sourceCurr.style.backgroundColor = "red";
      targetCurr.style.backgroundColor = "red";
      targetCurrLabel.textContent = 'Currency pair should not be the same';
      targetCurrLabel.style.color = 'red';
      } else {
          sourceCurr.style.backgroundColor = "gray";
          targetCurr.style.backgroundColor = "gray";
      }
  });
});
/*
$(document).ready(function() {
    $("#formConvertFX").on("submit", function() {
      $(this).trigger("reset");
    });
  });*/
// not to allow improper inserting of Currency Pairs
/*function check_currency() {
if (
    document.getElementById("sourceCurrency").value ==
    document.getElementById("targetCurrency").value
  ) 
    {document.getElementById("sourceCurrency").style.borderColor = "rgb(255,100,0)";
    document.getElementById("targetCurrency").style.borderColor = "rgb(255,100,0)";}
    else {
    document.getElementById("sourceCurrency").style.borderColor = "rgb(0,255,0,0.5)";
    document.getElementById("targetCurrency").style.borderColor = "rgb(0,255,0,0.5)";
    }
}*/
/*
var form = document.getElementById("formConvertFX");
form.addEventListener("submit", function(event) {
  event.preventDefault(); // Prevent form submission

  var sourceCurr = document.getElementById("sourceCurrency");
  var targetCurr = document.getElementById("targetCurrency");
  var sourceCurrLabel = document.getElementById("labelSourceCurrency");
  var targetCurrLabel = document.getElementById("labelTargetCurrency");

  if (sourceCurr.value == targetCurr.value) {
    sourceCurr.style.backgroundColor = "red";
    targetCurr.style.backgroundColor = "red";
    sourceCurrLabel.innerHTML += '<span class="error-label"> Values can\'t be the same</span>';
    targetCurrLabel.innerHTML += '<span class="error-label"> Values can\'t be the same</span>';
    return;
  }

  // Validation passed, submit the form
  form.submit();
});*/