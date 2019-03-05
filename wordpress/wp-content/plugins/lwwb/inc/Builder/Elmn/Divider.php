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

class Divider extends Elmn {
	public $type = 'divider';
	public $label = 'Divider';
	public $key_words = 'divider,section, basic';
	public $icon = 'fa fa-arrows-h';
	public $group = 'basic';
	public $control_groups = array(
		'content',
		'style',
		'advanced',
		'background',
		'border',
		'responsive',
		'custom_css',
	);

	public function get_tab_control() {
		return array(
			'id'      => 'lwwb_tab_control',
			'label'   => '',
			'default' => 'content',
			'type'    => Control::TAB,
			'choices' => array(
				'content'  => __( 'Content', 'lwwb' ),
				'advanced' => __( 'Advanced', 'lwwb' ),
			),

		);
	}

	public function get_content_group_control() {
		return
			array(
				'id'           => 'lwwb_content_group_control',
				'label'        => __( 'Divider', 'lwwb' ),
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

	public static function get_content_controls() {
		return array(
			array(
				'id'             => 'type',
				'keywords'       => 'title, type, divider, text, link, button, size',
				'label'          => __( 'Style', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'default'        => 'solid',
				'choices'        => array(
					'solid'  => esc_html__( 'Solid', 'lwwb' ),
					'double' => esc_html__( 'Double', 'lwwb' ),
					'dotted' => esc_html__( 'Dotted', 'lwwb' ),
					'dashed' => esc_html__( 'dashed', 'lwwb' ),
				),
				'css_format'     => "ELMN_WRAPPER > .lwwb-elmn-content .lwwb-divider-separator {border-top-style: {{ VALUE }};}",
			),
			array(
				'id'          => 'weight',
				'keywords'    => 'title,weight,height, text, link, button, icon size',
				'label'       => __( 'Weight', 'lwwb' ),
				'type'        => Control::SLIDER,
				'default'     => '1',
				'input_attrs' => array(
					'min'  => '1',
					'max'  => '10',
					'step' => '1',
				),
				'css_format'  => "ELMN_WRAPPER > .lwwb-elmn-content .lwwb-divider-separator {border-top-width: {{ VALUE }}px ;}",
			),
			array(
				'id'         => 'color',
				'keywords'   => 'title,weight,height, text, link, button, icon size',
				'label'      => __( 'Color', 'lwwb' ),
				'type'       => Control::COLOR_PICKER,
				'default'    => '#a7a7a7',
				'css_format' => "ELMN_WRAPPER > .lwwb-elmn-content .lwwb-divider-separator { border-top-color: {{ VALUE }}; }",
			),
			array(
				'id'          => 'border_width',
				'keywords'    => 'title, gap, weight,height, text, link, button, icon size',
				'label'       => __( 'Width', 'lwwb' ),
				'type'        => Control::SLIDER,
				'default'     => '100',
				'input_attrs' => array(
					'min'  => '5',
					'max'  => '1050',
					'step' => '1',
				),
				'css_format'  => "ELMN_WRAPPER > .lwwb-elmn-content .lwwb-divider-separator { width: {{ VALUE }}px ; }",
			),
			array(
				'id'           => 'align',
				'keywords'     => 'title, text, link, button, size',
				'label'        => __( 'Alignment', 'lwwb' ),
				'type'         => Control::BUTTON_SET,
				'display_type' => 'icon',
				'default'      => 'left',
				'choices'      => array(
					'left'   => 'fa fa-align-left',
					'center' => 'fa fa-align-center',
					'right'  => 'fa fa-align-right',
				),
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content {text-align: {{ VALUE }} ;}",
			),
			array(
				'id'          => 'gap',
				'keywords'    => 'title, gap, weight,height, text, link, button, icon size',
				'label'       => __( 'Gap', 'lwwb' ),
				'type'        => Control::SLIDER,
				'default'     => '2',
				'input_attrs' => array(
					'min'  => '2',
					'max'  => '50',
					'step' => '1',
				),
				'css_format'  => "ELMN_WRAPPER > .lwwb-elmn-content { padding-top: {{ VALUE }}px; padding-bottom:{{ VALUE }}px; }",
			),
		);
	}

	public function get_default_data() {
		return array(
			'type'   => 'solid',
		);
	}

	public function render_content() {
		echo '<span class="lwwb-divider-separator"></span>';
	}

	public function content_template() {
		echo '<span class="lwwb-divider-separator"></span>';
	}

}