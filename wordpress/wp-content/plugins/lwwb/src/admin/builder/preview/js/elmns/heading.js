lwwb.Builder.Mn.Views['heading'] = lwwb.Builder.Mn.Views['elmn'].extend({

    onUpdateTitle(childView, dataKey, data) {
        this.render();
    },
    onUpdateLinkUrl(childView, dataKey, data) {
        this.render();
    },
    onUpdateLinkTarget(childView, dataKey, data) {
        this.render();
    },
    onUpdateHtmlTag(childView, dataKey, data) {
        this.render();
    },
    onUpdateAlign(childView, dataKey, data) {
        $(this.$el.find('.lwwb-elmn-content')).removeClass(function (index, css) {
            return (css.match(/\bhas-text-\S+/g) || []).join(' ');
        }).addClass('has-text-' + data);
    },

});