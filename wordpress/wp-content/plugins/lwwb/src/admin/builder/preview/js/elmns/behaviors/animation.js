var AnimationBehavior = Marionette.Behavior.extend({
    onRender(){

        let elmnData = this.view.model.get('elmn_data');
        if (!elmnData) {
            return;
        }
        if (elmnData['entrance_animation']) {
        	this.view.$el.addClass('wow');
            this.view.$el.addClass(elmnData['entrance_animation']);
            if (elmnData['animation_duration']) {
            this.view.$el.addClass(elmnData['animation_duration']);

            }
        }

    }
})

module.exports = AnimationBehavior;