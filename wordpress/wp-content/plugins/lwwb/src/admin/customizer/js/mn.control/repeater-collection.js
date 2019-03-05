
lwwb.Control.Mn.Views['repeater-collection'] = Marionette.CollectionView.extend({
    childView: lwwb.Control.Mn.Views['repeater-item'],
    initialize(options) {
        let collection = _.map(options.collection.models, function(model, index) {
            model.set('fields', options.fields);
            model.set('label', options.label + ' ' + (index + 1));
            model.set('index', index);
            return model.toJSON();
        });
        this.collection = new Backbone.Collection(collection);
    },
    childViewTriggers: {
        'remove:item': 'child:remove:item',
        'clone:item': 'child:clone:item',
        'moveup:item': 'child:moveup:item',
        'movedown:item': 'child:movedown:item',
        'update:repeat:item': 'child:update:repeat:item'
    },
    onChildRemoveItem(childView) {
        this.collection.remove(childView.model);
        this.trigger('repeat:item:collection:update:data', this);
        this.render();
    },
    onChildUpdateRepeatItem(childView) {
        const index = this.collection.findIndex(childView.model.toJSON());
        this.collection.at(index).set(childView.model.toJSON());
        this.trigger('repeat:item:collection:update:data', this);
    },
    onChildCloneItem(childView, event){
        const index = this.collection.findIndex(childView.model.toJSON());
        let model = childView.model.clone();
        this.collection.add(model, {
            at: index + 1
        });
        this.trigger('repeat:item:collection:update:data', this);
        this.render();
    },
    onChildMoveupItem(childView, event){

    },

    onChildMovedownItem(childView, event){

    }
});