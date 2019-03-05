global.lwwb = global.lwwb || {};
lwwb.Control = lwwb.Control || {};
lwwb.Control.Mn || {};
lwwb.Control.Mn = lwwb.Control.Mn || {};
lwwb.Control.Mn.Views = lwwb.Control.Mn.Views || {};
lwwb.Control.Mn.Behaviors = lwwb.Control.Mn.Behaviors || {};
lwwb.Control.Mn['templateSettings'] = {
    evaluate: /<#([\s\S]+?)#>/g,
    interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
    escape: /\{\{([^\}]+?)\}\}(?!\})/g,
};
var _operators = {
    '==': function(a, b) {
        return a == b
    },
    '===': function(a, b) {
        return a === b
    },
    '!==': function(a, b) {
        let o1 = _.isArray(a) || _.isObject(a) ? Object.assign({}, a) : false;
        let o2 = _.isArray(b) || _.isObject(b) ? Object.assign({}, b) : false;
        if (o1 && o2) {
            return !_.isEqual(o1, o2);
        } else {
            return (a !== b);
        }
    },
    '<': function(a, b) {
        return a < b
    },
    '>': function(a, b) {
        return a > b
    },
    '<=': function(a, b) {
        return a <= b
    },
    '<=': function(a, b) {
        return a <= b
    },
    '>=': function(a, b) {
        return a >= b
    },
    '+': function(a, b) {
        return a + b
    },
    '-': function(a, b) {
        return a - b
    },
    '*': function(a, b) {
        return a * b
    },
    '/': function(a, b) {
        return a / b
    },
    '%': function(a, b) {
        return a % b
    },
    'in': function(a, b) {
        let check = (a.indexOf(b) > -1) ? true : false;
        return check;
    },
};
lwwb.Control.Mn.Behaviors['base'] = Marionette.Behavior.extend({
    triggers: {
        'change @ui.input': 'update:input:data',
        'change @ui.select': 'update:input:data',
        'change @ui.textarea': 'update:input:data',
        'keyup @ui.input': 'update:input:data',
        'keyup @ui.select': 'update:input:data',
        'keyup @ui.textarea': 'update:input:data',
    },
    onRender() {
        const self = this;
        if (self.view.model.get('type')) {
            let controlBehavior = self.view.model.get('type').replace('lwwb-', '');
            if ('undefined' !== typeof lwwb.Control.Wp[controlBehavior]) {
                lwwb.Control.Wp[controlBehavior].init(self.view.$el);
            }
        }
    },
});
lwwb.Control.Mn.Behaviors['reset'] = Marionette.Behavior.extend({
    triggers: {
        'click @ui.reset': 'reset:control',
    },
    onResetControl() {
        const self = this;
        let defaultValue = self.view.model.get('default');
        let _value = self.view.model.get('value');
        if (_operators['!=='](_value, defaultValue)) {
            self.view.model.set('value', defaultValue);
            self.view.trigger('update:data', self.view, defaultValue)
            self.view.render();
        }
    }
});
lwwb.Control.Mn.Views['base'] = Marionette.View.extend({
    ui: {
        input: 'input.lwwb-input',
        textarea: 'textarea.lwwb-input',
        hiddenInput: 'input[class*="-hidden-value"]',
        select: 'select.lwwb-select',
        reset: '.lwwb-reset-control',
    },
    el() {
        let activeDevice = $('.wp-full-overlay-footer .devices .active').data('device');
        let classes = [
            'customize-control',
            'lwwb-control-container',
            'lwwb-control-inner-' + this.model.get('type'),
            this.model.get('type'),
            (this.model.has('control_layout')) ? this.model.get('control_layout') : '',
            (this.model.has('on_device') && this.model.get('on_device') === activeDevice)? 'active' : '',

        ];
        let keywords = (this.model.has('keywords')) ? 'data-keywords="' + this.model.get('keywords') + '"' : '';
        let onDevice = (this.model.has('on_device')) ? 'data-on_device="' + this.model.get('on_device') + '"' : '';
        return $('<li id="customize-control-' + this.model.get('type') + '-' + this.model.get('id') + '" '+ onDevice + keywords +' class="'+ classes.join(' ') +'"></li>')
    },
    getTemplate() {
        const fieldType = this.model.get('type');
        const fieldTmpl = $('#tmpl-customize-control-' + fieldType + '-content');
        if (fieldTmpl.length) {
            return _.template(fieldTmpl.html(), lwwb.Control.Mn['templateSettings']);
        } else {
            return _.template(fieldType + ' template does not exists!')
        }
    },
    templateContext() {
        var data = this.model.toJSON();
        return {
            data: data,
            view: this
        };
    },
    behaviors() {
        let behaviorTypes = ['base', 'reset'];
        let behaviors = [];
        behaviors = _.map(behaviorTypes, function(behavior, index) {
            if (lwwb.Control.Mn.Behaviors[behavior]) {
                return lwwb.Control.Mn.Behaviors[behavior];
            }
        });
        
        if (this.options.model) {
            let controlType = this.options.model.get('type');
            if (controlType) {
                let controlName = controlType.replace('lwwb-', '');
                if (lwwb.Control.Mn.Behaviors[controlName]) {
                    behaviors.push(lwwb.Control.Mn.Behaviors[controlName])
                }
                
            }
        }else{
            console.log(this)
        }
        return behaviors;
    },
    onUpdateInputData(view, event) {
        const fieldTarget = $(event.currentTarget);
        let fieldData = this.model.get('value');
        if ('undefined' === typeof fieldData) {
            fieldData = '';
        }
        if (this.getUI('hiddenInput').length) {
            fieldData[fieldTarget.data('key')] = fieldTarget.val();
        } else {
            if ('checkbox' === fieldTarget.attr('type')) {
                fieldData = fieldTarget.prop('checked') ? 'yes' : 'no';
            } else {
                if (_.isObject(fieldData)) {
                    // fieldData = fieldData || {};
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
        }
        
        this.model.set('value', fieldData).trigger('change:value');
        this.triggerUpdateData();
    },
    triggerUpdateData(){
        if (this.model.get('save_on_change') === 'off' || 'lwwb-group' === this.model.get('type')) {
            return;
        }
            this.trigger('update:data', this, this.model.get('value'));
    },
    onRender() {
        const self = this;
        if (this.model.has('dependencies')) {
            if (self.isDepend()) {
                self.$el.css('display', '');
            } else {
                self.$el.css('display','none')
            }
            self.checkDepend();
        }
    },
    checkDepend() {
        const self = this;
        _.each(self.getDependModel(), function(md) {
            md.on('change:value', function(model) {
                if (self.isDepend()) {
                    self.$el.css('display', '');
                } else {
                    self.$el.css('display','none')
                }
            });
        })
    },
    isDepend: function() {
        const self = this;
        let show = true;
        let depends = self.model.get('dependencies');
        _.each(self.getDependModel(), function(md, key) {
            show = _operators[depends[key].operator](depends[key].value, md.get('value')) ? show : false;
        })
        return show;
    },
    getDependModel() {
        const self = this;
        let depends = self.model.get('dependencies');
        let depenControlIDs = _.map(depends, function(d) {
            return d.control;
        });
        return _.filter(this.model.collection.models, function(md) {
            return $.inArray(md.get('id'), depenControlIDs) > -1;
        })
    }
});