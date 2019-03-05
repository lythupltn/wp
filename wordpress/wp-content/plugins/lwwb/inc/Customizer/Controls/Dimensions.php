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

class Dimensions extends Base_Control
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-dimensions';
    public $unit = array(
        'px' => array(
            'min'  => '-1000',
            'max'  => '1000',
            'step' => '1',
        ),
        '%'  => array(
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

        $this->json['default'] = $this->setting->default;
        $this->json['value']   = $this->value();
        $this->json['link']    = $this->get_link();
        $this->json['unit']    = $this->unit;
        $this->json['l10n']    = $this->l10n();

    }

    protected function field_header()
    {
        ?>

            <#
                if(!data.value){
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
          <# if(data.unit ){ #>
                <div class="lwwb-unit">
                  <ul class="lwwb-unit-list">
                  <# _.each( data.unit, function(unit, key){ #>
                  <# var _unitValue = (data.value && data.value['unit'])? data.value['unit'] : Object.keys(data.unit)[0];#>
                    <li>
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
          <ul class=" control-wrapper device-wrapper">

            <# _.each( data.options, function(option, key ){ #>

            <#
              var _unitValue = (data.value && data.value['unit'])? data.value['unit'] : Object.keys(data.unit)[0];
              var _inputAttrs = data.unit[_unitValue];
              var _optionValue = (data.value && data.value[key])? data.value[key]: '';
            #>
                <li class="dimension-wrapper {{ key }} linked">
                    <input data-key="{{ key }}"
                           name="{{{ data.id }}}_{{ key }}"
                           min="{{ _inputAttrs.min }}"
                           max="{{ _inputAttrs.max }}"
                           step="{{ _inputAttrs.step }}"
                           class="lwwb-input dimension-{{ key }}"
                           value="{{ _optionValue }}"
                           <# if( 'auto' === _optionValue){ #> placeholder="auto" disabled <# }else{ #> type="number" <# } #> />
                    <span class="dimension-label">{{ option }}</span>
                </li>
            <# }); #>
            <li class="dimension-wrapper">
                <div class="link-dimensions">
                    <span class="dashicons dashicons-admin-links lwwb-linked" title="{{ data.id }}"></span>
                    <span class="dashicons dashicons-editor-unlink lwwb-unlinked" title="{{ data.id }}"></span>
                </div>
            </li>

          </ul>

            <input type="hidden" class="dimension-hidden-value" value="{{ data.value }}" <# if ( data.link ) { #> {{{ data.link }}} <# } #>>

    <?php
}

}