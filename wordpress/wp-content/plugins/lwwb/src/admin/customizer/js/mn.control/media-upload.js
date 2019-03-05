lwwb.Control.Mn.Behaviors['media-upload']  = Marionette.Behavior.extend({
    
        onRender() {
        const self = this;
        if (self.view.model.get('type')) {
            let mediaType;
            mediaType = self.view.model.get('media_type') ? self.view.model.get('media_type') : 'image';
            let controlBehavior = mediaType + '-upload';
            if ('undefined' !== typeof lwwb.Control.Wp[controlBehavior]) {
                lwwb.Control.Wp[controlBehavior].init(self.view.$el);
            }
        }
    },
});
lwwb.Control.Mn.Views['media-upload']  = lwwb.Control.Mn.Views['base'].extend({
});