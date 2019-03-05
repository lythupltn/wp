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
use Lwwb\Builder\Base\Elmn;
use Lwwb\Builder\Base\Elmn_Parent;
use Lwwb\Customizer\Control_Manager as Control;

class Section extends Elmn_Parent {

	public $type = 'section';
	public $label = 'Section';
	public $icon = 'fa fa-tasks';
	public $group = 'basic';
	public $drag_droppable = true;
	public $key_words = 'section, inner section';

	public $control_groups = array(
		'content',
		'advanced',
		'background',
		'background_overlay',
		'border',
		'animation',
		'shape',
//        'typography',
		'custom_css',
	);


	public function register() {
		parent::register();
		add_action( 'customize_controls_print_scripts', array( $this, 'print_helper_template' ) );
	}

	public function custom_enqueue() {
		if ( $this->get_data( 'entrance_animation' ) != '' ) {
			wp_enqueue_script( 'wow' );
			wp_enqueue_style( 'animated' );
			wp_enqueue_style( 'animations.min' );
		}
	}


	public static function get_content_controls() {
		return array(
			array(
				'id'          => 'in_container',
				'keywords'    => 'switcher',
				'label'       => __( 'In Container', 'lwwb' ),
				'description' => __( 'Section in container.', 'lwwb' ),
				'default'     => 'no',
				'type'        => Control::SWITCHER,
			),
			array(
				'id'             => 'container_width',
				'keywords'       => 'title, text, content, link, target , heading',
				'label'          => __( 'Content Width', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'default'        => '',
				'choices'        => array(
					'is-fluid'      => esc_html__( 'Fluid', 'lwwb' ),
					'is-widescreen' => esc_html__( 'Wide Screen', 'lwwb' ),
					'is-fullhd'     => esc_html__( 'Full HD', 'lwwb' ),
				),
				'dependencies'   => array(
					array(
						'control'  => 'in_container',
						'operator' => '===',
						'value'    => 'yes',
					),
				),

			),
			array(
				'id'             => 'section_height',
				'keywords'       => 'gap, section, height, column',
				'label'          => __( 'Height', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'default'        => '',
				'choices'        => array(
					''                   => esc_html__( 'Default', 'lwwb' ),
					'hero is-fullheight' => esc_html__( 'Fit to screen', 'lwwb' ),
					'min_height'         => esc_html__( 'Min Height', 'lwwb' ),
				),
			),
			array(
				'id'           => 'min_height',
				'keywords'     => 'Minimum Height,height, column',
				'label'        => __( 'Minimum Height (px)', 'lwwb' ),
				'default'      => '0',
				'type'         => Control::SLIDER,
				'input_attrs'  => array(
					'min'  => '0',
					'max'  => '1140',
					'step' => '1',
				),
				'dependencies' => array(
					array(
						'control'                => 'section_height',
						'operator'               => '===',
						'value'                  => 'min_height',
						'check_for_render_style' => true,
					),
				),
				'css_format'   => "ELMN_WRAPPER { min-height: {{ VALUE }}px; }",
			),
		);
	}

	public function get_background_group_control() {
		return
			array(
				'id'           => 'lwwb_background_group_control',
				'label'        => __( 'Background', 'lwwb' ),
				'type'         => Control::GROUP,
				'dependencies' => array(
					array(
						'control'  => 'lwwb_tab_control',
						'operator' => '===',
						'value'    => 'style',
					),
				),
				'fields'       => $this->get_background_controls(),
			);
	}

	public static function get_background_controls() {
		return array(
			array(
				'id'       => 'bg_state',
				'keywords' => 'background state normal hover',
				'label'    => __( '', 'lwwb' ),
				'default'  => '',
				'type'     => Control::BUTTON_SET,
				'choices'  => array(
					'normal' => __( 'Normal', 'lwwb' ),
					'hover'  => __( 'Hover', 'lwwb' ),
				),
			),
			// Normal
			array(
				'id'             => 'bg_type',
				'keywords'       => 'background type normal hover',
				'label'          => __( 'Background Type', 'lwwb' ),
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
				'id'           => 'bg_normal_color',
				'keywords'     => 'color picker',
				'default'      => '',
				'label'        => __( 'Color', 'lwwb' ),
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
				'label'        => __( 'Image', 'lwwb' ),
				'type'         => Control::MEDIA_UPLOAD,
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
						'control'                => 'bg_type',
						'operator'               => '===',
						'value'                  => 'classic',
						'check_for_render_style' => true
					),
				),
				'css_format'   => "ELMN_WRAPPER { background-image:url({{ URL }}); }",
			),
			array(
				'id'             => 'bg_position',
				'keywords'       => 'image position, media',
				'label'          => __( 'Position', 'lwwb' ),
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
				'label'          => __( 'Repeat', 'lwwb' ),
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
				'label'          => __( 'Attachment', 'lwwb' ),
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
				'label'          => __( 'Size', 'lwwb' ),
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
					'linear' => __( 'Linear', 'lwwb' ),
					'radial' => __( 'Radial', 'lwwb' ),
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
				'id'           => 'bg_normal_linear_gradient',
				'keywords'     => '',
				'label'        => __( 'Gradient linear', 'lwwb' ),
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
						'label'    => __( 'Color', 'lwwb' ),
						'type'     => Control::COLOR_PICKER,
					),
					array(
						'id'          => 'location',
						'keywords'    => 'gradient location angle',
						'label'       => __( 'Location', 'lwwb' ),
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
						'label'    => __( 'Second Color', 'lwwb' ),
						'type'     => Control::COLOR_PICKER,
					),
					array(
						'id'          => 'location2',
						'keywords'    => 'gradient location angle',
						'label'       => __( 'Second Location', 'lwwb' ),
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
						'label'        => __( 'Angle', 'lwwb' ),
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
						'control'                => 'bg_type',
						'operator'               => '===',
						'value'                  => 'gradient',
						'check_for_render_style' => true
					),
					array(
						'control'                => 'bg_gradient_type',
						'operator'               => '===',
						'value'                  => 'linear',
						'check_for_render_style' => true
					),
				),
			),
			array(
				'id'           => 'bg_normal_radial_gradient',
				'keywords'     => '',
				'label'        => __( 'Gradient Radial', 'lwwb' ),
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
						'label'    => __( 'Color', 'lwwb' ),
						'type'     => Control::COLOR_PICKER,
					),
					array(
						'id'          => 'location',
						'keywords'    => 'gradient location angle',
						'label'       => __( 'Location', 'lwwb' ),
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
						'label'    => __( 'Second Color', 'lwwb' ),
						'type'     => Control::COLOR_PICKER,
					),
					array(
						'id'          => 'location2',
						'keywords'    => 'gradient location angle',
						'label'       => __( 'Second Location', 'lwwb' ),
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
						'label'    => __( 'Position', 'lwwb' ),
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
						'control'                => 'bg_type',
						'operator'               => '===',
						'value'                  => 'gradient',
						'check_for_render_style' => true
					),
					array(
						'control'                => 'bg_gradient_type',
						'operator'               => '===',
						'value'                  => 'radial',
						'check_for_render_style' => true
					),
				),
			),

			// Video -- Comming soon
			array(
				'id'           => 'bg_normal_video-link',
				'keywords'     => 'background video bv yt vd',
				'label'        => __( 'Video Link', 'lwwb' ),
				'description'  => esc_html__( 'YouTube link or video file (mp4 is recommended).', 'lwwb' ),
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
				'id'             => 'bg_normal_video-start-time',
				'keywords'       => 'background video start time',
				'label'          => __( 'Start Time', 'lwwb' ),
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
				'id'             => 'bg_normal_video-end-time',
				'keywords'       => 'background video end time',
				'label'          => __( 'End Time', 'lwwb' ),
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
				'label'        => __( 'Background Fallback', 'lwwb' ),
				'type'         => Control::MEDIA_UPLOAD,
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
				'label'          => __( 'Background Type', 'lwwb' ),
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
				'label'        => __( 'Color', 'lwwb' ),
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
				'css_format'   => "ELMN_WRAPPER:hover{ background-color:{{ VALUE }}; }",
			),
			array(
				'id'           => 'bg_hover_image',
				'keywords'     => 'image, media background',
				'label'        => __( 'Image', 'lwwb' ),
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
						'check_for_render_style' => true
					),
				),
				'css_format'   => "ELMN_WRAPPER:hover { background-image:url({{ URL }}); }",
			),
			array(
				'id'             => 'bg_hover_position',
				'keywords'       => 'image position, media',
				'label'          => __( 'Position', 'lwwb' ),
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
						'control'  => 'bg_hover_image',
						'operator' => '!==',
						'value'    => array(
							'url' => '',
							'id'  => '',
						),
					),

				),
				'css_format'     => "ELMN_WRAPPER:hover{ background-position:{{ VALUE }}; }",
			),
			array(
				'id'             => 'bg_hover_repeat',
				'keywords'       => 'image repeat, media',
				'label'          => __( 'Repeat', 'lwwb' ),
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
						'control'  => 'bg_hover_image',
						'operator' => '!==',
						'value'    => array(
							'url' => '',
							'id'  => '',
						),
					),

				),
				'css_format'     => "ELMN_WRAPPER:hover{ background-repeat:{{ VALUE }}; }",
			),
			array(
				'id'             => 'bg_hover_attachment',
				'keywords'       => 'image attachment, media',
				'label'          => __( 'Attachment', 'lwwb' ),
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
						'control'  => 'bg_hover_image',
						'operator' => '!==',
						'value'    => array(
							'url' => '',
							'id'  => '',
						),
					),

				),
				'css_format'     => "ELMN_WRAPPER:hover{ background-attachment:{{ VALUE }}; }",
			),
			array(
				'id'             => 'bg_hover_size',
				'keywords'       => 'image size, media',
				'label'          => __( 'Size', 'lwwb' ),
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
						'control'  => 'bg_hover_image',
						'operator' => '!==',
						'value'    => array(
							'url' => '',
							'id'  => '',
						),
					),

				),
				'css_format'     => "ELMN_WRAPPER:hover{ background-size:{{ VALUE }}; }",
			),


			// Gradient
			array(
				'id'           => 'bg_hover_gradient_type',
				'keywords'     => 'background gradient type hover',
				'label'        => '',
				'default'      => 'linear',
				'type'         => Control::BUTTON_SET,
				'choices'      => array(
					'linear' => __( 'Linear', 'lwwb' ),
					'radial' => __( 'Radial', 'lwwb' ),
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
				'label'        => __( 'Gradient linear', 'lwwb' ),
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
						'label'    => __( 'Color', 'lwwb' ),
						'type'     => Control::COLOR_PICKER,
					),
					array(
						'id'          => 'location',
						'keywords'    => 'gradient location angle',
						'label'       => __( 'Location', 'lwwb' ),
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
						'label'    => __( 'Second Color', 'lwwb' ),
						'type'     => Control::COLOR_PICKER,
					),
					array(
						'id'          => 'location2',
						'keywords'    => 'gradient location angle',
						'label'       => __( 'Second Location', 'lwwb' ),
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
						'label'        => __( 'Angle', 'lwwb' ),
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
						'check_for_render_style' => true
					),
					array(
						'control'                => 'bg_hover_gradient_type',
						'operator'               => '===',
						'value'                  => 'linear',
						'check_for_render_style' => true
					),
				),
			),
			array(
				'id'           => 'bg_hover_radial_gradient',
				'keywords'     => '',
				'label'        => __( 'Gradient Radial', 'lwwb' ),
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
						'label'    => __( 'Color', 'lwwb' ),
						'type'     => Control::COLOR_PICKER,
					),
					array(
						'id'          => 'location',
						'keywords'    => 'gradient location angle',
						'label'       => __( 'Location', 'lwwb' ),
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
						'label'    => __( 'Second Color', 'lwwb' ),
						'type'     => Control::COLOR_PICKER,
					),
					array(
						'id'          => 'location2',
						'keywords'    => 'gradient location angle',
						'label'       => __( 'Second Location', 'lwwb' ),
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
						'label'    => __( 'Position', 'lwwb' ),
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
						'check_for_render_style' => true
					),
					array(
						'control'                => 'bg_hover_gradient_type',
						'operator'               => '===',
						'value'                  => 'radial',
						'check_for_render_style' => true
					),
				),
			),
			// End Hover
			array(
				'id'          => 'transition_duration',
				'keywords'    => 'Transition Duration, shadow,box shadow, horizontal shadow',
				'label'       => __('Transition Duration', 'lwwb'),
				'type'        => Control::SLIDER,
				'input_attrs' => array(
					'min'  => '0',
					'max'  => '1',
					'step' => '0.1',
				),
				'dependencies'   => array(
					array(
						'control'  => 'bg_state',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
				'css_format'     => "ELMN_WRAPPER { transition:background {{ VALUE }}s, border 0.3s, border-radius 0.3s, box-shadow 0.3s ; }",
			),
		);
	}


	public static function get_border_controls() {
		return array(
			array(
				'id'       => 'border_state',
				'keywords' => 'border state normal hover',
				'label'    => __( '', 'lwwb' ),
				'default'  => 'normal',
				'type'     => Control::BUTTON_SET,
				'choices'  => array(
					'normal' => __( 'Normal', 'lwwb' ),
					'hover'  => __( 'Hover', 'lwwb' ),
				),

			),
			array(
				'id'             => 'border_normal_type',
				'label'          => __( 'Border type', 'lwwb' ),
				'default'        => 'none',
				'control_layout' => 'inline',
				'keywords'       => 'border normal type',
				'type'           => Control::SELECT,
				'choices'        => array(
					'none'   => __( 'None', 'lwwb' ),
					'solid'  => __( 'Solid', 'lwwb' ),
					'double' => __( 'Double', 'lwwb' ),
					'dotted' => __( 'Dotted', 'lwwb' ),
					'dashed' => __( 'Dashed', 'lwwb' ),
					'groove' => __( 'Groove', 'lwwb' ),
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
				'id'            => 'border_normal_width',
				'keywords'      => 'border normal width',
				'label'         => __( 'Width', 'lwwb' ),
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
						'top'    => esc_html__( 'Top', 'lwwb' ),
						'right'  => esc_html__( 'Right', 'lwwb' ),
						'bottom' => esc_html__( 'Bottom', 'lwwb' ),
						'left'   => esc_html__( 'Left', 'lwwb' ),

					),
					'tablet'  => array(
						'top'    => esc_html__( 'Top', 'lwwb' ),
						'right'  => esc_html__( 'Right', 'lwwb' ),
						'bottom' => esc_html__( 'Bottom', 'lwwb' ),
						'left'   => esc_html__( 'Left', 'lwwb' ),

					),
					'mobile'  => array(
						'top'    => esc_html__( 'Top', 'lwwb' ),
						'right'  => esc_html__( 'Right', 'lwwb' ),
						'bottom' => esc_html__( 'Bottom', 'lwwb' ),
						'left'   => esc_html__( 'Left', 'lwwb' ),

					),
				),
				'input_attrs'   => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'unit'          => array(
					'px' => 'px',
				),
				'dependencies'  => array(
					array(
						'control'  => 'border_state',
						'operator' => '===',
						'value'    => 'normal',
					),
					array(
						'control'  => 'border_normal_type',
						'operator' => '!==',
						'value'    => 'none',
					),
				),
				'css_format'    => "ELMN_WRAPPER{border-width: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",

			),
			array(
				'id'           => 'border_normal_color',
				'keywords'     => 'border normal color picker',
				'default'      => '',
				'label'        => __( 'Border color', 'lwwb' ),
				'type'         => Control::COLOR_PICKER,
				'dependencies' => array(
					array(
						'control'  => 'border_state',
						'operator' => '===',
						'value'    => 'normal',
					),
					array(
						'control'  => 'border_normal_type',
						'operator' => '!==',
						'value'    => 'none',
					),
				),
				'css_format'   => 'ELMN_WRAPPER{border-color:{{ VALUE }};}',
			),
			array(
				'id'            => 'border_normal_radius',
				'keywords'      => 'border normal radius',
				'label'         => __( 'Border Radius', 'lwwb' ),
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
						'top'    => esc_html__( 'Top', 'lwwb' ),
						'right'  => esc_html__( 'Right', 'lwwb' ),
						'bottom' => esc_html__( 'Bottom', 'lwwb' ),
						'left'   => esc_html__( 'Left', 'lwwb' ),
					),
					'tablet'  => array(
						'top'    => esc_html__( 'Top', 'lwwb' ),
						'right'  => esc_html__( 'Right', 'lwwb' ),
						'bottom' => esc_html__( 'Bottom', 'lwwb' ),
						'left'   => esc_html__( 'Left', 'lwwb' ),
					),
					'mobile'  => array(
						'top'    => esc_html__( 'Top', 'lwwb' ),
						'right'  => esc_html__( 'Right', 'lwwb' ),
						'bottom' => esc_html__( 'Bottom', 'lwwb' ),
						'left'   => esc_html__( 'Left', 'lwwb' ),
					),
				),
				'input_attrs'   => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'unit'          => array(
					'px' => 'px',
					'%'  => '%',
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
				'id'           => 'box-shadow_normal',
				'keywords'     => '',
				'label'        => __( 'Box Shadow', 'lwwb' ),
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
						// 'default'      => '',
						'label'        => __( 'Box shadow color', 'lwwb' ),
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
						'label'        => __( 'Horizontal', 'lwwb' ),
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
						'label'        => __( 'Vertical', 'lwwb' ),
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
						'label'        => __( 'Blur', 'lwwb' ),
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
						'label'        => __( 'Spread', 'lwwb' ),
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
						'label'          => __( 'Position', 'lwwb' ),
						'type'           => Control::SELECT,
						'control_layout' => 'inline',
						'choices'        => array(
							''      => esc_html__( 'Outline', 'lwwb' ),
							'inset' => esc_html__( 'Inset', 'lwwb' ),
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
				'label'        => __( 'Border type', 'lwwb' ),
				'keywords'     => 'border hover type',
				'default'      => 'none',
				'type'         => Control::SELECT,
				'choices'      => array(
					'none'   => __( 'None', 'lwwb' ),
					'solid'  => __( 'Solid', 'lwwb' ),
					'double' => __( 'Double', 'lwwb' ),
					'dotted' => __( 'Dotted', 'lwwb' ),
					'dashed' => __( 'Dashed', 'lwwb' ),
					'groove' => __( 'Groove', 'lwwb' ),
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
				'label'         => __( 'Width', 'lwwb' ),
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
						'top'    => esc_html__( 'Top', 'lwwb' ),
						'right'  => esc_html__( 'Right', 'lwwb' ),
						'bottom' => esc_html__( 'Bottom', 'lwwb' ),
						'left'   => esc_html__( 'Left', 'lwwb' ),

					),
					'tablet'  => array(
						'top'    => esc_html__( 'Top', 'lwwb' ),
						'right'  => esc_html__( 'Right', 'lwwb' ),
						'bottom' => esc_html__( 'Bottom', 'lwwb' ),
						'left'   => esc_html__( 'Left', 'lwwb' ),

					),
					'mobile'  => array(
						'top'    => esc_html__( 'Top', 'lwwb' ),
						'right'  => esc_html__( 'Right', 'lwwb' ),
						'bottom' => esc_html__( 'Bottom', 'lwwb' ),
						'left'   => esc_html__( 'Left', 'lwwb' ),

					),
				),
				'input_attrs'   => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'unit'          => array(
					'px' => 'px',
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
				'label'        => __( 'Border color', 'lwwb' ),
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
				'label'         => __( 'Border Radius', 'lwwb' ),
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
						'top'    => esc_html__( 'Top', 'lwwb' ),
						'right'  => esc_html__( 'Right', 'lwwb' ),
						'bottom' => esc_html__( 'Bottom', 'lwwb' ),
						'left'   => esc_html__( 'Left', 'lwwb' ),
					),
					'tablet'  => array(
						'top'    => esc_html__( 'Top', 'lwwb' ),
						'right'  => esc_html__( 'Right', 'lwwb' ),
						'bottom' => esc_html__( 'Bottom', 'lwwb' ),
						'left'   => esc_html__( 'Left', 'lwwb' ),
					),
					'mobile'  => array(
						'top'    => esc_html__( 'Top', 'lwwb' ),
						'right'  => esc_html__( 'Right', 'lwwb' ),
						'bottom' => esc_html__( 'Bottom', 'lwwb' ),
						'left'   => esc_html__( 'Left', 'lwwb' ),
					),
				),
				'input_attrs'   => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'unit'          => array(
					'px' => 'px',
					'%'  => '%',
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
				'id'           => 'box-shadow_hover',
				'keywords'     => '',
				'label'        => __( 'Box Shadow', 'lwwb' ),
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
						'label'        => __( 'Box shadow color', 'lwwb' ),
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
						'label'        => __( 'Horizontal', 'lwwb' ),
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
						'label'        => __( 'Vertical', 'lwwb' ),
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
						'label'        => __( 'Blur', 'lwwb' ),
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
						'label'        => __( 'Spread', 'lwwb' ),
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
						'label'          => __( 'Position', 'lwwb' ),
						'type'           => Control::SELECT,
						'control_layout' => 'inline',
						'choices'        => array(
							''      => esc_html__( 'Outline', 'lwwb' ),
							'inset' => esc_html__( 'Inset', 'lwwb' ),
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
	public function get_shape_group_control() {
		return
			array(
				'id'           => 'lwwb_shape_group_control',
				'label'        => __( 'Shape', 'lwwb' ),
				'type'         => Control::GROUP,
				'dependencies' => array(
					array(
						'control'  => 'lwwb_tab_control',
						'operator' => '===',
						'value'    => 'advanced',
					),
				),
				'fields'       => static::get_shape_controls(),
			);
	}


	public static function get_shape_controls() {
		return array(
			// Shape Top
			array(
				'id'              => 'shape_top_switch',
				'keywords'        => 'show shape top, ',
				'label'           => __( 'Shape Top', 'lwwb' ),
				'type'            => Control::SWITCHER,
				'render_required' => 'true',
				'default'         => 'no',
			),
			array(
				'id'           => 'shape_top',
				'label'        => __( 'Type', 'lwwb' ),
				'keywords'     => 'shape type ',
				'default'      => 'clouds-opacity',
				'type'         => Control::SELECT,
				'choices'      => Default_Elmn_Controls::get_svg_shapes(),
				'dependencies' => array(
					array(
						'control'  => 'shape_top_switch',
						'operator' => '===',
						'value'    => 'yes',
					),
				),

			),
			array(
				'id'           => 'shape_top_color',
				'keywords'     => 'shape top color picker',
				'default'      => '#0073aa',
				'label'        => __( 'Color', 'lwwb' ),
				'type'         => Control::COLOR_PICKER,
				'dependencies' => array(
					array(
						'control'  => 'shape_top_switch',
						'operator' => '===',
						'value'    => 'yes',
					),
				),
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-shape-top svg path{ fill: {{ VALUE }}; }",

			),
			array(
				'id'           => 'shape_top_width',
				'keywords'     => 'shape top width',
				'label'        => __( 'Width', 'lwwb' ),
				'type'         => Control::SLIDER,
				'input_attrs'  => array(
					'min'  => 100,
					'max'  => 500,
					'step' => 1,
				),
				'default'      => '',
				'dependencies' => array(
					array(
						'control'  => 'shape_top_switch',
						'operator' => '===',
						'value'    => 'yes',
					),
				),
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-shape-top svg{ width: {{ VALUE }}%; }",
			),
			array(
				'id'           => 'shape_top_height',
				'keywords'     => 'shape top height',
				'label'        => __( 'Height', 'lwwb' ),
				'type'         => Control::SLIDER,
				'input_attrs'  => array(
					'min'  => 1,
					'max'  => 100,
					'step' => 1,
				),
				'default'      => '',
				'dependencies' => array(
					array(
						'control'  => 'shape_top_switch',
						'operator' => '===',
						'value'    => 'yes',
					),
				),
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-shape-top svg{ height: {{ VALUE }}vh; }",
			),
			array(
				'id'             => 'shape_top_flip',
				'label'          => __( 'Flip', 'lwwb' ),
				'keywords'       => 'shape type flip ',
				'default'        => 'rotateY(0deg) translateX(-50%)',
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'choices'        => array(
					'rotateY(180deg) translateX(50%)' => esc_html__( 'Yes', 'lwwb' ),
					'rotateY(0deg) translateX(-50%)'  => esc_html__( 'No', 'lwwb' ),
				),
				'dependencies'   => array(
					array(
						'control'  => 'shape_top_switch',
						'operator' => '===',
						'value'    => 'yes',
					),
				),
				'css_format'     => "ELMN_WRAPPER > .lwwb-elmn-shape-top svg{ transform: {{ VALUE }}; }",

			),
			array(
				'id'             => 'shape_top_bring_to_front',
				'label'          => __( 'Bring To Front', 'lwwb' ),
				'keywords'       => 'shape type invert ',
				'default'        => '',
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'choices'        => array(
					'2' => esc_html__( 'Yes', 'lwwb' ),
					''  => esc_html__( 'No', 'lwwb' ),
				),
				'dependencies'   => array(
					array(
						'control'  => 'shape_top_switch',
						'operator' => '===',
						'value'    => 'yes',
					),
				),
				'css_format'     => "ELMN_WRAPPER > .lwwb-elmn-shape-top { z-index: {{ VALUE }}; }",
			),


			// Shape Bottom
			array(
				'id'              => 'shape_bottom_switch',
				'keywords'        => 'show shape bottom, ',
				'label'           => __( 'Shape Bottom', 'lwwb' ),
				'type'            => Control::SWITCHER,
				'render_required' => 'true',
				'default'         => 'no',
			),
			array(
				'id'           => 'shape_bottom',
				'label'        => __( 'Type', 'lwwb' ),
				'keywords'     => 'shape type ',
				'default'      => 'clouds-opacity',
				'type'         => Control::SELECT,
				'choices'      => Default_Elmn_Controls::get_svg_shapes(),
				'dependencies' => array(
					array(
						'control'  => 'shape_bottom_switch',
						'operator' => '===',
						'value'    => 'yes',
					),
				),

			),
			array(
				'id'           => 'shape_bottom_color',
				'keywords'     => 'shape bottom color picker',
				'default'      => '#0073aa',
				'label'        => __( 'Color', 'lwwb' ),
				'type'         => Control::COLOR_PICKER,
				'dependencies' => array(
					array(
						'control'  => 'shape_bottom_switch',
						'operator' => '===',
						'value'    => 'yes',
					),
				),
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-shape-bottom svg path{ fill: {{ VALUE }}; }",

			),
			array(
				'id'           => 'shape_bottom_width',
				'keywords'     => 'shape bottom width',
				'label'        => __( 'Width', 'lwwb' ),
				'type'         => Control::SLIDER,
				'input_attrs'  => array(
					'min'  => 100,
					'max'  => 500,
					'step' => 1,
				),
				'default'      => '',
				'dependencies' => array(
					array(
						'control'  => 'shape_bottom_switch',
						'operator' => '===',
						'value'    => 'yes',
					),
				),
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-shape-bottom svg{ width: {{ VALUE }}%; }",
			),
			array(
				'id'           => 'shape_bottom_height',
				'keywords'     => 'shape bottom height',
				'label'        => __( 'Height', 'lwwb' ),
				'type'         => Control::SLIDER,
				'input_attrs'  => array(
					'min'  => 1,
					'max'  => 100,
					'step' => 1,
				),
				'default'      => '',
				'dependencies' => array(
					array(
						'control'  => 'shape_bottom_switch',
						'operator' => '===',
						'value'    => 'yes',
					),
				),
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-shape-bottom svg{ height: {{ VALUE }}%; }",
			),
			array(
				'id'             => 'shape_bottom_flip',
				'label'          => __( 'Flip', 'lwwb' ),
				'keywords'       => 'shape type flip ',
				'default'        => 'rotateY(0deg) translateX(-50%)',
				'control_layout' => 'inline',
				'type'           => Control::SELECT,
				'choices'        => array(
					'rotateY(180deg) translateX(50%)' => esc_html__( 'Yes', 'lwwb' ),
					'rotateY(0deg) translateX(-50%)'  => esc_html__( 'No', 'lwwb' ),
				),
				'dependencies'   => array(
					array(
						'control'  => 'shape_bottom_switch',
						'operator' => '===',
						'value'    => 'yes',
					),
				),
				'css_format'     => "ELMN_WRAPPER > .lwwb-elmn-shape-bottom svg{ transform: {{ VALUE }}; }",

			),
			array(
				'id'             => 'shape_bottom_bring_to_front',
				'label'          => __( 'Bring To Front', 'lwwb' ),
				'keywords'       => 'shape type invert ',
				'default'        => 'no',
				'control_layout' => 'inline',
				'type'           => Control::SELECT,
				'choices'        => array(
					'2' => esc_html__( 'Yes', 'lwwb' ),
					''  => esc_html__( 'No', 'lwwb' ),
				),
				'dependencies'   => array(
					array(
						'control'  => 'shape_bottom_switch',
						'operator' => '===',
						'value'    => 'yes',
					),
				),
				'css_format'     => "ELMN_WRAPPER > .lwwb-elmn-shape-bottom { z-index: {{ VALUE }}; }",
			),
		);
	}

	public static function get_advanced_controls() {
		return array(
			array(
				'id'            => 'margin',
				'keywords'      => 'margin dimension',
				'label'         => __( 'Margin', 'lwwb' ),
				'type'          => Control::DIMENSIONS,
				'default'       => array(
					'desktop-top'    => '',
					'desktop-right'  => 'auto',
					'desktop-bottom' => '',
					'desktop-left'   => 'auto',
					'desktop-unit'   => 'px',
					'tablet-top'     => '',
					'tablet-right'   => 'auto',
					'tablet-bottom'  => '',
					'tablet-left'    => 'auto',
					'tablet-unit'    => 'px',
					'mobile-top'     => '',
					'mobile-right'   => 'auto',
					'mobile-bottom'  => '',
					'mobile-left'    => 'auto',
					'mobile-unit'    => 'px',
				),
				'device_config' => array(
					'desktop' => array(
						'top'    => esc_html__( 'Top', 'lwwb' ),
						'right'  => esc_html__( 'Right', 'lwwb' ),
						'bottom' => esc_html__( 'Bottom', 'lwwb' ),
						'left'   => esc_html__( 'Left', 'lwwb' ),
					),
					'tablet'  => array(
						'top'    => esc_html__( 'Top', 'lwwb' ),
						'right'  => esc_html__( 'Right', 'lwwb' ),
						'bottom' => esc_html__( 'Bottom', 'lwwb' ),
						'left'   => esc_html__( 'Left', 'lwwb' ),
					),
					'mobile'  => array(
						'top'    => esc_html__( 'Top', 'lwwb' ),
						'right'  => esc_html__( 'Right', 'lwwb' ),
						'bottom' => esc_html__( 'Bottom', 'lwwb' ),
						'left'   => esc_html__( 'Left', 'lwwb' ),
					),
				),
				'input_attrs'   => array(
					'min'  => '-1000',
					'max'  => '1000',
					'step' => '1',
				),
				'unit'          => array(
					'px' => 'px',
					'%'  => '%',
				),
				'css_format'    => "ELMN_WRAPPER {margin: {{ TOP }}{{ UNIT }} auto {{ BOTTOM }}{{ UNIT }} auto ;}",
			),
			array(
				'id'            => 'padding',
				'keywords'      => 'padding dimension',
				'label'         => __( 'Padding', 'lwwb' ),
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
						'top'    => esc_html__( 'Top', 'lwwb' ),
						'right'  => esc_html__( 'Right', 'lwwb' ),
						'bottom' => esc_html__( 'Bottom', 'lwwb' ),
						'left'   => esc_html__( 'Left', 'lwwb' ),
					),
					'tablet'  => array(
						'top'    => esc_html__( 'Top', 'lwwb' ),
						'right'  => esc_html__( 'Right', 'lwwb' ),
						'bottom' => esc_html__( 'Bottom', 'lwwb' ),
						'left'   => esc_html__( 'Left', 'lwwb' ),
					),
					'mobile'  => array(
						'top'    => esc_html__( 'Top', 'lwwb' ),
						'right'  => esc_html__( 'Right', 'lwwb' ),
						'bottom' => esc_html__( 'Bottom', 'lwwb' ),
						'left'   => esc_html__( 'Left', 'lwwb' ),
					),
				),
				'input_attrs'   => array(
					'min'  => '-1000',
					'max'  => '1000',
					'step' => '1',
				),
				'unit'          => array(
					'px' => 'px',
					'%'  => '%',
				),
				'css_format'    => "ELMN_WRAPPER {padding: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",
			),
			array(
				'id'             => 'z_index',
				'keywords'       => 'z-index z index',
				'label'          => __( 'Z-index', 'lwwb' ),
				'type'           => Control::TEXT,
				'control_layout' => 'inline',
				'input_type'     => 'number',
				'default'        => '',
				'css_format'     => 'ELMN_WRAPPER {z-index:{{ VALUE }};}',
			),
			array(
				'id'             => 'css_id',
				'keywords'       => 'css_id cssid',
				'label'          => __( 'CSS ID', 'lwwb' ),
				'type'           => Control::TEXT,
				'control_layout' => 'inline',
				'input_type'     => 'text',
				'default'        => '',
			),
			array(
				'id'             => 'css_classes',
				'keywords'       => 'css_classes class classes',
				'label'          => __( 'CSS Classes', 'lwwb' ),
				'type'           => Control::TEXT,
				'control_layout' => 'inline',
				'input_type'     => 'text',
				'default'        => '',
			),
		);
	}

	public function get_default_data() {
		return array(
			'bg_type' => 'normal',
		);
	}

	public function render_up_control() {
		?>
        <li class="lwwb-elmn-setting lwwb-elmn-up" data-action="up"
            title="<?php echo __( 'Move up' ); ?> <?php echo esc_attr( $this->type ); ?>">
            <i class="fa fa fa-chevron-up" aria-hidden="true"></i><span
                    class="lwwb-control-label"><?php echo __( 'Move up' ); ?><?php echo esc_attr( $this->type ); ?></span>
        </li>

		<?php
	}

	public function render_down_control() {
		?>
        <li class="lwwb-elmn-setting lwwb-elmn-down" data-action="down"
            title="<?php echo __( 'Move down' ); ?> <?php echo esc_attr( $this->type ); ?>">
            <i class="fa fa fa-chevron-down" aria-hidden="true"></i><span
                    class="lwwb-control-label"><?php echo __( 'Move down' ); ?><?php echo esc_attr( $this->type ); ?></span>
        </li>

		<?php
	}

	public function get_elmn_builder_control() {
		return array(
			'move',
			'edit',
			'up',
			'down',
			// 'add',
			'clone',
			'save',
			'remove',
		);
	}

	public function render_content() {
		$classes = array();
		if ( $this->get_data( 'in_container' ) == 'yes' ) {
			echo '<div class="container ' . $this->get_data( 'container_width' ) . '">';
		}
		$classes[] = 'columns is-multiline';
		echo '<div class="' . implode( ' ', $classes ) . '">';
		$this->render_childs();
		echo '</div>';
		if ( $this->get_data( 'in_container' ) == 'yes' ) {
			echo '</div>';
		}
	}


	public function get_elmn_classes() {
		$classes        = $this->get_default_classes();
		$classes[]      = 'section';
		$custom_classes = $this->get_data( 'css_classes' );

		$classes[] = isset( $custom_classes ) ? esc_attr( $custom_classes ) : '';
		$classes[] = ( $this->get_data( 'section_height' ) ) ? ' ' . esc_attr( $this->get_data( 'section_height' ) ) : '';
		$classes[] = ( $this->get_data( 'entrance_animation' ) != '' ) ? 'wow ' . esc_attr( $this->get_data( 'entrance_animation' ) ) : '';
		$classes[] = ( $this->get_data( 'entrance_animation' ) != '' ) ? '' . esc_attr( $this->get_data( 'animation_duration' ) ) : ' normal';

		return $classes;
	}

	public function bottom_control_template() {
		?>
        <div class="bottom_settings lwwb-elmn-setting-list">
            <ul class="lwwb-elmn-settings lwwb-<?php echo esc_attr( $this->type ); ?>-settings">
                <li class="lwwb-elmn-setting lwwb-elmn-save" data-action="save" draggable="true"
                    title="<?php echo __( 'Save section' ); ?>">
                    <i class="fa fa-save" aria-hidden="true"></i><span
                            class="lwwb-control-label"><?php echo __( 'Save section' ); ?></span>
                </li>
                <li class="lwwb-elmn-setting lwwb-elmn-add" data-action="add" draggable="true"
                    title="<?php echo __( 'Add section' ); ?>">
                    <i class="fa fa-plus" aria-hidden="true"></i><span
                            class="lwwb-control-label"><?php echo __( 'Add section' ); ?></span>
                </li>
                <ul class="lwwb-elmn-settings lwwb-<?php echo esc_attr( $this->type ); ?>-settings">
                    <li class="lwwb-elmn-setting lwwb-elmn-import" data-action="import" draggable="true"
                        title="<?php echo __( 'Import section' ); ?>">
                        <i class="fa fa-cloud-download" aria-hidden="true"></i><span
                                class="lwwb-control-label"><?php echo __( 'Import section' ); ?></span>
                    </li>
                </ul>
        </div>
		<?php
	}

	public function get_background_overlay_group_control() {
		return
			array(
				'id'           => 'lwwb_background_overlay_group_control',
				'label'        => __( 'Background Overlay', 'lwwb' ),
				'type'         => Control::GROUP,
				'dependencies' => array(
					array(
						'control'  => 'lwwb_tab_control',
						'operator' => '===',
						'value'    => 'style',
					),
				),
				'fields'       => $this->get_background_overlay_controls(),
			);
	}

	public static function get_background_overlay_controls() {
		return array(
			array(
				'id'       => 'bg_overlay_state',
				'keywords' => 'bg_overlay state normal hover',
				'label'    => __( '', 'lwwb' ),
				'default'  => '',
				'type'     => Control::BUTTON_SET,
				'choices'  => array(
					'normal' => __( 'Normal', 'lwwb' ),
					'hover'  => __( 'Hover', 'lwwb' ),
				),
			),
			// Normal
			array(
				'id'             => 'bg_overlay_normal_type',
				'keywords'       => 'bg_overlay type normal hover',
				'label'          => __( 'Background Type', 'lwwb' ),
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

			// Classic
			array(
				'id'           => 'bg_overlay_normal_color',
				'keywords'     => 'background overlay normal color picker',
				'default'      => '',
				'label'        => __( 'Color', 'lwwb' ),
				'type'         => Control::COLOR_PICKER,
				'dependencies' => array(
					array(
						'control'  => 'bg_overlay_state',
						'operator' => '===',
						'value'    => 'normal',
					),
					array(
						'control'  => 'bg_overlay_normal_type',
						'operator' => '===',
						'value'    => 'classic',
					),
				),
				'css_format'   => "ELMN_WRAPPER >.lwwb-elmn-background-overlay{ background-color: {{ VALUE }}; }",

			),
			array(
				'id'           => 'bg_overlay_normal_image',
				'keywords'     => 'background image overlay normal color picker',
				'default'      => array(
					'url' => '',
					'id'  => '',
				),
				'label'        => __( 'Image', 'lwwb' ),
				'type'         => Control::MEDIA_UPLOAD,
				'dependencies' => array(
					array(
						'control'  => 'bg_overlay_state',
						'operator' => '===',
						'value'    => 'normal',
					),
					array(
						'control'  => 'bg_overlay_normal_type',
						'operator' => '===',
						'value'    => 'classic',
					),
				),

				'css_format' => "ELMN_WRAPPER >.lwwb-elmn-background-overlay{ background-image: url({{ URL }}); }",
			),
			array(
				'id'             => 'bg_overlay_normal_position',
				'keywords'       => 'image position, media',
				'label'          => __( 'Position', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'default'        => '',
				'choices'        => Default_Elmn_Controls::get_background_position(),
				'dependencies'   => array(
					array(
						'control'  => 'bg_overlay_state',
						'operator' => '===',
						'value'    => 'normal',
					),
					array(
						'control'  => 'bg_overlay_normal_type',
						'operator' => '===',
						'value'    => 'classic',
					),
					array(
						'control'  => 'bg_overlay_normal_image',
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
				'id'             => 'bg_overlay_normal_repeat',
				'keywords'       => 'image repeat, media',
				'label'          => __( 'Repeat', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'default'        => '',
				'choices'        => Default_Elmn_Controls::get_background_repeat(),
				'dependencies'   => array(
					array(
						'control'  => 'bg_overlay_state',
						'operator' => '===',
						'value'    => 'normal',
					),
					array(
						'control'  => 'bg_overlay_normal_type',
						'operator' => '===',
						'value'    => 'classic',
					),
					array(
						'control'  => 'bg_overlay_normal_image',
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
				'id'             => 'bg_overlay_normal_attachment',
				'keywords'       => 'image attachment, media',
				'label'          => __( 'Attachment', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'default'        => '',
				'choices'        => Default_Elmn_Controls::get_background_attachment(),
				'dependencies'   => array(
					array(
						'control'  => 'bg_overlay_state',
						'operator' => '===',
						'value'    => 'normal',
					),
					array(
						'control'  => 'bg_overlay_normal_type',
						'operator' => '===',
						'value'    => 'classic',
					),
					array(
						'control'  => 'bg_overlay_normal_image',
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
				'id'             => 'bg_overlay_normal_size',
				'keywords'       => 'image size, media',
				'label'          => __( 'Size', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'default'        => '',
				'choices'        => Default_Elmn_Controls::get_background_size(),
				'dependencies'   => array(
					array(
						'control'  => 'bg_overlay_state',
						'operator' => '===',
						'value'    => 'normal',
					),
					array(
						'control'  => 'bg_overlay_normal_type',
						'operator' => '===',
						'value'    => 'classic',
					),
					array(
						'control'  => 'bg_overlay_normal_image',
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
				'id'           => 'bg_overlay_normal_opacity',
				'keywords'     => 'overlay background opacity',
				'label'        => __( 'Opacity', 'lwwb' ),
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
						'control'  => 'bg_overlay_normal_type',
						'operator' => '===',
						'value'    => 'classic',
					),
					array(
						'control'  => 'bg_overlay_normal_image',
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
				'id'           => 'bg_overlay_normal_gradient-type',
				'keywords'     => 'background gradient type normal hover',
				'label'        => '',
				'default'      => 'linear',
				'type'         => Control::BUTTON_SET,
				'choices'      => array(
					'linear' => __( 'Linear', 'lwwb' ),
					'radial' => __( 'Radial', 'lwwb' ),
				),
				'dependencies' => array(
					array(
						'control'  => 'bg_overlay_state',
						'operator' => '===',
						'value'    => 'normal',
					),
					array(
						'control'  => 'bg_overlay_normal_type',
						'operator' => '===',
						'value'    => 'gradient',
					),
				),
			),
			array(
				'id'           => 'bg_overlay_normal_linear-gradient',
				'keywords'     => '',
				'label'        => __( 'Gradient linear', 'lwwb' ),
				'type'         => Control::MODAL,
				'button_icon'  => 'fa fa-pencil',
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-background-overlay  { background-image:linear-gradient({{ ANGLE }}deg, {{ COLOR }} {{ LOCATION }}%, {{ COLOR2 }} {{ LOCATION2 }}% ); }",
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
						'label'    => __( 'Color', 'lwwb' ),
						'type'     => Control::COLOR_PICKER,
					),
					array(
						'id'          => 'location',
						'keywords'    => 'gradient location angle',
						'label'       => __( 'Location', 'lwwb' ),
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
						'label'    => __( 'Second Color', 'lwwb' ),
						'type'     => Control::COLOR_PICKER,
					),
					array(
						'id'          => 'location2',
						'keywords'    => 'gradient location angle',
						'label'       => __( 'Second Location', 'lwwb' ),
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
						'label'        => __( 'Angle', 'lwwb' ),
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
						'control'  => 'bg_overlay_normal_type',
						'operator' => '===',
						'value'    => 'gradient',
					),
					array(
						'control'  => 'bg_overlay_normal_gradient-type',
						'operator' => '===',
						'value'    => 'linear',
					),
				),
			),
			array(
				'id'           => 'bg_overlay_normal_radial-gradient',
				'keywords'     => '',
				'label'        => __( 'Gradient Radial', 'lwwb' ),
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
						'label'    => __( 'Color', 'lwwb' ),
						'type'     => Control::COLOR_PICKER,
					),
					array(
						'id'          => 'location',
						'keywords'    => 'gradient location angle',
						'label'       => __( 'Location', 'lwwb' ),
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
						'label'    => __( 'Second Color', 'lwwb' ),
						'type'     => Control::COLOR_PICKER,
					),
					array(
						'id'          => 'location2',
						'keywords'    => 'gradient location angle',
						'label'       => __( 'Second Location', 'lwwb' ),
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
						'label'    => __( 'Position', 'lwwb' ),
						'default'  => 'center center',
						'type'     => Control::SELECT,
						'choices'  => Default_Elmn_Controls::get_background_position(),
					),
				),
				'dependencies' => array(
					array(
						'control'  => 'bg_overlay_state',
						'operator' => '===',
						'value'    => 'normal',
					),
					array(
						'control'  => 'bg_overlay_normal_type',
						'operator' => '===',
						'value'    => 'gradient',
					),
					array(
						'control'  => 'bg_overlay_normal_gradient-type',
						'operator' => '===',
						'value'    => 'radial',
					),
				),
			),


			// DIVIDER
			array(
				'id'           => 'bg_overlay_normal_divider',
				'keywords'     => 'background overlay normal color picker',
				'default'      => '',
				'label'        => __( '', 'lwwb' ),
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
				'id'           => 'css_filter_normal',
				'keywords'     => '',
				'label'        => __( 'CSS Filters', 'lwwb' ),
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
						'label'       => __( 'Blur', 'lwwb' ),
						// 'default'      => '0',
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
						'label'       => __( 'Brightness', 'lwwb' ),
						// 'default'      => '0',
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
						'label'       => __( 'Contrast', 'lwwb' ),
						// 'default'      => '0',
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
						'label'       => __( 'Saturation', 'lwwb' ),
						// 'default'      => '0',
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
						'label'       => __( 'Hue', 'lwwb' ),
						// 'default'      => '0',
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
				'label'          => __( 'Blend Mode', 'lwwb' ),
				'default'        => 'none',
				'control_layout' => 'inline',
				'keywords'       => 'blend Mode, Css filters normal type',
				'type'           => Control::SELECT,
				'choices'        => array(
					''            => esc_html__( 'Normal', 'lwwb' ),
					'multiply'    => esc_html__( 'Multiply', 'lwwb' ),
					'screen'      => esc_html__( 'Screen', 'lwwb' ),
					'overlay'     => esc_html__( 'Overlay', 'lwwb' ),
					'darken'      => esc_html__( 'Darken', 'lwwb' ),
					'lighten'     => esc_html__( 'Lighten', 'lwwb' ),
					'color-dodge' => esc_html__( 'Color Dodge', 'lwwb' ),
					'saturation'  => esc_html__( 'Saturation', 'lwwb' ),
					'color'       => esc_html__( 'Color', 'lwwb' ),
					'luminosity'  => esc_html__( 'Luminosity', 'lwwb' ),
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

			// Hover

			array(
				'id'             => 'bg_overlay_hover_type',
				'keywords'       => 'bg_overlay type hover hover',
				'label'          => __( 'Background Type', 'lwwb' ),
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
						'value'    => 'hover',
					),
				),
			),

			// Classic
			array(
				'id'           => 'bg_overlay_hover_color',
				'keywords'     => 'background overlay normal color picker',
				'default'      => '',
				'label'        => __( 'Color', 'lwwb' ),
				'type'         => Control::COLOR_PICKER,
				'dependencies' => array(
					array(
						'control'  => 'bg_overlay_state',
						'operator' => '===',
						'value'    => 'hover',
					),
					array(
						'control'  => 'bg_overlay_hover_type',
						'operator' => '===',
						'value'    => 'classic',
					),
				),
				'css_format'   => "ELMN_WRAPPER:hover >.lwwb-elmn-background-overlay{ background-color: {{ VALUE }}; }",

			),
			array(
				'id'           => 'bg_overlay_hover_image',
				'keywords'     => 'background image overlay hover color picker',
				'default'      => array(
					'url' => '',
					'id'  => '',
				),
				'label'        => __( 'Image', 'lwwb' ),
				'type'         => Control::MEDIA_UPLOAD,
				'dependencies' => array(
					array(
						'control'  => 'bg_overlay_state',
						'operator' => '===',
						'value'    => 'hover',
					),
					array(
						'control'  => 'bg_overlay_hover_type',
						'operator' => '===',
						'value'    => 'classic',
					),
				),

				'css_format' => "ELMN_WRAPPER:hover >.lwwb-elmn-background-overlay{ background-image: url({{ URL }}); }",
			),
			array(
				'id'             => 'bg_overlay_hover_position',
				'keywords'       => 'image position, media',
				'label'          => __( 'Position', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'default'        => '',
				'choices'        => Default_Elmn_Controls::get_background_position(),
				'dependencies'   => array(
					array(
						'control'  => 'bg_overlay_state',
						'operator' => '===',
						'value'    => 'hover',
					),
					array(
						'control'  => 'bg_overlay_hover_type',
						'operator' => '===',
						'value'    => 'classic',
					),
					array(
						'control'  => 'bg_overlay_hover_image',
						'operator' => '!==',
						'value'    => array(
							'url' => '',
							'id'  => '',
						),
					),

				),
				'css_format'     => "ELMN_WRAPPER:hover >.lwwb-elmn-background-overlay{ background-position:{{ VALUE }}; }",
			),
			array(
				'id'             => 'bg_overlay_hover_repeat',
				'keywords'       => 'image repeat, media',
				'label'          => __( 'Repeat', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'default'        => '',
				'choices'        => Default_Elmn_Controls::get_background_repeat(),
				'dependencies'   => array(
					array(
						'control'  => 'bg_overlay_state',
						'operator' => '===',
						'value'    => 'hover',
					),
					array(
						'control'  => 'bg_overlay_hover_type',
						'operator' => '===',
						'value'    => 'classic',
					),
					array(
						'control'  => 'bg_overlay_hover_image',
						'operator' => '!==',
						'value'    => array(
							'url' => '',
							'id'  => '',
						),
					),
				),
				'css_format'     => "ELMN_WRAPPER:hover >.lwwb-elmn-background-overlay{ background-repeat:{{ VALUE }}; }",
			),
			array(
				'id'             => 'bg_overlay_hover_attachment',
				'keywords'       => 'image attachment, media',
				'label'          => __( 'Attachment', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'default'        => '',
				'choices'        => Default_Elmn_Controls::get_background_attachment(),
				'dependencies'   => array(
					array(
						'control'  => 'bg_overlay_state',
						'operator' => '===',
						'value'    => 'hover',
					),
					array(
						'control'  => 'bg_overlay_hover_type',
						'operator' => '===',
						'value'    => 'classic',
					),
					array(
						'control'  => 'bg_overlay_hover_image',
						'operator' => '!==',
						'value'    => array(
							'url' => '',
							'id'  => '',
						),
					),
				),
				'css_format'     => "ELMN_WRAPPER:hover >.lwwb-elmn-background-overlay{ background-attachment:{{ VALUE }}; }",
			),
			array(
				'id'             => 'bg_overlay_hover_size',
				'keywords'       => 'image size, media',
				'label'          => __( 'Size', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'default'        => '',
				'choices'        => Default_Elmn_Controls::get_background_size(),
				'dependencies'   => array(
					array(
						'control'  => 'bg_overlay_state',
						'operator' => '===',
						'value'    => 'hover',
					),
					array(
						'control'  => 'bg_overlay_hover_type',
						'operator' => '===',
						'value'    => 'classic',
					),
					array(
						'control'  => 'bg_overlay_hover_image',
						'operator' => '!==',
						'value'    => array(
							'url' => '',
							'id'  => '',
						),
					),
				),
				'css_format'     => "ELMN_WRAPPER:hover >.lwwb-elmn-background-overlay{ background-size:{{ VALUE }}; }",
			),
			array(
				'id'           => 'bg_overlay_hover_opacity',
				'keywords'     => 'overlay background opacity',
				'label'        => __( 'Opacity', 'lwwb' ),
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
						'value'    => 'hover',
					),
					array(
						'control'  => 'bg_overlay_hover_type',
						'operator' => '===',
						'value'    => 'classic',
					),
					array(
						'control'  => 'bg_overlay_hover_image',
						'operator' => '!==',
						'value'    => array(
							'url' => '',
							'id'  => '',
						),
					),
				),
				'css_format'   => "ELMN_WRAPPER:hover >.lwwb-elmn-background-overlay{ opacity:{{ VALUE }}; }",
			),

			// Gradient
			array(
				'id'           => 'bg_overlay_hover_gradient-type',
				'keywords'     => 'background gradient type hover hover',
				'label'        => '',
				'default'      => 'linear',
				'type'         => Control::BUTTON_SET,
				'choices'      => array(
					'linear' => __( 'Linear', 'lwwb' ),
					'radial' => __( 'Radial', 'lwwb' ),
				),
				'dependencies' => array(
					array(
						'control'  => 'bg_overlay_state',
						'operator' => '===',
						'value'    => 'hover',
					),
					array(
						'control'  => 'bg_overlay_hover_type',
						'operator' => '===',
						'value'    => 'gradient',
					),
				),
			),
			array(
				'id'           => 'bg_overlay_hover_linear-gradient',
				'keywords'     => '',
				'label'        => __( 'Gradient linear', 'lwwb' ),
				'type'         => Control::MODAL,
				'button_icon'  => 'fa fa-pencil',
				'css_format'   => "ELMN_WRAPPER:hover > .lwwb-elmn-background-overlay { background-image:linear-gradient({{ ANGLE }}deg, {{ COLOR }} {{ LOCATION }}%, {{ COLOR2 }} {{ LOCATION2 }}% ); }",
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
						'label'    => __( 'Color', 'lwwb' ),
						'type'     => Control::COLOR_PICKER,
					),
					array(
						'id'          => 'location',
						'keywords'    => 'gradient location angle',
						'label'       => __( 'Location', 'lwwb' ),
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
						'label'    => __( 'Second Color', 'lwwb' ),
						'type'     => Control::COLOR_PICKER,
					),
					array(
						'id'          => 'location2',
						'keywords'    => 'gradient location angle',
						'label'       => __( 'Second Location', 'lwwb' ),
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
						'label'        => __( 'Angle', 'lwwb' ),
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
						'value'    => 'hover',
					),
					array(
						'control'  => 'bg_overlay_hover_type',
						'operator' => '===',
						'value'    => 'gradient',
					),
					array(
						'control'  => 'bg_overlay_hover_gradient-type',
						'operator' => '===',
						'value'    => 'linear',
					),
				),
			),
			array(
				'id'           => 'bg_overlay_hover_radial-gradient',
				'keywords'     => '',
				'label'        => __( 'Gradient Radial', 'lwwb' ),
				'type'         => Control::MODAL,
				'button_icon'  => 'fa fa-pencil',
				'css_format'   => "ELMN_WRAPPER:hover > .lwwb-elmn-background-overlay { background-image:radial-gradient(at {{ POSITION }}, {{ COLOR }} {{ LOCATION }}%, {{ COLOR2 }} {{ LOCATION2 }}% ); }",
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
						'label'    => __( 'Color', 'lwwb' ),
						'type'     => Control::COLOR_PICKER,
					),
					array(
						'id'          => 'location',
						'keywords'    => 'gradient location angle',
						'label'       => __( 'Location', 'lwwb' ),
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
						'label'    => __( 'Second Color', 'lwwb' ),
						'type'     => Control::COLOR_PICKER,
					),
					array(
						'id'          => 'location2',
						'keywords'    => 'gradient location angle',
						'label'       => __( 'Second Location', 'lwwb' ),
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
						'label'    => __( 'Position', 'lwwb' ),
						'default'  => 'center center',
						'type'     => Control::SELECT,
						'choices'  => Default_Elmn_Controls::get_background_position(),
					),
				),
				'dependencies' => array(
					array(
						'control'  => 'bg_overlay_state',
						'operator' => '===',
						'value'    => 'hover',
					),
					array(
						'control'  => 'bg_overlay_hover_type',
						'operator' => '===',
						'value'    => 'gradient',
					),
					array(
						'control'  => 'bg_overlay_hover_gradient-type',
						'operator' => '===',
						'value'    => 'radial',
					),
				),
			),


			// DIVIDER
			array(
				'id'           => 'bg_overlay-divider',
				'keywords'     => 'background overlay hover color picker',
				'default'      => '',
				'label'        => __( '', 'lwwb' ),
				'type'         => Control::DIVIDER,
				'dependencies' => array(
					array(
						'control'  => 'bg_overlay_state',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
			),
			// CSS Filters
			array(
				'id'           => 'css_filter_hover',
				'keywords'     => '',
				'label'        => __( 'CSS Filters', 'lwwb' ),
				'type'         => Control::MODAL,
				'button_icon'  => 'fa fa-pencil',
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-background-overlay:hover{filter: brightness( {{ BRIGHTNESS }}% ) contrast( {{ CONTRAST }}% ) saturate( {{ SATURATION }}% ) blur( {{ BLUR }}px ) hue-rotate( {{ HUE }}deg ) ;}",
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
						'label'       => __( 'Blur', 'lwwb' ),
						// 'default'      => '0',
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
						'label'       => __( 'Brightness', 'lwwb' ),
						// 'default'      => '0',
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
						'label'       => __( 'Contrast', 'lwwb' ),
						// 'default'      => '0',
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
						'label'       => __( 'Saturation', 'lwwb' ),
						// 'default'      => '0',
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
						'label'       => __( 'Hue', 'lwwb' ),
						// 'default'      => '0',
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
						'value'    => 'hover',
					),
				),
			),


		);

	}

	public function render_elmn_shape_top() {
		if ( $this->get_data( 'shape_top_switch' ) == 'yes' ) {
			echo '<div class="lwwb-elmn-shape lwwb-elmn-shape-top">' . $this->print_shape( $this->get_data( 'shape_top' ) ) . '</div>';
		}
	}

	public function render_elmn_shape_bottom() {
		if ( $this->get_data( 'shape_bottom_switch' ) == 'yes' ) {
			echo '<div class="lwwb-elmn-shape lwwb-elmn-shape-bottom">' . $this->print_shape( $this->get_data( 'shape_bottom' ) ) . '</div>';
		}
	}

	public function print_shape( $type ) {
		$shape_path = LWWB_PLUGIN_DIR . 'assets/shapes/' . $type . '.svg';
		$content    = file_get_contents( $shape_path );

		return $content;
	}

	public function content_template() {
		?>
        <# if(elmn_data.background_normal_type == 'video') { #>
        <div class="lwwb-elmn-background-video is-hidden-mobile">
            <div class="lwwb-background-video-embed"></div>
            <video class="lwwb-background-video-hosted" autoplay loop muted></video>
        </div>
        <# } #>

        <div class="lwwb-elmn-background-overlay">&nbsp;</div>
        <div class="lwwb-elmn-shape lwwb-elmn-shape-top"></div>
        <div class="lwwb-elmn-shape lwwb-elmn-shape-bottom"></div>

        <# if( elmn_data.in_container === 'yes') { #>
        <div class="container {{ elmn_data.container_width }}">
            <# } #>
            <div class="lwwb-elmn-content {{ elmn_data.section_height }}">
                <div class="columns is-multiline ui-sortable">
                </div>
            </div>
            <# if( elmn_data.in_container === 'yes') { #>
        </div>
        <# } #>
		<?php
	}

	// Render template for builder
	public function print_content_template() {
		$this->content_template();
	}

	final public function print_helper_template() {
		?>
        <script type="text/html" id="tmpl-lwwb-elmn-<?php echo $this->type; ?>-preset-content">
			<?php $this->section_preset_template(); ?>
        </script>
		<?php
	}

	public function section_preset_template() {
		?>
        <div class="lwwb-section-preset">
            <ul class="lwwb-preset-list lwwb-3-cols">
                <li class="lwwb-preset-item" data-section_preset="_12">
                    <span class="lwwb-preset-text">1</span>
                </li>
                <li class="lwwb-preset-item" data-section_preset="_8_4">
                    <span class="lwwb-preset-text lwwb-8-cols">2/3</span>
                    <span class="lwwb-preset-text lwwb-4-cols">1/3</span>
                </li>
                <li class="lwwb-preset-item" data-section_preset="_6_3_3">
                    <span class="lwwb-preset-text lwwb-6-cols">1/2</span>
                    <span class="lwwb-preset-text lwwb-3-cols">1/4</span>
                    <span class="lwwb-preset-text lwwb-3-cols">1/4</span>
                </li>
            </ul>
            <ul class="lwwb-preset-list lwwb-3-cols">
                <li class="lwwb-preset-item" data-section_preset="_2_cols">
                    <span class="lwwb-preset-text lwwb-6-cols">1/2</span>
                    <span class="lwwb-preset-text lwwb-6-cols">1/2</span>
                </li>
                <li class="lwwb-preset-item" data-section_preset="_4_cols">
                    <span class="lwwb-preset-text lwwb-3-cols">1/4</span>
                    <span class="lwwb-preset-text lwwb-3-cols">1/4</span>
                    <span class="lwwb-preset-text lwwb-3-cols">1/4</span>
                    <span class="lwwb-preset-text lwwb-3-cols">1/4</span>
                </li>
                <li class="lwwb-preset-item" data-section_preset="_3_6_3">
                    <span class="lwwb-preset-text lwwb-3-cols">1/4</span>
                    <span class="lwwb-preset-text lwwb-6-cols">1/2</span>
                    <span class="lwwb-preset-text lwwb-3-cols">1/4</span>
                </li>
            </ul>
            <ul class="lwwb-preset-list lwwb-3-cols">
                <li class="lwwb-preset-item" data-section_preset="_3_cols">
                    <span class="lwwb-preset-text lwwb-4-cols">1/3</span>
                    <span class="lwwb-preset-text lwwb-4-cols">1/3</span>
                    <span class="lwwb-preset-text lwwb-4-cols">1/3</span>
                </li>
                <li class="lwwb-preset-item" data-section_preset="_5_7">
                    <span class="lwwb-preset-text lwwb-5-cols">5/12</span>
                    <span class="lwwb-preset-text lwwb-7-cols">7/12</span>
                </li>
                <li class="lwwb-preset-item" data-section_preset="_5_cols">
                    <span class="lwwb-preset-text">1/5</span>
                    <span class="lwwb-preset-text">1/5</span>
                    <span class="lwwb-preset-text">1/5</span>
                    <span class="lwwb-preset-text">1/5</span>
                    <span class="lwwb-preset-text">1/5</span>
                </li>
            </ul>
            <ul class="lwwb-preset-list lwwb-3-cols">
                <li class="lwwb-preset-item" data-section_preset="_4_8">
                    <span class="lwwb-preset-text lwwb-4-cols">1/3</span>
                    <span class="lwwb-preset-text lwwb-8-cols">2/3</span>
                </li>
                <li class="lwwb-preset-item" data-section_preset="_3_3_6">
                    <span class="lwwb-preset-text lwwb-3-cols">1/4</span>
                    <span class="lwwb-preset-text lwwb-3-cols">1/4</span>
                    <span class="lwwb-preset-text lwwb-6-cols">1/2</span>
                </li>
                <li class="lwwb-preset-item" data-section_preset="_6_cols">
                    <span class="lwwb-preset-text">1/6</span>
                    <span class="lwwb-preset-text">1/6</span>
                    <span class="lwwb-preset-text">1/6</span>
                    <span class="lwwb-preset-text">1/6</span>
                    <span class="lwwb-preset-text">1/6</span>
                    <span class="lwwb-preset-text">1/6</span>

                </li>
            </ul>
        </div>

		<?php
	}
}
