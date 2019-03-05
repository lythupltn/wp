<?php
/**
 *
 * @link       lwwbwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@lwwbwp.com>
 */

namespace Lwwb\Base\Assets;

class Font_Families extends Assets_Base {


	/**
	 * System Fonts
	 *
	 * @since       Lwwb 1.0.0
	 * @var array
	 */
	public static $system_fonts = array();

	/**
	 * Google Fonts
	 *
	 * @since       Lwwb 1.0.0
	 * @var array
	 */
	public static $google_fonts = array();

	/**
	 * Get System Fonts
	 *
	 * @since       Lwwb 1.0.0
	 *
	 * @return Array All the system fonts in Lwwb
	 */
	public static function get_system_fonts() {
		if ( empty( self::$system_fonts ) ) {
			self::$system_fonts = array(
				'Helvetica' => array(
					'fallback' => 'Verdana, Arial, sans-serif',
					'weights'  => array(
						'300',
						'400',
						'700',
					),
				),
				'Verdana'   => array(
					'fallback' => 'Helvetica, Arial, sans-serif',
					'weights'  => array(
						'300',
						'400',
						'700',
					),
				),
				'Arial'     => array(
					'fallback' => 'Helvetica, Verdana, sans-serif',
					'weights'  => array(
						'300',
						'400',
						'700',
					),
				),
				'Times'     => array(
					'fallback' => 'Georgia, serif',
					'weights'  => array(
						'300',
						'400',
						'700',
					),
				),
				'Georgia'   => array(
					'fallback' => 'Times, serif',
					'weights'  => array(
						'300',
						'400',
						'700',
					),
				),
				'Courier'   => array(
					'fallback' => 'monospace',
					'weights'  => array(
						'300',
						'400',
						'700',
					),
				),
			);
		}

		return apply_filters( 'lwwb_system_fonts', self::$system_fonts );
	}

	/**
	 * Google Fonts used in lwwb.
	 * Array is generated from the google-fonts.json file.
	 *
	 * @since       Lwwb 1.0.0
	 *
	 * @return Array Array of Google Fonts.
	 */
	public static function get_google_fonts() {

		if ( empty( self::$google_fonts ) ) {

			$google_fonts_file = apply_filters( 'lwwb_google_fonts_json_file', LWWB_PLUGIN_URI . 'assets/vendors/fonts/google-fonts.json' );
			if ( ! file_exists( LWWB_PLUGIN_DIR . 'assets/vendors/fonts/google-fonts.json' ) ) {
				return array();
			}

			global $wp_filesystem;
			if ( empty( $wp_filesystem ) ) {
				require_once ABSPATH . '/wp-admin/includes/file.php';
				WP_Filesystem();
			}

			$file_contants     = $wp_filesystem->get_contents( $google_fonts_file );
			$google_fonts_json = json_decode( $file_contants, 1 );
			$args_fonts        = array();

			foreach ( $google_fonts_json as $item ) {
				$args_fonts[ $item['family'] ][] = $item['variants'];
				$args_fonts[ $item['family'] ][] = $item['category'];
				foreach ( $item['variants'] as $variant_key => $variant ) {
					if ( stristr( $variant, 'italic' ) ) {
						unset( $args_fonts[ $item['family'] ][0][ $variant_key ] );
					}
					if ( 'regular' == $variant ) {
						$args_fonts[ $item['family'] ][0][ $variant_key ] = '400';
					}
				}
			}
			self::$google_fonts = $args_fonts;
		}


		return apply_filters( 'lwwb_google_fonts', self::$google_fonts );
	}

	/**
	 * Custom Fonts
	 *
	 * @since       Lwwb 1.0.0
	 *
	 * @return Array All the custom fonts in Lwwb
	 */
	public static function get_custom_fonts() {
		$custom_fonts = array();

		return apply_filters( 'lwwb_custom_fonts', $custom_fonts );
	}
	/**
	 * Localize Fonts
	 */
	public static function add_localize_fonts() {
		$system = json_encode( self::get_system_fonts() );
		$google = json_encode( self::get_google_fonts() );
		$custom = json_encode( self::get_custom_fonts() );
		if ( ! empty( $custom ) ) {
			return 'var LwwbFontFamilies = { system: ' . $system . ', custom: ' . $custom . ', google: ' . $google . ' };';
		} else {
			return 'var LwwbFontFamilies = { system: ' . $system . ', google: ' . $google . ' };';
		}
	}
}