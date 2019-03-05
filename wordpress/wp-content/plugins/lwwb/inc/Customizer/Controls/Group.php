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

class Group extends Base_Control
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-group';


    public $fields = array();

    public function to_json()
    {
        parent::to_json();

        // $this->json['default'] = $this->setting->default;
        // $this->json['value']   = $this->value();
        // $this->json['link']    = $this->get_link();
        $this->json['fields']  = $this->fields;

    }
    
    protected function field_header()
    {}

    protected function field_template()
    {
        ?>
        <div class="widget-top">
            <div class="widget-title-action">
                <button type="button" class="widget-action" aria-expanded="true">
                    <span class="screen-reader-text">{{{ data.label }}}</span>
                    <span class="toggle-indicator" aria-hidden="true"></span>
                </button>
            </div>
            <div class="widget-title"><h3>{{{ data.label }}}</h3></div>
        </div>
        <div class="widget-inside">
            <div class="widget-content">
            </div>
        </div>
        <?php
    }


}