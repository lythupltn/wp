(function ($, document) {
    'use strict';

    /**
     * The analyze module for Yoast SEO.
     */
    var module = {
        timeout: undefined,

        // Initialize
        init: function () {
            if (typeof YoastSEO !== 'undefined') {
                // the variable is defined
                addEventListener('load', module.load);
            }
        },

        // Load plugin and add hooks.
        load: function () {
            YoastSEO.app.registerPlugin('LWWB', {status: 'loading'});

            // Update Yoast SEO analyzer when fields are updated.
            module.listenToField;

            YoastSEO.app.pluginReady('LWWB');
            YoastSEO.app.registerModification('content', module.addContent, 'LWWB', 5);


            // Make the Yoast SEO analyzer works for existing content when page loads.
            module.update();
        },

        // Add content to Yoast SEO Analyzer.
        addContent: function (content) {
            content += ' ' + getFieldContent();
            return content;
        },

        // Listen to field change and update Yoast SEO analyzer.
        listenToField: function () {

            var field = document.getElementById('lwwb_meta_content');
            if (field) {
                field.addEventListener('keyup change', module.update);
            }
        },

        // Update the YoastSEO result. Use debounce technique, which triggers only when keys stop being pressed.
        update: function () {
            clearTimeout(module.timeout);
            module.timeout = setTimeout(function () {
                YoastSEO.app.refresh();
            }, 250);
        },
    };


    /**
     * Get field content.
     * Works for normal inputs and TinyMCE editors.
     *
     * @param fieldId The field ID
     * @returns string
     */
    function getFieldContent() {
        var field = document.querySelector('textarea#lwwb_meta_content');
        if (field) {
            var content = field.value;
            return content ? content : '';
        }
        return '';
    }


    // Run on document ready.
    $(module.init);
})(jQuery, document);