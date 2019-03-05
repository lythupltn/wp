lwwb.Builder.Mn.Views['block'] = lwwb.Builder.Mn.Views['parent-elmn'].extend({
    getTemplate() {
        return _.template('<div class="lwwb-elmn-content"><div class="ui-sortable" ><div class="ui-droppable placeholder" ></div></div></div>');
    },
    regions: {
        childRegion: {
            el: '.ui-sortable',
        }
    },
    _getBehaviors(){
        return ['elmn', 'sortable'];
    },
    onRender() {
        const self = this,
            childs = this.model.get('elmn_child');
        if (childs.length < 1) {
            let section = lwwb.Builder.HelperFn.getDefaultElmn('section');
            childs.push(section);
            this.model.set('elmn_child', childs);
        }
        this.showChildView('childRegion', new lwwb.Builder.Mn.Views['elmn-collection']({
            el: this.$el.find('.ui-sortable'),
            collection: new Backbone.Collection(childs),
        }));
    },
});