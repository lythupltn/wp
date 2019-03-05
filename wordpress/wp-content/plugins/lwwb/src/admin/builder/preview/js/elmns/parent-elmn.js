lwwb.Builder.Mn.Behaviors['parent-elmn'] = Marionette.Behavior.extend({
    onRender(){
        let self = this;
        let elmnIndex = this.view.model.collection.findIndex(this.view.model);

            if (0=== elmnIndex) {
                if (self.view.getUI('up').length) {
                self.view.getUI('up').hide();
            }
            }
            if (self.view.model.collection.size() -1 === elmnIndex) {
                if (self.view.getUI('down').length) {
                self.view.getUI('down').hide();
            }
            }
        self.view.renderShapeTop();
        self.view.renderShapeBottom();
        }

});

lwwb.Builder.Mn.Views['parent-elmn'] = lwwb.Builder.Mn.Views['elmn'].extend({
    initialize() {
        const self = this;
        this.listenTo(lwwb.Radio.channel, 'move:elmn:by:model:cid', function (parentCid, childView, prevCid, nextCid) {
            let prCid = self.$el.data('model-cid');
            let childRegion = self.getRegion('childRegion');
            if (!childRegion) {
                return;
            }
            let childRegionView = childRegion.currentView;
            if (prCid === parentCid) {
                if ('undefined' !== typeof childRegionView) {
                    childRegionView.onAddElmnByModelCid(childView, prevCid, nextCid);
                } else {
                    let currentChilds = self.model.get('elmn_child');
                    if (_.isEmpty(currentChilds)) {
                        currentChilds.push(childView.model.clone().toJSON());
                        self.model.set('elmn_child', currentChilds)
                        self.trigger('update:elmn', self);
                        childView.trigger('remove:elmn', childView);
                        self.render();
                    }
                }
            }
        });
    },
    getTemplate() {
        let eType = this.model.get('elmn_type');
        let elmnTmpl = $(window.parent.document).find('#tmpl-lwwb-elmn-' + eType + '-content');
        let elmnTmplHtml = ((elmnTmpl.length > 0) && (elmnTmpl.html().trim() !== '')) ? elmnTmpl.html() : '';
        const tmpl = [
            elmnTmplHtml,
        ].join('');
        return _.template(tmpl, lwwb.Builder.Mn.templateSettings);
    },
    onUpElmn() {
        this.trigger('move:up', this);
    },
    onDownElmn() {
        this.trigger('move:down', this);
    },
    _getBehaviors(){
        return ['sortable'];
    },
    childViewTriggers: {
        'update:collection': 'child:update:collection',
        'empty': 'child:empty',
    },
    onChildEmpty() {
        this.render();
    },
    triggers: {
        'sort:elmn:by:model:cid': 'sort:elmn:by:model:cid',
    },

    onChildUpdateCollection(childView) {
        this.model.set('elmn_child', childView.collection.toJSON());
        this.trigger('update:elmn', this);
    },
    regions: {
        childRegion: {
            el: '.ui-sortable',
        }
    },
    onUpdateShapeTopSwitch(childView, dataKey, data) {
        this.renderShapeTop();
    },
    onUpdateShapeTop(childView, dataKey, data) {
        this.renderShapeTop();
    },
    onUpdateShapeBottomSwitch(childView, dataKey, data) {
        this.renderShapeBottom();
    },
    onUpdateShapeBottom(childView, dataKey, data) {
        this.renderShapeBottom();
    },
    renderShapeTop() {
        const self = this;
        let sectionData = this.model.get('elmn_data');
        if (sectionData.shape_top_switch === 'yes' && sectionData.shape_top) {
            let shapeUrl = _lwwbData.config.assetsUrl + '/shapes/' + sectionData.shape_top + '.svg';
            $.get(shapeUrl, function (data) {
                self.$el.find('.lwwb-elmn-shape-top').html(data.childNodes[0]);
            });
        } else {
            self.$el.find('.lwwb-elmn-shape-top').html('');
        }
    },
    renderShapeBottom() {
        const self = this;
        let sectionData = this.model.get('elmn_data');
        if (sectionData.shape_bottom_switch === 'yes' && sectionData.shape_bottom) {
            let shapeUrl = _lwwbData.config.assetsUrl + '/shapes/' + sectionData.shape_bottom + '.svg';
            $.get(shapeUrl, function (data) {
                self.$el.find('.lwwb-elmn-shape-bottom').html(data.childNodes[0]);
            });
        } else {
            self.$el.find('.lwwb-elmn-shape-bottom').html('');
        }
    },
});