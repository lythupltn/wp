(function ($) {
	$(document).ready(function () {
		// Menu
		// Check for click events on the navbar burger icon
		$('.lwwb-elmn-navigation .navbar-burger').click(function() {
			// Toggle the 'is-active' class on both the 'navbar-burger' and the 'navbar-menu'
			$('.navbar-burger').toggleClass('is-active');
			$('.navbar-menu').toggleClass('is-active');
			$('.lwwb-navigation').toggleClass('lwwb-mobile');
		});

		//video popup

		let dataLightbox = $('.lwwb-video-bg-overlay .lwwb-play-icon').attr('data-popup');

		if('yes' === dataLightbox){
			$('.lwwb-play-icon').magnificPopup({
				type: 'iframe',
				iframe: {
					markup: '<div class="mfp-iframe-scaler">'+
						'<div class="mfp-close"></div>'+
						'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
						'</div>'
				}
			});
		}else{
			$('.lwwb-play-icon').on('click',function (e) {
				e.preventDefault();
				$('.lwwb-video-bg-overlay').hide();
			});
			$('.lwwb-video-bg-overlay').on('click',function (e) {
				e.preventDefault();
				$('.lwwb-video-bg-overlay').hide();
			});
		}
		$('.lwwb-image').magnificPopup({
			type: 'image'
		});



	});

	// Accordion
	lwwb_accordion_elmn();
	function lwwb_accordion_elmn() {
		let $accordionEl = $('.lwwb-elmn-accordion');
		$accordionEl.each(function() {
			let $aEl = $(this);
			$aEl.on('click', '.accordion-header', function() {
				let $aHeader = $(this);
				let $aPanel = $aHeader.next('.accordion-panel').not('.active');
				$aEl.find('.accordion-header').removeClass('active')
				$aEl.find('.accordion-panel').removeClass('active').slideUp('fast');
				$aHeader.addClass('active');
				$aPanel.slideDown('fast');
				$aPanel.addClass('active');
			});
		})

	}
})(jQuery);


