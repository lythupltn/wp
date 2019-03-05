<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Admin\Settings;

use Lwwb\Admin\Base\Base_Admin_Controller;
use Lwwb\Admin\Base\Callback_Manager;

class Settings_Controller extends Base_Admin_Controller {
	public $settings;

	public $callbacks;

	public $page = array();

	public $cpt = array();

	public function register() {
		$this->callbacks = new Callback_Manager();
		parent::register(); // TODO: Change the autogenerated stub
	}

	public function get_sub_page() {
		return array(
			'parent_slug' => $this->plugin_prefix,
			'page_title'  => esc_html__( 'Settings', 'lwwb' ),
			'menu_title'  => esc_html__( 'Settings', 'lwwb' ),
			'capability'  => 'manage_options',
			'menu_slug'   => $this->plugin_prefix . '-settings',
			'callback'    => array( $this, 'admin_settings' )
		);
	}

	public function admin_settings() {
		return require_once $this->plugin_path . "inc/Admin/templates/settings.php";

	}

	public function get_settings() {
		$args = array(
			array(
				'option_group' => 'lwwb_settings_general',
				'option_name'  => 'lwwb_settings',
				'callback'     => array( $this->callbacks, 'options_sanitize' ),
			),
			array(
				'option_group' => 'lwwb_css_print_method',
				'option_name'  => 'lwwb_settings',
				'callback'     => array( $this->callbacks, 'options_sanitize' ),
			),
			array(
				'option_group' => 'lwwb_responsive_breakpoint',
				'option_name'  => 'lwwb_settings',
				'callback'     => array( $this->callbacks, 'options_sanitize' ),
			),
		);

		return $args;
	}

	public function get_sections() {
		$args = array(
			array(
				'id'    => 'lwwb_settings_section',
				'title' => '',
				'page'  => 'lwwb-settings'
			),
			array(
				'id'    => 'lwwb_css_print_method_section',
				'title' => '',
				'page'  => 'lwwb-settings'
			),
			array(
				'id'    => 'lwwb_responsive_breakpoint',
				'title' => '',
				'page'  => 'lwwb-settings'
			)
		);

		return $args;
	}

}
