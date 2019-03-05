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

class Spacer extends Elmn{
	public $type = 'spacer';
	public $label = 'Spacer';
	public $key_words = 'spacer,section, basic';
	public $icon = 'fa fa-arrows-v';
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
				'label'        => __( 'Spacer', 'lwwb' ),
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
				'id'            => 'spacer',
				'keywords'      => 'font space font-size spacer',
				'label'         => __('Space', 'lwwb'),
				'type'          => Control::SLIDER,
				'input_type'    => 'number',
				'default'       => array(
					'desktop-value' => '',
					'desktop-unit'  => 'px',
					'tablet-value'  => '',
					'tablet-unit'   => 'px',
					'mobile-value'  => '',
					'mobile-unit'   => 'px',
				),
				'device_config' => array(
					'desktop' => '',
					'tablet'  => '',
					'mobile'  => '',
				),
				'unit'          => array(
					'px' => array(
						'min'  => '0',
						'max'  => '600',
						'step' => '1',
					),
				),
				'css_format'    => 'ELMN_WRAPPER > .lwwb-elmn-content .lwwb-spacer{height:{{ VALUE }}{{ UNIT }};}',
			),
		);
	}

	public function render_content() {
		echo '<span class="lwwb-spacer"></span>';
	}

	public function content_template() {
		echo '<span class="lwwb-spacer"></span>';
	}
}