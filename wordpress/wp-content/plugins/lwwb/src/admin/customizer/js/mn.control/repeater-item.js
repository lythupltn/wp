lwwb.Control.Mn.Behaviors['repeater-item'] = Marionette.Behavior.extend({
    ui:{
        clone: '.repeater-action-clone',
        remove: '.repeater-action-remove',
        moveup: '.repeater-action-up',
        movedown: '.repeater-action-down',
    },
    triggers:{
        'click @ui.clone': 'clone:item',
        'click @ui.remove': 'remove:item',
        'click @ui.moveup': 'moveup:item',
        'click @ui.movedown': 'movedown:item',
    },

    onRender(){
        if (this.view.model.collection.size() === 1) {
            this.getUI('remove').remove();
        }
    }
});
lwwb.Control.Mn.Views['repeater-item'] = lwwb.Control.Mn.Views['base'].extend({
    el() {
        return $('<li  class="lwwb-field-container lwwb-control-lwwb-repeater-item" data-cid="' + this.cid + '"></li>');
    },
    getTemplate() {
        const fieldTmpl = $('#tmpl-customize-control-lwwb-repeater-item-content');
        return _.template(fieldTmpl.html(), lwwb.Control.Mn['templateSettings']);
    },
    templateContext() {
        var data = this.model.toJSON();
        return {
            data: data,
        };
    },
        behaviors() {
        let behaviorTypes = ['group', 'repeater-item'];
        let behaviors = [];
        behaviors = _.map(behaviorTypes, function(behavior, index) {
            if (lwwb.Control.Mn.Behaviors[behavior]) {
                return lwwb.Control.Mn.Behaviors[behavior];
            }
        });

        return behaviors;
    },
    regions: {
        repeatFields: '.widget-content'
    },
    childViewTriggers: {
        'list:control:update:data': 'child:list:control:update:data',
    },
    onRender() {
        var fields = this.model.get('fields');
        var data = this.model.toJSON();
        var fieldData = _.map(fields, function(field) {
            field['value'] = data[field.id];
            return field;
        })
        this.showChildView('repeatFields',new lwwb.Control.Mn.Views['control-collection']({
            collection: new Backbone.Collection(fieldData)
        }))
    },
    onChildListControlUpdateData(childView, data) {
        let dataKey = childView.model.get('id');
        this.model.set(dataKey, data);
        this.trigger('update:repeat:item', this);
    },
});