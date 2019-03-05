wp.customize.controlConstructor['page_section'] = wp.customize.Control.extend({
	
	ready: function () {
		'use strict';
		const control = this;
		// Change the value
		const inputControl = control.container.find('.dataControls');
		let dataControl = inputControl.val();
	}
	
});