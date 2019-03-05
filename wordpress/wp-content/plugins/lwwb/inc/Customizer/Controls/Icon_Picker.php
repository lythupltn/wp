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

class Icon_Picker extends Base_Control
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-icon-picker';

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

    }

    protected function field_template()
    {

        ?>
        <div class="lwwb-icon-picker">
            <div class="preview-icon-wrap">
                <div class="preview-icon-icon">
                    <i class="{{ data.value }}"></i>
                </div>
            </div>
            <input type="text" readonly class="lwwb-input pick-icon"
                   placeholder="<?php esc_attr_e('Pick an icon', 'lwwb');?>"
                   data-key="{{{ data.id }}}"
                   name="{{{ data.id }}}" 
                   value="{{ data.value }}"
                   <# if ( data.link ) { #> {{{ data.link }}} <# } #> />
            <span class="remove-icon" title="<?php esc_attr_e('Remove', 'lwwb');?>">
                    <span class="dashicons dashicons-no-alt"></span>
                    <span class="screen-reader-text">
                    <?php _e('Remove', 'lwwb')?></span>
                </span>
        </div>


        <?php
}
}