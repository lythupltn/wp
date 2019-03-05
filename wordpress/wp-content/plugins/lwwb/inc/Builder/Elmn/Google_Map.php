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

class Google_Map extends Elmn {
	public $type = 'google_map';
	public $label = 'Google Map';
	public $key_words = 'map, google map basic, location';
	public $icon = 'fa fa-map-o';
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

	public function get_content_group_control() {
		return
			array(
				'id'           => 'lwwb_content_group_control',
				'label'        => __( 'Map', 'lwwb' ),
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
				'id'         => 'address',
				'keywords'   => 'location address google maps map goo',
				'label'      => __( 'Address', 'lwwb' ),
				'input_type' => 'text',
				'type'       => Control::TEXT,
				'default'    => esc_html__( 'London Eye, London, United Kingdom', 'lwwb' ),
			),
			array(
				'id'       => 'divider',
				'keywords' => 'location divider google maps map goo',
				'type'     => Control::DIVIDER,
			),
			array(
				'id'          => 'zoom',
				'keywords'    => 'location zoom google maps map goo',
				'label'       => __( 'Zoom', 'lwwb' ),
				'default'     => '10',
				'type'        => Control::SLIDER,
				'input_attrs' => array(
					'min'  => '1',
					'max'  => '20',
					'step' => '1',
				),
			),
			array(
				'id'          => 'map_height',
				'keywords'    => 'location zoom google maps map goo',
				'label'       => __( 'Height', 'lwwb' ),
				'default'     => '300',
				'type'        => Control::SLIDER,
				'input_attrs' => array(
					'min'  => '100',
					'max'  => '1000',
					'step' => '1',
				),
				'css_format'  => "ELMN_WRAPPER > .lwwb-elmn-content iframe { height:{{ VALUE }}px }",
			),
			array(
				'id'             => 'prevent_scroll',
				'keywords'       => 'image position, media',
				'label'          => __( 'Prevent Scroll', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'default'        => 'none',
				'choices'        => array(
					'none' => esc_html__( 'Yes', 'Lwwb' ),
					'auto' => esc_html__( 'No', 'Lwwb' ),
				),
				'css_format'     => "ELMN_WRAPPER > .lwwb-elmn-content iframe{ pointer-events:{{ VALUE }}; }",
			),
		);
	}
	public function get_style_group_control() {
		return
			array(
				'id'           => 'lwwb_style_group_control',
				'label'        => __( 'Map', 'lwwb' ),
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

	public static  function get_style_controls(  ) {
        return array(
	        array(
		        'id'       => 'map_style_state',
		        'keywords' => 'icon state normal hover',
		        'label'    => __( '', 'lwwb' ),
		        'default'  => 'normal',
		        'type'     => Control::BUTTON_SET,
		        'choices'  => array(
			        'normal' => __( 'Normal', 'lwwb' ),
			        'hover'  => __( 'Hover', 'lwwb' ),
		        ),
	        ),
	        // Normal
	        array(
		        'id'           => 'css_filter_normal',
		        'keywords'     => '',
		        'label'        => __('CSS Filters', 'lwwb'),
		        'type'         => Control::MODAL,
		        'button_icon'  => 'fa fa-pencil',
		        'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content iframe {filter: brightness( {{ BRIGHTNESS }}% ) contrast( {{ CONTRAST }}% ) saturate( {{ SATURATION }}% ) blur( {{ BLUR }}px ) hue-rotate( {{ HUE }}deg ) ;}",
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
				        'label'       => __('Brightness', 'lwwb'),
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
				        'label'       => __('Contrast', 'lwwb'),
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
				        'label'       => __('Saturation', 'lwwb'),
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
				        'label'       => __('Hue', 'lwwb'),
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
				        'control'  => 'map_style_state',
				        'operator' => '===',
				        'value'    => 'normal',
			        ),
		        ),
	        ),
	        // Hover
	        array(
		        'id'           => 'css_filter_hover',
		        'keywords'     => '',
		        'label'        => __('CSS Filters', 'lwwb'),
		        'type'         => Control::MODAL,
		        'button_icon'  => 'fa fa-pencil',
		        'css_format'   => "ELMN_WRAPPER:hover > .lwwb-elmn-content iframe{filter: brightness( {{ BRIGHTNESS }}% ) contrast( {{ CONTRAST }}% ) saturate( {{ SATURATION }}% ) blur( {{ BLUR }}px ) hue-rotate( {{ HUE }}deg ) ;}",
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
				        'label'       => __('Brightness', 'lwwb'),
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
				        'label'       => __('Contrast', 'lwwb'),
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
				        'label'       => __('Saturation', 'lwwb'),
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
				        'label'       => __('Hue', 'lwwb'),
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
				        'control'  => 'map_style_state',
				        'operator' => '===',
				        'value'    => 'hover',
			        ),
		        ),
	        ),
        );
	}

	public function get_default_data() {
		return array(
			'address'        => esc_html__( 'London Eye, London, United Kingdom', 'lwwb' ),
			'zoom'           => '10',
			'prevent_scroll' => 'none',
		);
	}

	public function render_content() {
		$address = $this->get_data( 'address' ) ? $this->get_data( 'address' ) : '';
		$zoom    = ( $this->get_data( 'zoom' ) != '' ) ? $this->get_data( 'zoom' ) : '10';

		printf(
			'<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=%s&amp;t=m&amp;z=%d&amp;output=embed&amp;iwloc=near" aria-label="%s"></iframe>',
			rawurlencode( $address ),
			absint( $zoom ),
			esc_attr( $address )
		);
		?>
		<?php
	}

	public function content_template() {
		?>
        <#
        let address = encodeURIComponent(elmn_data.address);
        #>
        <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                src="https://maps.google.com/maps?q={{ address }}&amp;t=m&amp;z={{ elmn_data.zoom }}&amp;output=embed&amp;iwloc=near"
                aria-label="{{ elmn_data.location }}"></iframe>
		<?php
	}

}