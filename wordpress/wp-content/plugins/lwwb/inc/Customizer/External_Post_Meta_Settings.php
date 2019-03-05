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

use Lwwb\Frontend\Generate_Style;

class External_Post_Meta_Settings extends \WP_Customize_Setting {

	const TYPE = 'lwwb_external_post';

	/**
	 * Type of setting.
	 *
	 * @access public
	 * @var string
	 */
	public $type = self::TYPE;
	protected $has_preview_filters = false;
	/**
	 * Post type.
	 *
	 * @access public
	 * @var string
	 */
	public $page_setting_id;

	public $post_id;
	public $single = true;
	public $meta_key;
	public $meta_tmpl_key;
	public $previewed_postmeta_settings = array();

	/**
	 * WP_Customize_Post_Setting constructor.
	 *
	 * @access public
	 *
	 * @param \WP_Customize_Manager $manager Manager.
	 * @param string $id Setting ID.
	 * @param array $args Setting args.
	 *
	 * @throws \Exception If the ID is in an invalid format.
	 * @global array $wp_meta_keys
	 */
	public function __construct( \WP_Customize_Manager $manager, $id, $args = array() ) {

		$parsed_setting_id = self::parse_setting_id( $id );

		if ( ! $parsed_setting_id ) {
			throw new \Exception( 'Illegal setting ID format.' );
		};
		$args = array_merge( $args, $parsed_setting_id );

		$this->page_setting_id = $args['page_setting_id'];
		$this->meta_tmpl_key   = $args['meta_key'];

		if ( 'conditions' === $args['meta_key'] ) {
			$this->meta_key = $args['meta_key'] = '_lwwb_conditions';
		} else {
			$this->meta_key = $args['meta_key'] = '_lwwb_data';
		}
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Parse setting ID.
	 *
	 * @param string $setting_id Setting ID.
	 *
	 * @return array|bool Parsed setting ID or false if parse error.
	 */
	static function parse_setting_id( $setting_id ) {

		if ( ! preg_match( Post_Meta_Settings::ID_PATTERN, $setting_id, $matches ) ) {
			return false;
		}
		if ( $matches['page_setting_id'] == '' ) {
			return false;
		}

		return wp_array_slice_assoc( $matches, array( 'page_setting_id', 'meta_key' ) );
	}

	protected function check_post_cpt() {
		$check        = false;
		$page_meta_id = '';
		$posts        = get_posts( [
			'post_type'   => 'lwwb_external_post',
			'post_status' => 'publish',
			'numberposts' => - 1
		] );

		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post ) {

				$meta_key = get_post_meta( $post->ID, '_lwwb_id', true );

				if ( $meta_key == $this->page_setting_id ) {
					$this->post_id = $post->ID;
					$page_meta_id  = $post->ID;
					$check         = true;
				}
			}
		}

