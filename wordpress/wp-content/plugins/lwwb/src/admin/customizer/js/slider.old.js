jQuery( document ).ready(
	function( $ ) {
		$('.lwwb-slider-control-wrapper').each( function() {

				'use strict';

				var $range_control = $(this),
					// control = this,
					range,
					range_input,
					value,
					this_input,
					input_default,
					changeAction,
					lwwb_range_input_number_timeout;

				// Update the text value
				$range_control.find( 'input[type=range]' ).on( 'mousedown', function() {

					range 			= $( this );
					range_input 	= $range_control.find( '.lwwb-range-input' );
					value 			= range.attr( 'value' );

					range_input.val( value );

					range.mousemove( function() {
						value = range.attr( 'value' );
						range_input.val( value ).change();
					} );

				} );

				// Auto correct the number input
				function lwwb_autocorrect_range_input_number( input_number, timeout ) {

					var range_input 	= input_number,
						range 			= range_input.parent().find( 'input[type="range"]' ),
						value 			= parseFloat( range_input.val() ),
						reset 			= parseFloat( range.attr( 'data-reset_value' ) ),
						step 			= parseFloat( range_input.attr( 'step' ) ),
						min 			= parseFloat( range_input.attr( 'min') ),
						max 			= parseFloat( range_input.attr( 'max') );

					clearTimeout( lwwb_range_input_number_timeout );

					lwwb_range_input_number_timeout = setTimeout( function() {

						if ( isNaN( value ) ) {
							range_input.val( reset );
							range.val( reset ).trigger( 'change' );
							return;
						}

						if ( step >= 1 && value % 1 !== 0 ) {
							value = Math.round( value );
							range_input.val( value );
							range.val( value );
						}

						if ( value > max ) {
							range_input.val( max );
							range.val( max ).trigger( 'change' );
						}

						if ( value < min ) {
							range_input.val( min );
							range.val( min ).trigger( 'change' );
						}

					}, timeout );

					range.val( value ).trigger( 'change' );

				}

				// Change the text value
				$range_control.find( 'input.lwwb-range-input' ).on( 'change keyup', function() {

					lwwb_autocorrect_range_input_number( $( this ), 1000);

				} ).on( 'focusout', function() {

					lwwb_autocorrect_range_input_number( $( this ), 0);

				} );

				// Handle the reset button
				$range_control.find( '.lwwb-reset-slider' ).on('click', function() {

					this_input 		= $range_control.find( 'input' );

					input_default 	= this_input.data( 'reset_value' );

					input_default = input_default || '';

					this_input.val( input_default );

					this_input.change();

				} );

				// if ( 'postMessage' === control.setting.transport ) {
				// 	changeAction = 'mousemove change';
				// } else {
				// 	changeAction = 'change';
				// }

				// // Change the value
				// this.container.on( changeAction, 'input', function() {
				// 	control.setting.set( $( this ).val() );
				// });

		});
});
		
