lwwb.Control.Wp['wysiwyg'] = {
    $control: null,
    init: function($ctr) {
        const self = this;
        self.$control = $ctr ? $ctr : $(document);
        self.$control.find('.lwwb-control-lwwb-wysiwyg > textarea').each(function() {
            var $this = $(this),
                editorID = $this.attr('id'),
                editor,
                setChange,
                content;
            setTimeout(function() {
                let editorConfig = window.wp.editor.getDefaultSettings();
                _.extend(editorConfig, {
                    mediaButtons: true,
                })
                _.extend(editorConfig.tinymce, {
                    height: 250,
                })
                wp.editor.initialize(editorID, editorConfig);
                editor = window.tinyMCE.get(editorID);
                if (editor) {
                    editor.on('change', function(e) {
                        editor.save();
                        content = editor.getContent();
                        clearTimeout(setChange);
                        setChange = setTimeout(function() {
                            $this.val(content).trigger('change');
                        }, 50);
                    });
                }
            }, 50);
        });
    }
}
