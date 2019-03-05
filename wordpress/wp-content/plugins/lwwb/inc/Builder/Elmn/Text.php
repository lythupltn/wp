<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    lwwb.core
 * @subpackage lwwb.core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Builder\Elmn;

use Lwwb\Builder\Base\Elmn;
use Lwwb\Customizer\Control_Manager as Control;

class Text extends Elmn
{
    public $type         = 'text';
    public $label        = 'Text';
    public $icon         = 'fa  fa-paint-brush';
    public $group        = 'basic';
    public $key_words    = 'text, content';
    public $default_data = array();

    public $control_groups = array(
        // 'content',
        // 'style',
        'advanced',
        // 'background',
        // 'typography',
        // 'custom_css',
    );
    public function __construct(array $elmn = array())
    {
        parent::__construct($elmn);
        add_action('wp_ajax_get_content_via_ajax', array($this, 'get_content_via_ajax'));
    }
    public function get_content_group_control()
    {
        return
        array(
            'id'           => 'lwwb_content_group_control',
            'label'        => __('Text Content', 'lwwb'),
            'type'         => Control::GROUP,
            'dependencies' => array(
                array(
                    'control'  => 'lwwb_tab_control',
                    'operator' => '===',
                    'value'    => 'content',
                ),
            ),
            'fields'       => static::get_content_controls(),
        );
    }

    public function get_style_group_control()
    {
        return
        array(
            'id'           => 'lwwb_style_group_control',
            'label'        => __('Text Content', 'lwwb'),
            'type'         => Control::GROUP,
            'dependencies' => array(
                array(
                    'control'  => 'lwwb_tab_control',
                    'operator' => '===',
                    'value'    => 'style',
                ),
            ),
            'fields'       => static::get_style_controls(),
        );
    }

    public static function get_content_controls()
    {
        return array(
            array(
                'id'              => 'content',
                'keywords'        => 'title, text',
                'label'           => __('Content', 'lwwb'),
                'type'            => Control::WYSIWYG,
                'default'         => '',
                'editor_settings' => array(
                    'tinymce'   => true,
                    'quicktags' => true,
                ),
            ),

        );
    }

    public static function get_style_controls()
    {
        return array(
            array(
                'id'           => 'alignment',
                'keywords'     => 'title, text',
                'label'        => __('Alignment', 'lwwb'),
                'type'         => Control::BUTTON_SET,
                'display_type' => 'icon',
                'default'      => '',
                'choices'      => array(
                    'left'    => 'fa fa-align-left',
                    'right'   => 'fa fa-align-right',
                    'center'  => 'fa fa-align-center',
                    'justify' => 'fa fa-align-justify',
                ),
                'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content{ text-align:{{ VALUE }}; }",
            ),
            array(
                'id'         => 'color',
                'keywords'   => 'color picker Text',
                'default'    => '',
                'label'      => __('Text Color', 'lwwb'),
                'type'       => Control::COLOR_PICKER,
                'css_format' => "ELMN_WRAPPER > .lwwb-elmn-content{ color:{{ VALUE }}; }",
            ),
        );
    }
    public function get_content_via_ajax()
    {
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        echo do_shortcode(stripcslashes($content));
        wp_die();

    }
    public function get_default_data()
    {
        return array(
            'content'   => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'lwwb'),
            'alignment' => 'left',
        );
    }

    public function render_content()
    {
        echo do_shortcode($this->get_data('content'));
    }

    public function print_content_template()
    {
        $this->content_template();
    }

    public function content_template()
    {
        ?>
		<div class="lwwb-elmn-content"></div>
		<?php
}
}