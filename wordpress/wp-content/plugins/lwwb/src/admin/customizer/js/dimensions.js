wp.customize.controlConstructor['lwwb-dimensions'] = wp.customize.Control.extend({
    ready: function() {
        'use strict';
        var control = this;
            lwwb.Control.Wp['dimensions'].init(control.container);
        control.container.on('change', 'input.lwwb-input', function(event) {
            let data_key = $(this).data('key');
            let val = $(this).val();
            if (data_key) {
                control.setValue(data_key, val);
            }
        });
    },
    setValue: function(property, value) {
        var control = this,
            hidden_input = control.container.find('.dimension-hidden-value'),
            val = control.setting.get();
        val[property] = value;
        hidden_input.val(JSON.stringify(val)).trigger('change');
        control.setting.set(val);
    }
});