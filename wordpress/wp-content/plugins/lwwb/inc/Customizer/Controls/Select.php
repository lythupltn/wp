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

class Select extends Base_Control
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-select';

    public $choice = array();

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
        $this->json['choices'] = $this->choices;
        $this->json['link']    = $this->get_link();

    }

    protected function field_template()
    {
        ?>
            <select name="{{{ data.id }}}" class="lwwb-select" data-key="{{{ data.id }}}" <# if ( data.link ) { #> {{{ data.link }}} <# } #> >
                <# _.each( data.choices, function(key, val){ #>
                    <option value="{{ val }}" <# if( data.value === val ){ #> selected <# } #> >{{{ key }}}</option>
                <# }) #>
            </select>
        <?php
}
}