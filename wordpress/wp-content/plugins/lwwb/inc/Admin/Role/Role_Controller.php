<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Admin\Role;

use Lwwb\Admin\Base\Base_Admin_Controller;
use Lwwb\Admin\Base\Callback_Manager;

class Role_Controller extends Base_Admin_Controller {
	public $settings;

	public $callbacks;

	public $page = array();

	protected $components = array( 'widgets', 'nav_menus');

	public function register() {
		$this->callbacks = new Callback_Manager();
		parent::register(); // TODO: Change the autogenerated stub
		add_action( 'admin_init', array( $this, 'lock_cap_theme' ) );
		add_action( 'admin_menu', array( $this, 'remove_by_caps_admin_menu' ), 999 );
		add_filter( 'customize_loaded_components', array( $this, 'remove_widgets_panel' ), 999 );
	}

	public function get_sub_page() {
		return array(
			'parent_slug' => $this->plugin_prefix,
			'page_title'  => esc_html__( 'Role Manager', 'lwwb' ),
			'menu_title'  => esc_html__( 'Role Manager', 'lwwb' ),
			'capability'  => 'manage_options',
			'menu_slug'   => $this->plugin_prefix . '-role',
			'callback'    => array( $this, 'admin_settings' )
		);
	}

	public function admin_settings() {
		return require_once $this->plugin_path . "inc/Admin/templates/role.php";
	}

	public function get_settings() {
		$args = array(
			array(
				'option_group' => 'lwwb_role_general',
				'option_name'  => 'lwwb_settings',
				'callback'     => array( $this->callbacks, 'options_sanitize' )
			)
		);

		return $args;
	}

	public function get_sections() {
		$args = array(
			array(
				'id'    => 'lwwb_role_section',
				'title' => esc_html__( 'Role Manager Access to LWWB editor', 'lwwb' ),
				'page'  => 'lwwb-role'
			)
		);

		return $args;
	}

	public function get_fields() {
		$all_roles = wp_roles()->roles;
		$args      = array();
		foreach ( $all_roles as $role_slug => $role_data ) {
			if ( 'administrator' === $role_slug ) {
				continue;
			}
			$args[] = array(
				'id'       => $role_slug,
				'title'    => $role_data['name'],
				'callback' => array( $this->callbacks, 'checkbox_field' ),
				'page'     => 'lwwb-role',
				'section'  => 'lwwb_role_section',
				'args'     => array(
					'option_name' => 'lwwb_settings',
					'label_for'   => $role_slug,
					'option_slug' => 'role',
				),
			);
		}


		return $args;
	}

	public function lock_cap_theme() {
		global $submenu, $userdata;
		$userdata = wp_get_current_user();
		if ( $userdata->ID != 1 ) {
			unset( $submenu['themes.php'][5] );
			unset( $submenu['themes.php'][15] );
			unset( $submenu['themes.php'][7] ); // Widgets
			unset( $submenu['themes.php'][10] ); // Menu
		}
	}

	public function remove_by_caps_admin_menu() {
		if ( ! current_user_can( 'manage_options' ) ) {
			remove_submenu_page( 'themes.php', 'widgets.php' );
			remove_submenu_page( 'themes.php', 'nav-menus.php' );
			remove_submenu_page( 'themes.php', 'theme-editor.php' );
			$result  = stripos( $_SERVER['REQUEST_URI'], 'widgets.php' );
			$result1 = stripos( $_SERVER['REQUEST_URI'], 'themes.php' );
			$result2 = stripos( $_SERVER['REQUEST_URI'], 'nav-menus.php' );
			if ( ( $result !== false ) || ( $result1 !== false ) || ( $result2 !== false ) ) {
				wp_redirect( get_option( 'siteurl' ) . '/wp-admin/index.php' );
			}
		}
	}

	public function remove_widgets_panel() {

		if ( ! current_user_can( 'manage_options' ) ) {
			foreach ( $this->components as $key => $component ) {
				unset( $this->components[ $key ] );
			}
		}

		return $this->components;
	}

}