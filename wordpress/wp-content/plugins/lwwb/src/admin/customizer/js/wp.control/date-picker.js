lwwb.Control.Wp['data-picker'] = {
    $control: null,
    init: function($ctr) {
        const self = this;
        self.$control = $ctr ? $ctr : $(document);

        self.$control.find('.lwwb-control-lwwb-date-picker input.datepicker').each( function() {
            $(this).datepicker();
        });
    }
}
