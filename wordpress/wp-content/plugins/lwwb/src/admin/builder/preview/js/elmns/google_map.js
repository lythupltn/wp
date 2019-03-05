lwwb.Builder.Mn.Views['google_map'] = lwwb.Builder.Mn.Views['elmn'].extend({
    onUpdateAddress(childView, dataKey, data){
        this.render();
    },
    onUpdateZoom(childView, dataKey, data){
        this.render();
    }

});