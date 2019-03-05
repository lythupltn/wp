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

class Base_Control extends \WP_Customize_Control
{
    public $dependencies = null;
    public $on_device = '';

    public function to_json()
    {
        parent::to_json();
        $this->json['id']           = $this->id;
        $this->json['dependencies'] = $this->dependencies;
        $this->json['on_device'] = $this->on_device;
    }

    protected function field_header()
    {
        ?>

            <#
                if(!data.value){
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
            </div>
            <# } #>
        <?php
}

    protected function before_field()
    {
        static::field_header();
        ?>
        <div id="lwwb-control-{{{ data.id }}}" class="lwwb-control lwwb-control-{{{ data.type }}}">
        <?php

    }

    protected function after_field()
    {
        ?>
        </div>
        <?php
}

    protected function content_template()
    {

        static::before_field();
        static::field_template();
        static::after_field();
    }

    protected function field_template()
    {}

}