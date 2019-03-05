<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    lwwb.core
 * @subpackage lwwb.core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Builder\Base;

use Lwwb\Base\Assets\Font_Families;
use Lwwb\Customizer\Control_Manager as Control;

class Default_Elmn_Controls
{

    public static function get_content_controls()
    {
        return array();
    }

    public static function get_style_controls()
    {
        return array();
    }

    public static function get_advanced_controls()
    {
        return array(
            array(
                'id'            => 'margin_responsive_switcher',
                'keywords'      => '',
                'label'         => __('Margin', 'lwwb'),
                'type'          => Control::RESPONSIVE_SWITCHER,
                'default'       => array(),
                'device_config' => array(
                    'desktop' => __('Desktop', 'lwwb'),
                    'tablet'  => __('Tablet', 'lwwb'),
                    'mobile'  => __('Mobile', 'lwwb'),
                ),
            ),
            array(
                'id'         => 'margin',
                'keywords'   => 'margin dimension',
                // 'label'      => __('Margin', 'lwwb'),
                'type'       => Control::DIMENSIONS,
                'default'    => array(),
                'on_device'  => 'desktop',
                'options' => array(
                        'top'    => esc_html__('Top', 'lwwb'),
                        'right'  => esc_html__('Right', 'lwwb'),
                        'bottom' => esc_html__('Bottom', 'lwwb'),
                        'left'   => esc_html__('Left', 'lwwb'),
                    ),
                'unit'       => array(
                    'px' => array(
                        'min'  => '-1000',
                        'max'  => '1000',
                        'step' => '1',
                    ),
                    '%'  => array(
                        'min'  => '0',
                        'max'  => '100',
                        'step' => '1',
                    ),
                ),
                'css_format' => "ELMN_WRAPPER > .lwwb-elmn-content{margin: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",
            ),
            array(
                'id'         => '_tablet_margin',
                'keywords'   => 'margin dimension',
                // 'label'      => __('Margin', 'lwwb'),
                'type'       => Control::DIMENSIONS,
                'default'    => array(),
                'on_device'  => 'tablet',
                'options' => array(
                        'top'    => esc_html__('Top', 'lwwb'),
                        'right'  => esc_html__('Right', 'lwwb'),
                        'bottom' => esc_html__('Bottom', 'lwwb'),
                        'left'   => esc_html__('Left', 'lwwb'),
                    ),
                'unit'       => array(
                    'px' => array(
                        'min'  => '-1000',
                        'max'  => '1000',
                        'step' => '1',
                    ),
                    '%'  => array(
                        'min'  => '0',
                        'max'  => '100',
                        'step' => '1',
                    ),
                ),
                'css_format' => "ELMN_WRAPPER > .lwwb-elmn-content{margin: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",
            ),
            array(
                'id'         => '_mobile_margin',
                'keywords'   => 'margin dimension',
                // 'label'      => __('Margin', 'lwwb'),
                'type'       => Control::DIMENSIONS,
                'default'    => array(),
                'on_device'  => 'mobile',
                'options' => array(
                        'top'    => esc_html__('Top', 'lwwb'),
                        'right'  => esc_html__('Right', 'lwwb'),
                        'bottom' => esc_html__('Bottom', 'lwwb'),
                        'left'   => esc_html__('Left', 'lwwb'),
                    ),
                'unit'       => array(
                    'px' => array(
                        'min'  => '-1000',
                        'max'  => '1000',
                        'step' => '1',
                    ),
                    '%'  => array(
                        'min'  => '0',
                        'max'  => '100',
                        'step' => '1',
                    ),
                ),
                'css_format' => "ELMN_WRAPPER > .lwwb-elmn-content{margin: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",
            ),
            // array(
            //     'id'            => 'padding',
            //     'keywords'      => 'padding dimension',
            //     'label'         => __('Padding', 'lwwb'),
            //     'type'          => Control::DIMENSIONS,
            //     'default'       => array(),
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
            //     'unit'          => array(
            //         'px' => array(
            //             'min'  => '-1000',
            //             'max'  => '1000',
            //             'step' => '1',
            //         ),
            //         '%'  => array(
            //             'min'  => '0',
            //             'max'  => '100',
            //             'step' => '1',
            //         ),
            //     ),
            //     'css_format'    => "ELMN_WRAPPER > .lwwb-elmn-content{padding: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",
            // ),
            array(
                'id'             => 'z_index',
                'keywords'       => 'z-index z index',
                'label'          => __('Z-index', 'lwwb'),
                'type'           => Control::TEXT,
                'control_layout' => 'inline',
                'input_type'     => 'number',
                'default'        => '',
                'css_format'     => 'ELMN_WRAPPER {z-index:{{ VALUE }};}',
            ),
            array(
                'id'             => 'css_id',
                'keywords'       => 'css-id cssid',
                'label'          => __('CSS ID', 'lwwb'),
                'type'           => Control::TEXT,
                'control_layout' => 'inline',
                'input_type'     => 'text',
                'default'        => '',
            ),
            array(
                'id'             => 'css_classes',
                'keywords'       => 'css-classes class classes',
                'label'          => __('CSS Classes', 'lwwb'),
                'type'           => Control::TEXT,
                'control_layout' => 'inline',
                'input_type'     => 'text',
                'default'        => '',
            ),
        );
    }

