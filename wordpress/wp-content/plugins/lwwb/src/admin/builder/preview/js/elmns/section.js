lwwb.Builder.Mn.Behaviors['section'] = Marionette.Behavior.extend({
    ui: {
        toggleSectionHelper: '.lwwb-elmn-add',
        sectionPreset: '.lwwb-preset-item',
    },
    triggers: {
        'click @ui.toggleSectionHelper': 'toggle:section:helper',
        'click @ui.sectionPreset': 'add:section:preset',
    },
    onToggleSectionHelper() {
        this.view.showHelperView = !this.view.showHelperView;
        this.view.render();
    },
    onAddSectionPreset(view, event) {
        const sectionPreset = lwwb.Builder.HelperFn.sectionPresets;
        const preset = $(event.currentTarget).data('section_preset');
        if (preset) {
            let model = new Backbone.Model(lwwb.Builder.HelperFn.getSectionPresets(sectionPreset[preset]));
            this.view.trigger('add:elmn', this.view, model, 'after');
        }
        this.onToggleSectionHelper();
    },
});
lwwb.Builder.Mn.Views['section'] = lwwb.Builder.Mn.Views['parent-elmn'].extend({
    el() {
        let tmpl = [],
            eType = '',
            eID,
            cID,
            elmnData,
            isInner;
        if ('undefined' !== typeof this.model) {
            eType = this.model.get('elmn_type');
            elmnData = this.model.get('elmn_data');
            isInner = elmnData['is_inner'] ? 'is_inner' : '';
            eID = this.model.get('elmn_id');
            cID = this.model.cid;
            tmpl = ['<section' + ' class="lwwb-elmn lwwb-elmn-' + eID + ' lwwb-elmn-section' + ' section ' + isInner + '" ', 'data-model-cid="' + cID + '"', 'data-elmn_type="section"></section>', ];
        }
        return tmpl.join('');
    },
    getTemplate() {
        let elmnTmpl = $(window.parent.document).find('#tmpl-lwwb-elmn-section-content');
        let sectionPreset = $(window.parent.document).find('#tmpl-lwwb-elmn-section-preset-content');
        let elmnTmplHtml = ((elmnTmpl.length > 0) && (elmnTmpl.html().trim() !== '')) ? elmnTmpl.html() : '';
        const tmpl = [
            elmnTmplHtml, (this.showHelperView) ? sectionPreset.html().trim() : '',
        ].join('');
        return _.template(tmpl, lwwb.Builder.Mn['templateSettings']);
    },
    _getBehaviors() {
        return ['elmn', 'parent-elmn', 'sortable'];
    },
    onRender() {
        const self = this,
            childs = this.model.get('elmn_child');
        if (childs.length < 1) {
            let column = lwwb.Builder.HelperFn.getDefaultElmn('column');
            childs.push(column);
            this.model.set('elmn_child', childs);
        }
        this.showChildView('childRegion', new lwwb.Builder.Mn.Views['elmn-collection']({
            el: this.$el.find('.ui-sortable'),
            collection: new Backbone.Collection(childs),
        }));
    },
    onUpdateContainerWidth(childView, dataKey, data) {
        const self = this;
        let elmnData = this.model.get('elmn_data');
        let $containerEl = self.$el.find('.container');
        if ($containerEl.length) {
            if (elmnData['in_container'] === 'yes') {
                self.removeContainerWidth();
                $containerEl.addClass(data);
            } else {
                self.render();
            }
        }
    },
    onUpdateInContainer(childView, dataKey, data) {
        this.render();
    },
    onUpdateSectionHeight(childView, dataKey, data) {
        let $contentEl = this.$el.find('>.lwwb-elmn-content');
        $contentEl= $contentEl.length ? $contentEl : this.$el.find('>.container > .lwwb-elmn-content');
        if ('hero is-fullheight' === data) {
            $contentEl.addClass('hero is-fullheight')
        } else {
            $contentEl.removeClass('hero is-fullheight')
        }
    },
    removeContainerWidth() {
        const self = this;
        let containerClasses = ['is-fluid', 'is-widescreen', 'is-fullhd'];
        let $containerEl = self.$el.find('.container');
        _.each(containerClasses, function(classWidth) {
            $containerEl.removeClass(classWidth)
        })
    },
});