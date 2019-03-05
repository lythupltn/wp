<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Builder\Elmn;

use Lwwb\Builder\Base\Elmn;
use Lwwb\Customizer\Control_Manager as Control;

class Accordion extends Elmn
{

    public $type      = 'accordion';
    public $label     = 'Accordion';
    public $key_words = 'accordion';
    public $icon      = 'fa fa-list';
    public $group     = 'basic';

    public $control_groups = array(
        'content',
        'button',
        'advanced',
        'background',
        'border',
        'responsive',
        'custom_css',
    );

    public $default_data = array();
    public function __construct(array $elmn = array())
    {
        parent::__construct($elmn);
        add_action('wp_ajax_get_accordion_via_ajax', array($this, 'get_accordion_via_ajax'));
    }
    public static function get_content_controls()
    {
        return array(
            array(
                'id'       => 'accordion',
                'keywords' => 'accordion items',
                'label'    => __('Accordion Items', 'lwwb'),
                'type'     => Control::REPEATER,
                'fields'   => array(
                    array(
                        'id'                => 'header',
                        'label'             => __('Accordion header', 'lwwb'),
                        'type'              => Control::TEXT,
                        'default'           => __('Accordion Header', 'lwwb'),
                        'input_type'        => 'text',
                        'sanitize_callback' => 'sanitize_text_field',
                    ),
                    array(
                        'id'      => 'content',
                        'label'   => __('Accordion content', 'lwwb'),
                        'type'    => Control::WYSIWYG,
                        'default' => __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'lwwb'),
                    ),

                ),
            ),
        );
    }
    public function get_default_data()
    {
        return array(
            'accordion' => array(
                array(
                    'header'  => __('Accordion Header', 'lwwb'),
                    'content' => __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'lwwb'),
                ),
                array(
                    'header'  => __('Accordion Header', 'lwwb'),
                    'content' => __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'lwwb'),
                ),
            ),
        );

    }
    public function render_content($accordion = array())
    {
        $accordion = empty($accordion)? $this->get_data('accordion') : $accordion;
        foreach ($accordion as $acc) {
            ?>
            <div class="accordion-header"><?php echo esc_attr($acc['header']) ?><i class="fa fa-plus"></i></div>
            <div class="accordion-panel">
              <?php echo do_shortcode(stripcslashes($acc['content'])); ?>
            </div>
            <?php
}

        ?>

        <?php
}

    public function get_accordion_via_ajax()
    {
        $accordion = isset($_POST['accordion']) ? $_POST['accordion'] : array();
        $this->render_content($accordion);
        wp_die();
    }

    public function content_template()
    {
        ?>
        <# _.each(elmn_data.accordion, function(accordion, index){ #>
            <div class="accordion-header">{{ accordion.header }}<i class="fa fa-plus"></i></div>
            <div class="accordion-panel"><# print(accordion.content); #></div>
        <# });#>
        <?php
}

}