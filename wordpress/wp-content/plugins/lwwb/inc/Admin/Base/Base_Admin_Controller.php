<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Admin\Base;

class Base_Admin_Controller extends \Lwwb\Base\Base_Controller {

	public $settings = array();

	public $sections = array();

	public $fields = array();

	public $capability = 'lwwb_manager_options';

	public function register() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'add_cap_for_role' ) );
		add_action( 'admin_init', array( $this, 'register_custom_fields' ) );
		add_action( 'admin_init', array( $this, 'is_current_user_in_editing' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'wp_before_admin_bar_render', array( $this, 'change_admin_bar_lwwb_customizer' ), 999 );

		$this->settings = $this->get_settings();
		$this->sections = $this->get_sections();
		$this->fields   = $this->get_fields();


	}

// get role add cap
	public function get_settings() {
		return array();
	}

	public function get_sections() {
		return array();
	}

// Set default values here

	public function get_fields() {
		return array();
	}

	public function add_cap_for_role() {
		$roles = wp_roles()->get_names();
		foreach ( $roles as $key => $role ) {
			$get_role = get_role( $key );
			$get_role->add_cap( $this->capability );
		}
	}

	public function enqueue() {
		wp_enqueue_script( $this->plugin_prefix . '-dashboard' );
		wp_enqueue_style( $this->plugin_prefix . '-dashboard' );
		wp_enqueue_script( $this->plugin_prefix . '-compatibility' );

	}

	public function add_admin_menu() {
		$page     = $this->get_page();
		$sub_page = $this->get_sub_page();

		if(!empty($sub_page)){
			add_submenu_page( $sub_page['parent_slug'], $sub_page['page_title'], $sub_page['menu_title'], $sub_page['capability'], $sub_page['menu_slug'], $sub_page['callback'] );
		}
		if(!empty($page)) {
			add_menu_page( $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['position'] );
		}
	}

	public function get_page() {
		return array();
	}

	public function get_sub_page() {
		return array();
	}

	public function register_custom_fields() {
		// register setting
		foreach ( $this->settings as $setting ) {
			register_setting( $setting["option_group"], $setting["option_name"], ( isset( $setting["callback"] ) ? $setting["callback"] : '' ) );

		}
		// add settings section
		foreach ( $this->sections as $section ) {
			add_settings_section( $section["id"], $section["title"], ( isset( $section["callback"] ) ? $section["callback"] : '' ), $section["page"] );
		}

		// add settings field
		foreach ( $this->fields as $field ) {
			add_settings_field( $field["id"], $field["title"], ( isset( $field["callback"] ) ? $field["callback"] : '' ), $field["page"], $field["section"], ( isset( $field["args"] ) ? $field["args"] : '' ) );
		}
	}

	public function is_current_user_in_editing() {
		$user = wp_get_current_user();
		if ( ! isset( $user->roles[0] ) ) {
			return false;
		}
		$exclude_roles = array();
		$options       = get_option( 'lwwb_settings', [] );
		foreach ( $options as $key => $option ) {
			if ( 'role' === $key ) {
				$exclude_roles = $option;
			}
		}
		if ( empty( $exclude_roles ) ) {
			$exclude_roles = array();
		}
		$compare_roles = in_array( $user->roles[0], $exclude_roles );

		if ( $compare_roles ) {
			foreach ( $exclude_roles as $exclude_role ) {
				$role = get_role( $exclude_role );
				if ( ! $role->has_cap( 'edit_theme_options' ) ) {
					$role->add_cap( 'edit_theme_options' );
				}
			}

			return true;
		} else {
			if ( 'administrator' !== $user->roles[0] ) {
				$role = get_role( $user->roles[0] );
				$role->remove_cap( 'edit_theme_options' );
			} else {
				return true;
			}

		}

		return false;
	}
	function change_admin_bar_lwwb_customizer() {
		global $wp_customize, $wp_admin_bar;

		// Don't show for users who can't access the customizer or when in the admin.
		if ( ! current_user_can( 'customize' ) || is_admin() ) {
			return;
		}

		// Don't show if the user cannot edit a given customize_changeset post currently being previewed.
		if ( is_customize_preview() && $wp_customize->changeset_post_id() && ! current_user_can( get_post_type_object( 'customize_changeset' )->cap->edit_post, $wp_customize->changeset_post_id() ) ) {
			return;
		}

		$current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		if ( is_customize_preview() && $wp_customize->changeset_uuid() ) {
			$current_url = remove_query_arg( 'customize_changeset_uuid', $current_url );
		}

		$customize_url = add_query_arg( 'url', urlencode( $current_url ), wp_customize_url() );
		if ( is_customize_preview() ) {
			$customize_url = add_query_arg( array( 'changeset_uuid' => $wp_customize->changeset_uuid() ), $customize_url );
		}


		$wp_admin_bar->remove_node( 'customize' );

		$args = array(
			'id'    => 'customize',
			'title' => __( 'LWWB Customize' ),
			'href'  => $customize_url,
			'meta'  => array(
				'class' => 'hide-if-no-customize lwwb_customizer',
			),
		);

		$wp_admin_bar->add_node( $args );
	}
}