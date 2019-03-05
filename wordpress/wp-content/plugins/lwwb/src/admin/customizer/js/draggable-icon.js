jQuery( document ).ready(
	function( $ ) {
		$('.lwwb-control-lwwb-draggable-icon > ul > li').bind('dragstart',function( event ){
			let data = $(this).data('icon');
			event.originalEvent.dataTransfer.setData('text/plain', data);
		});
	}
);