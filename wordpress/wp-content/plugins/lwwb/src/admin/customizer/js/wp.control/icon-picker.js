lwwb.Control.Wp['icon-picker'] = {
    $control: null,
    $iconSidebar: null,
    $customizerEl: null,
    customizerWidth: null,
    init: function($ctr) {
        var $document = $ctr? $ctr: $(document);
        const self = this;
        self.$iconSidebar = $('#lwwb-sidebar-icons').first();
        self.$customizerEl = $('#customize-controls');
        self.customizerWidth = $('#customize-controls').width();
        $document.on('click', '.lwwb-control-lwwb-icon-picker input.pick-icon', function(e) {
            e.preventDefault();
            self.$control = $(this).parents('.lwwb-control-lwwb-icon-picker').first();
            self.openIconSidebar();
        });
        $document.on('click', '.lwwb-control-lwwb-icon-picker .remove-icon', function(e) {
            e.preventDefault();
            self.$control = $(this).parents('.lwwb-control-lwwb-icon-picker').first();
            self.removeIcon();
        });
    },
    openIconSidebar: function() {
        const self = this;
        self.$iconSidebar.css('left', self.customizerWidth + 1).addClass('lwwb-active');
        self.searchIcon();
        self.pickIcon();
        self.$iconSidebar.on('click', '.customize-controls-icon-close', function(event) {
            event.preventDefault();
            self.closeIconSidebar();
        });
    },
    pickIcon: function() {
        const self = this;
        self.$iconSidebar.on('click', '#lwwb-icon-browser li', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let icon = $(e.currentTarget).data('icon');
            self.$control.find('.preview-icon-icon i').attr('class', '').addClass(icon)
            self.$control.find('input.pick-icon').attr('value', icon).change();
            self.closeIconSidebar();
        });
    },
    removeIcon: function() {
        this.$control.find('.preview-icon-icon i').attr('class', '').addClass('');
        this.$control.find('input.pick-icon').attr('value', '').change();
    },
    closeIconSidebar() {
        const self = this;
        self.$iconSidebar.css('left', -(self.customizerWidth)).removeClass('lwwb-active');
        // self.$control = null;
    },
    searchIcon: function() {
        const self = this;
        self.$iconSidebar.find('#lwwb-icon-search').on('keyup', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let searchData = $(this).val().trim();
            if (searchData) {
                self.$iconSidebar.find('.lwwb-list-icons > li').hide();
                self.$iconSidebar.find('.lwwb-list-icons').find(" > li[data-icon*='" + searchData + "']").show()
            } else {
                self.$iconSidebar.find('.lwwb-list-icons > li').show();
            }
        })
    }
}
