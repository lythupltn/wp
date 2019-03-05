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

use Lwwb\Customizer\Control_Manager as Control;
use Lwwb\Modules\Menu\Bulma_Navwalker;

class Menu extends WP_Menu {
	public $type = 'menu';
	public $label = 'Menu';
	public $icon = 'fa fa-bars';
	public $key_words = 'navigation, menu';
	public $group = 'basic';

	public $control_groups = array(
		'content',
		'advanced',
		'style',
		'background',
		'border',
		'shape',
		'typography',
		'custom_css',
	);

	public function __construct( array $elmn = array() ) {
		parent::__construct( $elmn );
		add_action( 'wp_ajax_get_menu_html_via_ajax', array( $this, 'get_menu_html_via_ajax' ) );
	}

	public function get_tab_control() {
		return array(
			'id'      => 'lwwb_tab_control',
			'label'   => '',
			'default' => 'content',
			'type'    => Control::TAB,
			'choices' => array(
				'content'  => __( 'Content', 'lwwb' ),
				'style'    => __( 'Style', 'lwwb' ),
				'advanced' => __( 'Advanced', 'lwwb' ),
			),

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

	public static function get_style_controls() {
		return array(
			array(
				'id'       => 'menu-state',
				'keywords' => 'background menu state normal hover',
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
				'id'           => 'menu-color',
				'keywords'     => 'btn color bg menu navigation picker',
				'default'      => '',
				'label'        => __( 'Color', 'lwwb' ),
				'type'         => Control::COLOR_PICKER,
				'dependencies' => array(
					array(
						'control'  => 'menu-state',
						'operator' => '===',
						'value'    => 'normal',
					),
				),
				'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content .navbar-item{color:{{ VALUE }};}',
			),
			array(
				'id'           => 'background-nav-menu-color',
				'keywords'     => 'btn color bg menu navigation picker',
				'default'      => '',
				'label'        => __( 'Background Menu Color', 'lwwb' ),
				'type'         => Control::COLOR_PICKER,
				'dependencies' => array(
					array(
						'control'  => 'menu-state',
						'operator' => '===',
						'value'    => 'normal',
					),
				),
				'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content .navbar{background-color:{{ VALUE }};}',
			),
			array(
				'id'           => 'divider',
				'keywords'     => 'menu, navigation',
				'type'         => Control::DIVIDER,
				'label'        => esc_html__( 'Dropdown', 'lwwb' ),
				'dependencies' => array(
					array(
						'control'  => 'menu-state',
						'operator' => '===',
						'value'    => 'normal',
					),
				),
			),
			array(
				'id'           => 'text-dropdown-color',
				'keywords'     => 'btn color bg menu navigation picker',
				'default'      => '',
				'label'        => __( 'Text Dropdown Color', 'lwwb' ),
				'type'         => Control::COLOR_PICKER,
				'dependencies' => array(
					array(
						'control'  => 'menu-state',
						'operator' => '===',
						'value'    => 'normal',
					),
				),
				'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content .navbar-item.has-dropdown .navbar-dropdown .navbar-item{color:{{ VALUE }};}',
			),
			array(
				'id'           => 'bg-dropdown-color',
				'keywords'     => 'btn color bg menu navigation picker',
				'default'      => '',
				'label'        => __( 'Dropdown Background Color', 'lwwb' ),
				'type'         => Control::COLOR_PICKER,
				'dependencies' => array(
					array(
						'control'  => 'menu-state',
						'operator' => '===',
						'value'    => 'normal',
					),
				),
				'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content .navbar-item.has-dropdown:hover .navbar-dropdown{background-color:{{ VALUE }};}',
			),


			// Hover
			array(
				'id'           => 'menu-hover-color',
				'keywords'     => 'btn color hover bg menu navigation picker',
				'default'      => '',
				'label'        => __( 'Color Hover', 'lwwb' ),
				'type'         => Control::COLOR_PICKER,
				'dependencies' => array(
					array(
						'control'  => 'menu-state',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
				'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content .navbar-item:hover{color:{{ VALUE }};}',
			),
			array(
				'id'           => 'menu-item-bg-hover-color',
				'keywords'     => 'btn color hover bg menu navigation picker',
				'default'      => '',
				'label'        => __( 'Background Hover Color', 'lwwb' ),
				'type'         => Control::COLOR_PICKER,
				'dependencies' => array(
					array(
						'control'  => 'menu-state',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
				'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content .navbar-item:hover,ELMN_WRAPPER > .lwwb-elmn-content .navbar-item.has-dropdown:hover .navbar-link{background-color:{{ VALUE }};}',
			),
			array(
				'id'           => 'divider_hover',
				'keywords'     => 'menu, navigation',
				'type'         => Control::DIVIDER,
				'label'        => esc_html__( 'Dropdown', 'lwwb' ),
				'dependencies' => array(
					array(
						'control'  => 'menu-state',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
			),
			array(
				'id'           => 'text-dropdown-hover-color',
				'keywords'     => 'btn color bg menu navigation picker',
				'default'      => '',
				'label'        => __( 'Text Dropdown Hover Color', 'lwwb' ),
				'type'         => Control::COLOR_PICKER,
				'dependencies' => array(
					array(
						'control'  => 'menu-state',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
				'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content .navbar-item.has-dropdown .navbar-dropdown .navbar-item:hover{color:{{ VALUE }};}',
			),
			array(
				'id'           => 'bg-dropdown-hover-color',
				'keywords'     => 'btn color bg menu navigation picker',
				'default'      => '',
				'label'        => __( 'Dropdown Background Color', 'lwwb' ),
				'type'         => Control::COLOR_PICKER,
				'dependencies' => array(
					array(
						'control'  => 'menu-state',
						'operator' => '===',
						'value'    => 'hover',
					),
				),
				'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content .navbar-item.has-dropdown .navbar-dropdown .navbar-item:hover{background-color:{{ VALUE }};}',
			),
		);
	}

	public static function get_content_controls() {
		return array(
			array(
				'id'             => 'menu_id',
				'keywords'       => 'menu, navigation',
				'label'          => __( 'Select Menu', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'default'        => '',
				'choices'        => self::get_menu_id(),
			),
			array(
				'id'       => 'divider',
				'keywords' => 'menu, navigation',
				'type'     => Control::DIVIDER,
			),
			array(
				'id'             => 'menu_layout',
				'keywords'       => 'menu, navigation, layout',
				'label'          => __( 'Layout', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'default'        => 'horizontal',
				'choices'        => array(
					'horizontal' => esc_html__( 'Horizontal', 'lwwb' ),
					'vertical'   => esc_html__( 'Vertical', 'lwwb' ),
				),
			),
			array(
				'id'             => 'sticky',
				'keywords'       => 'menu, navigation, sticky, layout, transparent',
				'label'          => __( 'Menu Sticky', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'default'        => 'horizontal',
				'choices'        => array(
					''                => esc_html__( 'None', 'lwwb' ),
					'is-fixed-top'    => esc_html__( 'Sticky Top', 'lwwb' ),
					'is-fixed-bottom' => esc_html__( 'Sticky Bottom', 'lwwb' ),
				),
			),
			array(
				'id'             => 'pointer',
				'keywords'       => 'menu, navigation, layout, Pointer',
				'label'          => __( 'Pointer', 'lwwb' ),
				'control_layout' => 'inline',
				'type'           => Control::SELECT,
				'default'        => 'none',
				'choices'        => array(
					'none'        => esc_html__( 'None', 'lwwb' ),
					'underline'   => esc_html__( 'Underline', 'lwwb' ),
					'overline'    => esc_html__( 'Overline', 'lwwb' ),
					'double-line' => esc_html__( 'Double Line', 'lwwb' ),
					'framed'      => esc_html__( 'Framed', 'lwwb' ),
					'background'  => esc_html__( 'Background', 'lwwb' ),
					'text'        => esc_html__( 'Text', 'lwwb' ),
				),
			),
			array(
				'id'          => 'navbar-item-img-max-height',
				'keywords'    => 'logo menu navigation nav',
				'label'       => __( 'Max Height', 'lwwb' ),
				'default'     => '',
				'type'        => Control::SLIDER,
				'input_attrs' => array(
					'min'  => '0',
					'max'  => '600',
					'step' => '1',
				),
				'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content .navbar-item img {max-height:{{ VALUE }}px;}',
			),
			array(
				'id'           => 'align',
				'keywords'     => 'title, text, link, button, size, menu, navigation',
				'label'        => __( 'Alignment', 'lwwb' ),
				'type'         => Control::BUTTON_SET,
				'display_type' => 'icon',
				'default'      => 'start',
				'choices'      => array(
					'start'   => 'fa fa-align-left',
					'center'  => 'fa fa-align-center',
					'end'     => 'fa fa-align-right',
					'stretch' => 'fa fa-align-justify',
				),
			),
			array(
				'id'       => 'responsive_divider',
				'keywords' => 'menu, navigation',
				'type'     => Control::DIVIDER,
			),
			array(
				'id'           => 'logo_img',
				'keywords'     => 'image, media background',
				'label'        => __( 'Logo', 'lwwb' ),
				'type'         => Control::MEDIA_UPLOAD,
				'default'      => array(
					'url' => '',
					'id'  => '',
				),
			),
			array(
				'id'          => 'navbar-brand-img-max-width',
				'keywords'    => 'logo menu navigation nav',
				'label'       => __( 'Width', 'lwwb' ),
				'default'     => '',
				'type'        => Control::SLIDER,
				'input_attrs' => array(
					'min'  => '0',
					'max'  => '600',
					'step' => '1',
				),
				'css_format'   => 'ELMN_WRAPPER > .lwwb-elmn-content .navbar-item img.logo {min-width:{{ VALUE }}px;}',
			),

		);
	}

	public function get_default_data() {
		return array(
			'pointer'     => 'none',
			'align'       => 'start',
			'menu_layout' => 'horizontal',
		);
	}

	public function render_content() {
		$nav_menu = ! empty( $this->get_data( 'menu_id' ) ) ? wp_get_nav_menu_object( $this->get_data( 'menu_id' ) ) : false;

		if ( ! $nav_menu ) {
			return;
		}
		$nav_menu_args = array(
			'menu'           => $nav_menu,
			'walker'         => new Bulma_NavWalker(),
			'container'      => '',
			'depth'          => 3,
			'theme_location' => '',
			'menu_class'     => '',
			'items_wrap'     => '%3$s',
			'fallback_cb'    => 'Bulma_NavWalker::fallback'
		);

		?>
        <div class="lwwb-elmn-navigation">
            <nav class="navbar <?php echo esc_attr( $this->get_data( 'sticky' ) ); ?>">
                <div class="container">
                    <div class="navbar-brand">
	                    <?php if($this->get_data('logo_img')['url'] !='') { ?>
                            <a class="navbar-item" href="<?php echo home_url('/')?>">
                                <img src="<?php echo esc_attr($this->get_data('logo_img')['url'])?>"
                                     alt="<?php echo get_bloginfo();?>" >
                            </a>
                        <?php } ?>
                        <span class="navbar-burger burger" data-target="navMenu">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </div>

                    <div class="navbar-menu">
                        <div class="navbar-<?php echo esc_attr( $this->get_data( 'align' ) ); ?> lwwb-navigation lwwb-pointer--<?php echo esc_attr( $this->get_data( 'pointer' ) ); ?>">
							<?php
							wp_nav_menu( $nav_menu_args );
							?>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
		<?php

	}

	public function content_template() {
		?>
        <div class="lwwb-elmn-navigation">
            <nav class="navbar {{ elmn_data.sticky }}" role="navigation" aria-label="main navigation">
                <div class="container">
                    <div class="navbar-brand">
                        <# if(elmn_data.logo_img) { #>
                            <a class="navbar-item" href="#">
                                <img src="{{ elmn_data.logo_img.url }}"  class="logo">
                            </a>
                        <# } #>
                        <span class="navbar-burger burger" data-target="navMenu">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </div>
                    <div class="navbar-menu">
                        <div class="navbar-{{ elmn_data.align }} lwwb-pointer--{{ elmn_data.pointer }} lwwb-navigation lwwb-nav-empty">
                            <div class="lwwb-empty-image">
                                <# if(!elmn_data.menu_id) { #>
                                <div class="lwwb-image-placeholder"><i class="fa fa-2x fa-wordpress"
                                                                       aria-hidden="true"></i>
                                </div>
                                <# } #>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
		<?php
	}

	public function get_menu_html_via_ajax() {
		$id       = isset( $_POST['id'] ) ? $_POST['id'] : '';
		$nav_menu = ! empty( $id ) ? wp_get_nav_menu_object( $id ) : false;
		if ( ! $nav_menu ) {
			return;
		}
		$nav_menu_args = array(
			'menu'           => $nav_menu,
			'walker'         => new Bulma_NavWalker(),
			'container'      => '',
			'depth'          => 3,
			'theme_location' => '',
			'menu_class'     => '',
			'items_wrap'     => '%3$s',
			'fallback_cb'    => 'Bulma_NavWalker::fallback'
		);
		ob_start();
		wp_nav_menu( $nav_menu_args );
		$html = ob_get_clean();
		wp_send_json( array(
			'success' => true,
			'html'    => $html
		) );

	}
}