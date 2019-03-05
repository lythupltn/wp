<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Customizer;

use Lwwb\Base\Base_Controller;
use Lwwb\Builder\Elmn_Manager;
use Lwwb\Customizer\Controls as Customizer_Control;

class Plugin_Customizer extends Base_Controller
{

    public function register()
    {
        add_action('customize_register', array($this, 'register_customizer'));
    }

    public function register_elmn_picker_group($wp_customize, $group_name, $group_label)
    {
        $elmns = Elmn_Manager::get_instance()->get_elmn_by_group($group_name);
        if (empty($elmns)) {
            return;
        }
        $wp_customize->add_setting(
            $group_name, array(
                'type'      => 'theme_mod',
                'transport' => 'postMessage',
            )
        );
        $wp_customize->add_control(new Customizer_Control\Group($wp_customize, $group_name, array(
            'label'       => $group_label,
            'description' => '',
            'section'     => 'lwwb_section',
            'fields'      => array(
                array(
                    'label' => '',
                    'id'    => 'elmn-picker',
                    'type'  => Control_Manager::DRAGGABLE_ICON,
                    'icons' => $elmns,
                ),
            ),
        )
        ));

    }

    //  Register customizer
    public function register_customizer($wp_customize)
    {

        $wp_customize->add_section(
            'lwwb_section', array(
                'title'      => __('Website Builder', 'lwwb'),
                'capability' => 'edit_theme_options',
                'priority'   => 10,
            )
        );
        $wp_customize->add_setting(
            'setting_switcher', array(
                'type'      => 'theme_mod',
                'transport' => 'postMessage',
            )
        );
        $wp_customize->add_control(new Customizer_Control\Button_Set($wp_customize, 'setting_switcher', array(
            'section'      => 'lwwb_section',
            'display_type' => 'icon',
            'link_data'    => false,
            'default'      => 'elmn_picker',
            'choices'      => array(
                'current_page'   => 'fa fa-lg fa-gear',
                'elmn_picker'    => 'fa fa-lg fa-th',
                'elmn'           => 'fa fa-lg fa-magic',
                'global_setting' => 'fa fa-lg fa-globe',
            ),
        )
        ));
        $wp_customize->add_setting(
            'lwwb_build_panel', array(
                'type'      => 'theme_mod',
                'transport' => 'postMessage',
            )
        );
        $wp_customize->add_control(new Customizer_Control\Builder_Panel($wp_customize, 'lwwb_build_panel', array(
            'label'           => __('Builder Panel', 'lwwb'),
            'description'     => __('Builder panel for the website', 'lwwb'),
            'section'         => 'lwwb_section',
            'active_callback' => function () {
                return false;
            },
        )
        ));

        foreach (Elmn_Manager::get_instance()->group as $group_name => $group_label) {
            $this->register_elmn_picker_group($wp_customize, $group_name, $group_label);
        }

        // $wp_customize->add_setting(
        //     'select2_heading', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Heading($wp_customize, 'select2_heading', array(
        //     'label'       => 'Repeater Control',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        // )
        // ));

        // $wp_customize->add_setting(
        //     'image_control', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //         'default' => array(
        //             'select-date' => '',
        //             'image-setting' => array(
        //                 'url' => '',
        //                 'id' => '',
        //             ),
        //             'select' => 'test',
        //             'button_set' => 'choice2',
        //             'repeater_field'     => array(
        //                 array(
        //                     'date' =>'',
        //                     'image' =>array(
        //                             'url' => '',
        //                             'id' => '',
        //                         ),
        //                     'repeater_radio' =>'choice3',
        //                 ),
        //                 array(
        //                     'date' =>'',
        //                     'image' =>array(
        //                             'url' => '',
        //                             'id' => '',
        //                         ),
        //                     'repeater_radio' =>'choice1',
        //                 )
        //             ),
        //         ),
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Image($wp_customize, 'image_control', array(
        //     'label'       => 'Image Control',
        //     'description' => '',
        //     'id' => 'image_control',
        //     'section'     => 'lwwb_section',
        //     'fields'      => array(
        //         array(
        //             'label' => 'Date picker',
        //             'type'  => Control_Manager::DATE_PICKER,
        //             'id'    => 'select-date',
        //         ),
        //         array(
        //             'label'      => 'IMAGE',
        //             'type'       => Control_Manager::MEDIA_UPLOAD,
        //             'id'         => 'image-setting',
        //             'media_type' => 'image',
        //         ),
        //         array(
        //             'label'   => 'Select',
        //             'type'    => Control_Manager::SELECT,
        //             'id'      => 'select',
        //             'choices' => array(
        //                 'choice1' => 'Tab 1',
        //                 'choice2' => 'Tab 2',
        //                 'choice3' => 'Tab 3',
        //             ),
        //         ),
        //         array(
        //             'label'   => '',
        //             'type'    => Control_Manager::BUTTON_SET,
        //             'id'      => 'button_set',
        //             'choices' => array(
        //                 'choice1' => 'Tab 1',
        //                 'choice2' => 'Tab 2',
        //                 'choice3' => 'Tab 3',
        //             ),
        //         ),
        //         array(
        //             'label'  => 'Image slide',
        //             'type'   => Control_Manager::REPEATER,
        //             'id'     => 'repeater_field',
        //             'fields' => array(
        //                 array(
        //                     'label' => 'Date picker',
        //                     'type'  => Control_Manager::DATE_PICKER,
        //                     'id'    => 'date',
        //                 ),
        //                 array(
        //                     'label'      => 'Image',
        //                     'type'       => Control_Manager::MEDIA_UPLOAD,
        //                     'id'         => 'image',
        //                     'media_type' => 'image',
        //                 ),
        //                 array(
        //                     'label'   => 'Radio',
        //                     'type'    => Control_Manager::RADIO,
        //                     'id'      => 'repeater_radio',
        //                     'choices' => array(
        //                         'choice1' => 'Tab 1',
        //                         'choice2' => 'Tab 2',
        //                         'choice3' => 'Tab 3',
        //                     ),
        //                 ),
        //             ),
        //         ),
        //     ),
        // )
        // ));

        // $wp_customize->add_setting(
        //     'group_control', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //         'default' => array(
        //             'select-date' => '2019-01-05',
        //             'image-setting' => array(
        //                 'url' => '',
        //                 'id' => '',
        //             ),
        //             'select' => 'choice2',
        //             'button_set' => 'choice3',
        //         ),
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Group($wp_customize, 'group_control', array(
        //     'label'       => 'Aaa Control',
        //     'description' => '',
        //     'id' => 'group_control',
        //     'section'     => 'lwwb_section',
        //     'fields'      => array(
        //         array(
        //             'label' => 'Date picker',
        //             'type'  => Control_Manager::DATE_PICKER,
        //             'id'    => 'select-date',
        //         ),
        //         array(
        //             'label'      => 'IMAGE',
        //             'type'       => Control_Manager::MEDIA_UPLOAD,
        //             'id'         => 'image-setting',
        //             'media_type' => 'image',
        //         ),
        //         array(
        //             'label'   => 'Select',
        //             'type'    => Control_Manager::SELECT,
        //             'id'      => 'select',
        //             'choices' => array(
        //                 'choice1' => 'Tab 1',
        //                 'choice2' => 'Tab 2',
        //                 'choice3' => 'Tab 3',
        //             ),
        //         ),
        //         array(
        //             'label'   => '',
        //             'type'    => Control_Manager::BUTTON_SET,
        //             'id'      => 'button_set',
        //             'choices' => array(
        //                 'choice1' => 'Tab 1',
        //                 'choice2' => 'Tab 2',
        //                 'choice3' => 'Tab 3',
        //             ),
        //         ),
        // array(
        //     'label'  => 'Image slide',
        //     'type'   => Control_Manager::REPEATER,
        //     'id'     => 'repeater_field',
        //     'fields' => array(
        //         array(
        //             'label' => 'Date picker',
        //             'type'  => Control_Manager::DATE_PICKER,
        //             'id'    => 'date',
        //         ),
        //         array(
        //             'label'      => 'Image',
        //             'type'       => Control_Manager::MEDIA_UPLOAD,
        //             'id'         => 'image',
        //             'media_type' => 'image',
        //         ),
        //         array(
        //             'label'   => 'Radio',
        //             'type'    => Control_Manager::RADIO,
        //             'id'      => 'repeater_radio',
        //             'choices' => array(
        //                 'choice1' => 'Tab 1',
        //                 'choice2' => 'Tab 2',
        //                 'choice3' => 'Tab 3',
        //             ),
        //         ),
        //     ),
        // ),
        //     ),
        // )
        // ));

        // $wp_customize->add_setting(
        //     'repeater_control', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //     )
        // );
        // $wp_customize->add_control(new Customizer_Control\Repeater($wp_customize, 'repeater_control', array(
        //     'label'       => 'Repeater',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        //     'fields'      => array(
        //         array(
        //             'label' => 'Date picker',
        //             'type'  => Control_Manager::DATE_PICKER,
        //             'id'    => 'select-page',
        //         ),
        //         array(
        //             'label'      => 'Image',
        //             'type'       => Control_Manager::MEDIA_UPLOAD,
        //             'id'         => 'image-setting',
        //             'media_type' => 'image',
        //         ),
        //         array(
        //             'label'   => 'Radio',
        //             'type'    => Control_Manager::RADIO,
        //             'id'      => 'repeater_radio',
        //             'choices' => array(
        //                 'choice1' => 'Tab 1',
        //                 'choice2' => 'Tab 2',
        //                 'choice3' => 'Tab 3',
        //             ),
        //         ),
        //     ),
        // )
        // ));
        // $wp_customize->add_setting(
        //     'select2', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //         'default' => 'choice2',
        //     )
        // );
        // $wp_customize->add_control(new Customizer_Control\Select2($wp_customize, 'select2', array(
        //     'label'         => 'Input Control',
        //     'description'   => '',
        //     'capability'    => 'edit_theme_options', //Capability needed to tweak
        //     'section'       => 'lwwb_section',
        //     'multiple'       => true,
        //     // 'choices' => array(
        //     //             'choice1' => 'Tab 1',
        //     //             'choice2' => 'Tab 2',
        //     //             'choice3' => 'Tab 3',
        //     //         ),
        //     'option_groups' => array(
        //         array(
        //             'label'   => 'Option group 1',
        //             'choices' => array(
        //                 'choice1' => 'Choice 1',
        //                 'choice2' => 'Choice 2',
        //                 'choice3' => 'Choice 3',
        //             ),
        //         ),
        //         array(
        //             'label'   => 'Option group 2',
        //             'choices' => array(
        //                 'choice4' => 'Choice 4',
        //                 'choice5' => 'Choice 5',
        //                 'choice6' => 'Choice 6',
        //             ),
        //         ),
        //     ),
        // )
        // ));

        // $wp_customize->add_setting(
        //     'image_control_heading', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Heading($wp_customize, 'image_control_heading', array(
        //     'label'       => 'Image group',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        // )
        // ));

        // $wp_customize->add_setting(
        //     'image_control', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //     )
        // );
        // $wp_customize->add_control(new Customizer_Control\Image($wp_customize, 'image_control', array(
        //     'label'       => 'Image',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        //     'fields'      => array(
        //         array(
        //             'label' => 'Date picker',
        //             'type'  => Control_Manager::DATE_PICKER,
        //             'id'    => 'select-page',
        //         ),
        // array(
        //     'label'      => 'Image',
        //     'type'       => 'media-upload',
        //     'id'         => 'image-setting',
        //     'media_type' => 'image',
        // ),
        // array(
        //     'label'   => 'Radio',
        //     'type'    => 'radio',
        //     'id'      => 'repeater_radio',
        //     'choices' => array(
        //         'choice1' => 'Tab 1',
        //         'choice2' => 'Tab 2',
        //         'choice3' => 'Tab 3',
        //     ),
        // ),
        //     ),
        // )
        // ));

        // $wp_customize->add_setting(
        //     'current_page_setting', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //     )
        // );
        // $wp_customize->add_control(new Customizer_Control\Group($wp_customize, 'current_page_setting', array(
        //     'label'       => 'Current Page Setting',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        //     'fields'      => array(
        //         array(
        //             'label' => 'Page setting',
        //             'type'  => 'select',
        //             'id'    => 'select-page',
        //             'choices' => array(
        //                 'choice1' => 'Tab 1',
        //                 'choice2' => 'Tab 2',
        //                 'choice3' => 'Tab 3',
        //             ),
        //         ),
        //         array(
        //             'label'      => 'Image',
        //             'type'       => 'media-upload',
        //             'id'         => 'image-setting',
        //             'media_type' => 'image',
        //         ),
        //         array(
        //             'label'   => 'Radio',
        //             'type'    => 'radio',
        //             'id'      => 'repeater_radio',
        //             'choices' => array(
        //                 'choice1' => 'Tab 1',
        //                 'choice2' => 'Tab 2',
        //                 'choice3' => 'Tab 3',
        //             ),
        //         ),
        //     )
        // )
        // ));

        // Test slider control
        // $wp_customize->add_setting(
        //     'date_picker', array(
        //         'type'      => 'theme_mod',
        //         'default'   => '',
        //         'transport' => 'postMessage',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Date_Picker($wp_customize, 'date_picker', array(
        //     'label'       => 'Date picker',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        // )

        // ));

        // Test slider control
        // $wp_customize->add_setting(
        //     'slider_control', array(
        //         'type'              => 'theme_mod',
        //         'default'           => '20',
        //         'transport'         => 'postMessage',
        //         'capability'        => 'edit_theme_options',
        //         'sanitize_callback' => 'sanitize_text_field',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Slider($wp_customize, 'slider_control', array(
        //     'label'         => 'Test Slider 1',
        //     'description'   => '',
        //     'section'       => 'lwwb_section',
        //     'input_attrs'   => array(
        //         'min'  => 0,
        //         'max'  => 100,
        //         'step' => 1,
        //     ),
        //     'device_config' => array(
        //         'desktop' => array(
        //             'top'    => esc_html__('Top', 'lwwb'),
        //             'right'  => esc_html__('Right', 'lwwb'),
        //             'bottom' => esc_html__('Bottom', 'lwwb'),
        //             'left'   => esc_html__('Left', 'lwwb'),
        //         ),
        //         'tablet'  => array(
        //             'top'    => esc_html__('Top', 'lwwb'),
        //             'right'  => esc_html__('Right', 'lwwb'),
        //             'bottom' => esc_html__('Bottom', 'lwwb'),
        //             'left'   => esc_html__('Left', 'lwwb'),
        //         ),
        //         'mobile'  => array(
        //             'top'    => esc_html__('Top', 'lwwb'),
        //             'right'  => esc_html__('Right', 'lwwb'),
        //             'bottom' => esc_html__('Bottom', 'lwwb'),
        //             'left'   => esc_html__('Left', 'lwwb'),
        //         ),
        //     ),

        // )
        // ));
        // $wp_customize->add_setting(
        //     'icon_picker', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //     )
        // );
        // $wp_customize->add_control(new Customizer_Control\Group($wp_customize, 'icon_picker', array(
        //     'label'       => 'Basic Elmn',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        //     'fields'      => array(
        //         array(
        //             'label'      => '',
        //             'id'         => 'elmn-picker',
        //             'type' => 'draggable-icon',
        //             'icons' => array(
        //                 array(
        //                     'name' => 'column',
        //                     'icon' => 'fa fa-3x fa-barcode',
        //                     'label' => 'Column',

        //                 ),
        //                 array(
        //                     'name' => 'title',
        //                     'icon' => 'fa fa-3x fa-text-width',
        //                     'label' => 'Text',

        //                 ),
        //                 array(
        //                     'name' => 'video',
        //                     'icon' => 'fa fa-3x fa-camera',
        //                     'label' => 'Video',

        //                 ),
        //                 array(
        //                     'name' => 'image',
        //                     'icon' => 'fa fa-3x fa-image',
        //                     'label' => 'Image',

        //                 ),
        //                 array(
        //                     'name' => 'image',
        //                     'icon' => 'fa fa-3x fa-image',
        //                     'label' => 'Image',

        //                 ),
        //             )
        //         ),
        //     )
        // )
        // ));
        // $wp_customize->add_setting(
        //     'icon_picker1', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //     )
        // );
        // $wp_customize->add_control(new Customizer_Control\Group($wp_customize, 'icon_picker1', array(
        //     'label'       => 'Advance',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        //     'fields'      => array(
        //         array(
        //             'label'      => '',
        //             'id'         => 'elmn-picker',
        //             'type' => 'draggable-icon',
        //             'icons' => array(
        //                 array(
        //                     'name' => 'column',
        //                     'icon' => 'fa fa-3x fa-barcode',
        //                     'label' => 'Column',

        //                 ),
        //                 array(
        //                     'name' => 'title',
        //                     'icon' => 'fa fa-3x fa-text-width',
        //                     'label' => 'Text',

        //                 ),
        //                 array(
        //                     'name' => 'video',
        //                     'icon' => 'fa fa-3x fa-camera',
        //                     'label' => 'Video',

        //                 ),
        //                 array(
        //                     'name' => 'image',
        //                     'icon' => 'fa fa-3x fa-image',
        //                     'label' => 'Image',

        //                 ),
        //                 array(
        //                     'name' => 'image',
        //                     'icon' => 'fa fa-3x fa-image',
        //                     'label' => 'Image',

        //                 ),
        //             )
        //         ),
        //     )
        // )
        // ));
        // $wp_customize->add_setting(
        //     'global_setting', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //     )
        // );
        // $wp_customize->add_control(new Customizer_Control\Group($wp_customize, 'global_setting', array(
        //     'label'       => 'Global Setting',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        //     'fields'      => array(
        //         array(
        //             'label' => 'Repeater icon1',
        //             'type'  => 'icon-picker',
        //             'id'    => 'repeater_icon',
        //         ),
        //         array(
        //             'label'      => 'Input icon',
        //             'type'       => 'input',
        //             'id'         => 'repeater_input',
        //             'input_type' => 'text',
        //         ),
        //         array(
        //             'label'   => 'Radio',
        //             'type'    => 'radio',
        //             'id'      => 'repeater_radio',
        //             'choices' => array(
        //                 'choice1' => 'Tab 1',
        //                 'choice2' => 'Tab 2',
        //                 'choice3' => 'Tab 3',
        //             ),
        //         ),
        //     )
        // )
        // ));

        // $wp_customize->add_setting(
        //     'lwwb_elmn_picker', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //     )
        // );
        // $wp_customize->add_control(new Customizer_Control\Group($wp_customize, 'lwwb_elmn_picker', array(
        //     'label'       => 'Element Picker',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        // )
        // ));

        // $wp_customize->add_setting(
        //     'lwwb_elmn_picker', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Draggable_Icon($wp_customize, 'lwwb_elmn_picker', array(
        //     'label'       => 'Draggable Icon',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        //     'icons'       => array(
        //         array(
        //             'name'  => 'column',
        //             'icon'  => 'fa fa-3x fa-barcode',
        //             'label' => 'Column',

        //         ),
        //         array(
        //             'name'  => 'title',
        //             'icon'  => 'fa fa-3x fa-text-width',
        //             'label' => 'Text',

        //         ),
        //         array(
        //             'name'  => 'video',
        //             'icon'  => 'fa fa-3x fa-camera',
        //             'label' => 'Video',

        //         ),
        //         array(
        //             'name'  => 'image',
        //             'icon'  => 'fa fa-3x fa-image',
        //             'label' => 'Image',

        //         ),
        //         array(
        //             'name'  => 'image',
        //             'icon'  => 'fa fa-3x fa-image',
        //             'label' => 'Image',

        //         ),
        //     ),
        // )
        // ));

        // // Test buttonset control
        // $wp_customize->add_setting(
        //     'repeater', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //         'default'   => array(
        //             array(
        //                 'repeater_icon'  => 'fa fa-github',
        //                 'repeater_input' => 'This is the input 1',
        //                 'repeater_radio' => 'choice1',
        //             ),
        //             array(
        //                 'repeater_icon'  => 'fa-facebook',
        //                 'repeater_input' => 'This is the input 2',
        //             ),
        //             array(
        //                 'repeater_icon'  => 'fa fa-twitter',
        //                 'repeater_radio' => 'choice3',
        //             ),
        //         ),
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Repeater($wp_customize, 'repeater', array(
        //     'label'       => 'Slider',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        //     'fields'      => array(
        //         array(
        //             'label' => 'Repeater icon1',
        //             'type'  => 'icon-picker',
        //             'id'    => 'repeater_icon',
        //         ),
        //         array(
        //             'label'      => 'Input icon',
        //             'type'       => 'input',
        //             'id'         => 'repeater_input',
        //             'input_type' => 'text',
        //         ),
        //         array(
        //             'label'   => 'Radio',
        //             'type'    => 'radio',
        //             'id'      => 'repeater_radio',
        //             'choices' => array(
        //                 'choice1' => 'Tab 1',
        //                 'choice2' => 'Tab 2',
        //                 'choice3' => 'Tab 3',
        //             ),
        //         ),
        //     ),
        // )
        // ));

        // // Test buttonset control
        // $wp_customize->add_setting(
        //     'icon_pickerxx', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //         'default'   => 'fa fa-facebook',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Icon_Picker($wp_customize, 'icon_pickerxx', array(
        //     'label'       => 'Icon picker',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        // )
        // ));
        // // Test buttonset control
        // $wp_customize->add_setting(
        //     'icon_pickeryy', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //         'default'   => 'fa fa-facebook',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Icon_Picker($wp_customize, 'icon_pickeryy', array(
        //     'label'       => 'Icon picker',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        // )
        // ));

        // $wp_customize->add_control(new Customizer_Control\Heading($wp_customize, 'slider_control_heading', array(
        //     'label'       => 'Radio image',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        // )
        // ));

        // // Test buttonset control
        // $wp_customize->add_setting(
        //     'slider_control', array(
        //         'type'              => 'theme_mod',
        //         'default'           => '20',
        //         'transport'         => 'postMessage',
        //         'capability'        => 'edit_theme_options',
        //         'sanitize_callback' => 'sanitize_text_field',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Slider($wp_customize, 'slider_control', array(
        //     'label'       => 'Test Slider 1',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        //     'input_attrs' => array(
        //         'min'  => 0,
        //         'max'  => 100,
        //         'step' => 1,
        //     ),

        // )
        // ));

        // // Test buttonset control
        // $wp_customize->add_setting(
        //     'slider_controlxxx', array(
        //         'type'              => 'theme_mod',
        //         'default'           => '20',
        //         'transport'         => 'postMessage',
        //         'capability'        => 'edit_theme_options',
        //         'sanitize_callback' => 'sanitize_text_field',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Slider($wp_customize, 'slider_controlxxx', array(
        //     'label'       => 'Test Slider 2',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        //     'input_attrs' => array(
        //         'min'  => 0,
        //         'max'  => 100,
        //         'step' => 1,
        //     ),

        // )
        // ));

        // // Heading control
        // $wp_customize->add_setting(
        //     'switcher_control_heading', array(
        //         'type'       => 'theme_mod',
        //         'default'    => '',
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Heading($wp_customize, 'switcher_control_heading', array(
        //     'label'       => 'Switcher',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        // )
        // ));

        // // Test buttonset control
        // $wp_customize->add_setting(
        //     'switcher_control', array(
        //         'type'              => 'theme_mod',
        //         'default'           => 'choice1',
        //         'transport'         => 'postMessage',
        //         'capability'        => 'edit_theme_options',
        //         'sanitize_callback' => 'sanitize_text_field',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Switcher($wp_customize, 'switcher_control', array(
        //     'label'       => 'Test Switcher Control',
        //     'description' => esc_html__('This is description switcher button ', 'lwwb'),
        //     'section'     => 'lwwb_section',
        // )
        // ));

        // $wp_customize->add_control(new Customizer_Control\Icon_Picker($wp_customize, 'icon_picker', array(
        //     'label'       => 'Icon Picker',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        // )
        // ));
        // // Test buttonset control
        // $wp_customize->add_setting(
        //     'divider', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //         'default'   => 'choice2',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Divider($wp_customize, 'divider', array(
        //     // 'label'       => 'Test divider',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        //     // 'caption'     => 'This is the caption of divider',
        // )
        // ));
        // // Test buttonset control
        // $wp_customize->add_setting(
        //     'tab', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //         'default'   => 'choice2',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Tab($wp_customize, 'tab', array(
        //     'label'       => 'Test Tab',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        //     // 'display_type' => 'icon',
        //     'choices'     => array(
        //         'choice1' => 'Tab 1',
        //         'choice2' => 'Tab 2',
        //         'choice3' => 'Tab 3',
        //     ),
        // )
        // ));
        // // Test buttonset control
        // $wp_customize->add_setting(
        //     'test_group', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Group($wp_customize, 'test_group', array(
        //     'label'       => 'Test Group',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        // )
        // ));

        // // Test buttonset control
        // $wp_customize->add_setting(
        //     'test_checkbox', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //         'default'   => array('choice2'),
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Checkbox($wp_customize, 'test_checkbox', array(
        //     'label'       => 'Test Checkbox',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        //     'choices'     => array(
        //         'choice1' => 'Tab 1',
        //         'choice2' => 'Tab 2',
        //         'choice3' => 'Tab 3',
        //     ),
        // )
        // ));
        // // Heading control
        // $wp_customize->add_setting(
        //     'input_heading', array(
        //         'type'       => 'theme_mod',
        //         'default'    => '',
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Heading($wp_customize, 'input_heading', array(
        //     'label'        => 'Input',
        //     'description'  => '',
        //     'section'      => 'lwwb_section',
        //     'dependencies' => array(
        //         array(
        //             'control'  => 'tab',
        //             'operator' => '==',
        //             'value'    => 'choice1',
        //         ),
        //     ),
        // )
        // ));

        // $wp_customize->add_setting(
        //     'input', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //     )
        // );
        // $wp_customize->add_control(new Customizer_Control\Input($wp_customize, 'input', array(
        //     'label'        => 'Input Control',
        //     'description'  => '',
        //     'capability'   => 'edit_theme_options', //Capability needed to tweak
        //     'section'      => 'lwwb_section',
        //     'dependencies' => array(
        //         array(
        //             'control'  => 'tab',
        //             'operator' => '==',
        //             'value'    => 'choice1',
        //         ),
        //     ),
        // )
        // ));

        // // Heading control
        // $wp_customize->add_setting(
        //     'radio_heading', array(
        //         'type'       => 'theme_mod',
        //         'default'    => '',
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Heading($wp_customize, 'radio_heading', array(
        //     'label'       => 'Input',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        // )
        // ));

        // $wp_customize->add_setting(
        //     'radio', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //     )
        // );
        // $wp_customize->add_control(new Customizer_Control\Radio($wp_customize, 'radio', array(
        //     'label'       => 'Input Control',
        //     'description' => '',
        //     'capability'  => 'edit_theme_options', //Capability needed to tweak
        //     'section'     => 'lwwb_section',
        //     'choices'     => array(
        //         'choice1' => 'Choice 1',
        //         'choice2' => 'Choice 2',
        //         'choice3' => 'Choice 3',
        //     ),
        // )
        // ));

        // // Heading control
        // $wp_customize->add_setting(
        //     'select_heading', array(
        //         'type'       => 'theme_mod',
        //         'default'    => '',
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Heading($wp_customize, 'select_heading', array(
        //     'label'       => 'Input',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        // )
        // ));

        // $wp_customize->add_setting(
        //     'select', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //     )
        // );
        // $wp_customize->add_control(new Customizer_Control\Select($wp_customize, 'select', array(
        //     'label'       => 'Input Control',
        //     'description' => '',
        //     'capability'  => 'edit_theme_options', //Capability needed to tweak
        //     'section'     => 'lwwb_section',
        //     'choices'     => array(
        //         'choice1' => 'Choice 1',
        //         'choice2' => 'Choice 2',
        //         'choice3' => 'Choice 3',
        //     ),
        // )
        // ));

        // // Heading control
        // $wp_customize->add_setting(
        //     'radio_image_heading', array(
        //         'type'       => 'theme_mod',
        //         'default'    => '',
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Heading($wp_customize, 'radio_image_heading', array(
        //     'label'       => 'Input',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        // )
        // ));

        // // $wp_customize->add_setting(
        // //     'radio_image', array(
        // //         'type'      => 'theme_mod',
        // //         'transport' => 'postMessage',
        // //     )
        // // );
        // // $wp_customize->add_control(new Customizer_Control\Radio_Image($wp_customize, 'radio_image', array(
        // //     'label'       => 'Input Control',
        // //     'description' => '',
        // //     'capability'  => 'edit_theme_options', //Capability needed to tweak
        // //     'section'     => 'lwwb_section',
        // //     'choices' => array(
        // //             'choice1' => 'https://static.independent.co.uk/s3fs-public/thumbnails/image/2016/06/21/11/summer-solstice-rex3.jpg?w968',
        // //             'choice2' => 'Choice 2',
        // //             'choice3' => 'Choice 3',
        // //         )
        // //     )
        // // ));

        // // Heading control
        // $wp_customize->add_setting(
        //     'code_editor_heading', array(
        //         'type'       => 'theme_mod',
        //         'default'    => '',
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Heading($wp_customize, 'code_editor_heading', array(
        //     'label'       => 'Input',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        // )
        // ));

        // $wp_customize->add_setting(
        //     'code_editor', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //     )
        // );
        // $wp_customize->add_control(new Customizer_Control\Code_Editor($wp_customize, 'code_editor', array(
        //     'label'           => 'Input Control',
        //     'description'     => '',
        //     'capability'      => 'edit_theme_options', //Capability needed to tweak
        //     'section'         => 'lwwb_section',
        //     'code_type'       => 'text/css',
        //     'input_attrs'     => array(
        //         'aria-describedby' => 'editor-keyboard-trap-help-1 editor-keyboard-trap-help-2 editor-keyboard-trap-help-3 editor-keyboard-trap-help-4',
        //     ),
        //     'editor_settings' => array(),

        // )
        // ));

        // Teset Repeater

        // Heading control
        //        $wp_customize->add_setting(
        //            'repeater_heading', array(
        //                'type'       => 'theme_mod',
        //                'default'    => '',
        //                'transport'  => 'postMessage',
        //                'capability' => 'edit_theme_options',
        //            )
        //        );
        //
        //        $wp_customize->add_control( new Customizer_Control\Heading\Heading( $wp_customize, 'repeater_heading', array(
        //                'label'       => 'Repeater',
        //                'description' => '',
        //                'section'     => 'lwwb_section',
        //            )
        //        ) );
        // Teset Repeater

//        $wp_customize->add_setting( 'lwwb_value_xyz', array(
        //            'default'           => array(
        //                array(
        //                    'link_text'   => esc_html__( 'Demo', 'lwwb' ),
        //                    'link_url'    => 'https://google.com.vn',
        //                    'link_target' => '_self',
        //                    'image'       => array(
        //                        'repeater_image_url' => 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png',
        //                        'repeater_image_id'  => '232',
        //                    ),
        //                    'disable_row' => false,
        //                ),
        //                array(
        //                    'link_text'   => esc_html__( 'Repository', 'lwwb' ),
        //                    'link_url'    => 'https://youtube.com',
        //                    'link_target' => '_self',
        //                    'image'       => array(
        //                        'repeater_image_url' => 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png',
        //                        'repeater_image_id'  => '232',
        //                    ),
        //                    'disable_row' => false,
        //                ),
        //            ),
        //            'capability'        => 'edit_theme_options',
        //            'type'              => 'option',
        //            'sanitize_callback' => array( 'Lwwb\Customizer\Sanizite_Callback', 'sanitize_repeater_setting' )
        //        ) );
        //
        //        $wp_customize->add_control( new Customizer_Control\Repeater\Repeater( $wp_customize, 'lwwb_value_xyz', array(
        //            'label'       => __( 'Item', 'lwwb' ),
        //            'section'     => 'lwwb_section',
        //            'description' => esc_html__( 'The description here.', 'lwwb' ),
        //            'live_title'  => array(
        //                'type'  => 'field',
        //                'value' => 'Item',
        //                'field' => 'link_text',
        //            ),
        //            'fields'      => array(
        //                'link_text'   => array(
        //                    'type'        => 'text',
        //                    'label'       => esc_html__( 'Link Text', 'lwwb' ),
        //                    'description' => esc_html__( 'This will be the label for your link', 'lwwb' ),
        //                    'default'     => '',
        //                ),
        //                'link_url'    => array(
        //                    'type'        => 'text',
        //                    'label'       => esc_html__( 'Link URL', 'lwwb' ),
        //                    'description' => esc_html__( 'This will be the link URL', 'lwwb' ),
        //                    'default'     => '',
        //                ),
        //                'link_target' => array(
        //                    'type'        => 'select',
        //                    'label'       => esc_html__( 'Link Target', 'lwwb' ),
        //                    'description' => esc_html__( 'This will be the link target', 'lwwb' ),
        //                    'default'     => '_self',
        //                    'choices'     => array(
        //                        '_blank' => esc_html__( 'New Window', 'lwwb' ),
        //                        '_self'  => esc_html__( 'Same Frame', 'lwwb' ),
        //                    ),
        //                ),
        //                'image_kca'       => array(
        //                    'type'        => 'image',
        //                    'label'       => esc_html__( 'Image', 'lwwb' ),
        //                    'description' => esc_html__( 'This will be the link target', 'lwwb' ),
        //                ),
        //                'disable_row' => array(
        //                    'type'    => 'checkbox',
        //                    'class'   => 'hidden-row',
        //                    'default' => false,
        //                ),
        //            )
        //        ) ) );

        // // Heading control
        // $wp_customize->add_setting(
        //     'typography_control_heading', array(
        //         'type'       => 'theme_mod',
        //         'default'    => '',
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //     )
        // );

        // $wp_customize->add_control( new Customizer_Control\Heading\Heading( $wp_customize, 'typography_control_heading', array(
        //         'label'       => 'Typography',
        //         'description' => '',
        //         'section'     => 'lwwb_section',
        //     )
        // ) );

        // // Test buttonset control
        // $wp_customize->add_setting(
        //     'typography_control_test', array(
        //         'type'       => 'theme_mod',
        //         'default'    => array(
        //             'font-family' => ''
        //         ),
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //     )
        // );

        // $wp_customize->add_control( new Customizer_Control\Typography\Typography( $wp_customize, 'typography_control_test', array(
        //         'label'       => 'Test Typography Control',
        //         'description' => '',
        //         'section'     => 'lwwb_section',
        //     )
        // ) );

        // // Heading control
        // $wp_customize->add_setting(
        //     'slider_control_heading', array(
        //         'type'       => 'theme_mod',
        //         'default'    => '',
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //     )
        // );

        // // Heading control
        // $wp_customize->add_setting(
        //     'code_editor_heading', array(
        //         'type'       => 'theme_mod',
        //         'default'    => '',
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //     )
        // );

        // $wp_customize->add_control( new Customizer_Control\Heading\Heading( $wp_customize, 'code_editor_heading', array(
        //         'label'       => 'Radio image',
        //         'description' => '',
        //         'section'     => 'lwwb_section',
        //     )
        // ) );

        // $custom_css_setting = new \WP_Customize_Custom_CSS_Setting( $this, sprintf( 'custom_css[%s]', get_stylesheet( 'lwwb-dashboard' ) ), array(
        //     'capability' => 'edit_css',
        //     'default'    => '',
        // ) );

        // $wp_customize->add_setting( $custom_css_setting );

        // // Test buttonset control
        // $wp_customize->add_setting(
        //     'code_editor', array(
        //         'type'       => 'theme_mod',
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //     )
        // );

        // $wp_customize->add_control( new Customizer_Control\Code_Editor(
        //     $wp_customize,
        //     'code_editor', array(
        //         'label'       => 'Test Button_Set',
        //         'description' => '',
        //         'section'     => 'lwwb_section',
        //         'code_type'   => 'text/css',
        //         'input_attrs' => array(
        //             'aria-describedby' => 'editor-keyboard-trap-help-1 editor-keyboard-trap-help-2 editor-keyboard-trap-help-3 editor-keyboard-trap-help-4',
        //         ),

        //     )
        // ) );

        // // Heading control
        // $wp_customize->add_setting(
        //     'radio_image_heading', array(
        //         'type'       => 'theme_mod',
        //         'default'    => '',
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //     )
        // );

        // $wp_customize->add_control( new Customizer_Control\Heading\Heading( $wp_customize, 'radio_image_heading', array(
        //         'label'       => 'Radio image',
        //         'description' => '',
        //         'section'     => 'lwwb_section',
        //     )
        // ) );

        // // Test buttonset control
        // $wp_customize->add_setting(
        //     'radio_image', array(
        //         'type'              => 'theme_mod',
        //         'default'           => 'choice1',
        //         'transport'         => 'postMessage',
        //         'capability'        => 'edit_theme_options',
        //         'sanitize_callback' => 'sanitize_text_field'
        //     )
        // );

        // $wp_customize->add_control( new Customizer_Control\Radio_Image\Radio_Image( $wp_customize, 'radio_image', array(
        //         'label'       => 'Test Button_Set',
        //         'description' => '',
        //         'section'     => 'lwwb_section',
        //         'choices'     => array(
        //             'choice1' => 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png',
        //             'choice2' => 'https://cdn.vox-cdn.com/thumbor/d2lt8DK-xzkG6e13MJHM2AJEjsc=/0x14:800x547/920x613/filters:focal(0x14:800x547):format(webp)/cdn.vox-cdn.com/assets/3124217/new_youtube_logo.jpg',
        //             'choice3' => 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png',
        //         )
        //     )
        // ) );

        // Heading control
        //        $wp_customize->add_setting(
        //            'test_heading', array(
        //                'type'       => 'theme_mod',
        //                'default'    => '',
        //                'transport'  => 'postMessage',
        //                'capability' => 'edit_theme_options',
        //            )
        //        );
        //
        //        $wp_customize->add_control( new Customizer_Control\Heading\Heading( $wp_customize, 'test_heading', array(
        //                'label'       => 'Background control',
        //                'description' => '',
        //                'section'     => 'lwwb_section',
        //            )
        //        ) );
        //
        //
        //        // Test background control
        //        $wp_customize->add_setting(
        //            'test_background', array(
        //                'type'              => 'theme_mod',
        //                'default'           => array(
        //                    'background-type-normal'          => '', //classic, gradien
        //                    'background-color-normal'         => '#c0c0c0',
        //                    'background-image-normal'         => '',
        //                    'background-image-id-normal'      => '',
        //                    'background-position-normal'      => '',
        //                    'background-repeat-normal'        => '',
        //                    'background-size-normal'          => '',
        //                    'gradient-first-color-normal'     => '',
        //                    'gradient-first-location-normal'  => '',
        //                    'gradient-second-color-normal'    => '',
        //                    'gradient-second-location-normal' => '',
        //                    'gradient-type-normal'            => '',
        //                    'background-angle-normal'         => '',
        //
        //                    'video-link'               => '',
        //                    'video-start-timme'        => '',
        //                    'video-end-timme'          => '',
        //                    'video-background-falback' => '',
        //
        //                    'background-type-hover'          => '',
        //                    'background-color-hover'         => '',
        //                    'background-image-hover'         => '',
        //                    'background-image-id-hover'      => '',
        //                    'background-position-hover'      => '',
        //                    'background-repeat-hover'        => '',
        //                    'background-size-hover'          => '',
        //                    'gradient-first-color-hover'     => '',
        //                    'gradient-first-location-hover'  => '',
        //                    'gradient-second-color-hover'    => '',
        //                    'gradient-second-location-hover' => '',
        //                    'gradient-type-hover'            => '',
        //                    'background-angle-hover'         => '',
        //
        //
        //                ),
        //                'transport'         => 'postMessage',
        //                'capability'        => 'edit_theme_options',
        //                'sanitize_callback' => array( 'Lwwb\Customizer\Sanizite_Callback', 'background' )
        //            )
        //        );
        //
        //        $wp_customize->add_control( new Customizer_Control\Background\Background( $wp_customize, 'test_background', array(
        //                'label'       => 'Test background',
        //                'description' => '',
        //                'section'     => 'lwwb_section',
        //            )
        //        ) );

        // // Heading control
        // $wp_customize->add_setting(
        //     'buttonset_heading', array(
        //         'type'       => 'theme_mod',
        //         'default'    => '',
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //     )
        // );

        // $wp_customize->add_control( new Customizer_Control\Heading\Heading( $wp_customize, 'buttonset_heading', array(
        //         'label'       => 'Button set control',
        //         'description' => '',
        //         'section'     => 'lwwb_section',
        //     )
        // ) );

        // Test buttonset control
        // $wp_customize->add_setting(
        //     'test_buttonset', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //         'default'   => 'choice1',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Button_Set($wp_customize, 'test_buttonset', array(
        //     'label'       => 'Test Button_Set',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        //     // 'display_type' => 'icon',
        //     'choices'     => array(
        //         'choice1' => 'Choice 1',
        //         'choice2' => 'Choice 2',
        //         'choice3' => 'Choice 3',
        //     ),
        // )
        // ));

        // // Test buttonset control
        // $wp_customize->add_setting(
        //     'test_buttonset', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //         'default'   => 'choice1',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Button_Set($wp_customize, 'test_buttonset', array(
        //     'label'       => 'Test Button_Set',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        //     // 'display_type' => 'icon',
        //     'choices'     => array(
        //         'choice1' => 'Choice 1',
        //         'choice2' => 'Choice 2',
        //         'choice3' => 'Choice 3',
        //     ),
        // )
        // ));

        // // Test buttonset control
        // $wp_customize->add_setting(
        //     'tab_icon', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Button_Set($wp_customize, 'tab_icon', array(
        //     'label'        => 'Test Tab',
        //     'description'  => '',
        //     'section'      => 'lwwb_section',
        //     'display_type' => 'icon',
        //     'choices'      => array(
        //         'fa fa-facebook' => 'fa fa-facebook',
        //         'fa fa-google'   => 'fa fa-google',
        //         'fa fa-youtube'  => 'fa fa-youtube',
        //         'fa fa-github'   => 'fa fa-github',
        //     ),
        //     'dependencies' => array(
        //         array(
        //             'control'  => 'test_buttonset',
        //             'operator' => '==',
        //             'value'    => 'choice1',
        //         ),
        //         array(
        //             'control'  => 'tab',
        //             'operator' => '==',
        //             'value'    => 'choice2',
        //         ),
        //     ),
        // )
        // ));

        // // Heading control
        // $wp_customize->add_setting(
        //     'color_heading', array(
        //         'type'       => 'theme_mod',
        //         'default'    => '',
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Heading($wp_customize, 'color_heading', array(
        //     'label'       => 'Color control',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        // )
        // ));

        // Test color control
        // $wp_customize->add_setting(
        //     'test_color', array(
        //         'type'      => 'theme_mod',
        //         'default'   => '#000000',
        //         'transport' => 'postMessage',
        //         // 'sanitize_callback' => 'sanitize_text_field'
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Color_Picker($wp_customize, 'test_color', array(
        //     'label'       => 'Test Color',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        // )
        // ));

        // // Test color control
        // $wp_customize->add_setting(
        //     'test_color1', array(
        //         'type'      => 'theme_mod',
        //         'default'   => '#000000',
        //         'transport' => 'postMessage',
        //         // 'sanitize_callback' => 'sanitize_text_field'
        //     )
        // );

        // Test editor control
        //     $wp_customize->add_setting(
        //         'test_wysiwyg', array(
        //             'type'      => 'theme_mod',
        //             'default'   => '<p>Regarding the names and trademarks of other companies and plugins, don’t use them at the start of your plugin name. If you’re not Facebook, you shouldn’t submit a plugin that uses <code>facebook</code> as the first term in your slug. “Facebook Like Sharer” (which would be <code>facebook-like-sharer</code>) is not acceptable, but “Like Sharer for Facebook” (which would be <code>like-sharer-for-facebook</code>) would be alright.</p>',
        //             'transport' => 'postMessage',
        //             // 'sanitize_callback' => 'sanitize_text_field'
        //         )
        //     );

        //     $wp_customize->add_control(new Customizer_Control\WYSIWYG($wp_customize, 'test_wysiwyg', array(
        //         'label'       => 'Test Color',
        //         'description' => '',
        //         'section'     => 'lwwb_section',
        //         'editor_settings' => array(
        //     'tinymce' =>true,
        //     'quicktags' => true,
        //     'mediaButtons' => true,

        // )
        //     )
        //     ));

        // $wp_customize->add_control(new Customizer_Control\Color_Picker($wp_customize, 'test_color1', array(
        //     'label'       => 'Test Color 1',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        // )
        // ));

        // // Heading control
        // $wp_customize->add_setting(
        //     'dimension_heading', array(
        //         'type'       => 'theme_mod',
        //         'default'    => '',
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Heading($wp_customize, 'dimension_heading', array(
        //     'label'       => 'Dimensions control',
        //     'description' => 'This is the dimension control description',
        //     'section'     => 'lwwb_section',
        // )
        // ));

        // Test buttonset control
        // $wp_customize->add_setting(
        //     'test_unit', array(
        //         'type'      => 'theme_mod',
        //         'transport' => 'postMessage',
        //         'default'   => 'px',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Unit($wp_customize, 'test_unit', array(
        //     'label'       => ' &nbsp;',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        //     'choices'     => array(
        //         '%'   => '%',
        //         'px'  => 'px',
        //         'rem' => 'rem',
        //     ),
        // )
        // ));
        // // Test color control
        // $wp_customize->add_setting(
        //     'dimension_padding', array(
        //         'default'    => array(
        //             'desktop-top'    => '2',
        //             'desktop-right'  => '3',
        //             'desktop-bottom' => '4',
        //             'desktop-left'   => '5',
        //             'tablet-top'     => '',
        //             'tablet-right'   => 'auto',
        //             'tablet-bottom'  => '',
        //             'tablet-left'    => 'auto',
        //             'mobile-top'     => '',
        //             'mobile-right'   => '',
        //             'mobile-bottom'  => '',
        //             'mobile-left'    => '',
        //             'unit' => 'px'

        //         ),
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //         // 'sanitize_callback' => array( 'Lwwb\Customizer\Sanizite_Callback', 'dimensions' )
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Dimensions($wp_customize, 'dimension_padding', array(
        //     'label'         => '',
        //     'section'       => 'lwwb_section',
        //     'input_attrs'   => array(
        //         'min'  => 0,
        //         'max'  => 100,
        //         'step' => 1,
        //     ),
        //     'device_config' => array(
        //         'desktop' => array(
        //             'top'    => esc_html__('Top', 'lwwb'),
        //             'right'  => esc_html__('Right', 'lwwb'),
        //             'bottom' => esc_html__('Bottom', 'lwwb'),
        //             'left'   => esc_html__('Left', 'lwwb'),
        //         ),
        //         'tablet'  => array(
        //             'top'    => esc_html__('Top', 'lwwb'),
        //             'right'  => esc_html__('Right', 'lwwb'),
        //             'bottom' => esc_html__('Bottom', 'lwwb'),
        //             'left'   => esc_html__('Left', 'lwwb'),
        //         ),
        //         'mobile'  => array(
        //             'top'    => esc_html__('Top', 'lwwb'),
        //             'right'  => esc_html__('Right', 'lwwb'),
        //             'bottom' => esc_html__('Bottom', 'lwwb'),
        //             'left'   => esc_html__('Left', 'lwwb'),
        //         ),
        //     ),
        //     'unit' =>array(
        //         'px' => 'px',
        //         '%' => '%',
        //     )

        // )));
        // // Test color control
        // $wp_customize->add_setting(
        //     'dimension_padding', array(
        //         'default'    => array(
        //             'desktop-top'    => '2',
        //             'desktop-right'  => '3',
        //             'desktop-bottom' => '4',
        //             'desktop-left'   => '5',
        //             'tablet-top'     => '',
        //             'tablet-right'   => 'auto',
        //             'tablet-bottom'  => '',
        //             'tablet-left'    => 'auto',
        //             'mobile-top'     => '',
        //             'mobile-right'   => '',
        //             'mobile-bottom'  => '',
        //             'mobile-left'    => '',

        //         ),
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //         // 'sanitize_callback' => array( 'Lwwb\Customizer\Sanizite_Callback', 'dimensions' )
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Dimensions($wp_customize, 'dimension_padding', array(
        //     'label'         => '',
        //     'section'       => 'lwwb_section',
        //     'input_attrs'   => array(
        //         'min'  => 0,
        //         'max'  => 100,
        //         'step' => 1,
        //     ),
        //     'device_config' => array(
        //         'desktop' => array(
        //             'top'    => esc_html__('Top', 'lwwb'),
        //             'right'  => esc_html__('Right', 'lwwb'),
        //             'bottom' => esc_html__('Bottom', 'lwwb'),
        //             'left'   => esc_html__('Left', 'lwwb'),
        //         ),
        //         'tablet'  => array(
        //             'top'    => esc_html__('Top', 'lwwb'),
        //             'right'  => esc_html__('Right', 'lwwb'),
        //             'bottom' => esc_html__('Bottom', 'lwwb'),
        //             'left'   => esc_html__('Left', 'lwwb'),
        //         ),
        //         'mobile'  => array(
        //             'top'    => esc_html__('Top', 'lwwb'),
        //             'right'  => esc_html__('Right', 'lwwb'),
        //             'bottom' => esc_html__('Bottom', 'lwwb'),
        //             'left'   => esc_html__('Left', 'lwwb'),
        //         ),
        //     ),

        // )));
        // // Test color control
        // $wp_customize->add_setting(
        //     'dimension_margin', array(
        //         'default'    => array(
        //             'desktop-top'    => '2',
        //             'desktop-right'  => '3',
        //             'desktop-bottom' => '4',
        //             'desktop-left'   => '5',
        //             'tablet-top'     => '',
        //             'tablet-right'   => 'auto',
        //             'tablet-bottom'  => '',
        //             'tablet-left'    => 'auto',
        //             'mobile-top'     => '',
        //             'mobile-right'   => '',
        //             'mobile-bottom'  => '',
        //             'mobile-left'    => '',

        //         ),
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //         // 'sanitize_callback' => array( 'Lwwb\Customizer\Sanizite_Callback', 'dimensions' )
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Dimensions($wp_customize, 'dimension_margin', array(
        //     'label'         => '',
        //     'section'       => 'lwwb_section',
        //     'input_attrs'   => array(
        //         'min'  => 0,
        //         'max'  => 100,
        //         'step' => 1,
        //     ),
        //     'device_config' => array(
        //         'desktop' => array(
        //             'top'    => esc_html__('Top', 'lwwb'),
        //             'right'  => esc_html__('Right', 'lwwb'),
        //             'bottom' => esc_html__('Bottom', 'lwwb'),
        //             'left'   => esc_html__('Left', 'lwwb'),
        //         ),
        //         'tablet'  => array(
        //             'top'    => esc_html__('Top', 'lwwb'),
        //             'right'  => esc_html__('Right', 'lwwb'),
        //             'bottom' => esc_html__('Bottom', 'lwwb'),
        //             'left'   => esc_html__('Left', 'lwwb'),
        //         ),
        //         'mobile'  => array(
        //             'top'    => esc_html__('Top', 'lwwb'),
        //             'right'  => esc_html__('Right', 'lwwb'),
        //             'bottom' => esc_html__('Bottom', 'lwwb'),
        //             'left'   => esc_html__('Left', 'lwwb'),
        //         ),
        //     ),

        // )));

        // // Test dimension control
        // $wp_customize->add_setting(
        //     'dimension_margin', array(
        //         'type'              => 'option',
        //         'default'           => array(
        //             'desktop-top' => '',
        //             // 'desktop-right' => '',
        //             // 'desktop-bottom' => '',
        //             // 'desktop-left' => '',
        //             // 'tablet-top' => '',
        //             // 'tablet-right' => '',
        //             // 'tablet-bottom' => '',
        //             // 'tablet-left' => '',
        //             // 'mobile-top' => '',
        //             // 'mobile-right' => '',
        //             // 'mobile-bottom' => '',
        //             // 'mobile-left' => '',
        //             'unit'        => 'px',

        //         ),
        //         'transport'         => 'postMessage',
        //         'capability'        => 'edit_theme_options',
        //         'sanitize_callback' => array( 'Lwwb\Customizer\Sanizite_Callback', 'dimensions' )
        //     )
        // );

        // $wp_customize->add_control( new Customizer_Control\Dimensions\Dimensions( $wp_customize, 'dimension_margin', array(
        //     'label'       => esc_html__( 'Margin (px)', 'lwwb' ),
        //     'section'     => 'lwwb_section',
        //     'input_attrs' => array(
        //         'min'  => 0,
        //         'max'  => 100,
        //         'step' => 1,
        //     ),
        //     'unit'        => array(
        //         'px'  => 'px',
        //         '%'   => '%',
        //         // 'vh'  => 'vh',
        //         // 'wh'  => 'wh',
        //         'rem' => 'rem',
        //     ),

        //     'device_config' => array(
        //         'desktop' => array(
        //             'top'    => esc_html__( 'Top', 'lwwb' ),
        //             'right'  => esc_html__( 'Right', 'lwwb' ),
        //             'bottom' => esc_html__( 'Bottom', 'lwwb' ),
        //             'left'   => esc_html__( 'Left', 'lwwb' ),
        //         ),
        //         'tablet'  => array(
        //             'top'    => esc_html__( 'Top', 'lwwb' ),
        //             'right'  => esc_html__( 'Right', 'lwwb' ),
        //             'bottom' => esc_html__( 'Bottom', 'lwwb' ),
        //             'left'   => esc_html__( 'Left', 'lwwb' ),
        //         ),
        //         // 'mobile'  => array(
        //         //     'top'    => esc_html__( 'Top', 'lwwb' ),
        //         //     'right'  => esc_html__( 'Right', 'lwwb' ),
        //         //     'bottom' => esc_html__( 'Bottom', 'lwwb' ),
        //         //     'left'   => esc_html__( 'Left', 'lwwb' ),
        //         // )
        //     ),

        // ) ) );

        // // Heading control
        // $wp_customize->add_setting(
        //     'icon_picker_heading', array(
        //         'type'       => 'theme_mod',
        //         'default'    => '',
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //     )
        // );

        // $wp_customize->add_control( new Customizer_Control\Heading\Heading( $wp_customize, 'icon_picker_heading', array(
        //         'label'       => 'Icon picker control',
        //         'description' => '',
        //         'section'     => 'lwwb_section',
        //     )
        // ) );

        // // Test icon picker control
        // $wp_customize->add_setting(
        //     'test_icon_picker', array(
        //         'type'       => 'theme_mod',
        //         'default'    => 'fa fa-facebook',
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //         // 'sanitize_callback' => 'sanitize_text_field'
        //     )
        // );

        // $wp_customize->add_control( new Customizer_Control\Icon_Picker\Icon_Picker( $wp_customize, 'test_icon_picker', array(
        //         'label'       => 'Test icon picker',
        //         'description' => '',
        //         'section'     => 'lwwb_section',
        //     )
        // ) );

        // // Heading control
        // $wp_customize->add_setting(
        //     'image_heading', array(
        //         'type'       => 'theme_mod',
        //         'default'    => '',
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Heading($wp_customize, 'image_heading', array(
        //     'label'       => 'Image control',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        // )
        // ));

        // Test image control
        // $wp_customize->add_setting(
        //     'test_image', array(
        //         'type'       => 'theme_mod',
        //         'default'    => array(
        //             'url' => '',
        //             'id'  => false,

        //         ),
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //         // 'sanitize_callback' => array( 'Lwwb\Customizer\Sanizite_Callback', 'image' )
        //     )
        // );

        // $wp_customize->add_control(new Customizer_Control\Image($wp_customize, 'test_image', array(
        //     'label'       => 'Test image',
        //     'description' => '',
        //     'section'     => 'lwwb_section',
        // )
        // ));

        // // Heading control
        // $wp_customize->add_setting(
        //     'date_picker_heading', array(
        //         'type'       => 'theme_mod',
        //         'default'    => '',
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //     )
        // );

        // $wp_customize->add_control( new Customizer_Control\Heading\Heading( $wp_customize, 'date_picker_heading', array(
        //         'label'       => 'Date Picker',
        //         'description' => '',
        //         'section'     => 'lwwb_section',
        //     )
        // ) );

        // // Date Picker
        // $wp_customize->add_setting(
        //     'date_picker', array(
        //         'type'       => 'theme_mod',
        //         'default'    => '',
        //         'transport'  => 'postMessage',
        //         'capability' => 'edit_theme_options',
        //     )
        // );

        // $wp_customize->add_control( new Customizer_Control\Date_Picker\Date_Picker( $wp_customize, 'date_picker', array(
        //         'label'       => 'Date',
        //         'description' => '',
        //         'section'     => 'lwwb_section',
        //     )
        // ) );

    }

}
