wp.customize.controlConstructor['lwwb-radio-image'] = wp.customize.Control.extend({

	ready: function() {

		'use strict';

		var control = this;

		// Change the value
		this.container.on( 'change click', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}

});
