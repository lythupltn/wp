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

class Color_Picker extends Base_Control
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-color-picker';

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     *
     * @access public
     */
    public function to_json()
    {
        parent::to_json();

        $this->json['default']     = $this->setting->default;
        $this->json['value']       = $this->value();
        $this->json['link']        = $this->get_link();

    }

    protected function field_template()
    {
        ?>
        <input class="alpha-color-control lwwb-input" 
            data-key="{{{ data.id }}}" 
            name="{{{ data.id }}}"
            data-palette="true" 
            data-alpha="true"
            type="text" 
            value="{{ data.value }}" 
            data-show-opacity="true"
            data-default-color="{{ data.default }}" <# if ( data.link ) { #> {{{ data.link }}} <# } #> />
        <?php
}
}