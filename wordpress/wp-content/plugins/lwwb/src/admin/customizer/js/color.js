wp.customize.controlConstructor['lwwb-color-picker'] = wp.customize.Control.extend({

	ready: function() {

		'use strict';

		var control = this;

		lwwb.Control.Wp['color-picker'].init(control.container);
	}

});
