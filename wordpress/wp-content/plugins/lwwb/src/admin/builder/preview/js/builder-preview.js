import Views from './views';

(function (api) {
    api.bind('preview-ready', function () {
        api.preview.bind('active', function () {
            api.preview.send('preview_data', _lwwbData);
        });
        let _data = _lwwbData.page.content;
        let collection = new Backbone.Collection(_data);
        var hooks = [];
        _.each(_lwwbData.config.builderHooks, function (val, key) {
            if (val) {
                hooks.push(key);
            }
        });
        const lwwbViewContent = new Views.LWWB({
            collection: new Backbone.Collection(_data),
            hooks: hooks
        });

        _.each(_lwwbData.config.builderHooks, function (value, hook) {
            let hookEl = $('#lwwb-content-wrapper-' + hook);
            if (hookEl.length) {
                lwwbViewContent.addRegion(hook, {
                    el: hookEl
                });
            }
        });

        let hfHooks = [
            'lwwb_theme_header',
            'lwwb_theme_footer'
        ];


        const headerFooterData = _lwwbData.page.content;
        let headerFooterCollection = new Backbone.Collection(headerFooterData);
        const lwwbViewHeaderFooter = new Views.LWWB({
            collection: headerFooterCollection,
            hooks: hfHooks
        });

        _.each(hfHooks, function (hook) {
            let hookEl = $('#lwwb-content-wrapper-' + hook);

            if (hookEl.length) {
                lwwbViewHeaderFooter.addRegion(hook, {
                    el: hookEl
                });
            }
        });

        lwwbViewContent.on('update:region:data', function () {
            api.preview.send('collection_data' + _lwwbData.page.id, this.collection.toJSON());
        });
        lwwbViewHeaderFooter.on('update:region:data', function () {
            api.preview.send('collection_data' + _lwwbData.page.id, this.collection.toJSON());
        });
        lwwbViewContent.render();
        lwwbViewHeaderFooter.render();

    });
})(wp.customize);