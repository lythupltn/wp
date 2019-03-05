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

use Lwwb\Builder\Base\Default_Elmn_Controls;
use Lwwb\Builder\Base\Elmn;
use Lwwb\Customizer\Control_Manager as Control;

class Button extends Elmn {

	public $type = 'button';
	public $label = 'Button';
	public $key_words = 'button, media, btn';
	public $icon = 'fa fa-cc-diners-club';
	public $group = 'basic';

	public $control_groups = array(
		'content',
		'style',
		'advanced',
		'background',
		'border',
		'typography',
		'responsive',
		'custom_css',
	);

	public $default_data = array();

	public function get_style_group_control() {
		return
			array(
				'id'           => 'lwwb_button_group_control',
				'label'        => __( 'Button', 'lwwb' ),
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

	public function get_typography_group_control() {
		return
			array(
				'id'           => 'lwwb_typography_group_control',
				'label'        => __( 'Typography', 'lwwb' ),
				'type'         => Control::GROUP,
				'dependencies' => array(
					array(
						'control'  => 'lwwb_tab_control',
						'operator' => '===',
						'value'    => 'style',
					),
				),
				'fields'       => static::get_typography_controls(),
			);
	}

	public function get_border_group_control() {
		return
			array(
				'id'           => 'lwwb_border_group_control',
				'label'        => __( 'Border', 'lwwb' ),
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

	public static function get_style_controls() {
		return array(
			array(
				'id'       => 'btn_state',
				'keywords' => 'button state normal hover',
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
				'id'         => 'button_color',
				'keywords'   => 'btn color picker',
				'default'    => '',
				'label'      => __( 'Color', 'lwwb' ),
				'type'       => Control::COLOR_PICKER,
				'dependencies'   => array(
					array(
						'control'  => 'btn_state',
						'operator' => '===',
						'value'    => 'normal',
					),
				),
				'css_format' => 'ELMN_WRAPPER > .lwwb-elmn-content a{color:{{ VALUE }};}',
			),
			array(
				'id'         => 'button_bg_color',
				'keywords'   => 'btn color bg background picker',
				'default'    => '',
				'label'      => __( 'Background Color', 'lwwb' ),
				'type'       => Control::COLOR_PICKER,
				'dependencies'   => array(
					array(
						'control'  => 'btn_state',
						'operator' => '===',
						'value'    => 'normal',
					),
				),
				'css_format' => 'ELMN_WRAPPER > .lwwb-elmn-content a{background-color:{{ VALUE }};}',
			),
			// Hover
			array(
				'id'         => 'btn_hover_color',
				'keywords'   => 'btn color picker',
				'default'    => '',
				'label'      => __( 'Color', 'lwwb' ),
				'type'       => Control::COLOR_PICKER,
				'dependencies'   => array(
					array(
						'control'  => 'btn_state',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
				'css_format' => 'ELMN_WRAPPER:hover > .lwwb-elmn-content a{color:{{ VALUE }};}',
			),
			array(
				'id'         => 'btn_hover_bg_color',
				'keywords'   => 'btn color bg background picker',
				'default'    => '',
				'label'      => __( 'Background Color', 'lwwb' ),
				'type'       => Control::COLOR_PICKER,
				'dependencies'   => array(
					array(
						'control'  => 'btn_state',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
				'css_format' => 'ELMN_WRAPPER:hover > .lwwb-elmn-content a{background-color:{{ VALUE }};}',
			),


			// Padding
			array(
				'id'       => 'divider_shadow_padding',
				'keywords' => 'button, text',
				'label'    => '',
				'type'     => Control::DIVIDER,
			),
			array(
				'id'            => 'btn_padding',
				'keywords'      => 'border hover radius',
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
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'unit'          => array(
					'px' => 'px',
					'%'  => '%',
				),
				'css_format'    => "ELMN_WRAPPER > .lwwb-elmn-content .button { padding: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",
			),

		);
	}

	public static function get_content_controls() {
		return array(
			array(
				'id'             => 'type',
				'keywords'       => 'button, text',
				'label'          => __( 'Type', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'choices'        => static::get_button_types(),
			),
			array(
				'id'                => 'label',
				'keywords'          => 'title, text, button, label',
				'label'             => __( 'Label', 'lwwb' ),
				'type'              => Control::TEXT,
				'default'           => esc_html__( 'Button', 'lwwb' ),
				'input_type'        => 'text',
				'sanitize_callback' => 'sanitize_text_field',
			),
			array(
				'id'             => 'button_size',
				'keywords'       => 'title, text, link, button, size',
				'label'          => __( 'Button Size', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'default'        => '',
				'choices'        => static::get_button_sizes(),
			),
			array(
				'id'             => 'button_style',
				'keywords'       => 'title, text, link, button, size, style',
				'label'          => __( 'Button Style', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'default'        => '',
				'choices'        => static::get_button_styles(),
			),
			array(
				'id'           => 'align',
				'keywords'     => 'title, text, link, button, size',
				'label'        => __( 'Alignment', 'lwwb' ),
				'type'         => Control::BUTTON_SET,
				'display_type' => 'icon',
				'default'      => '',
				'choices'      => Default_Elmn_Controls::get_alignment(),
			),
			array(
				'id'                => 'link',
				'keywords'          => 'title, text, button, label, link, url',
				'label'             => __( 'Url Button', 'lwwb' ),
				'type'              => Control::TEXT,
				'default'           => '',
				'input_type'        => 'url',
				'sanitize_callback' => 'sanitize_text_field',
			),
			array(
				'id'       => 'font_icon',
				'keywords' => 'title, text, button, label',
				'label'    => __( 'Font Icon', 'lwwb' ),
				'type'     => Control::ICON_PICKER,
				'default'  => '',
			),


			array(
				'id'             => 'icon_position',
				'keywords'       => 'title, text, link, icon position, button, icon size',
				'label'          => __( 'Icon Position', 'lwwb' ),
				'type'           => Control::SELECT,
				'default'        => 'left',
				'control_layout' => 'inline',
				'choices'        => array(
					'left'  => esc_html__( 'Left', 'lwwb' ),
					'right' => esc_html__( 'Right', 'lwwb' ),
				),
				'dependencies'   => array(
					array(
						'control'  => 'font_icon',
						'operator' => '!==',
						'value'    => '',
					),
				)
			),
			array(
				'id'       => 'divider_btn',
				'keywords' => 'divider, btn, title, text, button, label, link, url',
				'label'    => '',
				'type'     => Control::DIVIDER,
			),
			array(
				'id'                => 'id',
				'keywords'          => 'btn, title, text, button, label, link, url',
				'label'             => __( 'Button ID', 'lwwb' ),
				'description'       => esc_html__( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows A-z 0-9 & underscore chars without spaces.', 'lwwb' ),
				'type'              => Control::TEXT,
				'default'           => '',
				'input_type'        => 'text',
				'sanitize_callback' => 'sanitize_text_field',
			),
		);
	}

	public static function get_typography_controls() {
		return array(
			array(
				'id'             => 'font_family',
				'keywords'       => 'font font-family',
				'label'          => __( 'Font Family', 'lwwb' ),
				'type'           => Control::SELECT2,
				'control_layout' => 'inline',
				'option_groups'  => array(
					array(
						'label'   => esc_html__( 'System Font' ),
						'choices' => Default_Elmn_Controls::get_system_font_family(),
					),
					array(
						'label'   => esc_html__( 'Google Font' ),
						'choices' => Default_Elmn_Controls::get_google_font_family(),
					),
				),
				'css_format'     => 'ELMN_WRAPPER > .lwwb-elmn-content a span.btn-label{font-family:{{ VALUE }};}',
			),
			array(
				'id'          => 'font_size',
				'keywords'    => 'font font-size',
				'label'       => __( 'Font Size', 'lwwb' ),
				'type'        => Control::SLIDER,
				'input_type'  => 'number',
				'default'     => '16',
				'input_attrs' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
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
				'css_format'  => 'ELMN_WRAPPER > .lwwb-elmn-content a {font-size:{{ VALUE }}px;}',
			),
			array(
				'id'             => 'font_weight',
				'keywords'       => 'font font-weight',
				'label'          => __( 'Font Weight', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'choices'        => Default_Elmn_Controls::typography_font_weight_config(),
				'css_format'     => 'ELMN_WRAPPER > .lwwb-elmn-content a span.btn-label{font-weight:{{ VALUE }};}',
			),
			array(
				'id'             => 'font_style',
				'keywords'       => 'font text font_style',
				'label'          => __( 'Font Style', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'choices'        => Default_Elmn_Controls::typography_font_style_config(),
				'css_format'     => 'ELMN_WRAPPER > .lwwb-elmn-content a span.btn-label{font-style:{{ VALUE }};}',
			),
			array(
				'id'             => 'text_transform',
				'keywords'       => 'font text transform',
				'label'          => __( 'Text Transform', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'choices'        => Default_Elmn_Controls::typography_text_transform_config(),
				'css_format'     => 'ELMN_WRAPPER > .lwwb-elmn-content a span.btn-label{text-transform:{{ VALUE }};}',
			),
			array(
				'id'             => 'text_decoration',
				'keywords'       => 'font text decoration',
				'label'          => __( 'Text Decoration', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'choices'        => Default_Elmn_Controls::typography_text_decoration_config(),
				'css_format'     => 'ELMN_WRAPPER > .lwwb-elmn-content a span.btn-label{text-decoration:{{ VALUE }};}',
			),
		);
	}

	public static function get_border_controls() {
		return array(
			// Border
			array(
				'id'       => 'btn_border_state',
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
				'id'             => 'btn_border_type',
				'label'          => __( 'Border type', 'lwwb' ),
				'default'        => '',
				'control_layout' => 'inline',
				'keywords'       => 'border normal type',
				'type'           => Control::SELECT,
				'choices'        => array(
					''       => __( 'Default', 'lwwb' ),
					'none'   => __( 'None', 'lwwb' ),
					'solid'  => __( 'Solid', 'lwwb' ),
					'double' => __( 'Double', 'lwwb' ),
					'dotted' => __( 'Dotted', 'lwwb' ),
					'dashed' => __( 'Dashed', 'lwwb' ),
					'groove' => __( 'Groove', 'lwwb' ),
				),
				'dependencies'   => array(
					array(
						'control'  => 'btn_border_state',
						'operator' => '===',
						'value'    => 'normal',
					),
				),
				'css_format'     => 'ELMN_WRAPPER > .lwwb-elmn-content .button{border-style:{{ VALUE }};}',
			),
			array(
				'id'            => 'btn_border_width',
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
						'control'  => 'btn_border_state',
						'operator' => '===',
						'value'    => 'normal',
					),
					array(
						'control'                => 'btn_border_type',
						'operator'               => '!==',
						'value'                  => 'none',
						'check_for_render_style' => true
					),
//					array(
//						'control'  => 'btn_border_type',
//						'operator' => '!==',
//						'value'    => '',
//						'check_for_render_style' => true
//					),
				),
				'css_format'    => "ELMN_WRAPPER > .lwwb-elmn-content .button{border-width: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",

			),
			array(
				'id'           => 'btn_border_color',
				'keywords'     => 'border normal color picker',
				'default'      => '',
				'label'        => __( 'Border color', 'lwwb' ),
				'type'         => Control::COLOR_PICKER,
				'dependencies' => array(
					array(
						'control'  => 'btn_border_state',
						'operator' => '===',
						'value'    => 'normal',
					),
					array(
						'control'                => 'btn_border_type',
						'operator'               => '!==',
						'value'                  => 'none',
						'check_for_render_style' => true
					),
					array(
						'control'                => 'btn_border_type',
						'operator'               => '!==',
						'value'                  => '',
						'check_for_render_style' => true
					),
				),
				'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content .button{border-color:{{ VALUE }};}',
			),
			array(
				'id'            => 'btn_border_radius',
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
						'control'  => 'btn_border_state',
						'operator' => '===',
						'value'    => 'normal',
					),
				),
				'css_format'    => "ELMN_WRAPPER > .lwwb-elmn-content .button{border-radius: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",
			),
			// Box shadow
			array(
				'id'           => 'btn_box_shadow',
				'keywords'     => '',
				'label'        => __( 'Box Shadow', 'lwwb' ),
				'type'         => Control::MODAL,
				'button_icon'  => 'fa fa-pencil',
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content .button{box-shadow: {{ HORIZONTAL }}px {{ VERTICAL }}px {{ BLUR }}px {{ SPREAD }}px {{ COLOR }}  {{ POSITION }}  ;}",
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
								'control'  => 'btn_border_state',
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
								'control'  => 'btn_border_state',
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
								'control'  => 'btn_border_state',
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
								'control'  => 'btn_border_state',
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
								'control'  => 'btn_border_state',
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
								'control'  => 'btn_border_state',
								'operator' => '===',
								'value'    => 'normal',
							),
						),
					),

				),
				'dependencies' => array(
					array(
						'control'  => 'btn_border_state',
						'operator' => '===',

						'value' => 'normal',
					),
//					array(
//						'control'  => 'btn_border_type',
//						'operator' => '!==',
//						'value'    => 'none',
//						'check_for_render_style' => true
//					),
//					array(
//						'control'  => 'btn_border_type',
//						'operator' => '!==',
//						'value'    => '',
//						'check_for_render_style' => true
//					),
				),
			),

			// Hover
			array(
				'id'           => 'btn_border_hover_type',
				'label'        => __( 'Border type', 'lwwb' ),
				'keywords'     => 'border hover type',
				'default'      => '',
				'type'         => Control::SELECT,
				'choices'      => array(
					''       => __( 'Default', 'lwwb' ),
					'none'   => __( 'None', 'lwwb' ),
					'solid'  => __( 'Solid', 'lwwb' ),
					'double' => __( 'Double', 'lwwb' ),
					'dotted' => __( 'Dotted', 'lwwb' ),
					'dashed' => __( 'Dashed', 'lwwb' ),
					'groove' => __( 'Groove', 'lwwb' ),
				),
				'dependencies' => array(
					array(
						'control'  => 'btn_border_state',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
				'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content .button:hover{border-style:{{ VALUE }};}',
			),
			array(
				'id'            => 'btn_border_hover_width',
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
					'%'  => '%',
				),
				'dependencies'  => array(
					array(
						'control'  => 'btn_border_state',
						'operator' => '===',
						'value'    => 'hover',
					),
					array(
						'control'                => 'btn_border_hover_type',
						'operator'               => '!==',
						'value'                  => 'none',
						'check_for_render_style' => true
					),
				),
				'css_format'    => "ELMN_WRAPPER > .lwwb-elmn-content .button:hover{border-width: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",

			),
			array(
				'id'           => 'btn_border_hover_color',
				'keywords'     => 'border hover color picker',
				'default'      => '',
				'label'        => __( 'Border color', 'lwwb' ),
				'type'         => Control::COLOR_PICKER,
				'dependencies' => array(
					array(
						'control'  => 'btn_border_state',
						'operator' => '===',
						'value'    => 'hover',
					),
//					array(
//						'control'                => 'btn_border_hover_type',
//						'operator'               => '!==',
//						'value'                  => 'none',
//						'check_for_render_style' => true
//					),
//					array(
//						'control'                => 'btn_border_hover_type',
//						'operator'               => '!==',
//						'value'                  => '',
//						'check_for_render_style' => true
//					),
				),
				'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content .button:hover{border-color:{{ VALUE }};}',
			),
			array(
				'id'            => 'btn_border_hover_radius',
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
						'control'  => 'btn_border_state',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
				'css_format'    => "ELMN_WRAPPER > .lwwb-elmn-content .button:hover{border-radius: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",
			),
			// Box shadow
			array(
				'id'           => 'box_shadow_hover',
				'keywords'     => '',
				'label'        => __( 'Box Shadow', 'lwwb' ),
				'type'         => Control::MODAL,
				'button_icon'  => 'fa fa-pencil',
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content .button:hover{box-shadow: {{ HORIZONTAL }}px {{ VERTICAL }}px {{ BLUR }}px {{ SPREAD }}px {{ COLOR }}  {{ POSITION }}  ;}",
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
								'control'  => 'btn_border_state',
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
								'control'  => 'btn_border_state',
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
								'control'  => 'btn_border_state',
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
								'control'  => 'btn_border_state',
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
								'control'  => 'btn_border_state',
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
								'control'  => 'btn_border_state',
								'operator' => '===',
								'value'    => 'normal',
							),
						),
					),

				),
				'dependencies' => array(
					array(
						'control'  => 'btn_border_state',
						'operator' => '===',
						'value'    => 'hover',
					),
//					array(
//						'control'                => 'btn_border_hover_type',
//						'operator'               => '!==',
//						'value'                  => 'none',
//						'check_for_render_style' => true
//					),
//					array(
//						'control'                => 'btn_border_hover_type',
//						'operator'               => '!==',
//						'value'                  => '',
//						'check_for_render_style' => true
//					),
				),
			),
		);
	}

	public static function get_button_types() {
		return array(
			'is-white'   => esc_html__( 'White', 'lwwb' ),
			'is-light'   => esc_html__( 'Light', 'lwwb' ),
			'is-dark'    => esc_html__( 'Dark', 'lwwb' ),
			'is-black'   => esc_html__( 'Black', 'lwwb' ),
			'is-text'    => esc_html__( 'Text', 'lwwb' ),
			'is-primary' => esc_html__( 'Primary', 'lwwb' ),
			'is-link'    => esc_html__( 'Link', 'lwwb' ),
			'is-info'    => esc_html__( 'Info', 'lwwb' ),
			'is-success' => esc_html__( 'Success', 'lwwb' ),
			'is-warning' => esc_html__( 'Warning', 'lwwb' ),
			'is-danger'  => esc_html__( 'Danger', 'lwwb' ),
		);
	}

	public static function get_button_sizes() {
		return array(
			'is-small'  => esc_html__( 'Small', 'lwwb' ),
			''          => esc_html__( 'Default', 'lwwb' ),
			'is-normal' => esc_html__( 'Normal', 'lwwb' ),
			'is-medium' => esc_html__( 'Medium', 'lwwb' ),
			'is-large'  => esc_html__( 'Large', 'lwwb' ),
		);
	}

	public static function get_button_styles() {
		return array(
			''            => esc_html__( 'Default', 'lwwb' ),
			'is-outlined' => esc_html__( 'Outlined', 'lwwb' ),
			'is-inverted' => esc_html__( 'Inverted', 'lwwb' ),
			'is-rounded'  => esc_html__( 'Rounded', 'lwwb' ),
		);
	}

	public function get_default_data() {
		return array(
			'label'         => esc_html__( 'Button', 'lwwb' ),
			'font_icon'     => '',
			'icon_position' => 'left',
		);
	}

	public function render_content() {

		$is_fullwidth = ( $this->get_data( 'align' ) == 'justified' ) ? 'is-fullwidth' : '';
		$btn_id       = ( $this->get_data( 'id' ) ) ? 'id="' . $this->get_data( 'id' ) . '"' : '';
		echo '<div ' . $btn_id . ' class="lwwb-elmn-heading has-text-' . $this->get_data( 'align' ) . '">';
		echo '<a class="button ' . $this->get_data( 'type' ) . ' ' . $this->get_data( 'button_size' ) . ' ' . $this->get_data( 'button_style' ) . ' ' . $is_fullwidth . '"
           href="' . $this->get_data( 'link' ) . '">';
		?>

		<?php if ( $this->get_data( 'font_icon' ) ) : ?>
			<?php if ( $this->get_data( 'icon_position' ) == 'right' ): ?>
                <span class="btn-label"><?php echo esc_attr( $this->get_data( 'label' ) ); ?></span>
			<?php endif; ?>
            <span class="icon">
              <i class="<?php echo esc_attr( $this->get_data( 'font_icon' ) ); ?>"></i>
            </span>
			<?php if ( $this->get_data( 'icon_position' ) == 'left' ): ?>
                <span class="btn-label"><?php echo esc_attr( $this->get_data( 'label' ) ); ?></span>
			<?php endif; ?>
		<?php else : ?>
            <span class="btn-label"><?php echo esc_attr( $this->get_data( 'label' ) ); ?></span>
		<?php endif; ?>
		<?php
		echo ' </a>';
		echo '</div>';
	}

	public function content_template() {
		?>
        <#
        let is_fullwidth = '';
        if(elmn_data.align === 'justified'){ is_fullwidth = 'is-fullwidth'; }
        let btn_id = '';
        if(elmn_data.id) { btn_id = 'id="'+elmn_data.id+'"'; }
        #>
        <div {{ btn_id }} class="lwwb-elmn-heading <# if(elmn_data.align) { #> has-text-{{ elmn_data.align }} <# } #>">
            <a class="button {{elmn_data.type}} {{elmn_data.button_size}} {{elmn_data.button_style}} {{is_fullwidth}}"
               href="{{ elmn_data.link }}">
                <# if(elmn_data.font_icon != '') {#>
                <# if(elmn_data.icon_position === 'right') {#>
                <span class="btn-label">{{ elmn_data.label }}</span>
                <# } #>
                <span class="icon">
                              <i class="{{ elmn_data.font_icon }}"></i>
                            </span>
                <# if(elmn_data.icon_position === 'left') {#>
                <span class="btn-label">{{ elmn_data.label }}</span>
                <# } #>
                <# }else{ #>
                <span class="btn-label">{{ elmn_data.label }}</span>
                <# } #>

            </a>

        </div>
		<?php
	}


}