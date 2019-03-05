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

class Unit extends Base_Control
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-unit';

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
            <# _.each( data.choices, function(unit, key){ #>
                <input
                    id="{{data.id}}_{{{ unit }}}"
                    type="radio"
                    data-key="unit"
                    name="{{ data.id }}_unit"
                    value="{{ key }}"
                    class="lwwb-input"
                    <# if ( unit === data.value ) { #> checked="checked" <# } #>
                    <# if ( data.link ) { #> {{{ data.link }}} <# } #> >
                <label for="{{data.id}}_{{{ unit }}}">{{{ unit }}}</label>
            <# }) #>
        <?php
}
}