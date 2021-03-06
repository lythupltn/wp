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

class WYSIWYG extends Base_Control
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-wysiwyg';

    public $placeholder = '';
    public $editor_settings = array();

    public $input_attrs = '';

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     *
     * @access public
     */

    public function enqueue()
    {
        wp_enqueue_editor();
    }
    public function to_json()
    {
        parent::to_json();

        $this->json['default']     = $this->setting->default;
        $this->json['value']       = $this->value();
        $this->json['link']        = $this->get_link();
        $this->json['input_attrs'] = $this->input_attrs;
        $this->json['placeholder'] = $this->placeholder;
        $this->json['editor_settings'] = $this->editor_settings;

    }

    protected function field_template()
    {
        ?>
            <textarea
            id="{{ data.id }}<# if('undefined' !== typeof view) {#>{{ view.cid }}<# } #>"
            class="lwwb-input widefat text"
            data-key="{{{ data.id }}}"
            type="<# if ( data.input_type ) { #>{{{ data.input_type }}}<# }  #>"
            placeholder="<# if ( data.placeholder ) { #>{{{ data.placeholder }}}<# }  #>"
            <# if ( data.link ) { #> {{{ data.link }}} <# } #>>{{ data.value }}</textarea>
        <?php

    }
}
