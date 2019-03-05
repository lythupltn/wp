var templateSettings = {
    evaluate: /<#([\s\S]+?)#>/g,
    interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
    escape: /\{\{([^\}]+?)\}\}(?!\})/g,
};
var FieldBehavior = Marionette.Behavior.extend({
    ui: {
        input: 'input.lwwb-input',
        select: 'select.lwwb-select',
        textarea: 'textarea.lwwb-textarea',
    },
    triggers: {
        'change @ui.input': 'update:data',
        'change @ui.select': 'update:data',
        'change @ui.textarea': 'update:data',
        'change @ui.radio': 'update:data',
        'keyup @ui.input': 'update:data',
        'keyup @ui.select': 'update:data',
        'keyup @ui.textarea': 'update:data',
        'keyup @ui.radio': 'update:data',
        'paste @ui.input': 'update:data',
        'paste @ui.select': 'update:data',
        'paste @ui.textarea': 'update:data',
        'paste @ui.radio': 'update:data',
    },
});
var RepeatItemBehavior = Marionette.Behavior.extend({
    onRender() {
        const self = this;
        this.view.$el.on('click', '.widget-top', function(event) {
            event.preventDefault();
            self.view.$el.find('.widget-inside').slideToggle();
        });
    }
});
var RepeatViewBehavior = Marionette.Behavior.extend({
    ui: {
        'addItem': '.repeater-add-item'
    },
    triggers: {
        'click @ui.addItem': 'add:item'
    }
});
var FieldView = Marionette.View.extend({
    el() {
        return $('<li id="customize-control-' + this.model.get('type') + '-' + this.model.get('id') + '" class="lwwb-field-container lwwb-control-lwwb-' + this.model.get('type') + '"></li>')
    },
    getTemplate() {
        const fieldType = this.model.get('type');
        const fieldTmpl = $('#tmpl-customize-control-lwwb-' + fieldType + '-content');
        if (fieldTmpl.length) {
            return _.template(fieldTmpl.html(), templateSettings);
        } else {
            return _.template(fieldType + ' template does not exists!')
        }
    },
    templateContext() {
        var data = this.model.toJSON();
        data.id = data.id + '-' + this.cid;
        return {
            data: data,
        };
    },
    behaviors: [FieldBehavior],
    onUpdateData(view, event) {
        let fieldData = this.model.get('value');
        const fieldTarget = $(event.currentTarget);
        if ('checkbox' === fieldTarget.attr('type')) {
            fieldData = fieldTarget.prop('checked') ? 'yes' : 'no';
        } else {
            if (typeof fieldData !== 'string') {
                fieldData = fieldData || {};
                if (fieldData[fieldTarget.data('key')]) {
                    fieldData[fieldTarget.data('key')] = fieldTarget.val();
                } else {
                    _.extend(fieldData, {
                        [fieldTarget.data('key')]: fieldTarget.val()
                    })
                    fieldData[fieldTarget.data('key')] = fieldTarget.val();
                }
            } else {
                fieldData = fieldTarget.val();
            }
        }
        this.model.set('value', fieldData);
        this.trigger('update:field', {
            [this.model.get('id')]: this.model.get('value')
        });
    },
});
var FieldCollectionView = Marionette.CollectionView.extend({
    childView: FieldView,
    initialize() {
        var fields = repeaterRadioChannel.request('repeater:fields');
        var collection = this.collection.toJSON();
        var fieldCollection = _.map(fields, function(field, key) {
            let data = _.find(collection, function(data) {
                return Object.keys(data).indexOf(field.id) > -1;
            })
            var _field = Object.assign(_.clone(field), data);
            _field['value'] = _field[_field.id] ? _field[_field.id] : '';
            return _.clone(_field);
        })
        this.collection = new Backbone.Collection(fieldCollection);
    },
    childViewTriggers: {
        'update:field': 'update:field'
    },
    onUpdateField(data) {
        const index = this.collection.findIndex(data);
        this.collection.at(index).set(data);
        var data = {};
        _.each(this.collection.toJSON(), function(dt) {
            data[dt.id] = dt.value;
        })
        this.trigger('update:item', data);
    }
});
var RepeatItemView = Marionette.View.extend({
    initialize(options) {
        this.collection = new Backbone.Collection(options.model.toJSON());
    },
    behaviors: [RepeatItemBehavior],
    getTemplate() {
        const fieldTmpl = $('#tmpl-customize-control-lwwb-group-content');
        if (fieldTmpl.length) {
            return _.template(fieldTmpl.html(), templateSettings);
        } else {
            return _.template(fieldType + ' template does not exists!')
        }
    },
    templateContext() {
        var label = repeaterRadioChannel.request('repeater:label');
        var data = this.model.toJSON();
        data['label'] = label;
        return {
            data: data
        };
    },
    regions: {
        listFieldRegion: {
            el: '.widget-content',
        },
    },
    childViewTriggers: {
        'update:item': 'update:item'
    },
    onRender() {
        let fieldCollectionView = new FieldCollectionView({
            collection: this.collection,
        });
        this.showChildView('listFieldRegion', fieldCollectionView);
    },
    onUpdateItem(data) {
        this.model.set(data);
        this.trigger('update:repeater', data);
    },
});
var RepeatCollectionView = Marionette.CollectionView.extend({
    childView: RepeatItemView,
    childViewTriggers: {
        'update:repeater': 'update:repeater'
    },
    onUpdateRepeater(data) {
        const index = this.collection.findIndex(data);
        this.collection.at(index).set(data);
        this.trigger('update:data', this.collection.toJSON());
        console.log(this.collection.toJSON())
    }
});
var RepeatView = Marionette.View.extend({
    getTemplate() {
        return _.template('<div class="list-item-view"></div><span class="button-secondary repeater-add-item">Add item</span>', templateSettings);
    },
    initialize(options) {
        this.model = options.model;
        this.collection = options.collection;
    },
    regions: {
        listItemRegion: {
            el: '.list-item-view',
        },
    },
    behaviors: [RepeatViewBehavior],
    childViewTriggers: {
        'update:data': 'update:data'
    },
    onRender() {
        let itemCollectionView = new RepeatCollectionView({
            collection: this.collection,
        });
        this.showChildView('listItemRegion', itemCollectionView);
    },
    onAddItem() {
        var newItem = this.collection.at(0).clone();
        newItem.clear();
        this.collection.push(newItem);
        this.render();
    },
});
var repeaterRadioChannel = Backbone.Radio.channel('repeater:fields');
wp.customize.controlConstructor['lwwb-repeater'] = wp.customize.Control.extend({
    ready: function() {
        var control = this;
        control.initRepeater();
    },
    initRepeater: function() {
        var control = this,
            dataSetting = control.setting.get(),
            dataCollection = new Backbone.Collection(dataSetting);
        repeaterRadioChannel.reply('repeater:fields', control.params.fields);
        repeaterRadioChannel.reply('repeater:label', control.params.label);
        var repeatView = new RepeatView({
            collection: dataCollection,
            el: '#repeater-fields',
        });
        repeatView.render();
        repeatView.on('update:data', function(data) {
            control.setting.set(data);
        });
    },
});
global.lwwb = global.lwwb || {}
lwwb.Marionette = lwwb.Marionette || {}
lwwb.Marionette.Views = lwwb.Marionette.Views || {}
lwwb.Marionette.Views['repeater'] = RepeatView;