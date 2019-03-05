lwwb.Control.Mn.Views['control-collection'] = Marionette.CollectionView.extend({
    el: '<ul class="lwwb-list-controls"></ul>',
    childView(field) {
        const fieldType = field.get('type');
        let controlName;
        if (fieldType) {
            controlName = fieldType.replace('lwwb-', '')
        }
        if ('undefined' !== typeof lwwb.Control.Mn.Views[controlName]) {
            return lwwb.Control.Mn.Views[controlName];
        } else {
            return lwwb.Control.Mn.Views['base']
        }
    },
    childViewTriggers: {
        'update:data': 'child:update:data',
        'group:update:data': 'child:group:update:data',
        'repeat:update:data': 'child:repeat:update:data',
        'repeat:add:new:item': 'child:repeat:add:new:item',
    },
    onChildGroupUpdateData(childView, data) {
        this.trigger('list:control:update:data', childView, data);
    },
    onChildRepeatAddNewItem(childView, data) {
        this.trigger('list:control:update:data', childView, data);
    },
    onChildRepeatUpdateData(childView, data) {
        this.trigger('list:control:update:data', childView, data);
    },
    onChildUpdateData(childView, data) {
        this.trigger('list:control:update:data', childView, data);
    }
});