		return array( 'check' => $check, 'page_meta_id' => $page_meta_id );
	}

	protected function insert_post_cpt() {
		// Insert the post into the database
		return wp_insert_post( array(
			'post_title'  => $this->page_setting_id,
			'post_status' => 'publish',
			'post_type'   => 'lwwb_external_post',
		) );
	}

	/**
	 * Return a post's setting value.
	 *
	 * @return mixed Meta value.
	 */
	public function value() {

		if ( ! isset( $value ) ) {
			$value = $this->default;
		}

		return $value;
	}

	/**
	 * Sanitize (and validate) an input.
	 *
	 * @see update_metadata()
	 * @access public
	 *
	 * @param string $value The value to sanitize.
	 *
	 * @return mixed|\WP_Error|null Sanitized post array or WP_Error if invalid (or null if not WP 4.6-alpha).
	 */
	public function sanitize( $value ) {
		if ( $this->meta_tmpl_key == 'header' ) {
			return $this->sanitize_header( $value );
		}
		if ( $this->meta_tmpl_key == 'footer' ) {
			return $this->sanitize_footer( $value );
		}
		if ( $this->meta_tmpl_key == 'hooks' ) {
			return $this->sanitize_hooks( $value );
		}
		$meta_decode = json_decode( $value, true );
		$data        = array();
		foreach ( $meta_decode['content'] as $elmn ) {
			$data[] = self::sanitize_elmn( $elmn );
		}
		$meta_decode['content'] = $data;

		return $meta_decode;
	}


	public static function sanitize_elmn( $elmn ) {

		$elmn_data  = array(
			'elmn_id'    => $elmn['elmn_id'],
			'elmn_type'  => $elmn['elmn_type'],
			'elmn_data'  => $elmn['elmn_data'],
			'elmn_child' => array(),
		);
		$elmn_child = array();
		if ( ! empty( $elmn['elmn_child'] ) ) {
			foreach ( $elmn['elmn_child'] as $data_child ) {
				$elmn_child[] = self::sanitize_elmn( $data_child );
			}
		}
		$elmn_data['elmn_child'] = $elmn_child;

		return $elmn_data;
	}

	public function sanitize_header( $value ) {
		$page_id     = $this->check_post_cpt();
		$meta_decode = array(
			'header'  => '',
			'footer'  => '',
			'content' => '',
			'hooks'   => '',
		);
		$meta_page   = get_post_meta( $page_id['page_meta_id'], '_lwwb_data', true );
		if ( ! empty( $meta_page ) ) {
			$meta_decode = json_decode( $meta_page, true );
		}
		$meta_decode['header'] = intval( $value );

		return $meta_decode;
	}

	public function sanitize_footer( $value ) {
		$page_id     = $this->check_post_cpt();
		$meta_decode = array(
			'header'  => '',
			'footer'  => '',
			'content' => '',
			'hooks'   => '',
		);
		$meta_page   = get_post_meta( $page_id['page_meta_id'], '_lwwb_data', true );
		if ( ! empty( $meta_page ) ) {
			$meta_decode = json_decode( $meta_page, true );
		}
		$meta_decode['footer'] = intval( $value );

		return $meta_decode;
	}

	public function sanitize_hooks( $value ) {
		$page_id     = $this->check_post_cpt();
		$meta_decode = array(
			'header'  => '',
			'footer'  => '',
			'content' => '',
			'hooks'   => '',
		);
		$meta_page   = get_post_meta( $page_id['page_meta_id'], '_lwwb_data', true );
		if ( ! empty( $meta_page ) ) {
			$meta_decode = json_decode( $meta_page, true );
		}
		$meta_decode['hooks'] = json_decode( $value );

		return $meta_decode;
	}

	/**
	 * Add filter to preview customized value.
	 *
	 * @return bool
	 */
	public function preview() {
		if ( $this->is_previewed ) {
			return true;
		}

		$page_id = $this->check_post_cpt();
		if ( ! $page_id['check'] ) {
			$meta_decode = (object) array(
				'header'  => '',
				'footer'  => '',
				'content' => '',
				'hooks'   => '',
			);
			$cpt_id      = $this->insert_post_cpt();
			if ( $cpt_id ) {
				update_post_meta( $cpt_id, '_lwwb_data', json_encode( $meta_decode ) );
				update_post_meta( $cpt_id, '_lwwb_id', $this->page_setting_id );
			}
		}
		$page_id_new = $this->check_post_cpt();
		if ( ! isset( $this->previewed_postmeta_settings[ $page_id_new['page_meta_id'] ] ) ) {
			$this->previewed_postmeta_settings[ $page_id_new['page_meta_id'] ] = array();
		}
		$this->previewed_postmeta_settings[ $page_id_new['page_meta_id'] ][ $this->meta_key ] = $this;
		$this->add_preview_filters();
		$this->is_previewed = true;

		return true;

	}

	/**
	 * Add preview filters for post and post meta settings.
	 */
	public function add_preview_filters() {
		if ( $this->has_preview_filters ) {
			return false;
		}

		add_filter( 'get_post_metadata', array( $this, 'filter_get_post_meta_to_preview' ), 1000, 4 );
		$this->has_preview_filters = true;

		return true;
	}

	/**
	 * Filter postmeta to inject customized post meta values.
	 *
	 * @param null|array|string $value The value get_metadata() should return - a single metadata value, or an array of values.
	 * @param int $object_id Object ID.
	 * @param string $meta_key Meta key.
	 * @param bool $single Whether to return only the first value of the specified $meta_key.
	 *
	 * @return mixed Value.
	 */
	public function filter_get_post_meta_to_preview( $value, $object_id, $meta_key, $single ) {

		static $is_recursing = false;
		$should_short_circuit = (
			$is_recursing
			||
			// Abort if another filter has already short-circuited.
			null !== $value
			||
			// Abort if the post has no meta previewed.
			! isset( $this->previewed_postmeta_settings[ $object_id ] )
			||
			( '' !== $meta_key && ! isset( $this->previewed_postmeta_settings[ $object_id ][ $meta_key ] ) )
		);

		if ( $should_short_circuit ) {
			if ( is_null( $value ) ) {
				return null;
			} elseif ( ! $single && ! is_array( $value ) ) {
				return array( $value );
			} else {
				return $value;
			}
		}
		/**
		 * Setting.
		 *
		 * @var WP_Customize_Postmeta_Setting $postmeta_setting
		 */


		if ( '' !== $meta_key ) {

			$post_values      = $this->manager->unsanitized_post_values();
			$postmeta_setting = $this->previewed_postmeta_settings[ $object_id ][ $meta_key ];

			$can_preview = (
				$postmeta_setting
				&&
				array_key_exists( $postmeta_setting->id, $post_values )
			);

			$is_recursing = true;
			$meta_decode  = (object) array(
				'header'  => '',
				'footer'  => '',
				'content' => '',
				'hooks'   => '',
			);
			$meta_page    = get_post_meta( $this->post_id, '_lwwb_data', true );

			if ( isset( $meta_page ) && $meta_page != '' ) {
				$meta_decode = json_decode( $meta_page );
			}
			if ( ! $can_preview ) {
				return null;
			}


			if ( isset( $meta_decode ) && $meta_decode != '' ) {

				foreach ( $post_values as $post_key => $post_value ) {
					preg_match( Post_Meta_Settings::ID_PATTERN, $post_key, $matches );
					if ( $matches['meta_key'] == 'data' ) {
						$data_content         = json_decode( $post_value );
						$meta_decode->content = $data_content->content;
					}
					if ( $matches['meta_key'] == 'header' && isset( $meta_decode->header ) ) {
						$meta_decode->header = intval( $post_value );
					}

					if ( $matches['meta_key'] == 'footer' && isset( $meta_decode->footer ) ) {
						$meta_decode->footer = intval( $post_value );
					}
					if ( $matches['meta_key'] == 'hooks' && isset( $meta_decode->hooks ) ) {
						$meta_decode->hooks = $post_value;
					}

				}
			} else {
				$meta_decode = json_decode( $value );
			}


			$value = json_encode( $meta_decode );


			$is_recursing = false;

			if ( $postmeta_setting->single ) {
				return $single ? $value : array( $value );
			} else {
				return $single ? $value[0] : $value;
			}

		}
	}

	/**
	 * Update the post.
	 *
	 * Please note that the capability check will have already been done.
	 *
	 * @see \WP_Customize_Setting::save()
	 *
	 * @param string $meta_value The value to update.
	 *
	 * @return bool The result of saving the value.
	 */
	protected function update( $meta_value ) {
		$css_method = get_option( 'lwwb_settings' );
		if ( $css_method['css_print_method'] == 'external_file' ) {
			$style = '';
			foreach ( $meta_value['content'] as $elmn ) {
				$style .= Generate_Style::get_elmn_style( $this->page_setting_id, $elmn );
			}
			Post_Meta_Settings::create_css_file( $this->page_setting_id, $style );
		}
		$page_check = $this->check_post_cpt();
		$json_value = wp_slash( wp_json_encode( $meta_value ) );

		if ( $page_check['check'] ) {
			$result = update_post_meta( $this->post_id, '_lwwb_data', $json_value );
		} else {
			$cpt_id = $this->insert_post_cpt();
			if ( $cpt_id ) {
				update_post_meta( $cpt_id, '_lwwb_id', $this->page_setting_id );
				$result = update_post_meta( $cpt_id, '_lwwb_data', $json_value );
			}
		}

		return ( false !== $result );
	}
}