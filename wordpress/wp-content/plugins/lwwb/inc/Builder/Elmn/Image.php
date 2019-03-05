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

class Image extends Elmn {
	public $type = 'image';
	public $label = 'Image';
	public $icon = 'fa fa-image';
	public $group = 'basic';
	public $key_words = 'image, media';

	public $control_groups = array(
		'content',
		'style',
//        'advanced',
		//        'background',
		//        'border',
		//        'typography',
		//        'responsive',
		//        'custom_css',
	);

	public function enqueue() {
		wp_enqueue_style( 'magnific-popup' );
		wp_enqueue_script( 'magnific-popup' );
	}

	public function get_content_group_control() {
		return
			array(
				'id'           => 'lwwb_content_group_control',
				'label'        => __( 'Image', 'lwwb' ),
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

	public function get_style_group_control() {
		return
			array(
				'id'           => 'lwwb_style_group_control',
				'label'        => __( 'Image', 'lwwb' ),
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

	public static function get_content_controls() {
		return array(
			array( 'type'     => Control::MEDIA_UPLOAD,
			       'label'    => esc_html__( 'Choose Image', 'lwwb' ),
			       'id'       => 'image',
			       'keywords' => 'choose image',
			       'default'  => array( 'url' => '', 'id' => '' ),
			),
			array(
				'type'           => Control::SELECT,
				'label'          => esc_html__( 'Image Size', 'lwwb' ),
				'id'             => 'image_size',
				'keywords'       => 'image size',
				'choices'        => static::get_image_size(),
				'control_layout' => 'inline',
				'dependencies'   => array(
					array(
						'control'  => 'image',
						'operator' => '!==',
						'value'    => array( 'url' => '', 'id' => '' ),
					),
				),
			),
			array(
				'type'          => Control::RESPONSIVE_SWITCHER,
				'label'         => esc_html__( 'Alignment', 'lwwb' ),
				'id'            => 'alignment_rs',
				'device_config' => array( 'desktop' => 'desktop', 'tablet' => 'tablet', 'mobile' => 'mobile', ),
				'dependencies'  => array(
					array(
						'control'  => 'image',
						'operator' => '!==',
						'value'    => array( 'url' => '', 'id' => '' ),
					),
				),
			),
			array(
				'type'         => Control::BUTTON_SET,
				'id'           => 'alignment',
				'keywords'     => 'alignment',
				'choices'      => array(
					'left'   => 'fa fa-align-left',
					'right'  => 'fa fa-align-right',
					'center' => 'fa fa-align-center',
				),
				'display_type' => 'icon',
				'on_device'    => 'desktop',
				'dependencies' => array(
					array(
						'control'  => 'image',
						'operator' => '!==',
						'value'    => array( 'url' => '', 'id' => '' ),
					),
				),
				'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content{text-align:{{ VALUE }};}',
			),
			array(
				'type'         => Control::BUTTON_SET,
				'id'           => '_tablet_alignment',
				'keywords'     => 'alignment',
				'choices'      => array(
					'left'   => 'fa fa-align-left',
					'right'  => 'fa fa-align-right',
					'center' => 'fa fa-align-center',
				),
				'display_type' => 'icon',
				'on_device'    => 'tablet',
				'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content{text-align:{{ VALUE }};}',
			),
			array(
				'type'         => Control::BUTTON_SET,
				'id'           => '_mobile_alignment',
				'keywords'     => 'alignment',
				'choices'      => array(
					'left'   => 'fa fa-align-left',
					'right'  => 'fa fa-align-right',
					'center' => 'fa fa-align-center',
				),
				'display_type' => 'icon',
				'on_device'    => 'mobile',
				'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content{text-align:{{ VALUE }};}',
			),
			array(
				'type'         => Control::SELECT,
				'label'        => esc_html__( 'Caption', 'lwwb' ),
				'id'           => 'caption',
				'keywords'     => 'caption',
				'choices'      => array(
					'none'           => 'None',
					'attachment'     => 'Attachment',
					'custom_caption' => 'Custom Caption',
				),
				'dependencies' => array(
					array(
						'control'  => 'image',
						'operator' => '!==',
						'value'    => array( 'url' => '', 'id' => '' ),
					),
				),
			),
			array(
				'type'         => Control::TEXT,
				'label'        => esc_html__( 'Custom Caption', 'lwwb' ),
				'id'           => 'custom_caption',
				'keywords'     => 'custom caption',
				'dependencies' => array(
					array(
						'control'  => 'caption',
						'operator' => '==',
						'value'    => 'custom_caption',
					),
				),
				'input_type'   => 'text',
			),
			array(
				'type'         => Control::BUTTON_SET,
				'label'        => esc_html__( 'Caption Alignment', 'lwwb' ),
				'id'           => 'caption_alignment',
				'keywords'     => 'caption alignment',
				'choices'      => array(
					'left'    => 'fa fa-align-left',
					'right'   => 'fa fa-align-right',
					'center'  => 'fa fa-align-center',
					'justify' => 'fa fa-align-justify',
				),
				'display_type' => 'icon',
				'dependencies' => array(
					array(
						'control'  => 'caption',
						'operator' => '!==',
						'value'    => 'none',
					),
					array(
						'control'  => 'image',
						'operator' => '!==',
						'value'    => array( 'url' => '', 'id' => '' ),
					),
				),
				'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content figcaption{text-align:{{ VALUE }};}',
			),
			array(
				'type'         => Control::COLOR_PICKER,
				'label'        => esc_html__( 'Caption Color', 'lwwb' ),
				'id'           => 'caption_color',
				'keywords'     => 'caption color',
				'dependencies' => array(
					array(
						'control'  => 'caption',
						'operator' => '!==',
						'value'    => 'none',
					),
					array(
						'control'  => 'image',
						'operator' => '!==',
						'value'    => array( 'url' => '', 'id' => '' ),
					),
				),
				'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content figcaption{color:{{ VALUE }};}',
			),
			array(
				'type'           => Control::SELECT,
				'label'          => esc_html__( 'Link', 'lwwb' ),
				'id'             => 'link',
				'keywords'       => 'link',
				'choices'        => array(
					'none'       => 'None',
					'media_file' => 'Media File',
					'custom_url' => 'Custom URL',
				),
				'control_layout' => 'inline',
				'dependencies'   => array(
					array(
						'control'  => 'image',
						'operator' => '!==',
						'value'    => array( 'url' => '', 'id' => '' ),
					),
				),
				'input_type'     => 'text',
			),
			array(
				'type'           => Control::SELECT,
				'label'          => esc_html__( 'Lightbox', 'lwwb' ),
				'id'             => 'lightbox',
				'keywords'       => 'lightbox',
				'choices'        => array(
					'default' => 'Default',
					'yes'     => 'Yes',
					'no'      => 'No',
				),
				'control_layout' => 'inline',
				'dependencies'   => array(
					array(
						'control'  => 'link',
						'operator' => '==',
						'value'    => 'media_file',
					),
				),
			),
			array(
				'type'         => Control::TEXT,
				'label'        => esc_html__( 'Custom URL', 'lwwb' ),
				'id'           => 'custom_url',
				'keywords'     => 'custom url',
				'dependencies' => array(
					array(
						'control'  => 'link',
						'operator' => '==',
						'value'    => 'custom_url',
					),
				),
				'input_type'   => 'text',
				'placeholder'  => ' Insert your link',
			),
			array(
				'type'           => Control::SELECT,
				'label'          => esc_html__( 'Link Target', 'lwwb' ),
				'id'             => 'link_target',
				'keywords'       => 'link target',
				'choices'        => static::get_link_target(),
				'control_layout' => 'inline',
				'dependencies'   => array(
					array(
						'control'  => 'link',
						'operator' => '==',
						'value'    => 'custom_url',
					),
					array(
						'control'  => 'custom_url',
						'operator' => '!==',
						'value'    => '',
					),
				),
			),
			array(
				'type'           => Control::SWITCHER,
				'label'          => esc_html__( 'No Follow?', 'lwwb' ),
				'id'             => 'no_follow',
				'keywords'       => 'nofollow',
				'control_layout' => 'inline',
				'dependencies'   => array(
					array(
						'control'  => 'link',
						'operator' => '==',
						'value'    => 'custom_url',
					),
					array(
						'control'  => 'custom_url',
						'operator' => '!==',
						'value'    => '',
					),
				),
			),
		);
	

	}

	public function get_default_data() {
		return array(
			'image'          => array(
				'url' => '',
				'id'  => '',
			),
			'caption_type'   => 'none',
			'image_size'     => 'full',
			'image_lightbox' => 'yes',
		);
	}

	public static function get_style_controls() {


		return array(
			array( 'type'          => Control::RESPONSIVE_SWITCHER,
			       'label'         => esc_html__( 'Width', 'lwwb' ),
			       'id'            => 'width_rs',
			       'device_config' => array( 'desktop' => 'desktop', 'tablet' => 'tablet', 'mobile' => 'mobile', ),
			),
			array(
				'type'        => Control::SLIDER,
				'id'          => 'width',
				'keywords'    => 'width',
				'on_device'   => 'desktop',
				'input_attrs' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'css_format'  => "ELMN_WRAPPER > .lwwb-elmn-content > img { width:{{ VALUE }}%; }",
			),
			array(
				'type'        => Control::SLIDER,
				'id'          => '_tablet_width',
				'keywords'    => 'width',
				'on_device'   => 'tablet',
				'input_attrs' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'css_format'  => "ELMN_WRAPPER > .lwwb-elmn-content > img { width:{{ VALUE }}%; }",
			),
			array(
				'type'        => Control::SLIDER,
				'id'          => '_mobile_width',
				'keywords'    => 'width',
				'on_device'   => 'mobile',
				'input_attrs' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'css_format'  => "ELMN_WRAPPER > .lwwb-elmn-content > img { width:{{ VALUE }}%; }",
			),
			array( 'type'          => Control::RESPONSIVE_SWITCHER,
			       'label'         => esc_html__( 'Max Width', 'lwwb' ),
			       'id'            => 'max_width_rs',
			       'device_config' => array( 'desktop' => 'desktop', 'tablet' => 'tablet', 'mobile' => 'mobile', ),
			),
			array(
				'type'        => Control::SLIDER,
				'id'          => 'max_width',
				'keywords'    => 'max width',
				'on_device'   => 'desktop',
				'input_attrs' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'css_format'  => "ELMN_WRAPPER > .lwwb-elmn-content > img { max-width:{{ VALUE }}%; }",
			),
			array(
				'type'        => Control::SLIDER,
				'id'          => '_tablet_max_width',
				'keywords'    => 'max width',
				'on_device'   => 'tablet',
				'input_attrs' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'css_format'  => "ELMN_WRAPPER > .lwwb-elmn-content > img { max-width:{{ VALUE }}%; }",
			),
			array(
				'type'        => Control::SLIDER,
				'id'          => '_mobile_max_width',
				'keywords'    => 'max width',
				'on_device'   => 'mobile',
				'input_attrs' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'css_format'  => "ELMN_WRAPPER > .lwwb-elmn-content > img { max-width:{{ VALUE }}%; }",
			),
			array(
				'type'     => Control::BUTTON_SET,
				'id'       => 'state_switcher',
				'keywords' => 'state switcher',
				'choices'  => array(
					'normal' => __( 'Normal', 'lwwb' ),
					'hover'  => __( 'Hover', 'lwwb' ),
				),
			),
			array(
				'type'         => Control::SLIDER,
				'label'        => esc_html__( 'Opacity', 'lwwb' ),
				'id'           => 'opacity',
				'keywords'     => 'opacity',
				'dependencies' => array(
					array(
						'control'  => 'state_switcher',
						'operator' => '===',
						'value'    => 'normal',
					),
				),
				'input_attrs'  => array(
					'min'  => '0.1',
					'max'  => '1',
					'step' => '0.01',
				),
				'css_format'   => "ELMN_WRAPPER >.lwwb-elmn-content{ opacity:{{ VALUE }}; }",
			),
			array(
				'type'         => Control::MODAL,
				'label'        => esc_html__( 'CSS Filters', 'lwwb' ),
				'id'           => 'css_filters',
				'keywords'     => 'css filters',
				'dependencies' => array(
					array(
						'control'  => 'state_switcher',
						'operator' => '===',
						'value'    => 'normal',
					),
				),
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content{filter: brightness( {{ BRIGHTNESS }}% ) contrast( {{ CONTRAST }}% ) saturate( {{ SATURATION }}% ) blur( {{ BLUR }}px ) hue-rotate( {{ HUE }}deg ) ;}",
				'fields'       => array(
					array(
						'type'        => Control::SLIDER,
						'label'       => esc_html__( 'Blur', 'lwwb' ),
						'id'          => 'blur',
						'keywords'    => 'blur',
						'input_attrs' => array(
							'min'  => '0',
							'max'  => '10',
							'step' => '0.1',
						),
					),
					array(
						'type'        => Control::SLIDER,
						'label'       => esc_html__( 'Brightness', 'lwwb' ),
						'id'          => 'brightness',
						'keywords'    => 'brightness',
						'input_attrs' => array(
							'min'  => '1',
							'max'  => '100',
							'step' => '1',
						),
					),
					array(
						'type'        => Control::SLIDER,
						'label'       => esc_html__( 'Contrast', 'lwwb' ),
						'id'          => 'contrast',
						'keywords'    => 'contrast',
						'input_attrs' => array(
							'min'  => '1',
							'max'  => '100',
							'step' => '1',
						),
					),
					array(
						'type'        => Control::SLIDER,
						'label'       => esc_html__( 'Saturation', 'lwwb' ),
						'id'          => 'saturation',
						'keywords'    => 'saturation',
						'input_attrs' => array(
							'min'  => '1',
							'max'  => '100',
							'step' => '1',
						),
					),
					array(
						'type'        => Control::SLIDER,
						'label'       => esc_html__( 'Hue', 'lwwb' ),
						'id'          => 'hue',
						'keywords'    => 'hue',
						'input_attrs' => array(
							'min'  => '1',
							'max'  => '100',
							'step' => '1',
						),
					),
				),
			),
			array(
				'type'           => Control::SELECT,
				'label'          => esc_html__( 'Border Type', 'lwwb' ),
				'id'             => 'border_type',
				'keywords'       => 'border type',
				'choices'        => static::get_border_type(),
				'control_layout' => 'inline',
				'dependencies'   => array(
					array(
						'control'  => 'state_switcher',
						'operator' => '===',
						'value'    => 'normal',
					),
				),
				'css_format'     => 'ELMN_WRAPPER > .lwwb-elmn-content{border-style:{{ VALUE }};}',
			),
			array(
				'type'          => Control::RESPONSIVE_SWITCHER,
				'label'         => esc_html__( 'Border Radius', 'lwwb' ),
				'id'            => 'border_radius_rs',
				'device_config' => array( 'desktop' => 'desktop', 'tablet' => 'tablet', 'mobile' => 'mobile', ),
				'dependencies'  => array(
					array(
						'control'  => 'state_switcher',
						'operator' => '===',
						'value'    => 'normal',
					),
				),
			),
			array(
				'type'         => Control::DIMENSIONS,
				'id'           => 'border_radius',
				'keywords'     => 'border radius',
				'on_device'    => 'desktop',
				'dependencies' => array(
					array(
						'control'  => 'state_switcher',
						'operator' => '===',
						'value'    => 'normal',
					),
				),
				'unit'         => array(
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
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content{border-radius: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",
				'options'      => array( 'top'    => esc_html__( 'Top', 'lwwb' ),
				                         'right'  => esc_html__( 'Right', 'lwwb' ),
				                         'bottom' => esc_html__( 'Bottom', 'lwwb' ),
				                         'left'   => esc_html__( 'Left', 'lwwb' ),
				),
			),
			array(
				'type'       => Control::DIMENSIONS,
				'id'         => '_tablet_border_radius',
				'keywords'   => 'border radius',
				'on_device'  => 'tablet',
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
				'css_format' => "ELMN_WRAPPER > .lwwb-elmn-content{border-radius: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",
				'options'    => array( 'top'    => esc_html__( 'Top', 'lwwb' ),
				                       'right'  => esc_html__( 'Right', 'lwwb' ),
				                       'bottom' => esc_html__( 'Bottom', 'lwwb' ),
				                       'left'   => esc_html__( 'Left', 'lwwb' ),
				),
			),
			array(
				'type'       => Control::DIMENSIONS,
				'id'         => '_mobile_border_radius',
				'keywords'   => 'border radius',
				'on_device'  => 'mobile',
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
				'css_format' => "ELMN_WRAPPER > .lwwb-elmn-content{border-radius: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",
				'options'    => array( 'top'    => esc_html__( 'Top', 'lwwb' ),
				                       'right'  => esc_html__( 'Right', 'lwwb' ),
				                       'bottom' => esc_html__( 'Bottom', 'lwwb' ),
				                       'left'   => esc_html__( 'Left', 'lwwb' ),
				),
			),
			array(
				'type'         => Control::MODAL,
				'label'        => esc_html__( 'Box Shadow', 'lwwb' ),
				'id'           => 'box_shadow',
				'keywords'     => 'box shadow',
				'dependencies' => array(
					array(
						'control'  => 'state_switcher',
						'operator' => '===',
						'value'    => 'normal',
					),
				),
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content{box-shadow: {{ HORIZONTAL }}px {{ VERTICAL }}px {{ BLUR }}px {{ SPREAD }}px {{ COLOR }}  {{ POSITION }}  ;}",
				'fields'       => array(
					array( 'type'     => Control::COLOR_PICKER,
					       'label'    => esc_html__( 'Color', 'lwwb' ),
					       'id'       => 'color',
					       'keywords' => 'color',
					),
					array(
						'type'        => Control::SLIDER,
						'label'       => esc_html__( 'Blur', 'lwwb' ),
						'id'          => 'blur',
						'keywords'    => 'blur',
						'input_attrs' => array(
							'min'  => '0',
							'max'  => '10',
							'step' => '0.1',
						),
					),
					array(
						'type'        => Control::SLIDER,
						'label'       => esc_html__( 'Horizontal', 'lwwb' ),
						'id'          => 'horizontal',
						'keywords'    => 'horizontal',
						'input_attrs' => array(
							'min'  => '-100',
							'max'  => '100',
							'step' => '1',
						),
					),
					array(
						'type'        => Control::SLIDER,
						'label'       => esc_html__( 'Vertical', 'lwwb' ),
						'id'          => 'vertical',
						'keywords'    => 'vertical',
						'input_attrs' => array(
							'min'  => '-100',
							'max'  => '100',
							'step' => '1',
						),
					),
					array(
						'type'        => Control::SLIDER,
						'label'       => esc_html__( 'Spread', 'lwwb' ),
						'id'          => 'spread',
						'keywords'    => 'spread',
						'input_attrs' => array(
							'min'  => '-100',
							'max'  => '100',
							'step' => '1',
						),
					),
					array(
						'type'        => Control::SELECT,
						'label'       => esc_html__( 'Position', 'lwwb' ),
						'id'          => 'position',
						'keywords'    => 'position ',
						'choices'     => array(
							''      => esc_html__( 'Outline', 'lwwb' ),
							'inset' => esc_html__( 'Inset', 'lwwb' ),
						),
						'input_attrs' => array(
							'min'  => '-100',
							'max'  => '100',
							'step' => '1',
						),
					),
				),
			),
			array(
				'type'         => Control::SLIDER,
				'label'        => esc_html__( 'Opacity', 'lwwb' ),
				'id'           => 'opacity_hover',
				'keywords'     => 'opacity',
				'dependencies' => array(
					array(
						'control'  => 'state_switcher',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
				'input_attrs'  => array(
					'min'  => '0.1',
					'max'  => '1',
					'step' => '0.01',
				),
				'css_format'   => "ELMN_WRAPPER:hover >.lwwb-elmn-content{ opacity:{{ VALUE }}; }",
			),
			array(
				'type'         => Control::MODAL,
				'label'        => esc_html__( 'CSS Filters', 'lwwb' ),
				'id'           => 'css_filters_hover',
				'keywords'     => 'css filters',
				'dependencies' => array(
					array(
						'control'  => 'state_switcher',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content{filter: brightness( {{ BRIGHTNESS }}% ) contrast( {{ CONTRAST }}% ) saturate( {{ SATURATION }}% ) blur( {{ BLUR }}px ) hue-rotate( {{ HUE }}deg ) ;}",
				'fields'       => array(
					array(
						'type'        => Control::SLIDER,
						'label'       => esc_html__( 'Blur', 'lwwb' ),
						'id'          => 'blur',
						'keywords'    => 'blur',
						'input_attrs' => array(
							'min'  => '0',
							'max'  => '10',
							'step' => '0.1',
						),
					),
					array(
						'type'        => Control::SLIDER,
						'label'       => esc_html__( 'Brightness', 'lwwb' ),
						'id'          => 'brightness',
						'keywords'    => 'brightness',
						'input_attrs' => array(
							'min'  => '1',
							'max'  => '100',
							'step' => '1',
						),
					),
					array(
						'type'        => Control::SLIDER,
						'label'       => esc_html__( 'Contrast', 'lwwb' ),
						'id'          => 'contrast',
						'keywords'    => 'contrast',
						'input_attrs' => array(
							'min'  => '1',
							'max'  => '100',
							'step' => '1',
						),
					),
					array(
						'type'        => Control::SLIDER,
						'label'       => esc_html__( 'Saturation', 'lwwb' ),
						'id'          => 'saturation',
						'keywords'    => 'saturation',
						'input_attrs' => array(
							'min'  => '1',
							'max'  => '100',
							'step' => '1',
						),
					),
					array(
						'type'        => Control::SLIDER,
						'label'       => esc_html__( 'Hue', 'lwwb' ),
						'id'          => 'hue',
						'keywords'    => 'hue',
						'input_attrs' => array(
							'min'  => '1',
							'max'  => '100',
							'step' => '1',
						),
					),
				),
			),
			array(
				'type'           => Control::SELECT,
				'label'          => esc_html__( 'Border Type', 'lwwb' ),
				'id'             => 'border_type_hover',
				'keywords'       => 'border type',
				'choices'        => static::get_border_type(),
				'control_layout' => 'inline',
				'dependencies'   => array(
					array(
						'control'  => 'state_switcher',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
				'css_format'     => 'ELMN_WRAPPER > .lwwb-elmn-content:hover{border-style:{{ VALUE }};}',
			),
			array(
				'type'          => Control::RESPONSIVE_SWITCHER,
				'label'         => esc_html__( 'Border Radius', 'lwwb' ),
				'id'            => 'border_radius_rs_hover',
				'device_config' => array( 'desktop' => 'desktop', 'tablet' => 'tablet', 'mobile' => 'mobile', ),
				'dependencies'  => array(
					array(
						'control'  => 'state_switcher',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
			),
			array(
				'type'         => Control::DIMENSIONS,
				'id'           => 'border_radius_hover',
				'keywords'     => 'border radius',
				'on_device'    => 'desktop',
				'dependencies' => array(
					array(
						'control'  => 'state_switcher',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
				'unit'         => array(
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
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content:hover{border-radius: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",
				'options'      => array( 'top'    => esc_html__( 'Top', 'lwwb' ),
				                         'right'  => esc_html__( 'Right', 'lwwb' ),
				                         'bottom' => esc_html__( 'Bottom', 'lwwb' ),
				                         'left'   => esc_html__( 'Left', 'lwwb' ),
				),
			),
			array(
				'type'       => Control::DIMENSIONS,
				'id'         => '_tablet_border_radius_hover',
				'keywords'   => 'border radius',
				'on_device'  => 'tablet',
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
				'css_format' => "ELMN_WRAPPER > .lwwb-elmn-content:hover{border-radius: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",
				'options'    => array( 'top'    => esc_html__( 'Top', 'lwwb' ),
				                       'right'  => esc_html__( 'Right', 'lwwb' ),
				                       'bottom' => esc_html__( 'Bottom', 'lwwb' ),
				                       'left'   => esc_html__( 'Left', 'lwwb' ),
				),
			),
			array(
				'type'       => Control::DIMENSIONS,
				'id'         => '_mobile_border_radius_hover',
				'keywords'   => 'border radius',
				'on_device'  => 'mobile',
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
				'css_format' => "ELMN_WRAPPER > .lwwb-elmn-content:hover{border-radius: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",
				'options'    => array( 'top'    => esc_html__( 'Top', 'lwwb' ),
				                       'right'  => esc_html__( 'Right', 'lwwb' ),
				                       'bottom' => esc_html__( 'Bottom', 'lwwb' ),
				                       'left'   => esc_html__( 'Left', 'lwwb' ),
				),
			),
			array(
				'type'         => Control::MODAL,
				'label'        => esc_html__( 'Box Shadow', 'lwwb' ),
				'id'           => 'box_shadow_hover',
				'keywords'     => 'box shadow',
				'dependencies' => array(
					array(
						'control'  => 'state_switcher',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content:hover{box-shadow: {{ HORIZONTAL }}px {{ VERTICAL }}px {{ BLUR }}px {{ SPREAD }}px {{ COLOR }}  {{ POSITION }}  ;}",
				'fields'       => array(
					array( 'type'     => Control::COLOR_PICKER,
					       'label'    => esc_html__( 'Color', 'lwwb' ),
					       'id'       => 'color',
					       'keywords' => 'color',
					),
					array(
						'type'        => Control::SLIDER,
						'label'       => esc_html__( 'Blur', 'lwwb' ),
						'id'          => 'blur',
						'keywords'    => 'blur',
						'input_attrs' => array(
							'min'  => '0',
							'max'  => '10',
							'step' => '0.1',
						),
					),
					array(
						'type'        => Control::SLIDER,
						'label'       => esc_html__( 'Horizontal', 'lwwb' ),
						'id'          => 'horizontal',
						'keywords'    => 'horizontal',
						'input_attrs' => array(
							'min'  => '-100',
							'max'  => '100',
							'step' => '1',
						),
					),
					array(
						'type'        => Control::SLIDER,
						'label'       => esc_html__( 'Vertical', 'lwwb' ),
						'id'          => 'vertical',
						'keywords'    => 'vertical',
						'input_attrs' => array(
							'min'  => '-100',
							'max'  => '100',
							'step' => '1',
						),
					),
					array(
						'type'        => Control::SLIDER,
						'label'       => esc_html__( 'Spread', 'lwwb' ),
						'id'          => 'spread',
						'keywords'    => 'spread',
						'input_attrs' => array(
							'min'  => '-100',
							'max'  => '100',
							'step' => '1',
						),
					),
					array(
						'type'        => Control::SELECT,
						'label'       => esc_html__( 'Position', 'lwwb' ),
						'id'          => 'position',
						'keywords'    => 'position ',
						'choices'     => array(
							''      => esc_html__( 'Outline', 'lwwb' ),
							'inset' => esc_html__( 'Inset', 'lwwb' ),
						),
						'input_attrs' => array(
							'min'  => '-100',
							'max'  => '100',
							'step' => '1',
						),
					),
				),
			),
			array(
				'type'         => Control::SLIDER,
				'label'        => esc_html__( 'Transition Duration', 'lwwb' ),
				'id'           => 'transition_duration',
				'keywords'     => 'transition duration',
				'dependencies' => array(
					array(
						'control'  => 'state_switcher',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
				'input_attrs'  => array(
					'min'  => '0',
					'max'  => '3',
					'step' => '0.1',
				),
			),
			array(
				'type'         => Control::SELECT2,
				'label'        => esc_html__( 'Hover Animation', 'lwwb' ),
				'id'           => 'hover_animation',
				'keywords'     => 'hover_animation',
				'choices'      => static::get_hover_animation(),
				'dependencies' => array(
					array(
						'control'  => 'state_switcher',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
			),
		);
	}

	public static function get_border_type() {
		return array(
			'none'   => __( 'None', 'lwwb' ),
			'solid'  => __( 'Solid', 'lwwb' ),
			'double' => __( 'Double', 'lwwb' ),
			'dotted' => __( 'Dotted', 'lwwb' ),
			'dashed' => __( 'Dashed', 'lwwb' ),
			'groove' => __( 'Groove', 'lwwb' ),
		);
	}

	public static function get_link_target() {
		return Default_Elmn_Controls::get_link_target();
	}

	public static function get_hover_animation() {

	}

	public static function get_position() {
		return array(
			'none'   => __( 'None', 'lwwb' ),
			'left'   => __( 'Left', 'lwwb' ),
			'center' => __( 'Center', 'lwwb' ),
			'right'  => __( 'Right', 'lwwb' ),
		);
	}

	public static function get_caption() {
		return array(
			'none'               => __( 'None', 'lwwb' ),
			'attachment_caption' => __( 'Attachment caption', 'lwwb' ),
			'custom_caption'     => __( 'Custom caption', 'lwwb' ),
		);
	}

	public static function get_link_to() {
		return array(
			'none'       => __( 'None', 'lwwb' ),
			'media_file' => __( 'Media file', 'lwwb' ),
			'custom_url' => __( 'Custom url', 'lwwb' ),
		);
	}

	public static function get_alignment() {
		return array(
			'left'   => 'fa fa-align-left',
			'center' => 'fa fa-align-center',
			'right'  => 'fa fa-align-right',
		);
	}

	public static function get_image_size() {
		global $_wp_additional_image_sizes;

		$default_image_sizes = [ 'thumbnail', 'medium', 'large', 'full' ];

		$image_sizes = [];

		foreach ( $default_image_sizes as $size ) {
			$image_sizes[ $size ] = [
				'width'  => (int) get_option( $size . '_size_w' ),
				'height' => (int) get_option( $size . '_size_h' ),
				'crop'   => (bool) get_option( $size . '_crop' ),
			];
		}

		if ( $_wp_additional_image_sizes ) {
			$image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
		}

		foreach ( $image_sizes as $size => $image ) {
			$image_sizes[ $size ] = ucfirst( $size ) . ' - (' . $image['width'] . '&times; ' . $image['height'] . ')';
		}
		$image_sizes['full'] = 'Full';

		return $image_sizes;
	}

	public function render_content() {

		$img_id = $this->get_data( 'image' )['id'];
		$url    = '<a href="' . $this->get_data( 'image' )['url'] . '">';
		if ( $this->get_data( 'link_to' ) === 'media_file' ) {
			if ( $this->get_data( 'image_lightbox' ) == 'no' ) {
				$url = '<a href="' . $this->get_data( 'image' )['url'] . '">';
			} else {
				$url = '<a href="' . $this->get_data( 'image' )['url'] . '" class="lwwb-image" >';

			}
		} elseif ( $this->get_data( 'link_to' ) == 'custom_url' || $this->get_data( 'custom_image_link_to' ) != '' ) {
			$url = '<a href="' . $this->get_data( 'custom_image_link_to' ) . '">';
		}

		if ( $this->get_data( 'link_to' ) !== 'none' ) {
			echo $url;
		}
		$animationClass = '';
		if ( $this->get_data( 'image_hover_animation' ) !== '' ) {
			$animationClass = 'lwwb-animation-' . $this->get_data( 'image_hover_animation' );
		}

		echo $this->get_html_image_by_id( $img_id, $animationClass );
		if ( $this->get_data( 'link_to' ) != 'none' ) {
			echo '</a>';
		}
		if ( $this->get_data( 'caption_type' ) != 'none' ) {
			if ( $this->get_data( 'caption_type' ) === 'attachment_caption' ) {
				$caption = wp_get_attachment_caption( $img_id );
			} else {
				$caption = $this->get_data( 'image_custom_caption' );
			}
			echo '<figcaption>' . $caption . '</figcaption>';
		}
	}

	public function content_template() {
		?>
        <#
        var getAttachmentData = function() {
        let id = elmn_data.image.id;
        let url = elmn_data.image.url;
        if (!id) {
        return '';
        }
        if('undefined' === typeof wp.media.attachment(id).get('caption')){
        wp.media.attachment(id).fetch().then(function(data) {
        view.render();
        });
        }
        return {
        caption: wp.media.attachment(id).get('caption'),
        alt: wp.media.attachment(id).get('alt'),
        title: wp.media.attachment(id).get('title'),
        sizes: wp.media.attachment(id).get('sizes')
        };
        }
        var attachmentData = getAttachmentData();
        var getUrlImageBySize = function() {
        var dataSize = elmn_data.image_size,url='';
        if (elmn_data.image_size === 'full') {
        url = elmn_data.image.url;
        }
        _.each(attachmentData.sizes, function(v, k) {
        if (k === dataSize & 'undefined' !== typeof dataSize) {
        url = v.url;
        }
        });
        if (typeof url !== 'undefined') {
        return url;
        }
        }
        var getUrlImageBySize = function() {
        let dataSize = elmn_data.image_size;
        let url= elmn_data.image.url;

        _.each(attachmentData.sizes, function(v, k) {
        if (k === dataSize & 'undefined' !== typeof dataSize) {
        url = v.url;
        }
        });
        if (typeof url !== 'undefined') {
        return url;
        }
        }
        var getAtachmentDataByKey = function(dataKey) {
        if (dataKey === 'caption') {
        return 'custom_caption' === elmn_data.caption_type ? elmn_data.image_custom_caption : attachmentData.caption;
        } else {
        return attachmentData[dataKey]
        }
        }
        #>
        <# if(elmn_data.image.url === '') { #>
        <div class="lwwb-image-placeholder"><i class="fa fa-2x fa-image"></i></div>
        <# } else { #>
        <# if('custom_url' === elmn_data.link_to) { #>
        <a href="{{ elmn_data.custom_image_link_to }}"><img src="{{{ getUrlImageBySize() }}}"
                                                            title="{{{ getAtachmentDataByKey('title') }}}"
                                                            alt="{{{ getAtachmentDataByKey('alt') }}}"/> </a>
        <# }else if('media_file' === elmn_data.link_to ){ #>
        <# if('yes' === elmn_data.image_lightbox) { #>
        <a href="{{ elmn_data.image.url }}" class="lwwb-image"><img src="{{{ getUrlImageBySize() }}}"
                                                                    title="{{{ getAtachmentDataByKey('title') }}}"
                                                                    alt="{{{ getAtachmentDataByKey('alt') }}}"/> </a>
        <# }else{ #>
        <a href="{{ elmn_data.image.url }}"><img src="{{{ getUrlImageBySize() }}}"
                                                 title="{{{ getAtachmentDataByKey('title') }}}"
                                                 alt="{{{ getAtachmentDataByKey('alt') }}}"/> </a>
        <# } #>
        <# }else{ #>
        <img src="{{{ getUrlImageBySize() }}}" title="{{{ getAtachmentDataByKey('title') }}}"
             alt="{{{ getAtachmentDataByKey('alt') }}}"/>
        <# } #>
        <# if(elmn_data.caption_type != 'none') { #>
        <figcaption>{{{ getAtachmentDataByKey('caption') }}}</figcaption>
        <# } #>
        <# } #>
		<?php
	}

	public function get_html_image_by_id( $id, $animationClass ) {
		$image_class = '';
		$size        = $this->get_data( 'image_size' );
		$image_class .= " attachment-$size size-$size";
		$image_class .= " " . $animationClass;
		$image_attr  = array( 'class' => trim( $image_class ) );
		$html        = wp_get_attachment_image( $id, $size, false, $image_attr );

		return $html;
	}

}
