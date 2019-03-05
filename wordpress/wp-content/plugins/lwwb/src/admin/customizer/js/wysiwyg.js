wp.customize.controlConstructor['lwwb-wysiwyg'] = wp.customize.Control.extend({
    ready: function() {
        'use strict';
        var control = this;
        control.init();
    },
    init: function() {
        var control = this,
            editorSettings = control.params.editor_settings;
        control.container.find('textarea').each(function() {
            let editorID = $(this).attr('id'),
                editor,
                setChange,
                content;
            setTimeout(function() {
                wp.editor.initialize(editorID, editorSettings);
                editor = window.tinyMCE.get(editorID);
                if (editor) {
                    editor.on('change', function(e) {
                        editor.save();
                        content = editor.getContent();
                        clearTimeout(setChange);
                        setChange = setTimeout(function() {
                            control.setting.set(content);
                        }, 50);
                    });
                }
            });
        });
    }
});