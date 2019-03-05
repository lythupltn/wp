jQuery(document).ready(function($) {
    // lwwb.Control['icon-picker'].init();
    // lwwb.Control['image'].init();
    // lwwb.Control['dimensions'].init();
    // lwwb.Control['responsive-switcher'].init();
    // lwwb.Control['color-picker'].init();
    // lwwb.Control['date-picker'].init();
    // lwwb.Control['select2'].init();
    // lwwb.Control['slider'].init();
    // lwwb.Control['wysiwyg'].init();
    lwwb.Control.Wp['responsive-switcher'].init();

});

(function( api, $ ) {
	api.bind('ready', function() {
	    api.control('setting_switcher', function(control) {
	        $(control.selector).on('click', 'input.lwwb-input', function(event) {

	            let currentControl,
	                otherControl;

	            currentControl = $(this).val();

	            _.map(control.params.choices, function(value, key) {
	                if (api.control(key) && key !== currentControl) {
	                    api.control(key).active(false);
	                }
	            });

	            if (api.control(currentControl)){
	            	api.control(currentControl).active(true);
	            }
	        });
	    });
	});

})(wp.customize, jQuery);
