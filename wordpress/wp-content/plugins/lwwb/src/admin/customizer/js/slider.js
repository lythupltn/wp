wp.customize.controlConstructor['lwwb-slider'] = wp.customize.Control.extend({
    ready: function() {
        var control = this;
        var resetBtn = control.container.find('.lwwb-reset-slider'),
            input = control.container.find('input'),
            resetData = control.container.find('input.lwwb-slider').data('reset_value');
        resetBtn.on('click', function(event) {
            event.preventDefault();
            input.val(resetData);
        });
    }
});