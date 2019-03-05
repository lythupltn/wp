lwwb.Builder.Mn.Behaviors['accordion'] = Marionette.Behavior.extend({
	ui: {
		accordionHeader: '.accordion-header',
	},
	triggers:{
		'click @ui.accordionHeader': 'toggle:accordion',
	},
    onToggleAccordion(view, event) {
    	let $header = $(event.currentTarget);
    	let $panel  = $header.next();
    	$header.toggleClass('active');
    	$panel.slideToggle();
    },

});
lwwb.Builder.Mn.Views['accordion'] = lwwb.Builder.Mn.Views['elmn'].extend({
    onRender() {
    	let self = this;
        let eData = this.model.get('elmn_data');
        if (eData['accordion']) {
            this.updateAjaxAccordion(eData['accordion']);
        }

    },
    onUpdateAccordion(childView, dataKey, accordion){
        this.updateAjaxAccordion(accordion);
    },
    updateAjaxAccordion(accordion) {
        let self = this;

	        $.ajax({
	            type: "post",
	            url: _lwwbData.config.ajaxUrl,
	            data: {
	                action: 'get_accordion_via_ajax',
	                accordion: accordion
	            },
	            success: function (data) {
	               self.$el.find('.lwwb-elmn-content').html(data);
	            }
	        });


    },
});
