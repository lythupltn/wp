lwwb.Control.Mn.Behaviors['code-editor']  = Marionette.Behavior.extend({
    
});
lwwb.Control.Mn.Views['code-editor']  = lwwb.Control.Mn.Views['base'].extend({
    // onUpdateInputData(view, event) {
    //     console.log('update')
    //     let dataKey = $(event.currentTarget).data('key');
    //     let val = $(event.currentTarget).val();
    //     let controlValue = this.model.get('value');
    //     _.extend(controlValue, {[dataKey]: val})

    //     let parents = $(event.target).parents('.dimension-wrapper.linked');
    //     if (parents.length) {
    //         let siblings = parents.siblings().find('input.lwwb-input:not(:disabled)');
    //         siblings.each(function(index, el) {
    //             $(el).val(val);
    //             let _dataKey = $(el).data('key');
    //             _.extend(controlValue, {[_dataKey]: val})
    //         });
            
    //     }

    //     this.model.set('value', controlValue);
        
    //     this.trigger('update:data', this, controlValue);
    // }
});