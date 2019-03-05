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

class Draggable_Icon extends Base_Control
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-draggable-icon';

    public $display_type = '';

    public $icons = array();

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     *
     * @access public
     */
    public function to_json()
    {
        parent::to_json();

        $this->json['display_type'] = $this->display_type;
        $this->json['icons'] = $this->icons;

    }

    protected function field_template()
    {

        ?>
            <ul class="list-icons">
                <# _.each( data.icons, function(item, key){ #>
                    <li title="{{{ item.label }}}" class="icon-{{{ item.type }}}" draggable="true" data-icon="{{{ item.type }}}">
                        <span class="icon"><i class="{{{ item.icon }}}"></i></span>
                        <span class="icon-title">{{{ item.label }}}</span>
                    </li>
                <# }) #>
            </ul>
        <?php
    }
}