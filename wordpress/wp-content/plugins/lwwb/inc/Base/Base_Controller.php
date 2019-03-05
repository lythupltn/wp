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


class Base_Controller {
	public $plugin_path;
	public $plugin_url;
	public $plugin;
	public $version;
	public $managers = array();
	public function __construct() {

		$this->plugin_path = LWWB_PLUGIN_DIR;
		$this->plugin_url = LWWB_PLUGIN_URI;
		$this->plugin = LWWB_PLUGIN_BASE_NAME;
		$this->plugin_prefix = LWWB_PLUGIN_PREFIX;
		$this->version = LWWB_PLUGIN_VERSION;

	}

	public function activated( string $key )
	{
		$option = get_option( 'lwwb' );
		return isset( $option[ $key ] ) ? $option[ $key ] : false;
	}
}
