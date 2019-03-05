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

class Responsive_Switcher extends Base_Control
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-responsive-switcher';

    public $device_config = array(
        'desktop' => 'desktop',
        'tablet'  => 'tablet',
        'mobile'  => 'mobile',
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
        $this->json['device_config'] = $this->device_config;

    }

    protected function field_header(){}
    protected function field_template()
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
              <ul class="list-devices">
                  <# _.each( data.device_config, function(val, device){
                            let activeDevice = $('.wp-full-overlay-footer .devices .active').data('device');
                   #>
                      <li class="{{{ device }}}">
                          <button type="button" class="preview-{{{ device }}} <# if( activeDevice === device ){ #> active <# } #>" data-device="{{{ device }}}">
                              <i class="dashicons dashicons-<# if( 'mobile' === device ){ #>smartphone <# }else { #>{{{ device }}} <# } #>" ></i>
                          </button>                           
                      </li>
                  <# }) #>
              </ul>
        </div>
        <?php
}

}