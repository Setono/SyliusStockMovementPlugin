(function($) {
  $('#filters a[data-form-collection="add"]').on('click', () => {
    setTimeout(() => {
      $('select[name^="setono_sylius_stock_movement_report_configuration[filters]"][name$="[type]"]').last().change();
    }, 50);
  });

  $('#transports a[data-form-collection="add"]').on('click', () => {
    setTimeout(() => {
      $('select[name^="setono_sylius_stock_movement_report_configuration[transports]"][name$="[type]"]').last().change();
    }, 50);
  });
})(jQuery);
