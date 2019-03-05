lwwb.Control.Wp['code-editor'] = {
    $control: null,
    init: function($ctr) {
        this.$control = $ctr ? $ctr : $(document);
        this.$control.find('textarea.code').each(function() {
            let $this = $(this),
                codeEditor,
                codeEditorSettings = $this.data('editor_settings');
            codeEditor = wp.codeEditor.initialize($this, codeEditorSettings);
            codeEditor.codemirror.refresh()
            codeEditor.codemirror.on('change', function(cm) {
                cm.save();
                $this.val(cm.getValue()).trigger('change');
                
            });
        });
    }
};