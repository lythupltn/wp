global.lwwb = global.lwwb || {};
global.lwwb.Control = global.lwwb.Control || {};
global.lwwb.Control.Wp = global.lwwb.Control.Wp || {};
lwwb.Control.Wp['responsive-switcher'] = {
    $controls: null,
    $body: $('.wp-full-overlay'),
    $footerDevices: $('.wp-full-overlay-footer .devices'),
    init: function() {
        var $document = $(document);
        const self = this;
        $document.on('click', '.lwwb-control-lwwb-responsive-switcher button', function(event) {
            const device = $(event.currentTarget).data('device');
            self.responsiveControl(device);
            self.wpResponsiveControl(device);
            
        });

        self.$footerDevices.on('click', 'button', function(event) {
            const device = $(event.currentTarget).data('device');
            self.responsiveControl(device);

        })
    },
    responsiveControl(device){
        var $document = $(document);
        const self = this;
        $document.find('.lwwb-control-lwwb-responsive-switcher button').removeClass('active');
        $document.find('.lwwb-control-lwwb-responsive-switcher button[data-device="' + device + '"]').addClass('active');
        $document.find('.lwwb-control-container[data-on_device]').removeClass('active');
        $document.find('.lwwb-control-container[data-on_device="' + device + '"]').addClass('active');

    },
    wpResponsiveControl(device){
        const self = this;
        self.$footerDevices.find('.preview-' + device).addClass('active').attr('aria-pressed', true).trigger('click');
    }
}
