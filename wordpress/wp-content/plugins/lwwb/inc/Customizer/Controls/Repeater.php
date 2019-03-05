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

class Repeater extends Group
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-repeater';

    public $fields = array();

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
        $this->json['fields']  = $this->fields;

    }

        
    protected function field_header()
    {
        ?>
            <#
                if(data.value == null){
                    data.value = data.default;
                }
            #>
            <# if ( data.label ) { #>
                <span class="customize-control-title">{{{ data.label }}}</span>
            <# } #>
            <# if ( data.description ) { #>
                <span class="customize-control-description">{{{ data.description }}}</span>
            <# } #>
        <?php 
    }
    

    protected function field_template()
    {
        ?>
        <ul class="repeater-items ui-sortable"></ul>
        <div class="button-secondary button "><span class="add-new-item"><?php echo __('Add item', 'lwwb'); ?></span></div>
        <?php
    }
}
