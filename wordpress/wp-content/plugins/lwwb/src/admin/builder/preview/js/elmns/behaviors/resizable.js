var ElmnResizable = Marionette.Behavior.extend({
	onRender(){
        if (12 <= this.view.model.collection.size()) {
            return;
        }
        this.view.resize();
	},
 
});

module.exports = ElmnResizable;