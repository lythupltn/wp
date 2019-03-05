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

class Heading extends Base_Control
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-heading';

    protected function field_header()
    {
        ?>
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
    }
}