<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Customizer;

use Lwwb\Base\Common\Common;

class Dynamic_Settings {

	public function register() {
		add_filter( 'customize_dynamic_setting_args', array( $this, 'filter_dynamic_setting_args' ), 10, 2 );
		add_filter( 'customize_dynamic_setting_class', array( $this, 'filter_dynamic_setting_class' ), 10, 3 );
	}


	/**
	 * Filters a dynamic setting's constructor args to ensure they are recognized when updating or publishing a changeset.
	 *
	 * @param false|array $setting_args The arguments to the WP_Customize_Setting constructor.
	 * @param string $setting_id ID for dynamic setting, usually coming from `$_POST['customized']`.
	 *
	 * @return false|array Setting args.
	 */
	function filter_dynamic_setting_args( $setting_args, $setting_id ) {

		$page_settings_args = array(
			'_search',
			'_404',
			'_archive',
			'_home',
			'_front_page',
			'_date',
			'_author'
		);

		if ( preg_match( Post_Meta_Settings::ID_PATTERN, $setting_id, $matches ) ) {

			$post = get_post( $matches['page_setting_id'] );

			if ( $post && post_type_exists( $post->post_type ) ) {

				$setting_args = array(
					'type'              => Post_Meta_Settings::TYPE, // See _filter_dynamic_setting_class().
					'transport'         => 'postMessage',
					'default'           => false,
					'sanitize_callback' => function ( $value ) {
						return (bool) $value;
					},
				);

				return $setting_args;
			} elseif ( in_array( $matches['page_setting_id'], $page_settings_args ) ) {
				$setting_args = array(
					'type'              => External_Post_Meta_Settings::TYPE,
					'default'           => false,
					'transport'         => 'postMessage',
					'sanitize_callback' => function ( $value ) {
						return $value;
					},
				);

				return $setting_args;
			} else {
				if ( strpos( $matches['page_setting_id'], '_tax_' ) >= 0 ) {
					$setting_args = array(
						'type'              => External_Post_Meta_Settings::TYPE,
						'default'           => false,
						'transport'         => 'postMessage',
						'sanitize_callback' => function ( $value ) {
							return $value;
						},
					);

					return $setting_args;
				}
			}
		}

		return $setting_args;
	}

	/**
	 * Filter dynamic setting class.
	 *
	 * @param string $setting_class WP_Customize_Setting or a subclass.
	 * @param string $setting_id ID for dynamic setting, usually coming from `$_POST['customized']`.
	 * @param array $setting_args WP_Customize_Setting or a subclass.
	 *
	 * @return string Setting class.
	 */
	function filter_dynamic_setting_class( $setting_class, $setting_id, $setting_args ) {
		unset( $setting_id ); // Unused.
		if ( isset( $setting_args['type'] ) && 'lwwb_post_data' === $setting_args['type'] ) {
			$setting_class = __NAMESPACE__ . '\Post_Meta_Settings';
		} elseif ( isset( $setting_args['type'] ) && 'lwwb_external_post' === $setting_args['type'] ) {
			$setting_class = __NAMESPACE__ . '\External_Post_Meta_Settings';
		}

		return $setting_class;
	}

}
