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

class Modal extends Base_Control
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-modal';

    public $fields      = array();
    public $button_icon = 'fa fa-pencil';

    public function to_json()
    {
        parent::to_json();

        $this->json['default']     = $this->setting->default;
        $this->json['value']       = $this->value();
        $this->json['link']        = $this->get_link();
        $this->json['button_icon'] = $this->button_icon;
        $this->json['fields']      = $this->fields;

    }

    protected function field_header()
    {
        ?>

            <#
                if(data.value == null){
                    data.value = data.default;
                }
            #>
        <# if(data.label || data.description) { #>
            <div class="control-title-description">
                <# if ( data.label ) { #>
                    <span class="customize-control-title">{{{ data.label }}}</span>
                <# } #>
                <# if ( data.description ) { #>
                    <span class="customize-control-description">{{{ data.description }}}</span>
                <# } #>
                    <# var _buttonIcon = (data.button_icon) ? data.button_icon : 'fa fa-pencil'; #>
                    <div class="control-action">
                        <span class="lwwb-reset-control"><span class="dashicons dashicons-image-rotate"></span></span>
                        <button type="button" class="modal-action button">
                           <i class="{{{ _buttonIcon }}}"></i>
                        </button>
                    </div>
            </div>
            <# } #>
        <?php
    }


    protected function field_template()
    {
        ?>

        <div class="modal-wrapper">
            <div class="widget-inside">
                <div class="modal-content">
                </div>
            </div>
        </div>
        <?php
}

}