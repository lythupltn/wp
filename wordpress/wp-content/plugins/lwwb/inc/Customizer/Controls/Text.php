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

class Text extends Base_Control
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-text';

    public $input_type = 'text';

    public $placeholder = '';

    public $input_attrs = '';

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
        $this->json['input_type']  = $this->input_type;
        $this->json['input_attrs'] = $this->input_attrs;
        $this->json['placeholder'] = $this->placeholder;

    }

    protected function field_template()
    {
        ?>
        <input
            id="{{ data.id }}"
            class="lwwb-input"
            data-key="{{{ data.id }}}"
            value="{{ data.value }}"
            type="{{ data.input_type }}"
            placeholder="<# if ( data.placeholder ) { #>{{{ data.placeholder }}}<# }  #>"
            <# if ( data.input_attrs ) { #>{{{ data.input_attrs }}}<# }  #>
            <# if ( data.link ) { #> {{{ data.link }}} <# } #> />
        <?php
}
}