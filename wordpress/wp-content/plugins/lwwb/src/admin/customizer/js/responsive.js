/**
 * File responsive.js
 *
 * Handles the responsive
 *
 * @package Lwwb
 */

wp.customize.controlConstructor['lwwb-responsive'] = wp.customize.Control.extend({

    // When we're finished loading continue processing.
    ready: function () {

        'use strict';

        var control = this,
            value;

        control.lwwbResponsiveInit();

        /**
         * Save on change / keyup / plwwbe
         */
        this.container.on('change keyup plwwbe', 'input.lwwb-responsive-input, select.lwwb-responsive-select', function () {

            value = jQuery(this).val();

            // Update value on change.
            control.updateValue();
        });

        /**
         * Refresh preview frame on blur
         */
        this.container.on('blur', 'input', function () {

            value = jQuery(this).val() || '';

            if (value == '') {
                wp.customize.previewer.refresh();
            }

        });

    },

    /**
     * Updates the sorting list
     */
    updateValue: function () {

        'use strict';

        var control = this,
            newValue = {};

        // Set the spacing container.
        control.responsiveContainer = control.container.find('.lwwb-responsive-wrapper').first();

        control.responsiveContainer.find('input.lwwb-responsive-input').each(function () {
            var responsive_input = jQuery(this),
                item = responsive_input.data('id'),
                item_value = responsive_input.val();

            newValue[item] = item_value;

        });

        control.responsiveContainer.find('select.lwwb-responsive-select').each(function () {
            var responsive_input = jQuery(this),
                item = responsive_input.data('id'),
                item_value = responsive_input.val();

            newValue[item] = item_value;
        });

        control.setting.set(newValue);
    },

    lwwbResponsiveInit: function () {

        'use strict';
        this.container.find('.lwwb-responsive-switchers button').on('click', function (event) {
            var device = jQuery(this).attr('data-device');
            jQuery('.wp-full-overlay-footer .devices button[data-device="' + device + '"]').trigger('click');
        });
    },
});