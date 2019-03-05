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
use Lwwb\Customizer\Control_Manager as Control;

class Icon extends Elmn {
	public $type = 'icon';
	public $label = 'Icon';
	public $key_words = 'icon, basic, font icon';
	public $icon = 'fa fa-empire';
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

	public function enqueue(  ) {
		wp_enqueue_style( 'animated' );
		wp_enqueue_style( 'animations.min' );
	}
	public function get_content_group_control() {
		return
			array(
				'id'           => 'lwwb_content_group_control',
				'label'        => __( 'Icon', 'lwwb' ),
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
				'id'          => 'icon',
				'keywords'    => 'icon picker',
				'default'     => 'fa fa-youtube',
				'label'       => __( 'Icon', 'lwwb' ),
				'description' => __( 'Icon picker control description', 'lwwb' ),
				'type'        => Control::ICON_PICKER,
			),
			array(
				'id'             => 'icon_view',
				'label'          => __( 'View', 'lwwb' ),
				'default'        => 'default',
				'control_layout' => 'inline',
				'type'           => Control::SELECT,
				'choices'        => array(
					'default' => __( 'Default', 'lwwb' ),
					'stacked' => __( 'Stacked', 'lwwb' ),
					'framed'  => __( 'Framed', 'lwwb' ),
				),
			),
			array(
				'id'             => 'icon_shape',
				'label'          => __( 'Shape', 'lwwb' ),
				'default'        => 'circle',
				'control_layout' => 'inline',
				'type'           => Control::SELECT,
				'choices'        => array(
					'circle' => __( 'Circle', 'lwwb' ),
					'square' => __( 'Square', 'lwwb' ),
				),
				'dependencies'   => array(
					array(
						'control'  => 'icon_view',
						'operator' => '!==',
						'value'    => 'default',
					),
				),
			),
			array(
				'id'         => 'icon_link',
				'keywords'   => 'link icon',
				'label'      => __( 'Link', 'lwwb' ),
				'type'       => Control::TEXT,
				'input_type' => 'url',
				'default'    => '',
			),
			array(
				'id'           => 'icon_alignment',
				'keywords'     => 'link icon alignment',
				'label'        => __( 'Alignment', 'lwwb' ),
				'type'         => Control::BUTTON_SET,
				'default'      => 'center',
				'display_type' => 'icon',
				'choices'      => array(
					'left'   => 'fa fa-align-left',
					'center' => 'fa fa-align-center',
					'right'  => 'fa fa-align-right',
				),
				'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content {text-align:{{ VALUE }};}',

			),
		);
	}

	public function get_style_group_control() {
		return
			array(
				'id'           => 'lwwb_style_group_control',
				'label'        => __( 'Icon', 'lwwb' ),
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

	public static function get_style_controls() {
		return array(
			array(
				'id'       => 'icon_style_state',
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
				'id'           => 'icon_color_normal',
				'keywords'     => 'icon color picker',
				'type'         => Control::COLOR_PICKER,
				'default'      => '',
				'label'        => __( 'Icon Color', 'lwwb' ),
				'dependencies' => array(
					array(
						'control'  => 'icon_style_state',
						'operator' => '===',
						'value'    => 'normal',
					),
				),
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content .lwwb-icon{ color:{{ VALUE }};border-color:{{ VALUE }} }",
			),
			array(
				'id'           => 'icon_second_color_normal',
				'keywords'     => 'icon color picker',
				'default'      => '',
				'label'        => __( 'Icon Secondary  Color', 'lwwb' ),
				'type'         => Control::COLOR_PICKER,
				'dependencies' => array(
					array(
						'control'  => 'icon_style_state',
						'operator' => '===',
						'value'    => 'normal',
					),
				),
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content .lwwb-icon{ background-color:{{ VALUE }} }",
			),
			// Hover
			array(
				'id'           => 'icon_color_hover',
				'keywords'     => 'icon color picker',
				'type'         => Control::COLOR_PICKER,
				'default'      => '',
				'label'        => __( 'Icon Color', 'lwwb' ),
				'dependencies' => array(
					array(
						'control'  => 'icon_style_state',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content .lwwb-icon:hover{ color:{{ VALUE }};border-color:{{ VALUE }} }",
			),
			array(
				'id'           => 'icon_second_color_hover',
				'keywords'     => 'icon color picker',
				'default'      => '',
				'label'        => __( 'Icon Secondary  Color', 'lwwb' ),
				'type'         => Control::COLOR_PICKER,
				'dependencies' => array(
					array(
						'control'  => 'icon_style_state',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content .lwwb-icon:hover{ background-color:{{ VALUE }} }",
			),
			array(
				'id'             => 'icon_hover_animation',
				'keywords'       => 'img image animation caption, media',
				'label'          => __( 'Hover Animation', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'default'        => 'none',
				'choices'        => Default_Elmn_Controls::get_image_hover_animation(),
				'dependencies'   => array(
					array(
						'control'  => 'icon_style_state',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
			),

			array(
				'id'          => 'size',
				'keywords'    => 'gradient location angle',
				'label'       => __( 'Size', 'lwwb' ),
				'default'     => '60',
				'type'        => Control::SLIDER,
				'input_attrs' => array(
					'min'  => '10',
					'max'  => '500',
					'step' => '1',
				),
				'css_format'  => "ELMN_WRAPPER > .lwwb-elmn-content .lwwb-icon{ font-size:{{ VALUE }}px }",
			),
			array(
				'id'          => 'icon_padding',
				'keywords'    => 'padding icon ',
				'label'       => __( 'Padding', 'lwwb' ),
				'default'     => '',
				'type'        => Control::SLIDER,
				'input_attrs' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'css_format'  => "ELMN_WRAPPER > .lwwb-elmn-content .lwwb-icon{ padding:{{ VALUE }}px }",
			),
			array(
				'id'          => 'rotate',
				'keywords'    => 'padding icon ',
				'label'       => __( 'Rotate', 'lwwb' ),
				'default'     => '',
				'type'        => Control::SLIDER,
				'input_attrs' => array(
					'min'  => '0',
					'max'  => '360',
					'step' => '1',
				),
				'css_format'  => "ELMN_WRAPPER > .lwwb-elmn-content .lwwb-icon i{ -webkit-transform: rotate({{ VALUE }}deg) ;-moz-transform: rotate({{ VALUE }}deg) ;-ms-transform: rotate({{ VALUE }}deg) ;-o-transform: rotate({{ VALUE }}deg) ;transform: rotate({{ VALUE }}deg) ; }",
			),
			array(
				'id'       => 'icon_divider',
				'keywords' => 'padding icon divider',
				'type'     => Control::DIVIDER,
			),
			array(
				'id'            => 'icon-border-width',
				'keywords'      => 'icon border normal width',
				'label'         => __( 'Border Width', 'lwwb' ),
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
				'unit'          => array(
					'px' => array(
						'min'  => '0',
						'max'  => '100',
						'step' => '1',
					),
				),
				'css_format'    => "ELMN_WRAPPER > .lwwb-elmn-content .lwwb-icon{border-width: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",
			),
			array(
				'id'            => 'icon_border_radius',
				'keywords'      => 'icon border normal radius',
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
				'css_format'    => "ELMN_WRAPPER > .lwwb-elmn-content .lwwb-icon{border-radius: {{ TOP }}{{ UNIT }} {{ RIGHT }}{{ UNIT }} {{ BOTTOM }}{{ UNIT }} {{ LEFT }}{{ UNIT }} ;}",
			),
		);
	}


	public function get_default_data() {
		return array(
			'icon'           => 'fa fa-empire',
			'size'           => '60',
			'icon_shape'     => 'circle',
			'icon_alignment' => 'center',
		);
	}
	public function get_classes_content() {
		$classes   = array();
		$classes[] = $this->get_data( 'icon_view' ) ? 'icon-view--' . $this->get_data( 'icon_view' ) : '';
		$classes[] = ( ( $this->get_data( 'icon_shape' ) ) && ( 'default' != $this->get_data( 'icon_view' ) ) ) ? 'icon-shape--' . $this->get_data( 'icon_shape' ) : '';
		return $classes;
	}
	public function render_content() {

		$animationClass = '';
		if ( $this->get_data( 'icon_hover_animation' ) !== '' ) {
			$animationClass = 'lwwb-animation-' . $this->get_data( 'icon_hover_animation' );
		}

		?>
        <div class="lwwb-icon <?php echo esc_attr( $animationClass ); ?>">
			<?php if ( $this->get_data( 'icon_link' ) ) { ?>
            <a href="{{ elmn_data.icon_link }}" target="_blank">
				<?php } ?>
                <i class="<?php echo esc_attr( $this->get_data( 'icon' ) ); ?>" aria-hidden="true"></i>
				<?php if ( $this->get_data( 'icon_link' ) ) { ?>
            </a>
		<?php } ?>
        </div>
		<?php
	}

	public function content_template() {
		?>
        <div class="lwwb-icon">
            <# if( elmn_data.icon_link ){ #>
            <a href="{{ elmn_data.icon_link }}" target="_blank">
                <# } #>
                <i class="{{ elmn_data.icon }}" aria-hidden="true"></i>
                <# if( elmn_data.icon_link ){ #>
            </a>
            <# } #>
        </div>
		<?php
	}
}