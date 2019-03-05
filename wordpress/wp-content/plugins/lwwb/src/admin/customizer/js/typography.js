wp.customize.controlConstructor['lwwb-typography'] = wp.customize.Control.extend({
	ready: function() {

		'use strict';

		var control = this;
		control.initTypography();
	},

	initTypography: function() {

		var control = this,

			value   = control.setting.get();

		const typographyData = [
			'font-family',
			'font-weight',
			'font-size',
			'line-height',
			'text-transform',
			'font-style',
			'text-decoration',
        ];

        // Upate on change keyup paste
		control.container.on('change keyup paste', 'input, select', function (event) {

			const field = jQuery(this);

            let dataKey = field.data('key');

            let val = field.val();

            if ( typographyData.indexOf(dataKey) > -1) {
                control.setValue( dataKey, val );
            }


        });
	},
	setValue: function( property, value ) {

        var control = this,
            hidden_input   = control.container.find('.typography-hidden-value'),
            val     = control.setting.get();

             val[ property ] = value;

        hidden_input.val( JSON.stringify( val ) ).trigger('change');
        control.setting.set( val );
    }

});