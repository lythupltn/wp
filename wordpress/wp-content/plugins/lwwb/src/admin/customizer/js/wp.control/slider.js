lwwb.Control.Wp['slider']= {
    $control: null,
    init: function($ctr) {
        const self = this;
        self.$control = $ctr ? $ctr : $(document);
        self.$control.find('.lwwb-control-lwwb-slider .control-wrapper').each(function() {
            let slider = $(this).find('input.lwwb-slider');
            let input = $(this).find('input.lwwb-input');
            let reset = $(this).find('.lwwb-reset-control');
            let resetData = input.data('reset_value');
            slider.bind('input', function(event) {
                input.val($(event.currentTarget).val()).change();
                slider.val($(event.currentTarget).val()).change();
            });
            reset.on('click', function(event) {
                event.preventDefault();
                input.val(resetData).change();
                slider.val(resetData).change();
            });
        });


        self.$control.on('click', '.lwwb-control-lwwb-unit input.lwwb-input', function(event) {
            let unit = $(this).val();
            let device = $(this).data('device');
            let min = $(this).data('min');
            let max = $(this).data('max');
            let step = $(this).data('step');
            let sliderInputs = $(this).parents('.lwwb-control-header').first().next().find('.device-wrapper.'+device + ' input');
            sliderInputs.each(function(key, input) {
                    $(input).attr('min', min);
                    $(input).attr('max', max);
                    $(input).attr('step', step);
            })
        });
    }
}
