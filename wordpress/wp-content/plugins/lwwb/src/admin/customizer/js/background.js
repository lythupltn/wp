wp.customize.controlConstructor['lwwb-background'] = wp.customize.Control.extend({
	ready: function() {

		'use strict';

		var control = this;
        control.initDependencies();
		control.initBackgroundControl();
	},

	initBackgroundControl: function() {

		var control = this,

			value   = control.setting.get();

			const imageData = [

				'background-type-normal', 
				'background-color-normal',
        		'background-image-normal',
                'background-position-normal',
            	'background-attachment-normal',
            	'background-repeat-normal',
            	'background-size-normal',
            	'gradient-first-color-normal',
            	'gradient-first-color-location-normal',
            	'gradient-second-color-normal',
            	'gradient-second-color-location-normal',
            	'gradient-type-normal',
            	'background-angle-normal',

            	'video-url',
            	'video-start-timme',
            	'video-end-timme',
            	'video-background-falback',

				'background-type-hover',
				'background-color-hover',
        		'background-image-hover',
                'background-position-hover',
            	'background-attachmentn-hover',
            	'background-repeat-hover',
            	'background-size-hover',
            	'gradient-first-color-hover',
            	'gradient-first-color-location-hover',
            	'gradient-second-color-hover',
            	'gradient-second-color-location-hover',
            	'gradient-type-hover',
            	'background-angle-hover',
        ];

        // Upate on change keyup paste
		control.container.on('change keyup paste', 'input, select, checkbox', function (event) {

			const field = jQuery(this);

            let dataKey = field.data('key');

            let val = field.val();

            if ( 'checkbox' === field.attr("type") ) {
                val = field.is(":checked") ? 'true' : 'false';
            }

            if ( 'background-image-normal' == dataKey || 'background-image-hover' == dataKey) {

                control.backgroundImageDependencies();

            }

            if ( imageData.indexOf(dataKey) > -1) {
                control.setValue( dataKey, val );
            }


        });
	},

    initDependencies: function() {
        var control = this,
            $stateControls = control.container.find('.background-control-state'),
            state = 'normal',
            type = 'classic',
            $typeControls = control.container.find("[class*='lwwb-background-controls-']");

            control.container.find('.lwwb-background-controls-hover').hide();
            control.container.find('.lwwb-background-controls-' + state + ' .background-control.video').hide();
            control.container.find('.lwwb-background-controls-' + state + ' .background-control.gradient').hide();

            $stateControls.on('change', 'input', function(event) {

                event.preventDefault();
                state = $(this).val();
                control.container.find("[class*='lwwb-background-controls-']").hide();
                control.container.find('.lwwb-background-controls-' + state).show();

            });

            $typeControls.on('change', '.background-control-type input', function(event) {

                event.preventDefault();
                type = $(this).val();

                control.container.find('.lwwb-background-controls-' + state + ' .background-control').hide();
                control.container.find('.lwwb-background-controls-' + state + ' .background-control.' + type).show();
                

            });

            control.backgroundImageDependencies();


    },
    backgroundImageDependencies: function(){
        var control = this;
        var backgroundImage = control.container.find("[class*='background-image']");

            backgroundImage.each(function(){

                var backgroundPosition = $(this).siblings("[class*='background-position']"),
                backgroundAttachment = $(this).siblings("[class*='background-attachment']"),
                backgroundRepeat = $(this).siblings("[class*='background-repeat']"),
                backgroundSize = $(this).siblings("[class*='background-size']");


                if ( $(this).find('.thumbnail').length == 0 ) {

                    backgroundPosition.hide();
                    backgroundAttachment.hide();
                    backgroundRepeat.hide();
                    backgroundSize.hide();

                }else{

                    backgroundPosition.show();
                    backgroundAttachment.show();
                    backgroundRepeat.show();
                    backgroundSize.show();

                }

        });

    },
	setValue: function( property, value ) {

        var control = this,
            hidden_input   = control.container.find('.background-hidden-value'),
            val     = control.setting.get();

             val[ property ] = value;

        hidden_input.val( JSON.stringify( val ) ).trigger('change');

        control.setting.set( val );

    }

});
