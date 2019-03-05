lwwb.Builder.Mn.Views['wp_menu'] = lwwb.Builder.Mn.Views['elmn'].extend({
    onRender() {
        let eData = this.model.get('elmn_data');
        if (eData['menu_id']) {
            this.getMenuAjax(eData['menu_id']);
        }
    },
    getMenuAjax(data) {
        let self = this;
        $.ajax({
            type: "post",
            url: _lwwbData.config.ajaxUrl,
            data: {
                action: 'get_wp_menu_html_via_ajax',
                id: data
            },
            success: function (data) {
                if (data.success) {
                    self.$el.find('.lwwb-wp-navigation').html(data.html);
                } else {
                    self.$el.find('.lwwb-wp-navigation').html('<div class="lwwb-empty-image"></div>');
                }
            }
        });
    },

    onUpdateMenuId(childView, dataKey, data) {
        this.getMenuAjax(data);
    },
    onUpdateTitle(childView, dataKey, data){
        this.render();
    }
});