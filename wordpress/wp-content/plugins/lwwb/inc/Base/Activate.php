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


class Activate {
	public static function activate() {
		flush_rewrite_rules();
		$default = array(
			'settings'              => array(
				'page',
				'post',
				'lwwb_library',
			),
			'version'               => LWWB_PLUGIN_VERSION,
			'installed_time'        => time(),
			'role'                  => array(),
			'integrations'          => array(),
			'css_print_method'      => 'internal',
			'responsive_breakpoint' => array(
				'tablet'  => '1088',
				'mobile'  => '768',
			)
		);
		if ( ! get_option( 'lwwb_settings' ) ) {
			update_option( 'lwwb_settings', $default );
		}
	}
}