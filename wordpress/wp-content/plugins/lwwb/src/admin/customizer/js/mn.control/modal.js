lwwb.Control.Mn.Behaviors['modal'] = Marionette.Behavior.extend({
    ui: {
        modalAction: '.modal-action',
        modalContent: '.widget-inside',
        reset: '.lwwb-reset-control',
    },
    triggers: {
        'click @ui.modalAction': 'modal:show:content',
        'click @ui.reset': 'modal:reset',
    },
    behaviors() {
        let behaviorTypes = ['group'];
        let behaviors = [];
        behaviors = _.map(behaviorTypes, function(behavior, index) {
            if (lwwb.Control.Mn.Behaviors[behavior]) {
                return lwwb.Control.Mn.Behaviors[behavior];
            }
        });
        return behaviors;
    },
    onModalShowContent() {
        this.getUI('modalContent').slideToggle('fast');
    },
});
lwwb.Control.Mn.Views['modal'] = lwwb.Control.Mn.Views['group'].extend({
    el() {
        let controlID = this.model ? this.model.get('id') : '';
        return '<li id="customize-control-' + controlID + '" class="customize-control customize-control-modal customize-control-' + controlID + '"></li>';
    },
    regions: {
        controlRegion: {
            el: '.modal-content',
        }
    },
    onChildListControlUpdateData(childView, dt) {
        let data = this.model.get('value');
        let dataKey = childView.model.get('id');
        data = data || {};
        _.extend(data, {
            [dataKey]: dt
        });
        this.model.set('value', data);
        this.trigger('update:data', this, data);
    },
    onModalReset() {
        this.getRegion('controlRegion').currentView.children.each(function(controlView) {
            controlView.trigger('reset:control');
        })
    }
})