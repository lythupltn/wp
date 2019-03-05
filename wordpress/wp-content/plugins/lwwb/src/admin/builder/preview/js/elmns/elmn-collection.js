lwwb.Builder.Mn.Views['elmn-collection'] = Marionette.CollectionView.extend({
    onAddElmnByModelCid(childView, prevCid, nextCid) {
        const prevView = this.children.findByModelCid(prevCid),
            nextView = this.children.findByModelCid(nextCid);
        if (prevView) {
            prevView.trigger('add:elmn', prevView, childView.model, 'after');
            childView.trigger('remove:elmn', childView);
            return;
        } else if (nextView) {
            nextView.trigger('add:elmn', nextView, childView.model, 'before');
            childView.trigger('remove:elmn', childView);
            return;
        }
    },
    childView(elmn) {
        const eType = elmn.get('elmn_type');
        let elmnView = lwwb.Builder.Mn.Views[eType];
        let baseElmnView = lwwb.Builder.Mn.Views['elmn'];
        if (elmnView) {
            return elmnView;
        } else {
            return baseElmnView;
        }
    },
    childViewTriggers: {
        'add:elmn': 'child:add:elmn',
        'sort:elmn': 'child:sort:elmn',
        'edit:elmn': 'child:edit:elmn',
        'clone:elmn': 'child:clone:elmn',
        'remove:elmn': 'child:remove:elmn',
        'update:elmn': 'child:update:elmn',
        'sort:elmn:by:model:cid': 'child:sort:elmn:by:model:cid',
        'update:next:column': 'child:update:next:column',
        'move:up': 'child:move:up',
        'move:down': 'child:move:down',
        'update:width': 'child:update:width',
    },
    collectionEvents: {
        'update': 'onCollectionUpdate',
    },
    onChildCollectionUpdate() {
        this.trigger('update:collection', this);
    },
    onChildCloneElmn(childView, event) {
        let elmnType = childView.model.get('elmn_type'),
            cloneElmn = this.cloneRecursiveElmn(childView.model),
            index = this.collection.findIndex(childView.model.toJSON());
        this.collection.add(cloneElmn, {
            at: index + 1
        });
        if ('column' === elmnType) {
            this.resetColumWidth();
            return;
        }
        this.trigger('update:collection', this);
    },
    resetColumWidth() {
        const self = this;
        _.each(this.collection.models, function(column) {
            let columnData = column.get('elmn_data'),
                columnClasses = (0 == 12 % self.collection.size()) ? 'is-' + 12 / self.collection.size() : '';
            let width = (self.collection.size() <= 12) ? 100 / self.collection.size().toFixed(4) : '';
            _.extend(columnData, {
                classes: columnClasses,
                width: '',
            })
            column.set('elmn_data', columnData);
            self.collection.add(column, {
                merge: true
            });
        })
        this.trigger('update:collection', this);
        this.render();
    },
    cloneRecursiveElmn(elmn) {
        let cloneData = lwwb.Builder.HelperFn.cloneRecursiveElmn(elmn.toJSON());
        return new Backbone.Model(cloneData);
    },
    onChildUpdateElmn(childView) {
        const index = this.collection.findIndex(childView.model.toJSON());
        this.collection.at(index).set(childView.model.toJSON());
        this.trigger('update:collection', this);
    },
    onChildRemoveElmn(childView) {
        this.collection.remove(childView.model.toJSON())
        childView.model.destroy();
        childView.destroy();
        this.trigger('update:collection', this);
        if (this.collection.size() === 0) {
            this.trigger('empty', this);
        }
        if ('column' === childView.model.get('elmn_type')) {
            this.resetColumWidth();
        }
    },
    onChildAddElmn(elmnView, model, addPosition) {
        let index = this.collection.findIndex(elmnView.model.toJSON());
        if ('before' == addPosition) {
            index = index;
        } else {
            index = index + 1;
        }
        if (!(model instanceof Backbone.Model)) {
            model = new Backbone.Model(model);
        }
        this.collection.add(model.toJSON(), {
            at: index
        });
        if ('column' === model.get('elmn_type')) {
            this.resetColumWidth();
        }
        this.trigger('update:collection', this);
    },
    onChildSortElmn(elmnView, model, addPosition) {
        let index = this.collection.findIndex(elmnView.model.toJSON());
        if ('before' == addPosition) {
            index = index;
        } else {
            index = index + 1;
        }
        if (!(model instanceof Backbone.Model)) {
            model = new Backbone.Model(model);
        }
        this.collection.add(model.toJSON(), {
            at: index
        });
        this.trigger('update:collection', this);
    },
    onChildUpdateNextColumn(colView, data) {
        let index = this.collection.findIndex(colView.model.toJSON());
        let nextColData = this.collection.at(index + 1).get('elmn_data');
        nextColData['width'] = data['width'];
        nextColData['classes'] += (nextColData['classes'].indexOf(data['classes']) > -1) ? ' ' + data['classes']: '';
        this.collection.at(index + 1).set('elmn_data', nextColData);
        this.trigger('update:collection', this);
        this.render();
    },
    onChildMoveUp(childView) {
        let eType = childView.model.get('elmn_type');
        const index = this.collection.findIndex(childView.model.toJSON());
        if (index < 1) {
            return;
        }
        let elmnBefore = this.collection.at(index - 1).clone();
        this.collection.remove(this.collection.at(index - 1))
        this.collection.add(elmnBefore.toJSON(), {
            at: index
        });
        this.collection.add(childView.model.toJSON(), {
            at: index - 1
        });
        elmnBefore.destroy();
        childView.model.destroy();
        childView.destroy();
        this.trigger('update:collection', this);
    },
    onChildMoveDown(childView) {
        let eType = childView.model.get('elmn_type');
        const index = this.collection.findIndex(childView.model.toJSON());
        if (index === this.collection.size() - 1) {
            return;
        }
        let elmnBefore = this.collection.at(index + 1).clone();
        this.collection.remove(this.collection.at(index + 1))
        this.collection.add(elmnBefore.toJSON(), {
            at: index
        });
        this.collection.add(childView.model.toJSON(), {
            at: index + 1
        });
        elmnBefore.destroy();
        childView.model.destroy();
        childView.destroy();
        this.trigger('update:collection', this);
    },
    onChildUpdateWidth(childView, dataKey, data) {
        let childViewIndex = this.children.findIndexByView(childView);
        let nextView = this.children.findByIndex(childViewIndex + 1);
        let prevView = this.children.findByIndex(childViewIndex - 1);
        nextView = nextView || prevView;
        if (!nextView || childViewIndex === -1) {
            return;
        }
        let fullwidth = childView.getSectionWidth();
        let gapWidth = childView.$el.outerWidth() - childView.$el.width();
        let totalPercentWidth = 100 * (childView.$el.outerWidth() + nextView.$el.outerWidth()) / (fullwidth + gapWidth);
        totalPercentWidth = (Math.floor(parseFloat(totalPercentWidth) * 100) / 100).toFixed(2)
        let targetColPercentWidth = 100 * childView.$el.outerWidth() / (fullwidth + gapWidth);
        let nextColPercentWidth = (data !== '') ? (totalPercentWidth - data).toFixed(2) : '';
        let nextData = nextView.model.get('elmn_data');
        nextData[dataKey] = nextColPercentWidth;
        nextView.model.set('elmn_data', nextData);
        this.trigger('update:collection', this);
        this.render();
    },
});