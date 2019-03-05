wp.customize.controlConstructor['lwwb-group'] = wp.customize.Control.extend({
    ready: function() {
        var control = this;
        control.groupBehavior();
        control.initGroup();
    },
    initGroup: function() {
        var control = this,
            dataSetting = control.setting.get(),
            fields = control.params.fields;
        fields = _.map(fields, function(field) {
            let fieldData = _.find(dataSetting, function(dt, key) {
                if ((key === field.id)) {
                    return dt;
                }
            });
            if (fieldData) {
                field['value'] = fieldData;
            }
            return field;
        })
        var dataCollection = new Backbone.Collection(fields);
        var fieldsElmn = '#lwwb-control-' + control.id + ' .widget-content';
        var groupView = new lwwb.Control.Mn.Views['control-collection']({
            collection: dataCollection,
            el: fieldsElmn,
        });
        groupView.render();
        groupView.on('list:control:update:data', function(childView, data) {
            let _data = control.setting.get();
            _.extend(_data, data);
            control.setting.set(_data)._dirty = true;
            wp.customize.state('saved').set(false);
        });
    },
    groupBehavior() {
        var control = this;
        control.container.find('#lwwb-control-' + control.id + ' > .widget-inside').show();
        control.container.on('click', '#lwwb-control-' + control.id + ' > .widget-top', function(event) {
            event.preventDefault();
            $(this).next('.widget-inside').slideToggle('fast');
        });
    }
});