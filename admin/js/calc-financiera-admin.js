(function ($) {
  'use strict';
  const exportBtn = $('#export-btn');
  $('.custom_date').datepicker({
    dateFormat: 'yy-mm-dd',
  });
  let desde = $('#desde').val();
  let hasta = $('#hasta').val();
  let tipo = $('#tipo-de-solicitud').val();
  $('#desde').change(function () {
    desde = $(this).val();
  });
  $('#hasta').change(function () {
    hasta = $(this).val();
  });
  $('#tipo-de-solicitud').change(function () {
    tipo = $(this).val();
  });
  exportBtn.click(function (e) {
    e.preventDefault();
    let url = exportBtn.attr('href');
    url = url.split('?')[0];
    url = `${url}?action=csv_export&tipo_de_solicitud=${tipo}&desde=${desde}&hasta=${hasta}`;
    window.location.href = url;
  });
})(jQuery);
