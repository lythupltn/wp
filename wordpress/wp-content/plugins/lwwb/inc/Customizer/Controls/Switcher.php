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

class Switcher extends Base_Control
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-switcher';

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     *
     * @access public
     */
    public function to_json()
    {
        parent::to_json();
        $this->json['default'] = $this->setting->default;
        $this->json['value']   = $this->value();
        $this->json['link']    = $this->get_link();
    }

    protected function field_template()
    {

        ?>
        <div class="switcher-wrapper">
            <input data-key="data.id" name="{{{ data.id }}}" id="switcher_{{ data.id }}"
                   type="checkbox" class="lwwb-input"
                   value="{{ data.value }}" 
                   <# if ( 'yes' === data.value ) { #> checked="checked" <# } #>
                   <# if ( data.link ) { #> {{{ data.link }}} <# } #> />
            <label for="switcher_{{ data.id }}"></label>
        </div>
        <?php
}

}