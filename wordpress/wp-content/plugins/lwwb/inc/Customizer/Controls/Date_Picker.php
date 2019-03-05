<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Customizer\Controls;

class Date_Picker extends Text
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-date-picker';

    public $input_type = 'date';

    public $input_attrs = '';

    protected function field_template()
    {
        ?>
        <input
            id="{{ data.id }}"
            class="datepicker lwwb-input"
            data-key="{{{ data.id }}}"
            value="{{ data.value }}"
            type="date"
            <# if ( data.input_attrs ) { #>{{{ data.input_attrs }}}<# }  #>
            <# if ( data.link ) { #> {{{ data.link }}} <# } #> />
        <?php
}
}