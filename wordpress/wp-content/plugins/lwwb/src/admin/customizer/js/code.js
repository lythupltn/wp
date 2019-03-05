wp.customize.controlConstructor['lwwb-code-editor'] = wp.customize.Control.extend({
    ready: function() {
        'use strict';
        var control = this;
        lwwb.Control.Wp['code-editor'].init(control.container);
    }
});