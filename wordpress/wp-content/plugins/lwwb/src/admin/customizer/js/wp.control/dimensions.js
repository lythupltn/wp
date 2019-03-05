lwwb.Control.Wp['dimensions'] = {
    $control: null,
    init: function($ctr) {
        const self = this;
        self.$control = $ctr ? $ctr : $(document);
        self.$control.on('click', '.lwwb-control-lwwb-dimensions .lwwb-linked', function(event) {
            event.preventDefault();
            const target = $(event.target),
                siblingsLink = target.siblings('.lwwb-unlinked'),
                parent = target.parents('.control-wrapper');
            target.hide();
            siblingsLink.css('display', 'block');
            parent.find('.dimension-wrapper').addClass('unlinked');
            parent.find('.dimension-wrapper').removeClass('linked');
            parent.find('input.lwwb-input').each(function() {
                let $input = $(this);
                if ($input.val() === '') {
                    $input.val('0');
                }
            })
        });
        self.$control.on('click', '.lwwb-control-lwwb-dimensions .lwwb-unlinked', function(event) {
            event.preventDefault();
            const target = $(event.target),
                siblingsLink = target.siblings('.lwwb-linked'),
                parent = target.parents('.control-wrapper');
            target.hide();
            siblingsLink.css('display', 'block');
            parent.find('.dimension-wrapper').addClass('linked');
            parent.find('.dimension-wrapper').removeClass('unlinked');
        });
        self.$control.on('click', '.lwwb-control-lwwb-unit input.lwwb-input', function(event) {
            let unit = $(this).val();
            let min = $(this).data('min');
            let max = $(this).data('max');
            let step = $(this).data('step');
            let dimensionInputs = self.$control.find('.dimension-wrapper input.lwwb-input');
            dimensionInputs.each(function(key, input) {
                $(input).attr('min', min);
                $(input).attr('max', max);
                $(input).attr('step', step);
            })
        });
    },
}