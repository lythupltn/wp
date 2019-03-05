<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    lwwb
 * @subpackage lwwb/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Base;


class Settings_Links extends Base_Controller {
	public function register() {
		add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) );
	}

	public function settings_link( $links ) {
		$settings_link = array(
			'<a href="' . admin_url() . 'admin.php?page=' . $this->plugin_prefix . '-settings">' . esc_html__( 'Settings', 'lwwb' ) . '</a>',
			'<a href="' . admin_url() . 'edit.php?post_type=' . $this->plugin_prefix . '_library">' . esc_html__( 'Library', 'lwwb' ) . '</a>',
		);;

		return array_merge( $links, $settings_link );
	}
}
