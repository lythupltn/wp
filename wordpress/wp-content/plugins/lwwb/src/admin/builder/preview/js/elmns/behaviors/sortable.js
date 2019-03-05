var SortableElmn = Marionette.Behavior.extend({
    onRender() {
        let self = this,
            eType = this.view.model.get('elmn_type'),
            eChilds = this.view.model.get('elmn_childs'),
            connectWith = '.' + eType + ' .lwwb-elmn-content > .ui-sortable',
            sortableElm = this.view.$el.find(' > .lwwb-elmn-content >.ui-sortable');
        const elmnConfig = window.parent._lwwbConfig.elmns;
        let forcePlaceholderSize = false,
            elmnItem = '> .lwwb-elmn',
            axis = false;
        if (eType === 'section') {
            let eData = this.view.model.get('elmn_data');
            forcePlaceholderSize = true;
            elmnItem = '> .lwwb-elmn-column';
            if (eData['in_container'] && 'yes' === eData['in_container']) {
                sortableElm = this.view.$el.find('> .container > .lwwb-elmn-content >.ui-sortable');
            } else {
                sortableElm = this.view.$el.find('>.lwwb-elmn-content >.ui-sortable');
            }
            connectWith = '.' + eType + ' .columns.ui-sortable';
        } else if ('column' !== eType) {
            axis = 'y';
            elmnItem = '.lwwb-elmn-section';
        }
        sortableElm.sortable({
            axis: axis,
            cancel: '',
            classes: {},
            connectWith: connectWith,
            cursor: 'move',
            cursorAt: {
                top: 20,
                left: 25
            },
            delay: 150,
            // disabled: true,
            // distance: 5,
            // dropOnEmpty: false,
            forcePlaceholderSize: forcePlaceholderSize,
            // forceHelperSize: true,
            // // grid: [ 20, 10 ],
            handle: '.lwwb-elmn-move, img',
            // helper: 'clone',
            helper: function(event, ui) {
                let eType, icon;
                eType = ui.closest('.lwwb-elmn').data('elmn_type').trim();
                icon = elmnConfig[eType] ? elmnConfig[eType].metas.icon : 'fa fa-arrows';
                let helper = $('<div class="lwwb-sortable-helper" style="width:90px; height:60px;" title="' + eType + '" draggable="true">\
                        <span class="icon"><i class="' + icon + '"></i></span>\
                        <span class="icon-title">' + eType + '</span>\
                    </div>');
                helper.css('position', 'absolute');
                return helper;
            },
            items: elmnItem,
            opacity: 1,
            placeholder: 'ui-state-highlight',
            // revert: true,
            scroll: false,
            // scrollSensitivity: 10,
            // scrollSpeed: 40,
            tolerance: 'pointer',
            zIndex: 9999,
            activate: function(event, ui) {},
            beforeStop: function(event, ui) {},
            change: function(event, ui) {
                $(ui.placeholder).hide().fadeIn('400');
            },
            create: function(event, ui) {

            },
            deactivate: function(event, ui) {},
            out: function(event, ui) {
                sortableElm.removeClass('lwwb-is-sortable')
                sortableElm.find('.placeholder').html('<i class="fa fa-plus"></i>');                
                sortableElm.find('>.ui-state-highlight').hide();                
            },
            over: function(event, ui) {
                sortableElm.addClass('lwwb-is-sortable')
                if (!sortableElm.find('>.placeholder >.ui-state-highlight').length) {
                    sortableElm.find('.placeholder').html('<div style="display:none;" class="ui-state-highlight">&nbsp;</div>');
                    sortableElm.find('>.placeholder >.ui-state-highlight').fadeIn('slow').css('height', '100%')
                }else{
                    sortableElm.find('>.ui-state-highlight').fadeIn('slow')
                }
            },
            receive: function(event, ui) {
                $(ui.placeholder).hide().fadeIn('400');
            },
            remove: function(event, ui) {

            },
            sort: function(event, ui) {},
            start: function(event, ui) {
                $(ui.placeholder).hide().fadeIn('400');
            },
            stop: function(event, ui) {

            },
            update: function(event, ui) {
                const modelCid = ui.item.data('model-cid'),
                    destinationSortableModelCid = ui.item.parents('.lwwb-elmn').first().data('model-cid'),
                    sourceSortableModelCid = self.view.model.cid,
                    childCollectionView = self.view.getRegion('childRegion').currentView;
                if (!childCollectionView) {
                    return
                }
                let prevModelCid = ui.item.prev().data('model-cid'),
                    nextModelCid = ui.item.next().data('model-cid'),
                    childView = childCollectionView.children.findByModelCid(modelCid),
                    prevView = childCollectionView.children.findByModelCid(prevModelCid),
                    nextView = childCollectionView.children.findByModelCid(nextModelCid);
                if (ui.sender === null) {
                    if (destinationSortableModelCid === sourceSortableModelCid && childView) {
                        if (prevView) {
                            prevView.trigger('sort:elmn', prevView, childView.model, 'after');
                            childView.trigger('remove:elmn', childView);
                        } else if (nextView) {
                            nextView.trigger('sort:elmn', nextView, childView.model, 'before');
                            childView.trigger('remove:elmn', childView);
                        }
                    } else {
                        lwwb.Radio.channel.trigger('move:elmn:by:model:cid', destinationSortableModelCid, childView, prevModelCid, nextModelCid);
                    }
                }
            },
        });
    },
});
module.exports = SortableElmn;