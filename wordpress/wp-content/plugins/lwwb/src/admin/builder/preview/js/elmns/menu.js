lwwb.Builder.Mn.Views['menu'] = lwwb.Builder.Mn.Views['wp_menu'].extend({
    onRender() {
        let eData = this.model.get('elmn_data');
        if (eData['menu_id']) {
            this.getMenuAjax(eData['menu_id']);
        }
        if(eData['menu_layout']){
            this.$el.find('.lwwb-navigation').addClass('lwwb-navigation--' + eData['menu_layout']);
        }
        if(eData['pointer']){
            this.$el.find('.lwwb-navigation').addClass('lwwb-pointer--' + eData['pointer']);
        }

    },
    getMenuAjax(data) {
        let self = this;
        $.ajax({
            type: "post",
            url: _lwwbData.config.ajaxUrl,
            data: {
                action: 'get_menu_html_via_ajax',
                id: data
            },
            success: function (data) {

                if (data.success) {
                    self.$el.find('.lwwb-navigation').html(data.html);
                    self.$el.find('.lwwb-navigation').removeClass('lwwb-nav-empty');
                } else {
                    self.$el.find('.lwwb-navigation').html('<div class="lwwb-empty-image"></div>');
                    self.$el.find('.lwwb-navigation').addClass('lwwb-nav-empty');
                }
            }
        });
    },
    onUpdateLogoImg(childView, dataKey, data){
        this.render();
    },
    onUpdateAlign(childView, dataKey, data) {
        $(this.$el.find('.lwwb-navigation')).removeClass(function (index, css) {
            return (css.match (/\bnavbar-\S+/g) || []).join(' ');
        }).addClass('navbar-' + data);
    },
    onUpdateMenuLayout(childView, dataKey, data) {
        $(this.$el.find('.lwwb-navigation')).removeClass(function (index, css) {
            return (css.match (/\blwwb-navigation--\S+/g) || []).join(' ');
        }).addClass('lwwb-navigation--' + data);
    },
    onUpdatePointer(childView, dataKey, data) {
        $(this.$el.find('.lwwb-navigation')).removeClass(function (index, css) {
            return (css.match (/\blwwb-pointer--\S+/g) || []).join(' ');
        }).addClass('lwwb-pointer--' + data);
    },
    onUpdateSticky(childView, dataKey, data) {
        $(this.$el.find('.navbar')).removeClass(function (index, css) {
            return (css.match (/\bis-fixed-\S+/g) || []).join(' ');
        }).addClass(data);
    },
    onUpdateTransparent(childView, dataKey, data) {
        if('is-transparent' === data){
            $(this.$el.find('.navbar')).removeClass('none').addClass('is-transparent');
        }else{
            $(this.$el.find('.navbar')).removeClass('is-transparent').addClass('none');
        }
    }

});