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

class Heading extends Elmn {
	public $type = 'heading';
	public $label = 'Heading';
	public $icon = 'fa fa-header';
	public $group = 'basic';
	public $key_words = 'heading, title, text';

	public $control_groups = array(
		'content',
//		'heading',
//		'advanced',
//		'background',
//		'border',
//		'responsive',
//		'custom_css',
	);

	public $default_data = array();

	public function get_content_group_control() {
		return
			array(
				'id'           => 'lwwb_content_group_control',
				'label'        => __( 'Title', 'lwwb' ),
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
				'label'    => esc_html__( 'Tittle', 'lwwb' ),
				'id'       => 'tittle',
				'keywords' => 'tittle',
				'type'     => Control::TEXTAREA,
				'default'  => 'Type your heading text here',
			),
			array(
				'label'    => esc_html__( 'Link', 'lwwb' ),
				'id'       => 'link',
				'keywords' => 'link',
				'type'     => Control::TEXTAREA,
				'default'  => 'Insert your URL',
			),
			array(
				'label'          => esc_html__( 'Link Target', 'lwwb' ),
				'id'             => 'link_target',
				'keywords'       => 'link target',
				'type'           => Control::SELECT,
				'choices'        => static::get_link_target(),
				'control_layout' => 'inline',
			),
			array(
				'label'          => esc_html__( 'No Follow?', 'lwwb' ),
				'id'             => 'no_follow',
				'keywords'       => 'nofollow',
				'type'           => Control::SWITCHER,
				'control_layout' => 'inline',
			),
			array(
				'label'          => esc_html__( 'Size', 'lwwb' ),
				'id'             => 'size',
				'keywords'       => 'size',
				'type'           => Control::SELECT,
				'choices'        => array(
					'default' => 'Default',
					'small'   => 'Small',
					'medium'  => 'Medium',
					'large'   => 'Large',
					'xl'      => 'XL',
					'xxl'     => 'XXL',
				),
				'control_layout' => 'inline',
			),
			array(
				'label'          => esc_html__( 'HTML Tag', 'lwwb' ),
				'id'             => 'html_tag',
				'keywords'       => 'html tag',
				'type'           => Control::SELECT,
				'choices'        => static::get_html_tag(),
				'control_layout' => 'inline',
			),
			array(
				'label' => esc_html__( 'Alignment', 'lwwb' ),
				'id'    => 'alignment_rs',
				'type'  => Control::RESPONSIVE_SWITCHER,
                'device_config' => array(
                        'desktop' => 'desktop',
                        'tablet' => 'tablet',
                        'mobile' => 'mobile',
                )
			),
			array(
				'id'            => 'alignment',
				'keywords'      => 'alignment',
				'type'          => Control::BUTTON_SET,
				'display_type' => 'icon',
				'on_device'     => 'desktop',
				'choices'   => array(
					'left'    => 'fa fa-align-left',
					'right'   => 'fa fa-align-right',
					'center'  => 'fa fa-align-center',
					'justify' => 'fa fa-align-justify',
				),
                'css_format' => 'ELMN_WRAPPER > .lwwb-elmn-content { text-align: {{ VALUE }}; }'
			),
			array(
				'id'            => '_tablet_alignment',
				'keywords'      => 'alignment',
				'type'          => Control::BUTTON_SET,
				'display_type' => 'icon',
				'on_device'     => 'tablet',
				'choices'   => array(
					'left'    => 'fa fa-align-left',
					'right'   => 'fa fa-align-right',
					'center'  => 'fa fa-align-center',
					'justify' => 'fa fa-align-justify',
				),
				'css_format' => 'ELMN_WRAPPER > .lwwb-elmn-content { text-align: {{ VALUE }}; }'
			),
			array(
				'id'            => '_mobile_alignment',
				'keywords'      => 'alignment',
				'type'          => Control::BUTTON_SET,
				'display_type' => 'icon',
				'on_device'     => 'mobile',
				'choices'   => array(
					'left'    => 'fa fa-align-left',
					'right'   => 'fa fa-align-right',
					'center'  => 'fa fa-align-center',
					'justify' => 'fa fa-align-justify',
				),
				'css_format' => 'ELMN_WRAPPER > .lwwb-elmn-content { text-align: {{ VALUE }}; }'
			),
		);
	}

	public function get_heading_group_control() {
		return
			array(
				'id'           => 'lwwb_heading_group_control',
				'label'        => __( 'Title', 'lwwb' ),
				'type'         => Control::GROUP,
				'dependencies' => array(
					array(
						'control'  => 'lwwb_tab_control',
						'operator' => '===',
						'value'    => 'style',
					),
				),
				'fields'       => static::get_heading_style_controls(),
			);
	}

	public static function get_heading_style_controls() {
		return array(
			array(
				'id'         => 'heading_color',
				'keywords'   => 'heading color picker',
				'default'    => '',
				'label'      => __( 'Text color', 'lwwb' ),
				'type'       => Control::COLOR_PICKER,
				'css_format' => 'ELMN_WRAPPER > .lwwb-elmn-content .lwwb-heading-title{color:{{ VALUE }};}',
			),
			array(
				'id'             => 'heading_typo_font_family',
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
				'css_format'     => 'ELMN_WRAPPER > .lwwb-elmn-content .lwwb-heading-title{font-family:{{ VALUE }};}',
			),
			array(
				'id'            => 'font_size',
				'keywords'      => 'font font-size',
				'label'         => __( 'Font Size', 'lwwb' ),
				'type'          => Control::SLIDER,
				'input_type'    => 'number',
				'default'       => array(),
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
				'css_format'    => 'ELMN_WRAPPER > .lwwb-elmn-content .lwwb-heading-title{font-size:{{ VALUE }}{{ UNIT }};}',
			),
			array(
				'id'             => 'heading_typo_font_weight',
				'keywords'       => 'font font-weight',
				'label'          => __( 'Font Weight', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'choices'        => Default_Elmn_Controls::typography_font_weight_config(),
				'css_format'     => 'ELMN_WRAPPER > .lwwb-elmn-content{font-weight:{{ VALUE }};}',
			),
			array(
				'id'             => 'heading_typo_font_style',
				'keywords'       => 'font text font_style',
				'label'          => __( 'Font Style', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'choices'        => Default_Elmn_Controls::typography_font_style_config(),
				'css_format'     => 'ELMN_WRAPPER > .lwwb-elmn-content{font-style:{{ VALUE }};}',
			),
			array(
				'id'             => 'heading_typo_text_transform',
				'keywords'       => 'font text transform',
				'label'          => __( 'Text Transform', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'choices'        => Default_Elmn_Controls::typography_text_transform_config(),
				'css_format'     => 'ELMN_WRAPPER > .lwwb-elmn-content{text-transform:{{ VALUE }};}',
			),
			array(
				'id'             => 'heading_typo_text_decoration',
				'keywords'       => 'font text decoration',
				'label'          => __( 'Text Decoration', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'choices'        => Default_Elmn_Controls::typography_text_decoration_config(),
				'css_format'     => 'ELMN_WRAPPER > .lwwb-elmn-content{text-decoration:{{ VALUE }};}',
			),

		);
	}

	public function get_default_data() {
		return array(
			'title'            => __( 'This is the default title', 'lwwb' ),
			'content_editable' => 'true',
		);
	}

	public function get_classes_content() {
		$classes   = array();
		$classes[] = $this->get_data( 'align' ) ? 'has-text-' . $this->get_data( 'align' ) : 'left';

		return $classes;
	}

	public function render_content() {

		$url    = $this->get_data( 'link_url' );
		$target = $this->get_data( 'link_target' ) ? $this->get_data( 'link_target' ) : '_blank';
		$title  = $this->get_data( 'title' ) ? $this->get_data( 'title' ) : '';

		$html_tag = $this->get_data( 'html_tag' ) ? $this->get_data( 'html_tag' ) : 'h3';
		if ( isset( $url ) && $url != '' ) {
			echo '<a href="' . esc_url( $url ) . '" target="' . $target . '">';
		}
		echo '<' . $html_tag . ' class="lwwb-heading-title">' . $title . '</' . $html_tag . '>';
		if ( isset( $url ) && $url != '' ) {
			echo '</a>';
		}
	}

	public function content_template() {
		?>
        <# if(!elmn_data.html_tag){ elmn_data.html_tag = 'h2' } #>
        <# if(elmn_data.link_url) { #>
        <a href="{{ elmn_data.link_url }}" target="{{ elmn_data.link_target }}">
            <# } #>
            <{{ elmn_data.html_tag }} class="lwwb-heading-title <# if(elmn_data.content_editable){
            #>lwwb-content-editable <# } #>" <# if(elmn_data.content_editable === 'true'){ #> contenteditable="true"
            data-key="title" <# } #> > {{ elmn_data.title }} </{{ elmn_data.html_tag }}>
        <# if(elmn_data.link_url) { #>
        </a>
        <# } #>
		<?php
	}
	public static function get_html_tag(){}
	public static function get_link_target(){}
}