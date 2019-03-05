lwwb.Control.Mn.Behaviors['repeater'] = Marionette.Behavior.extend({
    ui: {
        addItemBtn: '.add-new-item',
        repeatItems: '.repeater-items.ui-sortable',
    },
    triggers: {
        'click @ui.addItemBtn': 'add:item'
    },
    onRender() {
        const self = this;
        self.view.$el.find('.ui-sortable').sortable({
            items: '.lwwb-control-lwwb-repeater-item',
            helper:'clone',
            handle:'.widget-title',
            axis: 'y',
            stop:function(event, ui){
                self.view.render();
            },
            update: function(event, ui) {
                let sortViewCid = ui.item.data('cid'),
                    childCollectionView = self.view.getRegion('repeatRegion').currentView,
                    sortView = childCollectionView.children.findByCid(sortViewCid),
                    sortViewIndex = childCollectionView.children.findIndexByView(sortView),
                    nextViewCid = ui.item.next().data('cid'),
                    nextView = childCollectionView.children.findByCid(nextViewCid),
                    nextViewIndex = childCollectionView.children.findIndexByView(nextView),
                    prevViewCid = ui.item.prev().data('cid'),
                    prevView = childCollectionView.children.findByCid(prevViewCid),
                    prevViewIndex = childCollectionView.children.findIndexByView(prevView);
                if (prevViewCid) {
                    childCollectionView.collection.add([sortView.model.clone()], {
                        at: prevViewIndex + 1
                    });
                    childCollectionView.collection.remove([sortView.model]);
                    childCollectionView.trigger('repeat:item:collection:sort:update:data', childCollectionView);
                } else if (nextViewCid) {
                    childCollectionView.collection.add([sortView.model.clone()], {
                        at: nextViewIndex
                    });
                    childCollectionView.collection.remove([sortView.model]);
                    childCollectionView.trigger('repeat:item:collection:sort:update:data', childCollectionView);
                }
            },
        });

    }
});

lwwb.Control.Mn.Views['repeater'] = lwwb.Control.Mn.Views['base'].extend({
    el() {
        return '<div class="repeat-item"></div>';
    },
    regions: {
        repeatRegion: '.repeater-items'
    },
    childViewTriggers: {
        'repeat:item:collection:update:data': 'child:repeat:item:collection:update:data',
        'repeat:item:collection:sort:update:data': 'child:repeat:item:collection:sort:update:data'
    },
    onRender() {
        const self = this;
        let data = self.model.get('value');
        let fields = self.model.get('fields');

        self.showChildView('repeatRegion', new lwwb.Control.Mn.Views['repeater-collection']({
            collection: new Backbone.Collection(data),
            fields: fields,
            label: this.model.get('label')
        }));
    },
    onAddItem() {
        let data = this.model.get('value');
        let newItem = _.clone(JSON.parse(JSON.stringify(data[0])));
        data.push(newItem);
        this.model.set('value', data);
        this.trigger('repeat:add:new:item', this, data);
        this.render();
    },
    onChildRepeatItemCollectionUpdateData(childView) {
        let data = [];
        let cloneCollection = childView.collection.clone();
        data = _.map(cloneCollection.models, function(model) {
            let cloneModel = JSON.parse(JSON.stringify(model.toJSON()))
            delete cloneModel['fields'];
            delete cloneModel['label'];
            delete cloneModel['index'];
            return cloneModel;
        })
        this.model.set('value', data);
        this.trigger('repeat:update:data', this, this.model.get('value'));
    },
    onChildRepeatItemCollectionSortUpdateData(childView) {
        this.onChildRepeatItemCollectionUpdateData(childView)
        this.render();
    }
});