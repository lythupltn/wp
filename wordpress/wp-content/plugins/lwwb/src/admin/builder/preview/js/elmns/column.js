lwwb.Builder.Mn.Behaviors['column'] = Marionette.Behavior.extend({
    ui: {
        addColumn: '.lwwb-elmn-add',
        empty: '.lwwb-elmn-content.elmn-is-empty',
    },
    triggers: {
        'click @ui.add': 'add:column',
        'click @ui.empty': 'active:elmn:picker',
    },
    onAddColumn() {
        let model = new Backbone.Model(lwwb.Builder.HelperFn.getDefaultElmn('column'));
        this.view.trigger('add:elmn', this.view, model, 'after');
    },
    onActiveElmnPicker() {
        wp.customize.preview.send('active_group_control', 'elmn_picker');
    }
});
lwwb.Builder.Mn.Views['column'] = lwwb.Builder.Mn.Views['parent-elmn'].extend({
    el() {
        let tmpl = [],
            eID, cID, width, gridClass, styles, animated_class;
        if ('undefined' !== typeof this.model) {
            eID = this.model.get('elmn_id');
            cID = this.model.cid;
            gridClass = ' column ui-resizable ' + this.model.get('elmn_data').classes;
            gridClass += (width) ? ' is-narrow' : '';
            tmpl = ['<div class="lwwb-elmn lwwb-elmn-' + eID + ' lwwb-elmn-column' + gridClass + '" data-model-cid="' + cID + '" data-elmn_type="column"></div>', ];
        }
        return tmpl.join('');
    },
    _getBehaviors() {
        return ['elmn', 'parent-elmn', 'sortable', 'resizable', 'draggable'];
    },
    onUpdateWidth(childView, dataKey, data) {
        this.trigger('update:width', this, dataKey, data);
    },
    onUpdateTabletWidth(childView, dataKey, data) {
    },
    onUpdateMobileWidth(childView, dataKey, data) {
    },
    onEditElmn() {
        lwwb.Radio.channel.trigger('active:elmn:control', this.model);
        this.model.trigger('change:elmn_data:field', 'width', this.model.get('elmn_data').width, this.getColumnInputAttrs());
    },
    resize() {
        const self = this;
        let colData = this.model.get('elmn_data');
        let fullwidth, totalWidth, gapWidth;
        let resizableElmn = this.$el;
        let elmnID = this.model.get('elmn_id');
        resizableElmn.resizable({
            autoHide: true,
            classes: {
                "ui-resizable": "highlight"
            },
            handles: 'e',
            create: function(event, ui) {
                let lastModel = self.model.collection.last();
                if (lastModel.cid === self.model.cid) {
                    resizableElmn.resizable("option", "disabled", 'true');
                }
            },
            start: function(event, ui) {
                fullwidth = $('.lwwb-elmn.lwwb-elmn-' + elmnID).parents('.lwwb-elmn-section').first().width();
                var singleColWidth = fullwidth / 12;
                let targetCol = ui.element,
                    nextCol = targetCol.next();
                gapWidth = targetCol.outerWidth() - targetCol.width();
                totalWidth = targetCol.width() + nextCol.width();
                resizableElmn.resizable("option", "minWidth", singleColWidth - gapWidth);
                resizableElmn.resizable("option", "maxWidth", totalWidth - singleColWidth + gapWidth);
                nextCol.removeClass(function(index, css) {
                    return (css.match(/\bis-\S+/g) || []).join(' ');
                });
                targetCol.addClass('is-narrow');
                nextCol.addClass('is-narrow');
            },
            resize: function(event, ui) {
                let targetCol = ui.element,
                    nextCol = targetCol.next();
                targetCol.width(ui.size.width);
                nextCol.width(totalWidth - ui.size.width);
            },
            stop: function(event, ui) {
                var singleColWidth = fullwidth / 12;
                var nextCell = ui.originalElement.next();
                var totalPercentWidth = 100 * (ui.originalElement.outerWidth() + nextCell.outerWidth()) / (fullwidth + gapWidth);
                var targetColPercentWidth = 100 * ui.originalElement.outerWidth() / (fullwidth + gapWidth);
                targetColPercentWidth = (Math.floor(parseFloat(targetColPercentWidth) * 100) / 100).toFixed(2)
                var nextColPercentWidth = totalPercentWidth - targetColPercentWidth;
                nextColPercentWidth = (Math.floor(parseFloat(nextColPercentWidth) * 100) / 100).toFixed(2)
                ui.originalElement.css('width', targetColPercentWidth + '%');
                nextCell.css('width', nextColPercentWidth + '%');
                let min = (singleColWidth) / fullwidth * 100;
                let options = {
                    input_attrs: {
                        min: min.toFixed(2),
                        max: totalPercentWidth - min,
                        step: 0.01
                    },
                }
                let activeDevice = $(window.parent.document.body).find('.wp-full-overlay-footer .devices .active').data('device');
                let deviceKey = (activeDevice ==='desktop')? 'width': '_' + activeDevice + '_width';
                let columnClasses = colData['classes'] ? colData['classes'] : '';
                columnClasses += (columnClasses.indexOf('is-narrow') == -1) ? ' is-narrow' : '';
                _.extend(colData, {
                    classes: columnClasses,
                    [deviceKey]: targetColPercentWidth
                });
                self.model.set('elmn_data', colData);
                self.model.trigger('change:elmn_data:field', 'width', targetColPercentWidth, options);
                self.trigger('update:elmn', self);
                if (activeDevice === 'desktop') {

                self.trigger('update:next:column', self, {
                    classes: 'is-narrow',
                    [deviceKey]: nextColPercentWidth
                });
                }
            },
        });
    },
    widthToClass(width, singleColWidth) {
        const multiCol = Math.round(width / singleColWidth);
        if (multiCol < 1) {
            return 'is-' + '1';
        } else {
            return 'is-' + multiCol;
        }
    },
    getColumnInputAttrs() {
        let modelIndex, nextModel, currentWidth, nextWidth, maxPercentAvailale, minPercentAvailable, stepPercent,
            totalWidth, totalAvailableWidth, singleColWidth, prevModel;
        minPercentAvailable = 8.33;
        stepPercent = 0.01;
        if (!this.model.collection) {
            return;
        }
        modelIndex = this.model.collection.findIndex(this.model);
        nextModel = this.model.collection.at(modelIndex + 1);
        prevModel = this.model.collection.at(modelIndex - 1);
        nextModel = nextModel || prevModel;
        currentWidth = this.$el.width();
        if (nextModel) {
            nextWidth = this.$el.next().width();
        } else {
            return;
        }
        totalWidth = this.getSectionWidth();
        totalAvailableWidth = nextWidth + currentWidth;
        singleColWidth = minPercentAvailable * totalWidth / 100;
        maxPercentAvailale = (totalAvailableWidth - singleColWidth) * 100 / totalWidth;
        return {
            input_attrs: {
                min: (Math.floor(parseFloat(minPercentAvailable) * 100) / 100).toFixed(2),
                step: stepPercent,
                max: (Math.floor(parseFloat(maxPercentAvailale) * 100) / 100).toFixed(2)
            }
        }
    },
    onRender() {
        const self = this,
            childs = this.model.get('elmn_child');
        if (childs.length > 0) {
            this.showChildView('childRegion', new lwwb.Builder.Mn.Views['elmn-collection']({
                el: this.$el.find('.ui-sortable'),
                collection: new Backbone.Collection(childs),
            }));
        } else {
            this.$el.find('.lwwb-elmn-content').addClass('elmn-is-empty')
            this.$el.find('.ui-sortable').html('<div class="placeholder"><i class="fa fa-plus"></i></div>')
        }
    },
    getSectionWidth() {
        let sectionWrapper = $('.lwwb-elmn.lwwb-elmn-' + this.model.get('elmn_id')).parents('.lwwb-elmn-section').first();
        if (sectionWrapper.length) {
            return sectionWrapper.width();
        } else {
            return false;
        }
    },
});