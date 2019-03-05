<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Base\Assets;

use Lwwb\Base\Base_Controller;

class Assets_Base extends Base_Controller {
	public function register() {
		$this->register_action();
		$this->enqueue_scripts();
	}

	public function register_action() {
		add_action( 'init', array( $this, 'register_styles' ) );
		add_action( 'init', array( $this, 'register_scripts' ) );
	}

	public function enqueue_scripts() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_libs' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public' ),999 );
	}

	// Enqueue Admin
	public function enqueue_admin() {
	}

	public function enqueue_libs(  ) {
		wp_enqueue_style( 'bulma' );
	}

	// Enqueue public
	public function enqueue_public() {
		wp_add_inline_script( 'wow', 'new WOW().init();' );
		wp_enqueue_style( $this->plugin_prefix . '-public' );
		wp_enqueue_script( $this->plugin_prefix . '-public' );
	}

	//Register Styles
	public function register_styles() {
		$styles = array_merge( $this->get_vendor_styles(), $this->get_styles() );
		foreach ( $styles as $handle => $style ) {
			wp_register_style( $handle, $style['url'], $style['deps'], $style['version'], $style['media'] );
		}
	}

	public function get_vendor_styles() {
		return array(
			'select2' => array(
				'url'     => $this->plugin_url . 'assets/vendors/select2/css/select2.min.css',
				'deps'    => array(),
				'version' => '4.0.6-rc.1',
				'media'   => 'all'

			),
			'bulma'   => array(
				'url'     => $this->plugin_url . 'assets/vendors/bulma/bulma.min.css',
				'deps'    => array(),
				'version' => '0.7.2',
				'media'   => 'all'

			),
			'animated'   => array(
				'url'     => $this->plugin_url . 'assets/vendors/animated/animate.min.css',
				'deps'    => array(),
				'version' => '3.7.0',
				'media'   => 'all'

			),
			'animations.min'   => array(
				'url'     => $this->plugin_url . 'assets/vendors/animated/animations.min.css',
				'deps'    => array(),
				'version' => '3.7.0',
				'media'   => 'all'

			),
			'lightbox'   => array(
				'url'     => $this->plugin_url . 'assets/vendors/lightbox/css/lightbox.min.css',
				'deps'    => array(),
				'version' => '3.7.0',
				'media'   => 'all'
			),
			'magnific-popup'   => array(
				'url'     => $this->plugin_url . 'assets/vendors/magnific-popup/magnific-popup.css',
				'deps'    => array(),
				'version' => '3.7.0',
				'media'   => 'all'
			),

		);

	}

	//	Register scripts

	public function get_styles() {

		return array(
			$this->plugin_prefix . '-dashboard'  => array(
				'url'     => $this->plugin_url . 'assets/admin/dashboard/css/dashboard.min.css',
				'deps'    => array(),
				'version' => $this->version,
				'media'   => 'all'
			),
			$this->plugin_prefix . '-customizer' => array(
				'url'     => $this->plugin_url . 'assets/admin/customizer/css/customizer-control.min.css',
				'deps'    => array('select2'),
				'version' => $this->version,
				'media'   => 'all'
			),
			$this->plugin_prefix . '-public'     => array(
				'url'     => $this->plugin_url . 'assets/public/css/styles.min.css',
				'deps'    => array(),
				'version' => $this->version,
				'media'   => 'all',
			),
			$this->plugin_prefix . '-builder'     => array(
				'url'     => $this->plugin_url . 'assets/public/css/builder.min.css',
				'deps'    => array(),
				'version' => $this->version,
				'media'   => 'all',
			),
		);
	}

	// scripts + styles

	public function register_scripts() {
		$scripts = array_merge( $this->get_vendor_scripts(), $this->get_scripts() );
		foreach ( $scripts as $handle => $script ) {
			wp_register_script( $handle, $script['url'], $script['deps'], $script['version'], $script['footer'] );
		}
	}

	// get styles
	public function get_vendor_scripts() {
		return array(
			'select2'             => array(
				'url'     => $this->plugin_url . 'assets/vendors/select2/js/select2.min.js',
				'deps'    => array(),
				'version' => '4.0.6-rc.1',
				'footer'  => true
			),
			'backbone.marionette' => array(
				'url'     => $this->plugin_url . 'assets/vendors/marionettejs/backbone.marionette.min.js',
				'deps'    => array( 'jquery', 'underscore', 'backbone' ),
				'version' => 'v4.0.0',
				'footer'  => true
			),
			'backbone.radio'      => array(
				'url'     => $this->plugin_url . 'assets/vendors/marionettejs/backbone.radio.min.js',
				'deps'    => array( 'jquery', 'underscore', 'backbone' ),
				'version' => '2.0.0',
				'footer'  => true
			),
			'wow'      => array(
				'url'     => $this->plugin_url . 'assets/vendors/wow/wow.min.js',
				'deps'    => array( 'jquery'),
				'version' => '2.0.0',
				'footer'  => true
			),
			'lightbox'      => array(
				'url'     => $this->plugin_url . 'assets/vendors/lightbox/js/lightbox-plus-jquery.min.js',
				'deps'    => array( 'jquery'),
				'version' => '2.0.0',
				'footer'  => true
			),
			'magnific-popup'      => array(
				'url'     => $this->plugin_url . 'assets/vendors/magnific-popup/jquery.magnific-popup.min.js',
				'deps'    => array( 'jquery'),
				'version' => '2.0.0',
				'footer'  => true
			),
		);
	}

	public function get_scripts() {

		return array(
			$this->plugin_prefix . '-builder-control' => array(
				'url'     => $this->plugin_url . 'assets/admin/builder/js/builder-control.min.js',
				'deps'    => array( 'customize-controls' ),
				'version' => $this->version,
				'footer'  => true,
			),
			$this->plugin_prefix . '-builder-preview' => array(
				'url'     => $this->plugin_url . 'assets/admin/builder/js/builder-preview.min.js',
				'deps'    => array( 'customize-preview' ),
				'version' => $this->version,
				'footer'  => true,
			),
			$this->plugin_prefix . '-dashboard'       => array(
				'url'     => $this->plugin_url . 'assets/admin/dashboard/js/dashboard.min.js',
				'deps'    => array( 'jquery'),
				'version' => $this->version,
				'footer'  => true,
			),

			$this->plugin_prefix . '-compatibility'       => array(
				'url'     => $this->plugin_url . 'assets/admin/dashboard/js/compatibility.min.js',
				'deps'    => array( 'jquery','yoast-seo-post-scraper' ),
				'version' => $this->version,
				'footer'  => true,
			),

			$this->plugin_prefix . '-customizer'      => array(
				'url'     => $this->plugin_url . 'assets/admin/customizer/js/customizer-control.min.js',
				'deps'    => array(
					'select2',
					'jquery-ui-datepicker',
					'wp-color-picker',
					'customize-base',
					'customize-controls',
				),
				'version' => $this->version,
				'footer'  => true,
			),
			$this->plugin_prefix . '-public'          => array(
				'url'     => $this->plugin_url . 'assets/public/js/public.min.js',
				'deps'    => array('jquery'),
				'version' => $this->version,
				'footer'  => true,
			),
		);
	}
}