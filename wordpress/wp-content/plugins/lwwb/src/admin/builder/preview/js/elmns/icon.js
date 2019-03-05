lwwb.Builder.Mn.Views['icon'] = lwwb.Builder.Mn.Views['elmn'].extend({
    onRender(){
        let eData = this.model.get('elmn_data');
        if(eData['icon_view']){
            this.$el.find('.lwwb-elmn-content').addClass('icon-view--'+eData['icon_view']);
        }
        if(eData['icon_shape']){
            this.$el.find('.lwwb-elmn-content').addClass('icon-shape--'+eData['icon_shape']);
        }
        if(eData['icon_hover_animation']){
            this.$el.find('.lwwb-icon').addClass('lwwb-animation-'+eData['icon_hover_animation']);

        }

    },
    onUpdateIcon(childView, dataKey, data) {
        this.render();
    },
    onUpdateIconView(childView, dataKey, data) {
        $(this.$el.find('.lwwb-elmn-content')).removeClass(function (index, css) {
            return (css.match(/\bicon-view--\S+/g) || []).join(' ');
        }).addClass('icon-view--' + data);
        if('default' === data){
            $(this.$el.find('.lwwb-elmn-content')).removeClass(function (index, css) {
                return (css.match(/\bicon-shape--\S+/g) || []).join(' ');
            });
        }
    },
    onUpdateIconShape(childView, dataKey, data) {
        $(this.$el.find('.lwwb-elmn-content')).removeClass(function (index, css) {
            return (css.match(/\bicon-shape--\S+/g) || []).join(' ');
        }).addClass('icon-shape--' + data);
    },
    onUpdateIconHoverAnimation(childView, dataKey, data) {
        $(this.$el.find('.lwwb-icon')).removeClass(function (index, css) {
            return (css.match(/\blwwb-animation-\S+/g) || []).join(' ');
        }).addClass('lwwb-animation-' + data);
    },
});