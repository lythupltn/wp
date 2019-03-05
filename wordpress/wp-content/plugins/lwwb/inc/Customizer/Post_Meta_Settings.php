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

use Lwwb\Base\Common\Content_For_Yoast_SEO;
use Lwwb\Builder\Elmn_Manager;
use Lwwb\Frontend\Generate_Style;

class Post_Meta_Settings extends \WP_Customize_Setting {
	const ID_PATTERN = '/^lwwb_data\[(?P<page_setting_id>\S+)]\[(?P<meta_key>\w+)]$/';

	const TYPE = 'lwwb_post_data';

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
	public $post_type;

	/**
	 * Post ID.
	 *
	 * @access public
	 * @var string
	 */
	public $page_setting_id;
	/**
	 * Meta key.
	 *
	 * @access public
	 * @var string
	 */
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
		}
		$args = array_merge( $args, $parsed_setting_id );
		$post = get_post( $args['page_setting_id'] );

		if ( ! $post ) {
			throw new \Exception( 'Unknown post' );
		}
		$post_type_obj = get_post_type_object( $post->post_type );
		if ( ! $post_type_obj ) {
			throw new \Exception( 'Unrecognized post type: ' . $post->post_type );
		}
		$this->meta_tmpl_key = $args['meta_key'];

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
		if ( ! preg_match( self::ID_PATTERN, $setting_id, $matches ) ) {
			return false;
		}
		$matches['page_setting_id'] = intval( $matches['page_setting_id'] );
		if ( $matches['page_setting_id'] <= 0 ) {
			return false;
		}

		return wp_array_slice_assoc( $matches, array( 'page_setting_id', 'meta_key' ) );
	}

	/**
	 * Create setting ID.
	 *
	 * @param int $post_id Post ID.
	 * @param string $meta_key Meta key.
	 *
	 * @return string Setting ID.
	 */
	static function create_setting_id( $post_id ) {
		return sprintf( '%s[%d]', self::TYPE, $post_id );
	}

	/**
	 * Return a post's setting value.
	 *
	 * @return mixed Meta value.
	 */
	public function value() {
		$single = false; // For the sake of disambiguating empty values in filtering.
		$values = get_post_meta( $this->page_setting_id, $this->meta_key, $single );

		$value = array_shift( $values );
		if ( ! isset( $value ) ) {
			$value = $this->default;
		}

		return $value;
	}

	/**
	 * Sanitize (and validate) an input.
	 *
	 * Note for non-single postmeta, the validation and sanitization callbacks will be applied on each item in the array.
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
			$data[] = External_Post_Meta_Settings::sanitize_elmn( $elmn );
		}
		$meta_decode['content'] = $data;


		return $meta_decode;
	}

	public function sanitize_header( $value ) {
		$meta_decode = array(
			'header'  => '',
			'footer'  => '',
			'content' => '',
			'hooks'   => '',
		);
		$meta_page   = get_post_meta( $this->page_setting_id, '_lwwb_data', true );
		if ( ! empty( $meta_page ) ) {
			$meta_decode = json_decode( $meta_page, true );
		}
		$meta_decode['header'] = intval( $value );

		return $meta_decode;
	}

	public function sanitize_footer( $value ) {
		$meta_decode = array(
			'header'  => '',
			'footer'  => '',
			'content' => '',
			'hooks'   => '',
		);
		$meta_page   = get_post_meta( $this->page_setting_id, '_lwwb_data', true );
		if ( ! empty( $meta_page ) ) {
			$meta_decode = json_decode( $meta_page, true );
		}
		$meta_decode['footer'] = intval( $value );

		return $meta_decode;
	}

	public function sanitize_hooks( $value ) {
		$meta_decode = array(
			'header'  => '',
			'footer'  => '',
			'content' => '',
			'hooks'   => '',
		);
		$meta_page   = get_post_meta( $this->page_setting_id, '_lwwb_data', true );
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
		if ( ! isset( $this->previewed_postmeta_settings[ $this->page_setting_id ] ) ) {
			$this->previewed_postmeta_settings[ $this->page_setting_id ] = array();
		}
		$this->previewed_postmeta_settings[ $this->page_setting_id ][ $this->meta_key ] = $this;

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

			$meta_page = get_post_meta( $this->page_setting_id, '_lwwb_data', true );
			if ( ! empty( $meta_page ) ) {
				$meta_decode = json_decode( $meta_page );
			}

			if ( ! $can_preview ) {
				return null;
			}

			foreach ( $post_values as $post_key => $post_value ) {

				preg_match( self::ID_PATTERN, $post_key, $matches );
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
					$meta_decode->hooks = json_decode( $post_value );

				}

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
			self::create_css_file( $this->page_setting_id, $style );
		}


		$json_value = wp_slash( wp_json_encode( $meta_value ) );
		$result     = update_post_meta( $this->page_setting_id, '_lwwb_data', $json_value );
		if ( class_exists( 'WPSEO_Options' )  ) {
			$this->save_data_yoast_seo( $this->page_setting_id, $meta_value );
		}

		$post = array(
			'post_modified'     => date(),
			'post_modified_gmt' => date(),
			'ID'                => $this->page_setting_id, // $post->ID;
		);
		// update post
		wp_update_post( $post );


		return ( false !== $result );
	}

	public function save_data_yoast_seo( $page_id, $meta_value ) {

		$html_raw = '';
		foreach ( $meta_value['content'] as $elmn ) {
			$html_raw .= $this->recursive_render_elmn( $elmn );
		}
		$html = strip_tags( $html_raw, '<a><p><span><strong><b><i><u><h1><h2><h3><h4><h5><h6><img><label><button>' );
		if ( $html != '' ) {
			update_post_meta( $page_id, 'lwwb_meta_content', $html );
		}
	}

	public function recursive_render_elmn( $elmn ) {
		$html = '';
		if ( ! empty( $elmn['elmn_child'] ) ) {
			foreach ( $elmn['elmn_child'] as $data_child ) {
				$html .= $this->recursive_render_elmn( $data_child );
			}
		} else {
			$html .= $this->render_elmn( $elmn );
		}

		return $html;
	}

	public function render_elmn( $elmn ) {
		$html_raw  = '';
		$elmn_keys = array_keys( Elmn_Manager::get_instance()->elmns );
		if ( in_array( $elmn['elmn_type'], $elmn_keys ) ) {
			$elmn_class = Elmn_Manager::get_instance()->elmns[ $elmn['elmn_type'] ]['class_name'];
			$elmn_obj   = new $elmn_class( $elmn );
			ob_start();
			$elmn_obj->render_content();
			$html_raw = ob_get_contents();
			ob_end_clean();
		}

		return $html_raw;

	}

	public static function create_css_file( $page_id, $style ) {

		$output_css = Generate_Style::minify_css( $style );
		if ( ! $output_css ) {
			return;
		}
// We will probably need to load this file
		require_once( ABSPATH . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'file.php' );

		global $wp_filesystem;
		$upload_dir = wp_upload_dir(); // Grab uploads folder array
		$dir        = trailingslashit( $upload_dir['basedir'] ) . 'laser' . DIRECTORY_SEPARATOR; // Set storage directory path

		WP_Filesystem(); // Initial WP file system
		$wp_filesystem->mkdir( $dir ); // Make a new folder 'oceanwp' for storing our file if not created already.
		$wp_filesystem->put_contents( $dir . 'lwwb_' . $page_id . '-style.css', $output_css, 0644 ); // Store in the file.

	}

}