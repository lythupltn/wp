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

use Lwwb\Builder\Base\Default_Elmn_Controls;
use Lwwb\Builder\Base\Elmn_Parent;
use Lwwb\Customizer\Control_Manager as Control;

class Column extends Elmn_Parent
{
    public $type           = 'column';
    public $label          = 'Column';
    public $icon           = 'fa fa-columns';
    public $key_words      = 'section, inner section';
    public $group          = 'basic';
    public $drag_droppable = false;

    public $control_groups = array(
        'content',
        'advanced',
        'background',
        'background_overlay',
        'border',
        'responsive',
        'animation',
        'custom_css',
    );

    public function get_background_group_control()
    {
        return
        array(
            'id'           => 'lwwb_background_group_control',
            'label'        => __('Background', 'lwwb'),
            'type'         => Control::GROUP,
            'dependencies' => array(
                array(
                    'control'  => 'lwwb_tab_control',
                    'operator' => '===',
                    'value'    => 'style',
                ),
            ),
            'fields'       => static::get_background_controls(),
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
                'css_format'   => "ELMN_WRAPPER { background-color:{{ VALUE }}; }",
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
                'css_format'   => "ELMN_WRAPPER { background-image:url({{ URL }}); }",
            ),
            array(
                'id'             => 'bg_position',
                'keywords'       => 'image position, media',
                'label'          => __('Position', 'lwwb'),
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'default'        => '',
                'choices'        => Default_Elmn_Controls::get_background_position(),
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
                'css_format'     => "ELMN_WRAPPER { background-position:{{ VALUE }}; }",
            ),
            array(
                'id'             => 'bg_repeat',
                'keywords'       => 'image repeat, media',
                'label'          => __('Repeat', 'lwwb'),
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'default'        => '',
                'choices'        => Default_Elmn_Controls::get_background_repeat(),
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
                'css_format'     => "ELMN_WRAPPER { background-repeat:{{ VALUE }}; }",
            ),
            array(
                'id'             => 'bg_attachment',
                'keywords'       => 'image attachment, media',
                'label'          => __('Attachment', 'lwwb'),
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'default'        => '',
                'choices'        => Default_Elmn_Controls::get_background_attachment(),
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
                'css_format'     => "ELMN_WRAPPER { background-attachment:{{ VALUE }}; }",
            ),
            array(
                'id'             => 'bg_size',
                'keywords'       => 'image size, media',
                'label'          => __('Size', 'lwwb'),
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'default'        => '',
                'choices'        => Default_Elmn_Controls::get_background_size(),
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
                'css_format'     => "ELMN_WRAPPER { background-size:{{ VALUE }}; }",
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
                'css_format'   => "ELMN_WRAPPER { background-image:linear-gradient({{ ANGLE }}deg, {{ COLOR }} {{ LOCATION }}%, {{ COLOR2 }} {{ LOCATION2 }}% ); }",
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
                'css_format'   => "ELMN_WRAPPER { background-image:radial-gradient(at {{ POSITION }}, {{ COLOR }} {{ LOCATION }}%, {{ COLOR2 }} {{ LOCATION2 }}% ); }",
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
                        'choices'  => Default_Elmn_Controls::get_background_position(),
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
                'css_format'   => "ELMN_WRAPPER:hover  { background-color:{{ VALUE }}; }",
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
                'choices'        => Default_Elmn_Controls::get_background_position(),
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
                'choices'        => Default_Elmn_Controls::get_background_repeat(),
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
                'choices'        => Default_Elmn_Controls::get_background_attachment(),
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
                'choices'        => Default_Elmn_Controls::get_background_size(),
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
                'css_format'   => "ELMN_WRAPPER:hover { background-image:linear-gradient({{ ANGLE }}deg, {{ COLOR }} {{ LOCATION }}%, {{ COLOR2 }} {{ LOCATION2 }}% ); }",
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
                'css_format'   => "ELMN_WRAPPER:hover { background-image:radial-gradient(at {{ POSITION }}, {{ COLOR }} {{ LOCATION }}%, {{ COLOR2 }} {{ LOCATION2 }}% ); }",
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
                        'choices'  => Default_Elmn_Controls::get_background_position(),
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
                'css_format'   => "ELMN_WRAPPER  { transition:background {{ VALUE }}s, border 0.3s, border-radius 0.3s, box-shadow 0.3s ; }",
            ),
            // End Hover

        );
    }

    public function get_background_overlay_group_control()
    {
        return
        array(
            'id'           => 'lwwb_background_overlay_group_control',
            'label'        => __('Background Overlay', 'lwwb'),
            'type'         => Control::GROUP,
            'dependencies' => array(
                array(
                    'control'  => 'lwwb_tab_control',
                    'operator' => '===',
                    'value'    => 'style',
                ),
            ),
            'fields'       => static::get_background_overlay_controls(),
        );
    }

    public function get_border_group_control()
    {
        return
        array(
            'id'           => 'lwwb_border_group_control',
            'label'        => __('Border', 'lwwb'),
            'type'         => Control::GROUP,
            'dependencies' => array(
                array(
                    'control'  => 'lwwb_tab_control',
                    'operator' => '===',
                    'value'    => 'style',
                ),
            ),
            'fields'       => static::get_border_controls(),
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
                'css_format'     => 'ELMN_WRAPPER{border-style:{{ VALUE }};}',
            ),
            array(
                'id'            => 'border_width',
                'keywords'      => 'border normal width',
                'label'         => __('Width', 'lwwb'),
                'type'          => Control::DIMENSIONS,
                'default'       => array(),
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
                'css_format'    => "ELMN_WRAPPER{border-width: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",

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
                'css_format'   => 'ELMN_WRAPPER{border-color:{{ VALUE }};}',
            ),
            array(
                'id'            => 'border_radius',
                'keywords'      => 'border normal radius',
                'label'         => __('Border Radius', 'lwwb'),
                'type'          => Control::DIMENSIONS,
                'default'       => array(),
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
                'css_format'    => "ELMN_WRAPPER{border-radius: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",
            ),
            // Box shadow
            array(
                'id'           => 'box_shadow',
                'keywords'     => '',
                'label'        => __('Box Shadow', 'lwwb'),
                'type'         => Control::MODAL,
                'button_icon'  => 'fa fa-pencil',
                'css_format'   => "ELMN_WRAPPER{box-shadow: {{ HORIZONTAL }}px {{ VERTICAL }}px {{ BLUR }}px {{ SPREAD }}px {{ COLOR }}  {{ POSITION }}  ;}",
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
                'css_format'   => 'ELMN_WRAPPER:hover{border-style:{{ VALUE }};}',
            ),
            array(
                'id'            => 'border_hover_width',
                'keywords'      => 'border hover width',
                'label'         => __('Width', 'lwwb'),
                'type'          => Control::DIMENSIONS,
                'default'       => array(),
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
                'css_format'    => "ELMN_WRAPPER:hover{border-width: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",

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
                'css_format'   => 'ELMN_WRAPPER:hover{border-color:{{ VALUE }};}',
            ),
            array(
                'id'            => 'border_hover_radius',
                'keywords'      => 'border hover radius',
                'label'         => __('Border Radius', 'lwwb'),
                'type'          => Control::DIMENSIONS,
                'default'       => array(),
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
                'css_format'    => "ELMN_WRAPPER:hover{border-radius: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",
            ),
            // Box shadow
            array(
                'id'           => 'box_shadow_hover',
                'keywords'     => '',
                'label'        => __('Box Shadow', 'lwwb'),
                'type'         => Control::MODAL,
                'button_icon'  => 'fa fa-pencil',
                'css_format'   => "ELMN_WRAPPER:hover{box-shadow: {{ HORIZONTAL }}px {{ VERTICAL }}px {{ BLUR }}px {{ SPREAD }}px {{ COLOR }}  {{ POSITION }}  ;}",
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

    // public function get_typography_group_control() {
    //     return
    //         array(
    //             'id'           => 'lwwb_typography_group_control',
    //             'label'        => __( 'Typography', 'lwwb' ),
    //             'type'         => Control::GROUP,
    //             'dependencies' => array(
    //                 array(
    //                     'control'  => 'lwwb_tab_control',
    //                     'operator' => '===',
    //                     'value'    => 'style',
    //                 ),
    //             ),
    //             'fields'       => Default_Elmn_Controls::get_typography_controls(),
    //         );
    // }

    // public function get_content_group_control() {
    //     return
    //         array(
    //             'id'           => 'lwwb_content_group_control',
    //             'label'        => __( 'Layout', 'lwwb' ),
    //             'type'         => Control::GROUP,
    //             'dependencies' => array(
    //                 array(
    //                     'control'  => 'lwwb_tab_control',
    //                     'operator' => '===',
    //                     'value'    => 'content',
    //                 ),
    //             ),
    //             'fields'       => $this->get_content_controls(),
    //         );
    // }

    public static function get_content_controls()
    {
        return array(
            array(
                'id'            => 'width_rs',
                'keywords'      => '',
                'label'         => __('Column Width', 'lwwb'),
                'type'          => Control::RESPONSIVE_SWITCHER,
                'default'       => array(),
                'device_config' => array(
                    'desktop'=> __('Desktop', 'lwwb'),
			        'tablet'=> __('Tablet', 'lwwb'),
                ),
            ),
            array(
                'id'            => 'width',
                'keywords'      => 'column section width',
                // 'label'         => __('Desktop', 'lwwb'),
                'type'          => Control::SLIDER,
                'input_type'    => 'number',
                'on_device'    => 'desktop',
                'control_layout'    => 'inline',
                'default'       => '',
                'input_attrs'   => array(
                    'min'  => '8.33',
                    'max'  => '100',
                    'step' => '0.01',
                ),
                'css_format'    => "ELMN_WRAPPER {width: {{ VALUE }}%;}",

            ),
            array(
                'id'            => '_tablet_width',
                'keywords'      => 'column section width',
                // 'label'         => __('Tablet', 'lwwb'),
                'type'          => Control::SLIDER,
                'input_type'    => 'number',
                'on_device'    => 'tablet',
                'control_layout'    => 'inline',
                'default'       => '',
                'input_attrs'   => array(
                    'min'  => '8.33',
                    'max'  => '100',
                    'step' => '0.01',
                ),
                'css_format'    => "ELMN_WRAPPER {width: {{ VALUE }}%;}",

            ),
            array(
                'id'             => 'content_position',
                'keywords'       => 'space column content position',
                'label'          => __('Content Position', 'lwwb'),
                'default'        => '',
                'type'           => Control::SELECT,
                'control_layout' => 'inline',
                'input_type'     => 'number',
                'choices'        => array(
                    ''           => esc_html__('Default', 'lwwb'),
                    'flex-start' => esc_html__('Top', 'lwwb'),
                    'center'     => esc_html__('Middle', 'lwwb'),
                    'flex-end'   => esc_html__('Bottom', 'lwwb'),
                ),
                'placeholder'    => '',
                'css_format'     => "ELMN_WRAPPER{display:flex;align-items: {{ VALUE }};}",
            ),

            array(
                'id'             => 'elmnn_space',
                'keywords'       => 'space column content ',
                'label'          => __('Element Space (px)', 'lwwb'),
                'default'        => '',
                'type'           => Control::TEXT,
                'control_layout' => 'inline',
                'input_type'     => 'number',
                'placeholder'    => '',
                'css_format'     => "ELMN_WRAPPER > .lwwb-elmn-content  .lwwb-elmn:not(:last-child) {margin-bottom: {{ VALUE }}px;}",
            ),

        );
    }

    public function render_up_control()
    {
        ?>
        <li class="lwwb-elmn-setting lwwb-elmn-up" data-action="up"
            title="<?php echo __('Move left'); ?> <?php echo esc_attr($this->type); ?>">
            <i class="fa fa fa-chevron-left" aria-hidden="true"></i><span
                    class="lwwb-control-label"><?php echo __('Move left'); ?><?php echo esc_attr($this->type); ?></span>
        </li>

		<?php
}

    public function render_down_control()
    {
        ?>
        <li class="lwwb-elmn-setting lwwb-elmn-down" data-action="down"
            title="<?php echo __('Move right'); ?> <?php echo esc_attr($this->type); ?>">
            <i class="fa fa fa-chevron-right" aria-hidden="true"></i><span
                    class="lwwb-control-label"><?php echo __('Move right'); ?><?php echo esc_attr($this->type); ?></span>
        </li>

		<?php
}

    public function get_default_data()
    {
        return array(
        );
    }

    public function get_elmn_builder_control()
    {
        return array(
            'move',
            'edit',
            'up',
            'down',
            'add',
            'clone',
            'remove',
        );
    }

    public function get_elmn_classes()
    {
        $data_classes   = $this->get_data('classes');
        $custom_classes = $this->get_data('custom-classes');

        $classes   = $this->get_default_classes();
        $classes[] = 'column';
        $classes[] = $data_classes;
        $classes[] = isset($custom_classes) ? esc_attr($custom_classes) : '';

        return $classes;
    }

    public function content_template()
    {
        ?>
        <# if(elmn_data.bg_overlay_state) {  #>
        <div class="lwwb-elmn-background-overlay">&nbsp;</div>
        <# } #>
        <div class="lwwb-elmn-content ">
            <div class="ui-sortable"></div>
        </div>

		<?php
}
    // Render template for builder
    public function print_content_template()
    {
        $this->content_template();
    }
}