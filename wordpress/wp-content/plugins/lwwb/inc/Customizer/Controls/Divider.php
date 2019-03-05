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

class Divider extends Base_Control
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type    = 'lwwb-divider';
    public $caption = '';

    public function to_json()
    {
        parent::to_json();
        $this->json['caption'] = $this->caption;

    }

    protected function field_header()
    {
        ?>
        <# if ( data.caption ) { #>
            <span class="customize-control-caption">{{ data.caption }}</span>
        <# } #>
        <hr/>
            <# if ( data.label ) { #>
            <h2>{{{ data.label }}}</h2>
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