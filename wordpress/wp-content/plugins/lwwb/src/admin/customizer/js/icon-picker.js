wp.customize.controlConstructor['lwwb-icon-picker'] = wp.customize.Control.extend({
    ready: function() {
        'use strict';
        var control = this;
        lwwb.Control.Wp['icon-picker'].init(control.container);
    },
});
