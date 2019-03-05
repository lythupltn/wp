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

class Slider extends Base_Control
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-slider';

    public $input_attrs = array(
        'min'  => '',
        'step' => '',
        'max'  => '',
    );

    public $unit          = array(
        'px' => array(
            'min'  => '-1000',
            'max'  => '1000',
            'step' => '1',
          ),
        '%' => array(
            'min'  => '0',
            'max'  => '100',
            'step' => '0.1',
          ),
    );
    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     *
     * @access public
     */
    public function to_json()
    {
        parent::to_json();

        $this->json['default']       = $this->setting->default;
        $this->json['value']         = $this->value();
        $this->json['link']          = $this->get_link();
        $this->json['input_attrs']   = $this->input_attrs;
        $this->json['unit']          = $this->unit;

    }
   protected function field_header()
    {
        ?>

            <#
                if(data.value == null){
                    data.value = data.default;
                }
            #>
        <div class="lwwb-control-header">

        <# if(data.label || data.description) { #>
            <div class="control-title-description lwwb-header-item">
                <# if ( data.label ) { #>
                    <span class="customize-control-title">{{{ data.label }}}</span>
                <# } #>
                <# if ( data.description ) { #>
                    <span class="customize-control-description">{{{ data.description }}}</span>
                <# } #>
            </div>
            <# } #>

            <# if(data.unit ){ #>
                <div class="lwwb-control-lwwb-unit lwwb-header-item">
                  <ul class="unit-wrapper">
                  <# _.each( data.unit, function(unit, key){ #>
                  <# var _unitValue = (data.value && data.value['unit'])? data.value['unit'] : Object.keys(data.unit)[0]; #>                  
                    <li class="">
                      <input
                          id="{{data.id}}_{{{ key }}}"
                          type="radio"
                          data-key="unit"
                          data-min="{{ unit.min }}"
                          data-max="{{ unit.max }}"
                          data-step="{{ unit.step }}"
                          name="{{ data.id }}_unit"
                          value="{{ key }}"
                          class="lwwb-input"
                          <# if ( key === _unitValue ) { #> checked="checked" <# } #> >
                      <label for="{{data.id}}_{{{ key }}}">{{{ key }}}</label>
                    </li>
                  <# }) #>
                </ul>
                </div>
            <# } #>
        </div>
        <?php
}

    protected function before_field()
    {
        static::field_header();
        ?>
        <div id="lwwb-control-{{{ data.id }}}" class="lwwb-control lwwb-control-{{{ data.type }}}">
        <?php

    }

    protected function field_template()
    {

        ?>
        <div class="control-wrapper">
            <input name="{{ data.id }}_{{ data.name }}"
                   class="lwwb-slider"
                   type="range"
                   min="{{{ data.input_attrs.min }}}"
                   max="{{{ data.input_attrs.max }}}"
                   step="{{{ data.input_attrs.step }}}"
                   value="{{ data.value }}"
                   data-key="{{{ data.id }}}"
                   data-reset_value="{{ data.default }}"
                   <# if ( data.link ) { #> {{{ data.link }}} <# } #>/>

            <input
                   name="{{ data.id }}_{{ data.name }}"
                   type="number"
                   min="{{{ data.input_attrs.min }}}"
                   max="{{{ data.input_attrs.max }}}"
                   step="{{{ data.input_attrs.step }}}"
                   class="lwwb-input"
                   value="{{ data.value }}"
                   data-key="{{{ data.id }}}"
                   data-reset_value="{{ data.default }}"
                   <# if ( data.link ) { #> {{{ data.link }}} <# } #>/>

            <span class="lwwb-reset-control"><span class="dashicons dashicons-image-rotate"></span></span>
      </div>
    <?php
}

}