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

class Button_Set extends Radio
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-button-set';

    public $display_type = '';

    public $link_data = true;

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     *
     * @access public
     */
    public function to_json()
    {
        parent::to_json();

        $this->json['display_type'] = $this->display_type;
        $this->json['link'] = $this->link_data ? $this->get_link() : false;

    }

    protected function field_template()
    {

        ?>
            <# _.each( data.choices, function(val, key){ #>
                <input
                id="{{ data.id }}_{{ key }}"
                class="switch-input lwwb-input"
                type="radio"
                value="{{ key }}"
                name="{{{ data.id }}}_{{{ data.name }}}"
                data-key="{{{ data.name }}}" <# if ( key ===
                data.value ) { #> checked="checked" <# } #>
                <# if ( data.link ) { #> {{{ data.link }}} <# } #> />
                <label for="{{ data.id }}_{{ key }}">
                    <# if(data.display_type === 'icon'){ #>
                    <span class="{{ val }}"></span>
                    <# }else{ #> {{ val }} <# } #>
                </label>
            <# }) #>
        <?php
}
}