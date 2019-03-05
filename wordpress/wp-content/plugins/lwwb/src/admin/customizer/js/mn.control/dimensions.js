lwwb.Control.Mn.Behaviors['dimensions'] = Marionette.Behavior.extend({
    onRender() {
        let controlData = this.view.model.get('value');
        if (controlData) {
            if (controlData['is_linked'] && controlData['is_linked'] === 'true') {
                this.view.$el.find('.lwwb-unlinked').css('display', 'none');
                this.view.$el.find('.lwwb-linked').css('display', 'block');
            } else {
                this.view.$el.find('.lwwb-unlinked').css('display', 'block');
                this.view.$el.find('.lwwb-linked').css('display', 'none');
            }
        }
    },
});
lwwb.Control.Mn.Views['dimensions'] = lwwb.Control.Mn.Views['base'].extend({

    onUpdateInputData(view, event) {
        let key = $(event.currentTarget).data('key');
        let val = $(event.currentTarget).val();
        if ('' === val) {
            val = 0;
            $(event.currentTarget).val(0);
        }
        let controlData = this.model.get('value');
        controlData = (!Array.isArray(controlData)) ? controlData : {}
        controlData = controlData ? controlData : {};
        controlData['unit'] = controlData['unit'] ? controlData['unit'] : Object.keys(this.model.get('unit'))[0];
        controlData[key] = val;
        let parents = $(event.target).parents('.dimension-wrapper.linked');
        if (parents.length) {
            let siblings = parents.siblings().find('input.lwwb-input:not(:disabled)');
            siblings.each(function(index, el) {
                $(el).val(val);
                let _key = $(el).data('key');
                controlData[_key] = val;
            });
            controlData['is_linked'] = 'true';
        } else {
            controlData['is_linked'] = 'false';
        }
        this.model.set('value', controlData);
        this.trigger('update:data', this, controlData);
    }
});