lwwb.Control.Wp['slider'] = {
    $control: null,
    init: function($ctr) {
        const self = this;
        self.$control = $ctr ? $ctr : $(document);
        self.$control.find('.lwwb-control-lwwb-modal').each(function() {
            let reset = $(this).find('.lwwb-reset-control');
            reset.on('click', function(event) {
                event.preventDefault();
                input.val(resetData);
                slider.val(resetData);
            });
        });
    }
}
