lwwb.Control.Mn.Behaviors['slider'] = Marionette.Behavior.extend({

});
lwwb.Control.Mn.Views['slider'] = lwwb.Control.Mn.Views['base'].extend({
    onUpdateInputData(view, event) {
        let deviceConfigs = this.model.get('device_config');
        if (deviceConfigs) {
            this.updateResponsiveData(view, event);
            return;
        }
    lwwb.Control.Mn.Views['base'].prototype.onUpdateInputData.apply(this, arguments);

    },
    updateResponsiveData(view, event){
        let key = $(event.currentTarget).data('key');
        let device = $(event.currentTarget).data('device');
        let val = $(event.currentTarget).val();
        if ('unit' === key) {
            this.updateInputAttrs(device, val);
        }
        let controlValue = this.model.get('value');
        controlValue = (!Array.isArray(controlValue)) ? controlValue : {}
        controlValue[device] = controlValue[device] ? controlValue[device] : {};
        controlValue[device]['unit'] = controlValue[device]['unit'] ? controlValue[device]['unit'] : Object.keys(this.model.get('unit'))[0];
        _.extend(controlValue[device], {
            [key]: val
        })
        if (!controlValue[device]['value']) {
            return;
        }
        this.model.set('value', controlValue);
        this.trigger('update:data', this, controlValue);

    },
    updateInputAttrs(device, unit) {
        let deviceInput = this.$el.find('.lwwb-control-lwwb-slider .' + device + ' input');
        let unitConfig = this.model.get('unit');
        deviceInput.attr('min', unitConfig[unit]['min']);
        deviceInput.attr('max', unitConfig[unit]['max']);
        deviceInput.attr('step', unitConfig[unit]['step']);
    },
    onUpdateOptionUnit(option){
        if ('width'=== this.model.get('id')) {  
            let desktopInput = this.$el.find('.lwwb-control-lwwb-slider .desktop input');
                desktopInput.attr('min', option['%']['min']);
                desktopInput.attr('max', option['%']['max']);
                desktopInput.attr('step', option['%']['step']);            
        }
    }
});