    public static function get_background_controls()
    {
        return array(
            array(
                'id'       => 'bg_state',
                'keywords' => 'background state normal hover',
                'label'    => __('', 'lwwb'),
                'default'  => 'normal',
                'type'     => Control::BUTTON_SET,
                'choices'  => array(
                    'normal' => __('Normal', 'lwwb'),
                    'hover'  => __('Hover', 'lwwb'),
                ),
            ),
            // Normal
            array(
                'id'             => 'bg_type',
                'keywords'       => 'background type normal hover',
                'label'          => __('Background Type', 'lwwb'),
                'default'        => 'classic',
                'control_layout' => 'inline',
                'type'           => Control::BUTTON_SET,
                'display_type'   => 'icon',
                'choices'        => array(
                    'classic'  => 'fa fa-paint-brush',
                    'gradient' => 'fa fa-barcode',
//                    'video'    => 'fa fa-video-camera',
                ),
                'dependencies'   => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                ),
            ),
            array(
                'id'           => 'bg_color',
                'keywords'     => 'color picker',
                'default'      => '',
                'label'        => __('Color', 'lwwb'),
                'type'         => Control::COLOR_PICKER,
                'dependencies' => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_type',
                        'operator' => '===',
                        'value'    => 'classic',
                    ),
                ),
                'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content{ background-color:{{ VALUE }}; }",
            ),
            array(
                'id'           => 'bg_image',
                'keywords'     => 'image, media background',
                'label'        => __('Image', 'lwwb'),
                'type'         => Control::MEDIA_UPLOAD,
                'media_type'   => 'image',
                'default'      => array(
                    'url' => '',
                    'id'  => '',
                ),
                'dependencies' => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_type',
                        'operator' => '===',
                        'value'    => 'classic',
                    ),
                ),
                'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content{ background-image:url({{ URL }}); }",
            ),
            array(
                'id'             => 'bg_position',
                'keywords'       => 'image position, media',
                'label'          => __('Position', 'lwwb'),
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'default'        => '',
                'choices'        => static::get_background_position(),
                'dependencies'   => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_type',
                        'operator' => '===',
                        'value'    => 'classic',
                    ),
                    array(
                        'control'  => 'bg_image',
                        'operator' => '!==',
                        'value'    => array(
                            'url' => '',
                            'id'  => '',
                        ),
                    ),

                ),
                'css_format'     => "ELMN_WRAPPER > .lwwb-elmn-content{ background-position:{{ VALUE }}; }",
            ),
            array(
                'id'             => 'bg_repeat',
                'keywords'       => 'image repeat, media',
                'label'          => __('Repeat', 'lwwb'),
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'default'        => '',
                'choices'        => static::get_background_repeat(),
                'dependencies'   => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_type',
                        'operator' => '===',
                        'value'    => 'classic',
                    ),
                    array(
                        'control'  => 'bg_image',
                        'operator' => '!==',
                        'value'    => array(
                            'url' => '',
                            'id'  => '',
                        ),
                    ),

                ),
                'css_format'     => "ELMN_WRAPPER > .lwwb-elmn-content{ background-repeat:{{ VALUE }}; }",
            ),
            array(
                'id'             => 'bg_attachment',
                'keywords'       => 'image attachment, media',
                'label'          => __('Attachment', 'lwwb'),
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'default'        => '',
                'choices'        => static::get_background_attachment(),
                'dependencies'   => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_type',
                        'operator' => '===',
                        'value'    => 'classic',
                    ),
                    array(
                        'control'  => 'bg_image',
                        'operator' => '!==',
                        'value'    => array(
                            'url' => '',
                            'id'  => '',
                        ),
                    ),

                ),
                'css_format'     => "ELMN_WRAPPER > .lwwb-elmn-content{ background-attachment:{{ VALUE }}; }",
            ),
            array(
                'id'             => 'bg_size',
                'keywords'       => 'image size, media',
                'label'          => __('Size', 'lwwb'),
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'default'        => '',
                'choices'        => static::get_background_size(),
                'dependencies'   => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_type',
                        'operator' => '===',
                        'value'    => 'classic',
                    ),
                    array(
                        'control'  => 'bg_image',
                        'operator' => '!==',
                        'value'    => array(
                            'url' => '',
                            'id'  => '',
                        ),
                    ),

                ),
                'css_format'     => "ELMN_WRAPPER > .lwwb-elmn-content{ background-size:{{ VALUE }}; }",
            ),
            // Gradient
            array(
                'id'           => 'bg_gradient_type',
                'keywords'     => 'background gradient type normal hover',
                'label'        => '',
                'default'      => 'linear',
                'type'         => Control::BUTTON_SET,
                'choices'      => array(
                    'linear' => __('Linear', 'lwwb'),
                    'radial' => __('Radial', 'lwwb'),
                ),
                'dependencies' => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_type',
                        'operator' => '===',
                        'value'    => 'gradient',
                    ),
                ),
            ),
            array(
                'id'           => 'bg_linear_gradient',
                'keywords'     => '',
                'label'        => __('Gradient linear', 'lwwb'),
                'type'         => Control::MODAL,
                'button_icon'  => 'fa fa-pencil',
                'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content{ background-image:linear-gradient({{ ANGLE }}deg, {{ COLOR }} {{ LOCATION }}%, {{ COLOR2 }} {{ LOCATION2 }}% ); }",
                'default'      => array(
                    'color'     => '#fff',
                    'location'  => '0',
                    'color2'    => '#000',
                    'location2' => '100',
                    'angle'     => '90',
                ),
                'fields'       => array(
                    array(
                        'id'       => 'color',
                        'keywords' => 'gradient color picker',
                        'default'  => '',
                        'label'    => __('Color', 'lwwb'),
                        'type'     => Control::COLOR_PICKER,
                    ),
                    array(
                        'id'          => 'location',
                        'keywords'    => 'gradient location angle',
                        'label'       => __('Location', 'lwwb'),
                        'default'     => '0',
                        'type'        => Control::SLIDER,
                        'input_attrs' => array(
                            'min'  => '0',
                            'max'  => '100',
                            'step' => '1',
                        ),
                    ),
                    array(
                        'id'       => 'color2',
                        'keywords' => 'gradient color picker',
                        'default'  => '',
                        'label'    => __('Second Color', 'lwwb'),
                        'type'     => Control::COLOR_PICKER,
                    ),
                    array(
                        'id'          => 'location2',
                        'keywords'    => 'gradient location angle',
                        'label'       => __('Second Location', 'lwwb'),
                        'default'     => '100',
                        'type'        => Control::SLIDER,
                        'input_attrs' => array(
                            'min'  => '0',
                            'max'  => '100',
                            'step' => '1',
                        ),
                    ),
                    array(
                        'id'           => 'angle',
                        'keywords'     => 'gradient location angle',
                        'label'        => __('Angle', 'lwwb'),
                        'default'      => '180',
                        'type'         => Control::SLIDER,
                        'input_attrs'  => array(
                            'min'  => '0',
                            'max'  => '360',
                            'step' => '10',
                        ),
                        'dependencies' => array(
                            array(
                                'control'  => 'type',
                                'operator' => '===',
                                'value'    => 'linear',
                            ),
                        ),
                    ),
                ),
                'dependencies' => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_type',
                        'operator' => '===',
                        'value'    => 'gradient',
                    ),
                    array(
                        'control'  => 'bg_gradient_type',
                        'operator' => '===',
                        'value'    => 'linear',
                    ),
                ),
            ),
            array(
                'id'           => 'bg_radial_gradient',
                'keywords'     => '',
                'label'        => __('Gradient Radial', 'lwwb'),
                'type'         => Control::MODAL,
                'button_icon'  => 'fa fa-pencil',
                'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content{ background-image:radial-gradient(at {{ POSITION }}, {{ COLOR }} {{ LOCATION }}%, {{ COLOR2 }} {{ LOCATION2 }}% ); }",
                'default'      => array(
                    'color'     => '#fff',
                    'location'  => '0',
                    'color2'    => '#000',
                    'location2' => '100',
                    'position'  => 'center center',
                ),
                'fields'       => array(
                    array(
                        'id'       => 'color',
                        'keywords' => 'gradient color picker',
                        'default'  => '',
                        'label'    => __('Color', 'lwwb'),
                        'type'     => Control::COLOR_PICKER,
                    ),
                    array(
                        'id'          => 'location',
                        'keywords'    => 'gradient location angle',
                        'label'       => __('Location', 'lwwb'),
                        'default'     => '0',
                        'type'        => Control::SLIDER,
                        'input_attrs' => array(
                            'min'  => '0',
                            'max'  => '100',
                            'step' => '1',
                        ),
                    ),
                    array(
                        'id'       => 'color2',
                        'keywords' => 'gradient color picker',
                        'default'  => '',
                        'label'    => __('Second Color', 'lwwb'),
                        'type'     => Control::COLOR_PICKER,
                    ),
                    array(
                        'id'          => 'location2',
                        'keywords'    => 'gradient location angle',
                        'label'       => __('Second Location', 'lwwb'),
                        'default'     => '100',
                        'type'        => Control::SLIDER,
                        'input_attrs' => array(
                            'min'  => '0',
                            'max'  => '100',
                            'step' => '1',
                        ),
                    ),
                    array(
                        'id'       => 'position',
                        'keywords' => 'gradient position location angle',
                        'label'    => __('Position', 'lwwb'),
                        'default'  => 'center center',
                        'type'     => Control::SELECT,
                        'choices'  => static::get_background_position(),
                    ),
                ),
                'dependencies' => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_type',
                        'operator' => '===',
                        'value'    => 'gradient',
                    ),
                    array(
                        'control'  => 'bg_gradient_type',
                        'operator' => '===',
                        'value'    => 'radial',
                    ),
                ),
            ),

            // Video
            array(
                'id'           => 'bg_video_link',
                'keywords'     => 'background video bv yt vd',
                'label'        => __('Video Link', 'lwwb'),
                'description'  => esc_html__('YouTube link or video file (mp4 is recommended).', 'lwwb'),
                'default'      => '',
                'input_type'   => 'url',
                'type'         => Control::TEXT,
                'dependencies' => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_type',
                        'operator' => '===',
                        'value'    => 'video',
                    ),
                ),
            ),
            array(
                'id'             => 'bg_video-start-time',
                'keywords'       => 'background video start time',
                'label'          => __('Start Time', 'lwwb'),
                'default'        => '0',
                'control_layout' => 'inline',
                'input_type'     => 'number',
                'type'           => Control::TEXT,
                'dependencies'   => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_type',
                        'operator' => '===',
                        'value'    => 'video',
                    ),
                ),
            ),
            array(
                'id'             => 'bg_video-end-time',
                'keywords'       => 'background video end time',
                'label'          => __('End Time', 'lwwb'),
                'default'        => '',
                'control_layout' => 'inline',
                'input_type'     => 'number',
                'type'           => Control::TEXT,
                'dependencies'   => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_type',
                        'operator' => '===',
                        'value'    => 'video',
                    ),
                ),
            ),
            array(
                'id'           => 'bg_video-fallback',
                'keywords'     => 'image, media background video fallback',
                'label'        => __('Background Fallback', 'lwwb'),
                'type'         => Control::MEDIA_UPLOAD,
                'media_type'   => 'image',
                'default'      => array(
                    'url' => '',
                    'id'  => '',
                ),
                'dependencies' => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_type',
                        'operator' => '===',
                        'value'    => 'video',
                    ),
                ),
            ),
            // End Normal

            // Hover
            array(
                'id'             => 'bg_hover_type',
                'keywords'       => 'background type normal hover',
                'label'          => __('Background Type', 'lwwb'),
                'default'        => 'classic',
                'control_layout' => 'inline',
                'type'           => Control::BUTTON_SET,
                'display_type'   => 'icon',
                'choices'        => array(
                    'classic'  => 'fa fa-paint-brush',
                    'gradient' => 'fa fa-barcode',
                ),
                'dependencies'   => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'hover',
                    ),
                ),
            ),
            array(
                'id'           => 'bg_hover_color',
                'keywords'     => 'color picker',
                'default'      => '',
                'label'        => __('Color', 'lwwb'),
                'type'         => Control::COLOR_PICKER,
                'dependencies' => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'hover',
                    ),
                    array(
                        'control'  => 'bg_hover_type',
                        'operator' => '===',
                        'value'    => 'classic',
                    ),
                ),
                'css_format'   => "ELMN_WRAPPER:hover > .lwwb-elmn-content { background-color:{{ VALUE }}; }",
            ),
            array(
                'id'           => 'bg_hover_img',
                'keywords'     => 'image, media background',
                'label'        => __('Image', 'lwwb'),
                'media_type'   => 'image',
                'type'         => Control::MEDIA_UPLOAD,
                'default'      => array(
                    'url' => '',
                    'id'  => '',
                ),
                'dependencies' => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'hover',
                    ),
                    array(
                        'control'                => 'bg_hover_type',
                        'operator'               => '===',
                        'value'                  => 'classic',
                        'check_for_render_style' => true,
                    ),
                ),
            ),
            array(
                'id'             => 'bg_hover_position',
                'keywords'       => 'image position, media',
                'label'          => __('Position', 'lwwb'),
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'default'        => '',
                'choices'        => static::get_background_position(),
                'dependencies'   => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'hover',
                    ),
                    array(
                        'control'  => 'bg_hover_type',
                        'operator' => '===',
                        'value'    => 'classic',
                    ),
                    array(
                        'control'  => 'bg_hover_img',
                        'operator' => '!==',
                        'value'    => array(
                            'url' => '',
                            'id'  => '',
                        ),
                    ),

                ),
            ),
            array(
                'id'             => 'bg_hover_repeat',
                'keywords'       => 'image repeat, media',
                'label'          => __('Repeat', 'lwwb'),
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'default'        => '',
                'choices'        => static::get_background_repeat(),
                'dependencies'   => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'hover',
                    ),
                    array(
                        'control'  => 'bg_hover_type',
                        'operator' => '===',
                        'value'    => 'classic',
                    ),
                    array(
                        'control'  => 'bg_hover_img',
                        'operator' => '!==',
                        'value'    => array(
                            'url' => '',
                            'id'  => '',
                        ),
                    ),

                ),
            ),
            array(
                'id'             => 'bg_hover_attachment',
                'keywords'       => 'image attachment, media',
                'label'          => __('Attachment', 'lwwb'),
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'default'        => '',
                'choices'        => static::get_background_attachment(),
                'dependencies'   => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'hover',
                    ),
                    array(
                        'control'  => 'bg_hover_type',
                        'operator' => '===',
                        'value'    => 'classic',
                    ),
                    array(
                        'control'  => 'bg_hover_img',
                        'operator' => '!==',
                        'value'    => array(
                            'url' => '',
                            'id'  => '',
                        ),
                    ),

                ),
            ),
            array(
                'id'             => 'bg_hover_size',
                'keywords'       => 'image size, media',
                'label'          => __('Size', 'lwwb'),
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'default'        => '',
                'choices'        => static::get_background_size(),
                'dependencies'   => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'hover',
                    ),
                    array(
                        'control'  => 'bg_hover_type',
                        'operator' => '===',
                        'value'    => 'classic',
                    ),
                    array(
                        'control'  => 'bg_hover_img',
                        'operator' => '!==',
                        'value'    => array(
                            'url' => '',
                            'id'  => '',
                        ),
                    ),

                ),
            ),

            // Gradient
            array(
                'id'           => 'bg_gradient_hover_type',
                'keywords'     => 'background gradient type  hover',
                'label'        => '',
                'default'      => '',
                'type'         => Control::BUTTON_SET,
                'choices'      => array(
                    'linear' => __('Linear', 'lwwb'),
                    'radial' => __('Radial', 'lwwb'),
                ),
                'dependencies' => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'hover',
                    ),
                    array(
                        'control'  => 'bg_hover_type',
                        'operator' => '===',
                        'value'    => 'gradient',
                    ),
                ),
            ),
            array(
                'id'           => 'bg_hover_linear_gradient',
                'keywords'     => '',
                'label'        => __('Gradient linear', 'lwwb'),
                'type'         => Control::MODAL,
                'button_icon'  => 'fa fa-pencil',
                'css_format'   => "ELMN_WRAPPER:hover > .lwwb-elmn-content{ background-image:linear-gradient({{ ANGLE }}deg, {{ COLOR }} {{ LOCATION }}%, {{ COLOR2 }} {{ LOCATION2 }}% ); }",
                'default'      => array(
                    'color'     => '#fff',
                    'location'  => '0',
                    'color2'    => '#000',
                    'location2' => '100',
                    'angle'     => '90',
                ),
                'fields'       => array(
                    array(
                        'id'       => 'color',
                        'keywords' => 'gradient color picker',
                        'default'  => '',
                        'label'    => __('Color', 'lwwb'),
                        'type'     => Control::COLOR_PICKER,
                    ),
                    array(
                        'id'          => 'location',
                        'keywords'    => 'gradient location angle',
                        'label'       => __('Location', 'lwwb'),
                        'default'     => '0',
                        'type'        => Control::SLIDER,
                        'input_attrs' => array(
                            'min'  => '0',
                            'max'  => '100',
                            'step' => '1',
                        ),
                    ),
                    array(
                        'id'       => 'color2',
                        'keywords' => 'gradient color picker',
                        'default'  => '',
                        'label'    => __('Second Color', 'lwwb'),
                        'type'     => Control::COLOR_PICKER,
                    ),
                    array(
                        'id'          => 'location2',
                        'keywords'    => 'gradient location angle',
                        'label'       => __('Second Location', 'lwwb'),
                        'default'     => '100',
                        'type'        => Control::SLIDER,
                        'input_attrs' => array(
                            'min'  => '0',
                            'max'  => '100',
                            'step' => '1',
                        ),
                    ),
                    array(
                        'id'           => 'angle',
                        'keywords'     => 'gradient location angle',
                        'label'        => __('Angle', 'lwwb'),
                        'default'      => '180',
                        'type'         => Control::SLIDER,
                        'input_attrs'  => array(
                            'min'  => '0',
                            'max'  => '360',
                            'step' => '10',
                        ),
                        'dependencies' => array(
                            array(
                                'control'  => 'type',
                                'operator' => '===',
                                'value'    => 'linear',
                            ),
                        ),
                    ),
                ),
                'dependencies' => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'hover',
                    ),
                    array(
                        'control'                => 'bg_hover_type',
                        'operator'               => '===',
                        'value'                  => 'gradient',
                        'check_for_render_style' => true,
                    ),
                    array(
                        'control'                => 'bg_gradient_hover_type',
                        'operator'               => '===',
                        'value'                  => 'linear',
                        'check_for_render_style' => true,
                    ),
                ),
            ),
            array(
                'id'           => 'bg_hover_radial_gradient',
                'keywords'     => '',
                'label'        => __('Gradient Radial', 'lwwb'),
                'type'         => Control::MODAL,
                'button_icon'  => 'fa fa-pencil',
                'css_format'   => "ELMN_WRAPPER:hover > .lwwb-elmn-content{ background-image:radial-gradient(at {{ POSITION }}, {{ COLOR }} {{ LOCATION }}%, {{ COLOR2 }} {{ LOCATION2 }}% ); }",
                'default'      => array(
                    'color'     => '#fff',
                    'location'  => '0',
                    'color2'    => '#000',
                    'location2' => '100',
                    'position'  => 'center center',
                ),
                'fields'       => array(
                    array(
                        'id'       => 'color',
                        'keywords' => 'gradient color picker',
                        'default'  => '',
                        'label'    => __('Color', 'lwwb'),
                        'type'     => Control::COLOR_PICKER,
                    ),
                    array(
                        'id'          => 'location',
                        'keywords'    => 'gradient location angle',
                        'label'       => __('Location', 'lwwb'),
                        'default'     => '0',
                        'type'        => Control::SLIDER,
                        'input_attrs' => array(
                            'min'  => '0',
                            'max'  => '100',
                            'step' => '1',
                        ),
                    ),
                    array(
                        'id'       => 'color2',
                        'keywords' => 'gradient color picker',
                        'default'  => '',
                        'label'    => __('Second Color', 'lwwb'),
                        'type'     => Control::COLOR_PICKER,
                    ),
                    array(
                        'id'          => 'location2',
                        'keywords'    => 'gradient location angle',
                        'label'       => __('Second Location', 'lwwb'),
                        'default'     => '100',
                        'type'        => Control::SLIDER,
                        'input_attrs' => array(
                            'min'  => '0',
                            'max'  => '100',
                            'step' => '1',
                        ),
                    ),
                    array(
                        'id'       => 'position',
                        'keywords' => 'gradient position location angle',
                        'label'    => __('Position', 'lwwb'),
                        'default'  => 'center center',
                        'type'     => Control::SELECT,
                        'choices'  => static::get_background_position(),
                    ),
                ),
                'dependencies' => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'hover',
                    ),
                    array(
                        'control'                => 'bg_hover_type',
                        'operator'               => '===',
                        'value'                  => 'gradient',
                        'check_for_render_style' => true,
                    ),
                    array(
                        'control'                => 'bg_gradient_hover_type',
                        'operator'               => '===',
                        'value'                  => 'radial',
                        'check_for_render_style' => true,
                    ),
                ),
            ),
            array(
                'id'           => 'transition_duration',
                'keywords'     => 'Transition Duration, shadow,box shadow, horizontal shadow',
                'label'        => __('Transition Duration', 'lwwb'),
                'type'         => Control::SLIDER,
                'input_attrs'  => array(
                    'min'  => '0',
                    'max'  => '3',
                    'step' => '0.1',
                ),
                'dependencies' => array(
                    array(
                        'control'  => 'bg_state',
                        'operator' => '===',
                        'value'    => 'hover',
                    ),
                ),
                'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content { transition:background {{ VALUE }}s, border 0.3s, border-radius 0.3s, box-shadow 0.3s ; }",
            ),
            // End Hover

        );
    }

    public static function get_background_overlay_controls()
    {
        return array(
            array(
                'id'       => 'bg_overlay_state',
                'keywords' => 'bg_overlay state normal hover',
                'label'    => __('', 'lwwb'),
                'default'  => '',
                'type'     => Control::BUTTON_SET,
                'choices'  => array(
                    'normal' => __('Normal', 'lwwb'),
                    'hover'  => __('Hover', 'lwwb'),
                ),
            ),
            // Normal
            array(
                'id'             => 'bg_overlay_type',
                'keywords'       => 'bg_overlay type normal hover',
                'label'          => __('Background Type', 'lwwb'),
                'default'        => '',
                'control_layout' => 'inline',
                'type'           => Control::BUTTON_SET,
                'display_type'   => 'icon',
                'choices'        => array(
                    'classic'  => 'fa fa-paint-brush',
                    'gradient' => 'fa fa-barcode',
                ),
                'dependencies'   => array(
                    array(
                        'control'  => 'bg_overlay_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                ),
            ),
            array(
                'id'           => 'bg_overlay_color',
                'keywords'     => 'background overlay normal color picker',
                'default'      => '',
                'label'        => __('Color', 'lwwb'),
                'type'         => Control::COLOR_PICKER,
                'dependencies' => array(
                    array(
                        'control'  => 'bg_overlay_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_overlay_type',
                        'operator' => '===',
                        'value'    => 'classic',
                    ),
                ),
                'css_format'   => "ELMN_WRAPPER >.lwwb-elmn-background-overlay{ background-color: {{ VALUE }}; }",

            ),
            array(
                'id'           => 'bg_overlay_image',
                'keywords'     => 'background image overlay normal color picker',
                'default'      => array(
                    'url' => '',
                    'id'  => '',
                ),
                'label'        => __('Image', 'lwwb'),
                'type'         => Control::MEDIA_UPLOAD,
                'media_type'   => 'image',
                'dependencies' => array(
                    array(
                        'control'  => 'bg_overlay_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_overlay_type',
                        'operator' => '===',
                        'value'    => 'classic',
                    ),
                ),

                'css_format'   => "ELMN_WRAPPER >.lwwb-elmn-background-overlay{ background-image: url({{ URL }}); }",
            ),

            array(
                'id'             => 'bg_overlay_position',
                'keywords'       => 'image position, media',
                'label'          => __('Position', 'lwwb'),
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'default'        => '',
                'choices'        => static::get_background_position(),
                'dependencies'   => array(
                    array(
                        'control'  => 'bg_overlay_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_overlay_type',
                        'operator' => '===',
                        'value'    => 'classic',
                    ),
                    array(
                        'control'  => 'bg_overlay_image',
                        'operator' => '!==',
                        'value'    => array(
                            'url' => '',
                            'id'  => '',
                        ),
                    ),

                ),
                'css_format'     => "ELMN_WRAPPER >.lwwb-elmn-background-overlay{ background-position:{{ VALUE }}; }",
            ),
            array(
                'id'             => 'bg_overlay_repeat',
                'keywords'       => 'image repeat, media',
                'label'          => __('Repeat', 'lwwb'),
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'default'        => '',
                'choices'        => static::get_background_repeat(),
                'dependencies'   => array(
                    array(
                        'control'  => 'bg_overlay_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_overlay_type',
                        'operator' => '===',
                        'value'    => 'classic',
                    ),
                    array(
                        'control'  => 'bg_overlay_image',
                        'operator' => '!==',
                        'value'    => array(
                            'url' => '',
                            'id'  => '',
                        ),
                    ),
                ),
                'css_format'     => "ELMN_WRAPPER >.lwwb-elmn-background-overlay{ background-repeat:{{ VALUE }}; }",
            ),
            array(
                'id'             => 'bg_overlay_attachment',
                'keywords'       => 'image attachment, media',
                'label'          => __('Attachment', 'lwwb'),
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'default'        => '',
                'choices'        => static::get_background_attachment(),
                'dependencies'   => array(
                    array(
                        'control'  => 'bg_overlay_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_overlay_type',
                        'operator' => '===',
                        'value'    => 'classic',
                    ),
                    array(
                        'control'  => 'bg_overlay_image',
                        'operator' => '!==',
                        'value'    => array(
                            'url' => '',
                            'id'  => '',
                        ),
                    ),
                ),
                'css_format'     => "ELMN_WRAPPER >.lwwb-elmn-background-overlay{ background-attachment:{{ VALUE }}; }",
            ),
            array(
                'id'             => 'bg_overlay_size',
                'keywords'       => 'image size, media',
                'label'          => __('Size', 'lwwb'),
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'default'        => '',
                'choices'        => static::get_background_size(),
                'dependencies'   => array(
                    array(
                        'control'  => 'bg_overlay_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_overlay_type',
                        'operator' => '===',
                        'value'    => 'classic',
                    ),
                    array(
                        'control'  => 'bg_overlay_image',
                        'operator' => '!==',
                        'value'    => array(
                            'url' => '',
                            'id'  => '',
                        ),
                    ),
                ),
                'css_format'     => "ELMN_WRAPPER >.lwwb-elmn-background-overlay{ background-size:{{ VALUE }}; }",
            ),
            array(
                'id'           => 'bg_overlay_opacity',
                'keywords'     => 'overlay background opacity',
                'label'        => __('Opacity', 'lwwb'),
                'default'      => '0.5',
                'type'         => Control::SLIDER,
                'input_attrs'  => array(
                    'min'  => '0',
                    'max'  => '1',
                    'step' => '0.1',
                ),
                'dependencies' => array(
                    array(
                        'control'  => 'bg_overlay_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_overlay_type',
                        'operator' => '===',
                        'value'    => 'classic',
                    ),
                    array(
                        'control'  => 'bg_overlay_image',
                        'operator' => '!==',
                        'value'    => array(
                            'url' => '',
                            'id'  => '',
                        ),
                    ),
                ),
                'css_format'   => "ELMN_WRAPPER >.lwwb-elmn-background-overlay{ opacity:{{ VALUE }}; }",
            ),
            // Gradient
            array(
                'id'           => 'bg_overlay_gradient_type',
                'keywords'     => 'background gradient type normal hover',
                'label'        => '',
                'default'      => 'linear',
                'type'         => Control::BUTTON_SET,
                'choices'      => array(
                    'linear' => __('Linear', 'lwwb'),
                    'radial' => __('Radial', 'lwwb'),
                ),
                'dependencies' => array(
                    array(
                        'control'  => 'bg_overlay_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_overlay_type',
                        'operator' => '===',
                        'value'    => 'gradient',
                    ),
                ),
            ),
            array(
                'id'           => 'bg_overlay_linear_gradient',
                'keywords'     => '',
                'label'        => __('Gradient linear', 'lwwb'),
                'type'         => Control::MODAL,
                'button_icon'  => 'fa fa-pencil',
                'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-background-overlay{ background-image:linear-gradient({{ ANGLE }}deg, {{ COLOR }} {{ LOCATION }}%, {{ COLOR2 }} {{ LOCATION2 }}% ); }",
                'default'      => array(
                    'color'     => '#fff',
                    'location'  => '0',
                    'color2'    => '#000',
                    'location2' => '100',
                    'angle'     => '90',
                ),
                'fields'       => array(
                    array(
                        'id'       => 'color',
                        'keywords' => 'gradient color picker',
                        'default'  => '',
                        'label'    => __('Color', 'lwwb'),
                        'type'     => Control::COLOR_PICKER,
                    ),
                    array(
                        'id'          => 'location',
                        'keywords'    => 'gradient location angle',
                        'label'       => __('Location', 'lwwb'),
                        'default'     => '0',
                        'type'        => Control::SLIDER,
                        'input_attrs' => array(
                            'min'  => '0',
                            'max'  => '100',
                            'step' => '1',
                        ),
                    ),
                    array(
                        'id'       => 'color2',
                        'keywords' => 'gradient color picker',
                        'default'  => '',
                        'label'    => __('Second Color', 'lwwb'),
                        'type'     => Control::COLOR_PICKER,
                    ),
                    array(
                        'id'          => 'location2',
                        'keywords'    => 'gradient location angle',
                        'label'       => __('Second Location', 'lwwb'),
                        'default'     => '100',
                        'type'        => Control::SLIDER,
                        'input_attrs' => array(
                            'min'  => '0',
                            'max'  => '100',
                            'step' => '1',
                        ),
                    ),
                    array(
                        'id'           => 'angle',
                        'keywords'     => 'gradient location angle',
                        'label'        => __('Angle', 'lwwb'),
                        'default'      => '180',
                        'type'         => Control::SLIDER,
                        'input_attrs'  => array(
                            'min'  => '0',
                            'max'  => '360',
                            'step' => '10',
                        ),
                        'dependencies' => array(
                            array(
                                'control'  => 'type',
                                'operator' => '===',
                                'value'    => 'linear',
                            ),
                        ),
                    ),
                ),
                'dependencies' => array(
                    array(
                        'control'  => 'bg_overlay_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_overlay_type',
                        'operator' => '===',
                        'value'    => 'gradient',
                    ),
                    array(
                        'control'  => 'bg_overlay_gradient_type',
                        'operator' => '===',
                        'value'    => 'linear',
                    ),
                ),
            ),
            array(
                'id'           => 'bg_overlay_radial_gradient',
                'keywords'     => '',
                'label'        => __('Gradient Radial', 'lwwb'),
                'type'         => Control::MODAL,
                'button_icon'  => 'fa fa-pencil',
                'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-background-overlay{ background-image:radial-gradient(at {{ POSITION }}, {{ COLOR }} {{ LOCATION }}%, {{ COLOR2 }} {{ LOCATION2 }}% ); }",
                'default'      => array(
                    'color'     => '#fff',
                    'location'  => '0',
                    'color2'    => '#000',
                    'location2' => '100',
                    'position'  => 'center center',
                ),
                'fields'       => array(
                    array(
                        'id'       => 'color',
                        'keywords' => 'gradient color picker',
                        'default'  => '',
                        'label'    => __('Color', 'lwwb'),
                        'type'     => Control::COLOR_PICKER,
                    ),
                    array(
                        'id'          => 'location',
                        'keywords'    => 'gradient location angle',
                        'label'       => __('Location', 'lwwb'),
                        'default'     => '0',
                        'type'        => Control::SLIDER,
                        'input_attrs' => array(
                            'min'  => '0',
                            'max'  => '100',
                            'step' => '1',
                        ),
                    ),
                    array(
                        'id'       => 'color2',
                        'keywords' => 'gradient color picker',
                        'default'  => '',
                        'label'    => __('Second Color', 'lwwb'),
                        'type'     => Control::COLOR_PICKER,
                    ),
                    array(
                        'id'          => 'location2',
                        'keywords'    => 'gradient location angle',
                        'label'       => __('Second Location', 'lwwb'),
                        'default'     => '100',
                        'type'        => Control::SLIDER,
                        'input_attrs' => array(
                            'min'  => '0',
                            'max'  => '100',
                            'step' => '1',
                        ),
                    ),
                    array(
                        'id'       => 'position',
                        'keywords' => 'gradient position location angle',
                        'label'    => __('Position', 'lwwb'),
                        'default'  => 'center center',
                        'type'     => Control::SELECT,
                        'choices'  => static::get_background_position(),
                    ),
                ),
                'dependencies' => array(
                    array(
                        'control'  => 'bg_overlay_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'bg_overlay_type',
                        'operator' => '===',
                        'value'    => 'gradient',
                    ),
                    array(
                        'control'  => 'bg_overlay_gradient_type',
                        'operator' => '===',
                        'value'    => 'radial',
                    ),
                ),
            ),

            // DIVIDER
            array(
                'id'           => 'bg_overlay_divider',
                'keywords'     => 'background overlay normal color picker',
                'default'      => '',
                'label'        => __('', 'lwwb'),
                'type'         => Control::DIVIDER,
                'dependencies' => array(
                    array(
                        'control'  => 'bg_overlay_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                ),
            ),
            // CSS Filters
            array(
                'id'           => 'bg_overlay_css_filter',
                'keywords'     => '',
                'label'        => __('CSS Filters', 'lwwb'),
                'type'         => Control::MODAL,
                'button_icon'  => 'fa fa-pencil',
                'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-background-overlay{filter: brightness( {{ BRIGHTNESS }}% ) contrast( {{ CONTRAST }}% ) saturate( {{ SATURATION }}% ) blur( {{ BLUR }}px ) hue-rotate( {{ HUE }}deg ) ;}",
                'default'      => array(
                    'blur'       => '0',
                    'brightness' => '100',
                    'contrast'   => '100',
                    'saturation' => '100',
                    'hue'        => '0',
                ),
                'fields'       => array(
                    array(
                        'id'          => 'blur',
                        'keywords'    => 'shadow,box shadow, horizontal shadow',
                        'label'       => __('Blur', 'lwwb'),
                        'default'     => '0',
                        'type'        => Control::SLIDER,
                        'input_attrs' => array(
                            'min'  => '0',
                            'max'  => '100',
                            'step' => '1',
                        ),
                    ),
                    array(
                        'id'          => 'brightness',
                        'keywords'    => 'shadow,box shadow, vertical shadow',
                        'label'       => __('Brightness', 'lwwb'),
                        'default'     => '100',
                        'type'        => Control::SLIDER,
                        'input_attrs' => array(
                            'min'  => '0',
                            'max'  => '100',
                            'step' => '1',
                        ),
                    ),
                    array(
                        'id'          => 'contrast',
                        'keywords'    => 'shadow,box shadow, blur shadow',
                        'label'       => __('Contrast', 'lwwb'),
                        'default'     => '100',
                        'type'        => Control::SLIDER,
                        'input_attrs' => array(
                            'min'  => '0',
                            'max'  => '100',
                            'step' => '1',
                        ),
                    ),
                    array(
                        'id'          => 'saturation',
                        'keywords'    => 'shadow,box shadow, Spread shadow',
                        'label'       => __('Saturation', 'lwwb'),
                        'default'     => '100',
                        'type'        => Control::SLIDER,
                        'input_attrs' => array(
                            'min'  => '0',
                            'max'  => '100',
                            'step' => '1',
                        ),
                    ),
                    array(
                        'id'          => 'hue',
                        'keywords'    => 'shadow,box shadow, Spread shadow',
                        'label'       => __('Hue', 'lwwb'),
                        'default'     => '0',
                        'type'        => Control::SLIDER,
                        'input_attrs' => array(
                            'min'  => '0',
                            'max'  => '100',
                            'step' => '1',
                        ),
                    ),
                ),
                'dependencies' => array(
                    array(
                        'control'  => 'bg_overlay_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                ),
            ),
            // Blend Mode
            array(
                'id'             => 'bg_overlay_blend_mode',
                'keywords'       => 'select',
                'label'          => __('Blend Mode', 'lwwb'),
                'default'        => 'none',
                'control_layout' => 'inline',
                'keywords'       => 'blend Mode, Css filters normal type',
                'type'           => Control::SELECT,
                'choices'        => array(
                    ''            => esc_html__('Normal', 'lwwb'),
                    'multiply'    => esc_html__('Multiply', 'lwwb'),
                    'screen'      => esc_html__('Screen', 'lwwb'),
                    'overlay'     => esc_html__('Overlay', 'lwwb'),
                    'darken'      => esc_html__('Darken', 'lwwb'),
                    'lighten'     => esc_html__('Lighten', 'lwwb'),
                    'color-dodge' => esc_html__('Color Dodge', 'lwwb'),
                    'saturation'  => esc_html__('Saturation', 'lwwb'),
                    'color'       => esc_html__('Color', 'lwwb'),
                    'luminosity'  => esc_html__('Luminosity', 'lwwb'),
                ),
                'dependencies'   => array(
                    array(
                        'control'  => 'bg_overlay_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                ),
                'css_format'     => 'ELMN_WRAPPER > .lwwb-elmn-background-overlay{mix-blend-mode:{{ VALUE }};}',
            ),
        );

    }

    public static function get_border_controls()
    {
        return array(
            array(
                'id'       => 'border_state',
                'keywords' => 'border state normal hover',
                'label'    => __('', 'lwwb'),
                'default'  => 'normal',
                'type'     => Control::BUTTON_SET,
                'choices'  => array(
                    'normal' => __('Normal', 'lwwb'),
                    'hover'  => __('Hover', 'lwwb'),
                ),

            ),
            array(
                'id'             => 'border_type',
                'keywords'       => 'select',
                'label'          => __('Border type', 'lwwb'),
                'default'        => 'none',
                'control_layout' => 'inline',
                'keywords'       => 'border normal type',
                'type'           => Control::SELECT,
                'choices'        => array(
                    'none'   => __('None', 'lwwb'),
                    'solid'  => __('Solid', 'lwwb'),
                    'double' => __('Double', 'lwwb'),
                    'dotted' => __('Dotted', 'lwwb'),
                    'dashed' => __('Dashed', 'lwwb'),
                    'groove' => __('Groove', 'lwwb'),
                ),
                'dependencies'   => array(
                    array(
                        'control'  => 'border_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                ),
                'css_format'     => 'ELMN_WRAPPER > .lwwb-elmn-content{border-style:{{ VALUE }};}',
            ),
            array(
                'id'            => 'border_width',
                'keywords'      => 'border normal width',
                'label'         => __('Width', 'lwwb'),
                'type'          => Control::DIMENSIONS,
                'default'       => array(
                    'desktop-top'    => '',
                    'desktop-right'  => '',
                    'desktop-bottom' => '',
                    'desktop-left'   => '',
                    'desktop-unit'   => 'px',
                    'tablet-top'     => '',
                    'tablet-right'   => '',
                    'tablet-bottom'  => '',
                    'tablet-left'    => '',
                    'tablet-unit'    => 'px',
                    'mobile-top'     => '',
                    'mobile-right'   => '',
                    'mobile-bottom'  => '',
                    'mobile-left'    => '',
                    'mobile-unit'    => 'px',
                ),
                'device_config' => array(
                    'desktop' => array(
                        'top'    => esc_html__('Top', 'lwwb'),
                        'right'  => esc_html__('Right', 'lwwb'),
                        'bottom' => esc_html__('Bottom', 'lwwb'),
                        'left'   => esc_html__('Left', 'lwwb'),

                    ),
                    'tablet'  => array(
                        'top'    => esc_html__('Top', 'lwwb'),
                        'right'  => esc_html__('Right', 'lwwb'),
                        'bottom' => esc_html__('Bottom', 'lwwb'),
                        'left'   => esc_html__('Left', 'lwwb'),

                    ),
                    'mobile'  => array(
                        'top'    => esc_html__('Top', 'lwwb'),
                        'right'  => esc_html__('Right', 'lwwb'),
                        'bottom' => esc_html__('Bottom', 'lwwb'),
                        'left'   => esc_html__('Left', 'lwwb'),

                    ),
                ),
                'unit'          => array(
                    'px' => array(
                        'min'  => '-1000',
                        'max'  => '1000',
                        'step' => '1',
                    ),
                    '%'  => array(
                        'min'  => '0',
                        'max'  => '100',
                        'step' => '1',
                    ),
                ),
                'dependencies'  => array(
                    array(
                        'control'  => 'border_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'border_type',
                        'operator' => '!==',
                        'value'    => 'none',
                    ),
                ),
                'css_format'    => "ELMN_WRAPPER > .lwwb-elmn-content{border-width: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",

            ),
            array(
                'id'           => 'border_color',
                'keywords'     => 'border normal color picker',
                'default'      => '',
                'label'        => __('Border color', 'lwwb'),
                'type'         => Control::COLOR_PICKER,
                'dependencies' => array(
                    array(
                        'control'  => 'border_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                    array(
                        'control'  => 'border_type',
                        'operator' => '!==',
                        'value'    => 'none',
                    ),
                ),
                'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content{border-color:{{ VALUE }};}',
            ),
            array(
                'id'            => 'border_radius',
                'keywords'      => 'border normal radius',
                'label'         => __('Border Radius', 'lwwb'),
                'type'          => Control::DIMENSIONS,
                'default'       => array(
                    'desktop-top'    => '',
                    'desktop-right'  => '',
                    'desktop-bottom' => '',
                    'desktop-left'   => '',
                    'desktop-unit'   => 'px',
                    'tablet-top'     => '',
                    'tablet-right'   => '',
                    'tablet-bottom'  => '',
                    'tablet-left'    => '',
                    'tablet-unit'    => 'px',
                    'mobile-top'     => '',
                    'mobile-right'   => '',
                    'mobile-bottom'  => '',
                    'mobile-left'    => '',
                    'mobile-unit'    => 'px',
                ),
                'device_config' => array(
                    'desktop' => array(
                        'top'    => esc_html__('Top', 'lwwb'),
                        'right'  => esc_html__('Right', 'lwwb'),
                        'bottom' => esc_html__('Bottom', 'lwwb'),
                        'left'   => esc_html__('Left', 'lwwb'),
                    ),
                    'tablet'  => array(
                        'top'    => esc_html__('Top', 'lwwb'),
                        'right'  => esc_html__('Right', 'lwwb'),
                        'bottom' => esc_html__('Bottom', 'lwwb'),
                        'left'   => esc_html__('Left', 'lwwb'),
                    ),
                    'mobile'  => array(
                        'top'    => esc_html__('Top', 'lwwb'),
                        'right'  => esc_html__('Right', 'lwwb'),
                        'bottom' => esc_html__('Bottom', 'lwwb'),
                        'left'   => esc_html__('Left', 'lwwb'),
                    ),
                ),
                'unit'          => array(
                    'px' => array(
                        'min'  => '-1000',
                        'max'  => '1000',
                        'step' => '1',
                    ),
                    '%'  => array(
                        'min'  => '0',
                        'max'  => '100',
                        'step' => '1',
                    ),
                ),
                'dependencies'  => array(
                    array(
                        'control'  => 'border_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                ),
                'css_format'    => "ELMN_WRAPPER > .lwwb-elmn-content{border-radius: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",
            ),
            // Box shadow
            array(
                'id'           => 'border_box_shadow',
                'keywords'     => '',
                'label'        => __('Box Shadow', 'lwwb'),
                'type'         => Control::MODAL,
                'button_icon'  => 'fa fa-pencil',
                'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content{box-shadow: {{ HORIZONTAL }}px {{ VERTICAL }}px {{ BLUR }}px {{ SPREAD }}px {{ COLOR }}  {{ POSITION }}  ;}",
                'default'      => array(
                    'color'      => '#000',
                    'horizontal' => '0',
                    'vertical'   => '0',
                    'blur'       => '0',
                    'spread'     => '0',
                    'position'   => '',
                ),
                'fields'       => array(
                    array(
                        'id'           => 'color',
                        'keywords'     => 'border normal box-shadow color picker',
                        'default'      => '#000',
                        'label'        => __('Box shadow color', 'lwwb'),
                        'type'         => Control::COLOR_PICKER,
                        'dependencies' => array(
                            array(
                                'control'  => 'border_state',
                                'operator' => '===',
                                'value'    => 'normal',
                            ),
                        ),
                    ),
                    array(
                        'id'           => 'horizontal',
                        'keywords'     => 'shadow,box shadow, horizontal shadow',
                        'label'        => __('Horizontal', 'lwwb'),
                        'default'      => '0',
                        'type'         => Control::SLIDER,
                        'input_attrs'  => array(
                            'min'  => '-100',
                            'max'  => '100',
                            'step' => '1',
                        ),
                        'dependencies' => array(
                            array(
                                'control'  => 'border_state',
                                'operator' => '===',
                                'value'    => 'normal',
                            ),
                        ),
                    ),
                    array(
                        'id'           => 'vertical',
                        'keywords'     => 'shadow,box shadow, vertical shadow',
                        'label'        => __('Vertical', 'lwwb'),
                        'default'      => '0',
                        'type'         => Control::SLIDER,
                        'input_attrs'  => array(
                            'min'  => '-100',
                            'max'  => '100',
                            'step' => '1',
                        ),
                        'dependencies' => array(
                            array(
                                'control'  => 'border_state',
                                'operator' => '===',
                                'value'    => 'normal',
                            ),
                        ),
                    ),
                    array(
                        'id'           => 'blur',
                        'keywords'     => 'shadow,box shadow, blur shadow',
                        'label'        => __('Blur', 'lwwb'),
                        'default'      => '0',
                        'type'         => Control::SLIDER,
                        'input_attrs'  => array(
                            'min'  => '0',
                            'max'  => '100',
                            'step' => '1',
                        ),
                        'dependencies' => array(
                            array(
                                'control'  => 'border_state',
                                'operator' => '===',
                                'value'    => 'normal',
                            ),
                        ),
                    ),
                    array(
                        'id'           => 'spread',
                        'keywords'     => 'shadow,box shadow, Spread shadow',
                        'label'        => __('Spread', 'lwwb'),
                        'default'      => '0',
                        'type'         => Control::SLIDER,
                        'input_attrs'  => array(
                            'min'  => '-100',
                            'max'  => '100',
                            'step' => '1',
                        ),
                        'dependencies' => array(
                            array(
                                'control'  => 'border_state',
                                'operator' => '===',
                                'value'    => 'normal',
                            ),
                        ),
                    ),
                    array(
                        'id'             => 'position',
                        'keywords'       => 'shadow, position shadow',
                        'label'          => __('Position', 'lwwb'),
                        'type'           => Control::SELECT,
                        'control_layout' => 'inline',
                        'default'        => '',
                        'choices'        => array(
                            ''      => esc_html__('Outline', 'lwwb'),
                            'inset' => esc_html__('Inset', 'lwwb'),
                        ),
                        'dependencies'   => array(
                            array(
                                'control'  => 'border_state',
                                'operator' => '===',
                                'value'    => 'normal',
                            ),
                        ),
                    ),

                ),
                'dependencies' => array(
                    array(
                        'control'  => 'border_state',
                        'operator' => '===',
                        'value'    => 'normal',
                    ),
                ),
            ),

            // Hover
            array(
                'id'           => 'border_hover_type',
                'keywords'     => 'select',
                'label'        => __('Border type', 'lwwb'),
                'keywords'     => 'border hover type',
                'default'      => 'none',
                'type'         => Control::SELECT,
                'choices'      => array(
                    'none'   => __('None', 'lwwb'),
                    'solid'  => __('Solid', 'lwwb'),
                    'double' => __('Double', 'lwwb'),
                    'dotted' => __('Dotted', 'lwwb'),
                    'dashed' => __('Dashed', 'lwwb'),
                    'groove' => __('Groove', 'lwwb'),
                ),
                'dependencies' => array(
                    array(
                        'control'  => 'border_state',
                        'operator' => '===',
                        'value'    => 'hover',
                    ),
                ),
                'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content:hover{border-style:{{ VALUE }};}',
            ),
            array(
                'id'            => 'border_hover_width',
                'keywords'      => 'border hover width',
                'label'         => __('Width', 'lwwb'),
                'type'          => Control::DIMENSIONS,
                'default'       => array(
                    'desktop-top'    => '',
                    'desktop-right'  => '',
                    'desktop-bottom' => '',
                    'desktop-left'   => '',
                    'desktop-unit'   => 'px',
                    'tablet-top'     => '',
                    'tablet-right'   => '',
                    'tablet-bottom'  => '',
                    'tablet-left'    => '',
                    'tablet-unit'    => 'px',
                    'mobile-top'     => '',
                    'mobile-right'   => '',
                    'mobile-bottom'  => '',
                    'mobile-left'    => '',
                    'mobile-unit'    => 'px',
                ),
                'device_config' => array(
                    'desktop' => array(
                        'top'    => esc_html__('Top', 'lwwb'),
                        'right'  => esc_html__('Right', 'lwwb'),
                        'bottom' => esc_html__('Bottom', 'lwwb'),
                        'left'   => esc_html__('Left', 'lwwb'),

                    ),
                    'tablet'  => array(
                        'top'    => esc_html__('Top', 'lwwb'),
                        'right'  => esc_html__('Right', 'lwwb'),
                        'bottom' => esc_html__('Bottom', 'lwwb'),
                        'left'   => esc_html__('Left', 'lwwb'),

                    ),
                    'mobile'  => array(
                        'top'    => esc_html__('Top', 'lwwb'),
                        'right'  => esc_html__('Right', 'lwwb'),
                        'bottom' => esc_html__('Bottom', 'lwwb'),
                        'left'   => esc_html__('Left', 'lwwb'),

                    ),
                ),
                'unit'          => array(
                    'px' => array(
                        'min'  => '-1000',
                        'max'  => '1000',
                        'step' => '1',
                    ),
                    '%'  => array(
                        'min'  => '0',
                        'max'  => '100',
                        'step' => '1',
                    ),
                ),
                'dependencies'  => array(
                    array(
                        'control'  => 'border_state',
                        'operator' => '===',
                        'value'    => 'hover',
                    ),
                    array(
                        'control'  => 'border_hover_type',
                        'operator' => '!==',
                        'value'    => 'none',
                    ),
                ),
                'css_format'    => "ELMN_WRAPPER > .lwwb-elmn-content:hover{border-width: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",

            ),
            array(
                'id'           => 'border_hover_color',
                'keywords'     => 'border hover color picker',
                'default'      => '',
                'label'        => __('Border color', 'lwwb'),
                'type'         => Control::COLOR_PICKER,
                'dependencies' => array(
                    array(
                        'control'  => 'border_state',
                        'operator' => '===',
                        'value'    => 'hover',
                    ),
                    array(
                        'control'  => 'border_hover_type',
                        'operator' => '!==',
                        'value'    => 'none',
                    ),
                ),
                'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content:hover{border-color:{{ VALUE }};}',
            ),
            array(
                'id'            => 'border_hover_radius',
                'keywords'      => 'border hover radius',
                'label'         => __('Border Radius', 'lwwb'),
                'type'          => Control::DIMENSIONS,
                'default'       => array(
                    'desktop-top'    => '',
                    'desktop-right'  => '',
                    'desktop-bottom' => '',
                    'desktop-left'   => '',
                    'desktop-unit'   => 'px',
                    'tablet-top'     => '',
                    'tablet-right'   => '',
                    'tablet-bottom'  => '',
                    'tablet-left'    => '',
                    'tablet-unit'    => 'px',
                    'mobile-top'     => '',
                    'mobile-right'   => '',
                    'mobile-bottom'  => '',
                    'mobile-left'    => '',
                    'mobile-unit'    => 'px',
                ),
                'device_config' => array(
                    'desktop' => array(
                        'top'    => esc_html__('Top', 'lwwb'),
                        'right'  => esc_html__('Right', 'lwwb'),
                        'bottom' => esc_html__('Bottom', 'lwwb'),
                        'left'   => esc_html__('Left', 'lwwb'),
                    ),
                    'tablet'  => array(
                        'top'    => esc_html__('Top', 'lwwb'),
                        'right'  => esc_html__('Right', 'lwwb'),
                        'bottom' => esc_html__('Bottom', 'lwwb'),
                        'left'   => esc_html__('Left', 'lwwb'),
                    ),
                    'mobile'  => array(
                        'top'    => esc_html__('Top', 'lwwb'),
                        'right'  => esc_html__('Right', 'lwwb'),
                        'bottom' => esc_html__('Bottom', 'lwwb'),
                        'left'   => esc_html__('Left', 'lwwb'),
                    ),
                ),
                'unit'          => array(
                    'px' => array(
                        'min'  => '-1000',
                        'max'  => '1000',
                        'step' => '1',
                    ),
                    '%'  => array(
                        'min'  => '0',
                        'max'  => '100',
                        'step' => '1',
                    ),
                ),
                'dependencies'  => array(
                    array(
                        'control'  => 'border_state',
                        'operator' => '===',
                        'value'    => 'hover',
                    ),
                ),
                'css_format'    => "ELMN_WRAPPER > .lwwb-elmn-content:hover{border-radius: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",
            ),
            // Box shadow
            array(
                'id'           => 'box_shadow_hover',
                'keywords'     => '',
                'label'        => __('Box Shadow', 'lwwb'),
                'type'         => Control::MODAL,
                'button_icon'  => 'fa fa-pencil',
                'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content:hover{box-shadow: {{ HORIZONTAL }}px {{ VERTICAL }}px {{ BLUR }}px {{ SPREAD }}px {{ COLOR }}  {{ POSITION }}  ;}",
                'default'      => array(
                    'color'      => '#000',
                    'horizontal' => '0',
                    'vertical'   => '0',
                    'blur'       => '0',
                    'spread'     => '0',
                    'position'   => '',
                ),
                'fields'       => array(
                    array(
                        'id'           => 'color',
                        'keywords'     => 'border normal box-shadow color picker',
                        // 'default'      => '',
                        'label'        => __('Box shadow color', 'lwwb'),
                        'type'         => Control::COLOR_PICKER,
                        'dependencies' => array(
                            array(
                                'control'  => 'border_state',
                                'operator' => '===',
                                'value'    => 'normal',
                            ),
                        ),
                    ),
                    array(
                        'id'           => 'horizontal',
                        'keywords'     => 'shadow,box shadow, horizontal shadow',
                        'label'        => __('Horizontal', 'lwwb'),
                        // 'default'      => '0',
                        'type'         => Control::SLIDER,
                        'input_attrs'  => array(
                            'min'  => '-100',
                            'max'  => '100',
                            'step' => '1',
                        ),
                        'dependencies' => array(
                            array(
                                'control'  => 'border_state',
                                'operator' => '===',
                                'value'    => 'normal',
                            ),
                        ),
                    ),
                    array(
                        'id'           => 'vertical',
                        'keywords'     => 'shadow,box shadow, vertical shadow',
                        'label'        => __('Vertical', 'lwwb'),
                        // 'default'      => '0',
                        'type'         => Control::SLIDER,
                        'input_attrs'  => array(
                            'min'  => '-100',
                            'max'  => '100',
                            'step' => '1',
                        ),
                        'dependencies' => array(
                            array(
                                'control'  => 'border_state',
                                'operator' => '===',
                                'value'    => 'normal',
                            ),
                        ),
                    ),
                    array(
                        'id'           => 'blur',
                        'keywords'     => 'shadow,box shadow, blur shadow',
                        'label'        => __('Blur', 'lwwb'),
                        // 'default'      => '0',
                        'type'         => Control::SLIDER,
                        'input_attrs'  => array(
                            'min'  => '0',
                            'max'  => '100',
                            'step' => '1',
                        ),
                        'dependencies' => array(
                            array(
                                'control'  => 'border_state',
                                'operator' => '===',
                                'value'    => 'normal',
                            ),
                        ),
                    ),
                    array(
                        'id'           => 'spread',
                        'keywords'     => 'shadow,box shadow, Spread shadow',
                        'label'        => __('Spread', 'lwwb'),
                        // 'default'      => '0',
                        'type'         => Control::SLIDER,
                        'input_attrs'  => array(
                            'min'  => '-100',
                            'max'  => '100',
                            'step' => '1',
                        ),
                        'dependencies' => array(
                            array(
                                'control'  => 'border_state',
                                'operator' => '===',
                                'value'    => 'normal',
                            ),
                        ),
                    ),
                    array(
                        'id'             => 'position',
                        'keywords'       => 'shadow, position shadow',
                        'label'          => __('Position', 'lwwb'),
                        'type'           => Control::SELECT,
                        'control_layout' => 'inline',
                        'choices'        => array(
                            ''      => esc_html__('Outline', 'lwwb'),
                            'inset' => esc_html__('Inset', 'lwwb'),
                        ),
                        'dependencies'   => array(
                            array(
                                'control'  => 'border_state',
                                'operator' => '===',
                                'value'    => 'normal',
                            ),
                        ),
                    ),

                ),
                'dependencies' => array(
                    array(
                        'control'  => 'border_state',
                        'operator' => '===',
                        'value'    => 'hover',
                    ),
                    array(
                        'control'  => 'border_hover_type',
                        'operator' => '!==',
                        'value'    => 'none',
                    ),
                ),
            ),

        );
    }

    public static function get_typography_controls()
    {
        return array(
            array(
                'id'            => 'typography_font_family',
                'keywords'      => 'font font-family',
                'label'         => __('Font Family', 'lwwb'),
                'type'          => Control::SELECT2,
                'option_groups' => array(
                    array(
                        'label'   => esc_html__('System Font'),
                        'choices' => static::get_system_font_family(),
                    ),
                    array(
                        'label'   => esc_html__('Google Font'),
                        'choices' => static::get_google_font_family(),
                    ),
                ),

                'css_format'    => 'ELMN_WRAPPER > .lwwb-elmn-content {font-family:{{ VALUE }};}',
            ),
            array(
                'id'            => 'typography_font_size',
                'keywords'      => 'font font-size',
                'label'         => __('Font Size', 'lwwb'),
                'type'          => Control::SLIDER,
                'input_type'    => 'number',
                'default'       => array(
                ),
                'device_config' => array(
                    'desktop' => 'desktop',
                    'tablet'  => 'tablet',
                    'mobile'  => 'mobile',
                ),
                'unit'          => array(
                    'px'  => array(
                        'min'  => '0',
                        'max'  => '600',
                        'step' => '1',
                    ),
                    'em'  => array(
                        'min'  => '0',
                        'max'  => '10',
                        'step' => '0.1',
                    ),
                    'rem' => array(
                        'min'  => '0',
                        'max'  => '10',
                        'step' => '0.1',
                    ),
                ),
                'css_format'    => 'ELMN_WRAPPER > .lwwb-elmn-content {font-size:{{ VALUE }}{{ UNIT }};}',
            ),
            array(
                'id'             => 'typography_font_weight',
                'keywords'       => 'font font-weight',
                'label'          => __('Font Weight', 'lwwb'),
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'choices'        => static::typography_font_weight_config(),
                'css_format'     => 'ELMN_WRAPPER > .lwwb-elmn-content{font-weight:{{ VALUE }};}',
            ),
            array(
                'id'             => 'typography_font_style',
                'keywords'       => 'font text font_style',
                'label'          => __('Font Style', 'lwwb'),
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'choices'        => static::typography_font_style_config(),
                'css_format'     => 'ELMN_WRAPPER > .lwwb-elmn-content{font-style:{{ VALUE }};}',
            ),
            array(
                'id'             => 'typography_text_transform',
                'keywords'       => 'font text transform',
                'label'          => __('Text Transform', 'lwwb'),
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'choices'        => static::typography_text_transform_config(),
                'css_format'     => 'ELMN_WRAPPER > .lwwb-elmn-content{text-transform:{{ VALUE }};}',
            ),
            array(
                'id'             => 'typography_text_decoration',
                'keywords'       => 'font text decoration',
                'label'          => __('Text Decoration', 'lwwb'),
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'choices'        => static::typography_text_decoration_config(),
                'css_format'     => 'ELMN_WRAPPER > .lwwb-elmn-content{text-decoration:{{ VALUE }};}',
            ),
        );
    }

    public static function get_animation_controls()
    {
        return array(
            array(
                'id'             => 'entrance_animation',
                'keywords'       => 'select2',
                'label'          => __('Entrance Animation', 'lwwb'),
                'default'        => '',
                'control_layout' => 'inline',
                'type'           => Control::SELECT2,
                'choices'        => static::get_entrance_animation(),

            ),
            array(
                'id'             => 'animation_duration',
                'keywords'       => 'Animation Duration',
                'label'          => __('Animation Duration', 'lwwb'),
                'default'        => 'normal',
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'choices'        => array(
                    'slower' => esc_html__('Slower', 'lwwb'),
                    'slow'   => esc_html__('Slow', 'lwwb'),
                    'normal' => esc_html__('Normal', 'lwwb'),
                    'fast'   => esc_html__('Fast', 'lwwb'),
                    'faster' => esc_html__('Faster', 'lwwb'),
                ),
                'dependencies'   => array(
                    array(
                        'control'  => 'entrance_animation',
                        'operator' => '!==',
                        'value'    => '',
                    ),
                ),

            ),
            array(
                'id'             => 'animation_delay',
                'keywords'       => 'Animation Delay',
                'label'          => __('Animation Delay (ms)', 'lwwb'),
                'type'           => Control::TEXT,
                'control_layout' => 'inline',
                'input_type'     => 'number',
                'default'        => '',
                'dependencies'   => array(
                    array(
                        'control'  => 'entrance_animation',
                        'operator' => '!==',
                        'value'    => '',
                    ),
                ),
                'css_format'     => "ELMN_WRAPPER.animated {animation-delay: {{ VALUE }}ms ;}",
            ),
        );
    }

    public static function get_responsive_controls()
    {
        return array(
            array(
                'id'       => 'hide_desktop',
                'keywords' => 'show hide desktop mobile tablet',
                'label'    => __('Hide on desktop', 'lwwb'),
                'type'     => Control::SWITCHER,
                'default'  => '',
            ),
            array(
                'id'       => 'hide_tablet',
                'keywords' => 'show hide tablet mobile tablet',
                'label'    => __('Hide on tablet', 'lwwb'),
                'type'     => Control::SWITCHER,
                'default'  => '',
            ),
            array(
                'id'       => 'hide_mobile',
                'keywords' => 'show hide mobile mobile tablet',
                'label'    => __('Hide on mobile', 'lwwb'),
                'type'     => Control::SWITCHER,
                'default'  => '',
            ),
        );
    }

    public static function get_custom_css_controls()
    {
        return array(
            array(
                'id'              => 'custom_css',
                'keywords'        => 'custom css, css , style',
                'label'           => __('Custom CSS', 'lwwb'),
                'type'            => Control::CODE_EDITOR,
                'placeholder'     => '/*' . __('Your custom css', 'lwwb') . '*/',
                'editor_settings' => static::get_code_editor_settings(),
                'css_format'      => "{{ VALUE }}",
            ),
        );
    }

    public static function get_code_editor_settings()
    {
        $settings = array(
            'type'       => 'text/css',
            'codemirror' => array(
                'indentUnit' => 2,
                'tabSize'    => 2,
            ),
        );
        return wp_get_code_editor_settings($settings);
    }

    // Get option Typography
    public static function get_google_font_family()
    {
        $google_fonts = Font_Families::get_google_fonts();
        $fonts        = array();

        foreach ($google_fonts as $key => $google_font) {
            if ($key != '') {
                $fonts[$key] = $key;
            }
        }

        return $fonts;
    }

    public static function get_system_font_family()
    {
        $system_fonts = Font_Families::get_system_fonts();
        $fonts        = array();
        foreach ($system_fonts as $key => $system_font) {
            if ($key != '') {
                $fonts[$key] = $key;
            }
        }

        return $fonts;
    }

    public static function typography_font_weight_config()
    {
        return array(
            ''    => __('Default', 'lwwb'),
            '100' => __('100', 'lwwb'),
            '200' => __('200', 'lwwb'),
            '300' => __('300', 'lwwb'),
            '400' => __('Normal - 400', 'lwwb'),
            '500' => __('500', 'lwwb'),
            '700' => __('Bold - 700', 'lwwb'),
            '800' => __('800', 'lwwb'),
            '900' => __('Black - 900', 'lwwb'),
        );
    }

    public static function typography_text_transform_config()
    {
        return array(
            ''           => __('Default', 'lwwb'),
            'uppercase'  => __('Uppercase', 'lwwb'),
            'lowercase'  => __('Losercase', 'lwwb'),
            'capitalize' => __('Capitalize', 'lwwb'),
            'none'       => __('Normal', 'lwwb'),
        );
    }

    public static function typography_font_style_config()
    {
        return array(
            ''        => __('Default', 'lwwb'),
            'inherit' => __('Inherit', 'lwwb'),
            'italic'  => __('Italic', 'lwwb'),
            'normal'  => __('Normal', 'lwwb'),
            'oplique' => __('Oplique', 'lwwb'),
        );
    }

    public static function typography_text_decoration_config()
    {
        return array(
            ''             => __('Default', 'lwwb'),
            'inherit'      => __('Inherit', 'lwwb'),
            'line-through' => __('Line Through', 'lwwb'),
            'overline'     => __('Over Line', 'lwwb'),
            'underline'    => __('Under Line', 'lwwb'),
        );
    }

    public static function get_html_tags()
    {
        return array(
            'h1'   => 'H1',
            'h2'   => 'H2',
            'h3'   => 'H3',
            'h4'   => 'H4',
            'h5'   => 'H5',
            'h6'   => 'H6',
            'span' => 'Span',
            'div'  => 'Div',
        );
    }

    public static function get_link_target()
    {
        return array(
            '_blank'  => '_blank',
            '_self'   => '_self',
            '_parent' => '_parent',
            '_top'    => '_top',
        );
    }

    public static function get_alignment()
    {
        return array(
            'left'      => 'fa fa-align-left',
            'centered'  => 'fa fa-align-center',
            'right'     => 'fa fa-align-right',
            'justified' => 'fa fa-align-justify',
        );
    }

    public static function get_background_position()
    {
        return array(
            ''              => 'Default',
            'top left'      => 'Top Left',
            'top center'    => 'Top Center',
            'top right'     => 'Top Right',
            'center left'   => 'Center Left',
            'center center' => 'Center Center',
            'center right'  => 'Center Right',
            'bottom left'   => 'Bottom Left',
            'bottom center' => 'Bottom Center',
            'bottom right'  => 'Bottom Right',
        );
    }

    public static function get_background_attachment()
    {
        return array(
            ''       => esc_html__('Default', 'lwwb'),
            'scroll' => esc_html__('Scroll', 'lwwb'),
            'fixed'  => esc_html__('Fixed', 'lwwb'),
        );
    }

    public static function get_background_size()
    {
        return array(
            ''        => esc_html__('Default', 'lwwb'),
            'auto'    => esc_html__('Auto', 'lwwb'),
            'cover'   => esc_html__('Cover', 'lwwb'),
            'contain' => esc_html__('Contain', 'lwwb'),
        );
    }

    public static function get_background_repeat()
    {
        return array(
            ''          => esc_html__('Default', 'lwwb'),
            'no-repeat' => esc_html__('No-Repeat', 'lwwb'),
            'repeat'    => esc_html__('Repeat', 'lwwb'),
            'repeat-x'  => esc_html__('Repeat-x', 'lwwb'),
            'repeat-y'  => esc_html__('Repeat-y', 'lwwb'),
        );
    }

    public static function get_entrance_animation()
    {
        return array(
            ''                       => 'None',
            'fadeIn'                 => 'Fade In',
            'fadeInDown'             => 'Fade In Down',
            'fadeInLeft'             => 'Fade In Left',
            'fadeInRight'            => 'Fade In Right',
            'fadeInUp'               => 'Fade In Up',
            'zoomIn'                 => 'Zoom In',
            'zoomInDown'             => 'Zoom In Down',
            'zoomInLeft'             => 'Zoom In Left',
            'zoomInRight'            => 'Zoom In Right',
            'zoomInUp'               => 'Zoom In Up',
            'bounceIn'               => 'Bounce In',
            'bounceInDown'           => 'Bounce In Down',
            'bounceInLeft'           => 'Bounce In Left',
            'bounceInRight'          => 'Bounce In Right',
            'bounceInUp'             => 'Bounce In Up',
            'slideInDown'            => 'Slide In Down',
            'slideInLeft'            => 'Slide In Left',
            'slideInRight'           => 'Slide In Right',
            'slideInUp'              => 'Slide In Up',
            'rotateIn'               => 'Rotate In',
            'rotateInDownLeft'       => 'Rotate In Down Left',
            'rotateInDownRight'      => 'Rotate In Down Right',
            'rotateInUpLeft'         => 'Rotate In Up Left',
            'rotateInUpRight'        => 'Rotate In Up Right',
            'bounce'                 => 'Bounce',
            'flash'                  => 'Flash',
            'pulse'                  => 'Pulse',
            'rubberBand'             => 'Rubber Band',
            'shake'                  => 'Shake',
            'headShake'              => 'Head Shake',
            'swing'                  => 'Swing',
            'tada'                   => 'Tada',
            'wobble'                 => 'Wobble',
            'jello'                  => 'Jello',
            'lightSpeedIn'           => 'Light Speed In',
            'rollIn'                 => 'Roll In',
            'grow'                   => 'Grow',
            'shrink'                 => 'Shrink',
            'pulse'                  => 'Pulse',
            'pulse-grow'             => 'Pulse Grow',
            'pulse-shrink'           => 'Pulse Shrink',
            'push'                   => 'Push',
            'pop'                    => 'Pop',
            'bounce-in'              => 'Bounce In',
            'bounce-out'             => 'Bounce Out',
            'rotate'                 => 'Rotate',
            'grow-rotate'            => 'Grow Rotate',
            'float'                  => 'Float',
            'sink'                   => 'Sink',
            'bob'                    => 'Bob',
            'hang'                   => 'Hang',
            'skew'                   => 'Skew',
            'skew-forward'           => 'Skew Forward',
            'skew-backward'          => 'Skew Backward',
            'wobble-vertical'        => 'Wobble Vertical',
            'wobble-horizontal'      => 'Wobble Horizontal',
            'wobble-to-bottom-right' => 'Wobble To Bottom Right',
            'wobble-to-top-right'    => 'Wobble To Top Right',
            'wobble-top'             => 'Wobble Top',
            'wobble-bottom'          => 'Wobble Bottom',
            'wobble-skew'            => 'Wobble Skew',
            'buzz'                   => 'Buzz',
            'buzz-out'               => 'Buzz Out',
        );
    }

    public static function get_image_hover_animation()
    {
        return array(
            ''                       => 'None',
            'grow'                   => 'Grow',
            'shrink'                 => 'Shrink',
            'pulse'                  => 'Pulse',
            'pulse-grow'             => 'Pulse Grow',
            'pulse-shrink'           => 'Pulse Shrink',
            'push'                   => 'Push',
            'pop'                    => 'Pop',
            'bounce-in'              => 'Bounce In',
            'bounce-out'             => 'Bounce Out',
            'rotate'                 => 'Rotate',
            'grow-rotate'            => 'Grow Rotate',
            'float'                  => 'Float',
            'sink'                   => 'Sink',
            'bob'                    => 'Bob',
            'hang'                   => 'Hang',
            'skew'                   => 'Skew',
            'skew-forward'           => 'Skew Forward',
            'skew-backward'          => 'Skew Backward',
            'wobble-vertical'        => 'Wobble Vertical',
            'wobble-horizontal'      => 'Wobble Horizontal',
            'wobble-to-bottom-right' => 'Wobble To Bottom Right',
            'wobble-to-top-right'    => 'Wobble To Top Right',
            'wobble-top'             => 'Wobble Top',
            'wobble-bottom'          => 'Wobble Bottom',
            'wobble-skew'            => 'Wobble Skew',
            'buzz'                   => 'Buzz',
            'buzz-out'               => 'Buzz Out',
        );
    }

    // Get Shape
    public static function get_svg_shapes()
    {
        $shape_path = LWWB_PLUGIN_DIR . 'assets/shapes';
        $shapes     = glob($shape_path . '/*.svg');
        $shape_args = array();
        if (count($shapes)) {
            foreach ($shapes as $shape) {
                $shape_args[str_replace(array(
                    '.svg',
                    $shape_path . '/',
                ), '', $shape)] = ucfirst(str_replace('-', ' ', str_replace(array(
                    '.svg',
                    $shape_path . '/',
                ), '', $shape)));
            }
        }

        return $shape_args;
    }

}
