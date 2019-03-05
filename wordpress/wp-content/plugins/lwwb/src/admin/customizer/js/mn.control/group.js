
lwwb.Control.Mn.Behaviors['group'] = Marionette.Behavior.extend({
    ui: {
        widgetTop: '.lwwb-control >.widget-top',
        widgetInside: '.lwwb-control >.widget-inside',
    },

    triggers: {
        'click @ui.widgetTop': 'toggle:widget',
    },
    onToggleWidget() {
        let siblingGroup = this.view.$el.siblings('li.customize-control-group');
        siblingGroup.each(function(index, group) {
            $(group).find('.widget-inside').slideUp('fast');
        })
        this.getUI('widgetInside').slideToggle('fast');
    }
});

lwwb.Control.Mn.Views['group'] = lwwb.Control.Mn.Views['base'].extend({
    el() {
        let controlID = this.model ? this.model.get('id') : '';
        return '<li id="customize-control-' + controlID + '" class="customize-control customize-control-group customize-control-' + controlID + '"></li>';
    },
    regions: {
        controlRegion: {
            el: '.widget-content',
        }
    },
    childViewTriggers: {
        'update:data': 'child:update:data',
        'list:control:update:data': 'child:list:control:update:data',
    },
    onRender() {
        const self = this;
        let fields = self.model.get('fields');
        self.showChildView('controlRegion', new lwwb.Control.Mn.Views['control-collection']({
            collection: new Backbone.Collection(fields),
        }));
        if (this.model.has('dependencies')) {
            if (self.isDepend()) {
                self.$el.show()
            } else {
                self.$el.hide()
            }
            self.checkDepend();
        }
    },
    onChildRepeatUpdateData(childView, data) {
        this.trigger('group:update:data', childView, data);
    },
    onChildListControlUpdateData(childView, data) {
        this.trigger('group:update:data', childView, data);
    },
    onChildUpdateData(childView, data) {
        this.trigger('group:update:data', childView, data);
    },

});