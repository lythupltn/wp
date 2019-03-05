<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    lwwb.core
 * @subpackage lwwb.core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Frontend;

use Lwwb\Base\Base_Controller;
use Lwwb\Base\Common\Common;

class Auto_Css extends Base_Controller {
	public $font_name = array();

	public function register() {
		add_action( 'template_redirect', array( $this, 'get_elmn_data_from_db' ) );
		add_action( 'template_redirect', array( $this, 'get_css_header_footer_from_db' ) );
		add_filter( 'body_class', array( $this, 'add_body_classes' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_google_fonts' ) );
		$css_method = get_option( 'lwwb_settings' );


		if ( $css_method['css_print_method'] == 'external_file' ) {
//			add_action( 'customize_save', array( $this, 'create_css_file' ), 999999 );
		} else {
			add_action( 'wp_head', array( $this, 'add_css_to_head' ) );
		}
	}

	public function enqueue_css_file() {
		$page_id     = Common::get_current_page_id();
		$upload_path = wp_upload_dir();
		$file_url    = $upload_path['baseurl'] . '/laser/lwwb_' . $page_id . '-style.css';
		$file_path   = $upload_path['basedir'] . DIRECTORY_SEPARATOR . 'laser' . DIRECTORY_SEPARATOR . 'lwwb_' . $page_id . '-style.css';
		$css_method  = get_option( 'lwwb_settings' );
		if ( isset( $_REQUEST['customize_messenger_channel'] ) ) {
			return;
		}

		if ( $css_method['css_print_method'] != 'external_file' && file_exists( $file_path ) ) {
			wp_dequeue_style( 'lwwb_' . $page_id . '-style' );
		} else {
			if ( ! file_exists( $file_path ) ) {
				return;
			}
			wp_enqueue_style( 'lwwb_' . $page_id . '-style', $file_url, array(), LWWB_PLUGIN_VERSION );
		}
	}

	// get css from db
	public function get_elmn_data_from_db() {
		$page_id   = Common::get_current_page_id();
		$page_data = $this->get_data_by_id( $page_id );
		$data_arg  = json_decode( json_encode( $page_data ), true );
		$style     = '';
		if ( $data_arg ) {
			foreach ( $data_arg as $data ) {
				$style .= $this->get_elmn_style( $data );
			}

		}

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_css_file' ) );

		return $style;
	}

	// get css header + footer from db
	public function get_css_header_footer_from_db() {
		$page_id   = Common::get_current_page_id();
		$page_data = $this->get_data_by_page_id( $page_id );
		$style     = '';

		if ( isset( $page_data ) && ! empty( $page_data ) && $page_data->header != '' ) {
			$header_data = $this->get_data_by_id( $page_data->header );
			$data_arg    = json_decode( json_encode( $header_data ), true );
			if ( $data_arg ) {
				foreach ( $data_arg as $data ) {
					$style .= $this->get_elmn_style( $data );
				}

			}
		}
		if ( isset( $page_data ) && ! empty( $page_data ) && $page_data->footer != '' ) {
			$footer_data = $this->get_data_by_id( $page_data->footer );
			$data_arg    = json_decode( json_encode( $footer_data ), true );
			if ( $data_arg ) {
				foreach ( $data_arg as $data ) {
					$style .= $this->get_elmn_style( $data );
				}

			}
		}

		return $style;
	}

	function add_body_classes( $classes ) {
		$page_id   = Common::get_current_page_id();
		$classes[] = 'lwwb_page_' . $page_id;

		return $classes;
	}

	public function get_elmn_style( $elmn ) {
		$style = '';

		if ( isset( $elmn['elmn_data'] ) && ! empty( $elmn['elmn_data'] ) ) {

			$config_array = $this->get_elmn_config( $elmn['elmn_type'] );
			if ( ! empty( $config_array ) ) {
				$controls = array();
				foreach ( $config_array as $config ) {
					if ( isset( $config['fields'] ) ) {
						$controls = array_merge( $controls, $config['fields'] );
					}
				}
				foreach ( $elmn['elmn_data'] as $key => $data ) {
					foreach ( $controls as $k => $control ) {
						if ( isset( $control['id'] ) && isset( $control['css_format'] ) ) {
							if ( $control['id'] == $key ) {
								$style .= $this->generate_style( $elmn['elmn_data'], $elmn['elmn_type'], $elmn['elmn_id'], $control, $data );
							}
						}
					}
				}
			}

		}

		if ( ! empty( $elmn['elmn_child'] ) ) {
			$style .= $this->get_elmn_child_style( $elmn['elmn_child'] );
		}

		return $style;
	}

	public function get_elmn_child_style( $elmns ) {
		$style = '';
		foreach ( $elmns as $elmn ) {
			$style .= $this->get_elmn_style( $elmn );
		}

		return $style;
	}

	public function get_elmn_config( $elmn_type ) {
		$elmn_configs = apply_filters( 'lwwb/builder/elmn/config', array() );

		return $elmn_configs[ $elmn_type ]['controls'];
	}

	public function generate_style( $elmn_data, $elmn_type, $elmn_id, $control, $data ) {
		$style = '';
		if ( ! $this->check_for_render_style( $control, $elmn_data ) ) {
			return $style;
		}
		$page_id = Common::get_current_page_id();

		$css     = str_replace( 'ELMN_WRAPPER', '.lwwb-elmn-' . $elmn_id, $control['css_format'] );
		if ( 'lwwb_custom_css' != $elmn_type ) {
			$css = '.lwwb_page_' . $page_id . ' ' . $css;
		}
		$settings              = get_option( 'lwwb_settings' );
		$responsive_breakpoint = $settings['responsive_breakpoint'];

		if ( ! is_array( $data ) && $data != '' ) {

			if ( strpos( $css, 'font-family' ) ) {
				$this->font_name[] = $data;
				$style             .= str_replace( '{{ VALUE }}', '"' . $data . '"', $css );
			} else {
//				$style .= str_replace( '{{ VALUE }}', $data, $css );
				$style .= $this->replace_value( $data, $css );
			}
		} else {
			if ( isset( $control['device_config'] ) ) {

				$device_css = $css;

				foreach ( $control['device_config'] as $device => $device_config ) {
					$use_css = false;

					$device_data = array_filter( $data, function ( $key ) use ( $device ) {
						return ( strpos( $key, $device ) !== false ) ? true : false;
					}, ARRAY_FILTER_USE_KEY );

					$data_format = array();
					foreach ( $device_data as $key => $value ) {
						if ( '' != $value ) {
							$key                 = str_replace( $device . '-', '', $key );
							$use_css             = true;
							$data_format[ $key ] = $value;
							$device_css          = ( isset( $responsive_breakpoint[ $device ] ) && $responsive_breakpoint[ $device ] != '' ) ? '@media screen and (min-width:' . $responsive_breakpoint[ $device ] . 'px) {' . $this->replace_value( $data_format, $device_css ) . ' } ' : $this->replace_value( $data_format, $device_css );
						} else {
							$use_css    = false;
							$device_css = '';
							break;
						}
					}
					if ( $use_css ) {
						$style .= $device_css;
					}
				}


			} else {
				$style .= $this->replace_value( $data, $css );
			}

		}


		return $style;
	}

	public function check_for_render_style( $control, $elmn_data ) {
		$should_render = true;
		if ( ! isset( $control['dependencies'] ) ) {
			return true;
		}
		$dp_array = array_filter( $control['dependencies'], function ( $dp ) {
			return isset( $dp['check_for_render_style'] );
		} );

		if ( empty( $dp_array ) ) {
			return true;
		}
		foreach ( $dp_array as $dp ) {
			$should_render = $this->_operators( $elmn_data[ $dp['control'] ], $dp['operator'], $dp['value'] ) ? true : false;
			if ( ! $should_render ) {
				return false;
			}
		}

		return $should_render;
	}

	public function _operators( $a, $operator, $b ) {
		switch ( $operator ) {
			case '===':
				return $a === $b;
				break;
			case '!=':
				return $a != $b;
				break;
			case '>':
				return $a > $b;
				break;
			case '<':
				return $a < $b;
				break;
			case '<=':
				return $a <= $b;
				break;
			case '>=':
				return $a >= $b;
				break;
			case '+':
				return $a + $b;
				break;
			case '-':
				return $a - $b;
				break;
			case '*':
				return $a * $b;
				break;
			case '/':
				return $a / $b;
				break;
			case '%':
				return $a % $b;
				break;
			case 'in':
				return ( strpos( $b, $a ) );
				break;
			default:
				return false;
				break;
		}


	}

	public function replace_value( $data, $css ) {
		$style = $css;

		preg_match_all( '/{{(.+?)}}/', $style, $matches );
		if ( is_array( $data ) ) {
			foreach ( $data as $key => $value ) {
				foreach ( $matches[0] as $match ) {
					preg_match_all( '/{{(.+?)}}/', $match, $key_match );
					if ( trim( $key_match[1][0] ) == strtoupper( $key ) ) {
						$style = str_replace( $match, $value, $style );
					}
				}
			}
		} else {
			foreach ( $matches[0] as $match ) {
				$style = str_replace( $match, $data, $style );
			}

		}

		return $style;
	}

	public function add_css_to_head() {
		$style = '';
		if ( ! isset( $_REQUEST['customize_messenger_channel'] ) ) {
			$style .= $this->get_elmn_data_from_db();
		}
		$style .= $this->get_css_header_footer_from_db();
		echo '<style>' . $style . '</style>';
	}

	public function load_google_fonts() {
		$url             = '//fonts.googleapis.com/css?family=';
		$font_fontweight = '';
		$i               = 0;
		if ( empty( $this->font_name ) ) {
			return;
		}
		foreach ( $this->font_name as $font ) {
			$i ++;
			$font       = str_replace( ' ', '+', $font );
			$fontweight = ':300,400,400i,500,600,700,800,900';
			( $i == count( $this->font_name ) ) ? ( $font_fontweight .= $font . $fontweight ) : ( $font_fontweight .= $font . $fontweight . '|' );
		}
		wp_enqueue_style( 'google-fonts', $url . $font_fontweight, array(), LWWB_PLUGIN_VERSION );
	}

	public function create_css_file() {

		$page_id    = Common::get_current_page_id();
		$style      = $this->get_elmn_data_from_db();
		$output_css = $this->minify_css( $style );

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

	public function minify_css( $css = '' ) {

		// Return if no CSS
		if ( ! $css ) {
			return;
		}

		// Normalize whitespace
		$css = preg_replace( '/\s+/', ' ', $css );

		// Remove ; before }
		$css = preg_replace( '/;(?=\s*})/', '', $css );

		// Remove space after , : ; { } */ >
		$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

		// Remove space before , ; { }
		$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );

		// Strips leading 0 on decimal values (converts 0.5px into .5px)
		$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

		// Strips units if value is 0 (converts 0px to 0)
		$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

		// Trim
		$css = trim( $css );

		// Return minified CSS
		return $css;

	}

	public static function get_data_by_id_old( $id ) {
		$post        = get_post( $id );

		$decode_data = array();
		$result      = '';
		if ( $post) {

			$data        = get_post_meta( $post->ID, '_lwwb_data', true );
			$decode_data = json_decode( $data );

		} else {
			$posts = get_posts( [
				'post_type'   => 'lwwb_external_post',
				'post_status' => 'publish',
				'numberposts' => - 1
			] );

			if ( ! empty( $posts ) ) {
				foreach ( $posts as $post ) {
					$meta_key = get_post_meta( $post->ID, '_lwwb_id', true );
					if ( $meta_key == $id ) {
						$data        = get_post_meta( $post->ID, '_lwwb_data', true );
						$decode_data = json_decode( $data );
					}
				}
			}
		}
		if ( ! empty( $decode_data->content ) ) {
			$result = $decode_data->content;
		}

		return $result;
	}

	public function get_data_by_page_id_old( $id ) {
		$post        = get_post( $id );
		$decode_data = array();

		if ( $post ) {
			$data        = get_post_meta( $post->ID, '_lwwb_data', true );
			$decode_data = json_decode( $data );
		} else {
			$posts = get_posts( [
				'post_type'   => 'lwwb_external_post',
				'post_status' => 'publish',
				'numberposts' => - 1
			] );

			if ( ! empty( $posts ) ) {
				foreach ( $posts as $post ) {
					$meta_key = get_post_meta( $post->ID, '_lwwb_id', true );
					if ( $meta_key == $id ) {
						$data        = get_post_meta( $post->ID, '_lwwb_data', true );
						$decode_data = json_decode( $data );
					}
				}
			}
		}

		return $decode_data;
	}


}