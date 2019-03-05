lwwb.Control.Wp['select2'] = {
    $control: null,
    init: function($ctr) {
        const self = this;
        self.$control = $ctr ? $ctr : $(document);
        self.$control.find('.lwwb-control-lwwb-select2 select').each( function() {
            $(this).select2();
        });
    }
}
