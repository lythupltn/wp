lwwb.Control.Mn.Behaviors['color-picker']  = Marionette.Behavior.extend({
    
});
lwwb.Control.Mn.Views['color-picker']  = lwwb.Control.Mn.Views['base'].extend({
    onRender(){
        let self = this;
        self.$el.find('textarea').each(function() {
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
});