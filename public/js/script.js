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
  var sourceCurrLabel = document.getElementById("labelSourceCurrency");
  var targetCurrLabel = document.getElementById("labelTargetCurrency");

    if (selectedTwoDifferentCurrencies()) {
        sourceCurrLabel.textContent = 'Currency (source) & rate vs. PLN:';
        sourceCurrLabel.style.color = 'black';
        targetCurrLabel.textContent = 'Currency (target) & rate vs. PLN:';
        targetCurrLabel.style.color = 'black';
    } else {
      sourceCurrLabel.innerHTML = '<span class="invalid">Currency pair should not be the same</span>';
        sourceCurrLabel.style.color = 'red';
        sourceCurr.style.backgroundColor = "red";
        targetCurrLabel.innerHTML = '<span class="invalid">Currency pair should not be the same</span>';
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
      sourceCurrLabel.innerHTML = '<span class="invalid">Currency pair should not be the same</span>';
      targetCurrLabel.innerHTML = '<span class="invalid">Currency pair should not be the same</span>';
      targetCurrLabel.style.color = 'red';
      targetCurrLabel.style.color = 'red';
      } else {
          sourceCurr.style.backgroundColor = "gray";
          targetCurr.style.backgroundColor = "gray";
      }
  });
});