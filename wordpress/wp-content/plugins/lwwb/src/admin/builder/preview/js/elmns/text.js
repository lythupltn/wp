lwwb.Builder.Mn.Views['text'] = lwwb.Builder.Mn.Views['elmn'].extend({
    onRender() {
    	let self = this;
        let eData = this.model.get('elmn_data');
        if (eData['content']) {
            this.updateAjaxContent(eData['content']);
        }

    },
    onUpdateContent(childView, dataKey, content){
        this.updateAjaxContent(content);
    },
    updateAjaxContent(content) {
        let self = this;
        if (-1 === content.indexOf(']') && -1 === content.indexOf(']')) {
			self.$el.find('.lwwb-elmn-content').html(content);
        	return;
        }

        $.ajax({
            type: "post",
            url: _lwwbData.config.ajaxUrl,
            data: {
                action: 'get_content_via_ajax',
                content: content
            },
            success: function (data) {
               self.$el.find('.lwwb-elmn-content').html(data);
            }
        });
    },
});
