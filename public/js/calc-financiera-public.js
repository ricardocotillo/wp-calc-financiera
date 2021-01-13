(function( $ ) {
  'use strict';
  // Change text in gains box
  function changeGainsText(v, type) {
    let period;
    if (type === 0) {
      period = v > 1 ? 'años' : 'año';
    } else {
      period = v > 1 ? 'meses' : 'mes';
    }
    $('#calculadora-financiera .ganancia h6').text(`En ${v} ${period} ganarías`);
  }
  // End



  // Amount formatting function
  function formatToCurrency(value) {
    value = value.replace(/,/g, '');
    value = Number(value);
    value = value.toLocaleString('es-PE', {
      style: 'currency',
      currency: 'PEN',
      currencyDisplay: 'symbol',
      maximumFractionDigits: 0,
      minimumFractionDigits: 0,
    });
    return value;
  }
  // End

	$(function() {
    // Initial setup
    const years = [1, 2, 3, 4];
    const months = [3, 6, 9, 12];
    const periodSelect = $('#calculadora-financiera .periodo select');
    const typeInvest = $('#calculadora-financiera input[name="tipo"]');
    let type = 0;
    const amountInput = $('#amount-input');
    const step = Number(amountInput.data('step'));
    const min = Number(amountInput.data('min'));
    amountInput.val(formatToCurrency(amountInput.val()));
    // End

    // Unformat amount input on focus
    amountInput.focus(function(e) {
      this.value = this.value.split(/(\s+)/)[2];
      this.value = this.value.replace(/,/g, '');
    });
    // End

    // Reformat amount input on unfocus
    amountInput.focusout(function(e) {
      amountInput.val(formatToCurrency(amountInput.val()));
    });
    // End

    // Add or remove when amount btns are clicked
		$('.amount-btn').click(function(e) {
      let value = amountInput.val().split(/(\s+)/)[2];
      value = value.replace(/,/g, '');
      value = Number(value);
      if (this.id === 'add') {
        amountInput.val(formatToCurrency((value+step).toString()));
      } else if (value > min) {
        amountInput.val(formatToCurrency((value-step).toString()));
      }
    });
    // End

    // Change periods when types of investments change
    typeInvest.change(function(e) {
      if ($(this).val() === "1") {
        periodSelect.find('option').remove();
        months.forEach(function(el) {
          periodSelect.append(`<option ${el === 3 ? 'selected' : ''} value="${el}">${el} meses</option>`);
        });
        type = 1;
        changeGainsText(3, type);
      } else {
        periodSelect.find('option').remove();
        years.forEach(function(el) {
          periodSelect.append(`<option ${el === 1 ? 'selected' : ''} value="${el}">${el} año${el > 1 ? 's': ''}</option>`)
        });
        type = 0;
        changeGainsText(1, type);
      }
    });
    // End

    // Update gains box text when select changes
    periodSelect.change(function(e) {
      changeGainsText(Number($(this).val()), type);
    });
    // End
  });
})( jQuery );

