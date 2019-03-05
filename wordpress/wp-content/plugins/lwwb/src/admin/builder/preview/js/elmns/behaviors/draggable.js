// import HelperFn from './helper.functions';
var DraggableBehavior = Marionette.Behavior.extend({
    onRender() {
        const self = this;

        self.view.$el.on('dragenter', function(event) {
            self.onDragEnter(event);
        });
        self.view.$el.on('dragover', function(event) {
            self.onDragOver(event);
        });
        self.view.$el.on('dragleave', function(event) {
            self.onDragLeave(event);
        });
        self.view.$el.on('drop', function(event) {
            self.onDrop(event);
        });
    },
    onDragEnter(event) {
        event.preventDefault();
        event.stopPropagation();
        this.view.$el.addClass('lwwb-is-dragover');
    },
    onDragOver(event) {
        event.preventDefault();
        event.stopPropagation();
        const self = this;

        if (self.isEmptyChild()) {
            self.onDragOverEmpty(event);
            return;
        }

        let mousePrecentage = self.getMousePercentage(event);
        let lwwbElmn = $(event.target).closest('.lwwb-elmn');
        let elmnHasHighLight = lwwbElmn.find('.ui-state-highlight').length ? true : false;
         if (mousePrecentage.y < 50) {
                    if (! elmnHasHighLight) {
                        lwwbElmn.prepend($('<div style="display:none;" class="ui-state-highlight">&nbsp;</div>').fadeIn('slow'));
                    }
                } else {
                    if (! elmnHasHighLight) {
                        lwwbElmn.append($('<div style="display:none;" class="ui-state-highlight">&nbsp;</div>').fadeIn('slow'));
                    }
                }
        mousePrecentage = self.getMousePercentage(event);

        if (mousePrecentage.y > 40 && mousePrecentage.y < 60) {
            self.view.$el.find('.ui-state-highlight').remove();
        }

    },

    onDragOverEmpty(event){
        let self = this;
         if ( self.isHighLight()) {
            return;
         }        
        self.view.$el.find('.placeholder').html('<div style="display:none;" class="ui-state-highlight">&nbsp;</div>');
        self.view.$el.find('.ui-state-highlight').fadeIn('slow').css('height', '100%')

    },
    onDragLeave(event) {
        event.preventDefault();
        event.stopPropagation();
        const self = this;
            let currentViewModelCid = $(event.currentTarget).data('model-cid');
            let relatedModelCid = $(event.relatedTarget).parents('.lwwb-elmn-column').first().data('model-cid');
            if (!relatedModelCid ||( relatedModelCid !== currentViewModelCid)) {
                self.view.$el.removeClass('lwwb-is-dragover');
                self.view.$el.find('.ui-state-highlight').remove();
                self.view.$el.find('.elmn-is-empty .placeholder').html('<i class="fa fa-plus"></i>');
            }
    },
    onDrop(event) {
        event.preventDefault();
        event.stopPropagation();
        let self = this;
                self.view.$el.find('.placeholder').html('<i class="fa fa-plus"></i>');
        
        const dataElmnType = event.originalEvent.dataTransfer.getData('text/plain'),
                dataModel = lwwb.Builder.HelperFn.getDefaultElmn(dataElmnType),
                currentChildView = self.view.getRegion('childRegion').currentView,
                targetElmn = $(event.target).closest('.lwwb-elmn'),
                isInner = $(event.target).parents('.is_inner').length? true: false;
            if (dataModel) {
                if ('section' === dataElmnType) {
                    if (isInner) {
                        return;
                    }else{
                        dataModel.elmn_data['is_inner'] = true;
                        dataModel.elmn_child = [
                            lwwb.Builder.HelperFn.getDefaultElmn('column'),
                        ];
                    }
                }
                if (currentChildView) {
                    const elmnView = self.view.getRegion('childRegion').currentView.children.findByModelCid(targetElmn.data('model-cid')),
                        mousePrecentage = self.getMousePercentage(event);
                    if (elmnView) {
                        if (mousePrecentage.y < 50) {
                            elmnView.trigger('add:elmn', elmnView, dataModel, 'before');
                            self.view.render();
                        } else {
                            elmnView.trigger('add:elmn', elmnView, dataModel, 'after');
                            self.view.render();
                        }
                    }
                } else {
                    self.view.model.set('elmn_child', [dataModel]);
                    self.view.trigger('update:elmn', self.view);
                    self.view.render();
                }
            }        
    },
    isEmptyChild(){
        let emptyChild = this.view.model.get('elmn_child').length? false : true;
        return emptyChild;
    },
    isHighLight(){
        let highLight = this.view.$el.find('.ui-state-highlight').length? true :false; 
        return highLight;
    },


    getMousePercentage: function(event) {
        let target = $(event.target);
        var x = event.originalEvent.clientX;
        var y = event.originalEvent.clientY;
        var mousePosition = {
            x: x,
            y: y
        };
        return this.getMouseBearingsPercentage(target, null, mousePosition);
    },
    getMouseBearingsPercentage: function(elmn, elmnRect, mousePos) {
        if (!elmnRect) elmnRect = elmn.get(0).getBoundingClientRect();
        var mousePosPercent_X = ((mousePos.x - elmnRect.left) / (elmnRect.right - elmnRect.left)) * 100;
        var mousePosPercent_Y = ((mousePos.y - elmnRect.top) / (elmnRect.bottom - elmnRect.top)) * 100;
        return {
            x: mousePosPercent_X,
            y: mousePosPercent_Y
        };
    },
})
module.exports = DraggableBehavior;