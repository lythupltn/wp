<?php

	/**
	 * The plugin bootstrap file
	 *
	 * This file is read by WordPress to generate the plugin information in the plugin
	 * admin area. This file also includes all of the dependencies used by the plugin,
	 * registers the activation and deactivation functions, and defines a function
	 * that starts the plugin.
	 *
	 * @link              laserwp.com/contact
	 * @since             1.0.0
	 * @package           Lwwb
	 *
	 * @wordpress-plugin
	 * Plugin Name:       Laser WordPress Website Builder
	 * Plugin URI:        laserwp.com/lwwb
	 * Description:       The complete plugin for WordPress Website Builder, you can buy header, footer, post, page, and even category, archive pages via before_loop, after_loop or before_content after_content hooks
	 * Version:           1.0.0
	 * Author:            Laser WordPress Team
	 * Author URI:        laserwp.com/contact
	 * License:           GPL-2.0+
	 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
	 * Text Domain:       lwwb
	 * Domain Path:       /languages
	 */

// If this file is called directly, abort.
	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	define( 'LWWB_PLUGIN_VERSION', '1.0.0' );
	define( 'LWWB_PLUGIN_BASE_NAME', plugin_basename( __FILE__ ) );
	define( 'LWWB_PLUGIN_PREFIX', 'lwwb' );
	define( 'LWWB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	define( 'LWWB_PLUGIN_URI', plugin_dir_url( __FILE__ ) );

// Require once the Composer Autoload
	if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
		require_once dirname( __FILE__ ) . '/vendor/autoload.php';
	}
	/**
	 * The code that runs during plugin activation
	 */
	function activate_lwwb_plugin() {
		Lwwb\Base\Activate::activate();
	}

	register_activation_hook( __FILE__, 'activate_lwwb_plugin' );
	/**
	 * The code that runs during plugin deactivation
	 */
	function deactivate_lwwb_plugin() {
		Lwwb\Base\Deactivate::deactivate();
	}

	register_deactivation_hook( __FILE__, 'deactivate_lwwb_plugin' );
	/**
	 * Initialize all the core classes of the plugin
	 */
	if ( class_exists( 'Lwwb\\Init' ) ) {
		$lwwb = new Lwwb\Init();
		$lwwb->register_services();
	}
