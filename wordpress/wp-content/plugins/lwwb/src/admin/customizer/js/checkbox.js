wp.customize.controlConstructor['lwwb-checkbox'] = wp.customize.Control.extend({
    ready: function() {
        'use strict';
        var control = this;
        var value = control.setting.get();

        if ('string' === typeof value) {
            	value = [value];
            }
        let hidden_input = control.container.find('.checkbox-hidden-value');

        control.container.on('change click', 'input.lwwb-input', function(event) {
            let val = $(this).val(),
            	exits = value.indexOf(val);

            if ($(this).is(':checked')) {
            	if (-1 >= exits) {
            		value.push(val);
            	}
            }else{
            	if (-1 < exits) {
            		value.splice(exits, 1);
            	}
            }
            hidden_input.val(JSON.stringify(value)).trigger('change');
            if(control.setting.multi){
                control.setting.set(JSON.stringify(value));
            }else{
                control.setting.set(value);
            }
        });
    }

});