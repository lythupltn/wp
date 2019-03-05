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

class Tab extends Button_Set
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-tab';

    public $choice       = array();

    protected function field_header()
    {}

    protected function field_template()
    {

        ?>
        <ul class="lwwb-tabs-heading">
            <# _.each( data.choices, function(val, key){ #>
                <li class="lwwb-tab-heading lwwb-tab-{{{ key }}}"">
                    <input
                        id="{{ data.id }}_{{ key }}"
                        type="radio"
                        class="lwwb-input"
                        value="{{ key }}"
                        name="{{{ data.id }}}_{{{ data.name }}}"
                        data-key="{{{ data.name }}}" 
                        <# if ( key === data.value ) { #> checked="checked" <# } #> />
                    <label for="{{ data.id }}_{{ key }}" class="tab_content">{{{ val }}}</label>
                </li>
            <# }); #>
        </ul>
        <?php
    }
}