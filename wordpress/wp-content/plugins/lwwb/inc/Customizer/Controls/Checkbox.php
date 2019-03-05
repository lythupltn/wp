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

class Checkbox extends Base_Control
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type         = 'lwwb-checkbox';
    public $choice       = array();

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     *
     * @access public
     */
    public function to_json()
    {
        parent::to_json();

        $this->json['default']      = $this->setting->default;
        $this->json['value']        = $this->value();
        $this->json['choices']      = $this->choices;
        $this->json['link']         = $this->get_link();

    }

    protected function field_template()
    {
        ?>
        <# _.each(data.choices,function(val,key){ #>
            <input
                type="checkbox"
                id="{{ data.id }}_{{ key }}"
                value="{{ key }}"
                class="lwwb-input"
                data-input="{{ key }}"
                name="{{ key }}" <# if( _.contains(data.value, key)){ #> checked <# } #> />
            <label for"{{ data.id }}_{{ key }}">{{{ val }}}</label>
        <# }) #>
            <input type="hidden" class="checkbox-hidden-value" value="{{ data.value }}" <# if ( data.link ) { #> {{{ data.link }}} <# } #>>
        <?php
}
}