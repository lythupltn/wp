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

class WP_Menu extends Elmn {
	public $type = 'wp_menu';
	public $label = 'WP Menu';
	public $icon = 'fa fa-align-right';
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
		add_action( 'wp_ajax_get_wp_menu_html_via_ajax', array( $this, 'get_wp_menu_html_via_ajax' ) );
	}

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

	public static function get_content_controls() {
		return array(
			array(
				'id'         => 'title',
				'keywords'   => 'menu, title, nav, navigation',
				'label'      => __( 'Title', 'lwwb' ),
				'type'       => Control::TEXT,
				'input_type' => 'text',
			),
			array(
				'id'             => 'menu_id',
				'keywords'       => 'menu, navigation',
				'label'          => __( 'Select Menu', 'lwwb' ),
				'type'           => Control::SELECT,
				'control_layout' => 'inline',
				'default'        => '',
				'choices'        => self::get_menu_id(),
			),

		);
	}

	public function get_wp_menu_html_via_ajax() {
		$id       = isset( $_POST['id'] ) ? $_POST['id'] : '';
		$nav_menu = ! empty( $id ) ? wp_get_nav_menu_object( $id ) : false;
		if ( ! $nav_menu ) {
			return;
		}
		$nav_menu_args = array(
			'menu'       => $nav_menu,
			'depth'      => 3,
			'menu_class' => 'main-menu',
			'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		);
		ob_start();
		wp_nav_menu( $nav_menu_args );
		$html = ob_get_clean();
		wp_send_json( array(
			'success' => true,
			'html'    => $html
		) );

	}

	public static function get_menu_id() {
		$menus    = wp_get_nav_menus();
		$menu_arg = array( '' => esc_html__( 'Select Menu', 'lwwb' ) );
		foreach ( $menus as $menu ) :
			$menu_arg[ $menu->term_id ] = esc_html( $menu->name );
		endforeach;

		return $menu_arg;
	}

	public function render_content() {
		$nav_menu = ! empty( $this->get_data( 'menu_id' ) ) ? wp_get_nav_menu_object( $this->get_data( 'menu_id' ) ) : false;

		if ( ! $nav_menu ) {
			return;
		}
		$nav_menu_args = array(
			'menu'       => $nav_menu,
			'depth'      => 3,
			'menu_class' => 'main-menu',
			'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		);
		?>
        <div class="lwwb-elmn-navigation">
            <div class="lwwb-menu-title"><?php echo esc_attr( $this->get_data( 'title' ) ); ?></div>
            <div class="lwwb-wp-navigation">
				<?php
                if('' != $this->get_data('menu_id')){
	                echo '<div class="lwwb-image-placeholder"><i class="fa fa-2x fa-wordpress" aria-hidden="true"></i></div>';
                }
				wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu ) )
				?>
            </div>
        </div>
		<?php

	}

	public function content_template() {
		?>
        <div class="lwwb-elmn-navigation">
            <div class="lwwb-menu-title">{{ elmn_data.title }}</div>
            <div class="lwwb-wp-navigation">
                <# if(!elmn_data.menu_id) { #>
                <div class="lwwb-image-placeholder"><i class="fa fa-2x fa-wordpress" aria-hidden="true"></i></div>
                <# } #>
            </div>
        </div>
		<?php
	}
}