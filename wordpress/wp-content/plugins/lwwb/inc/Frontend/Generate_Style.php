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

class Generate_Style extends Base_Controller {

	public static function get_elmn_config( $elmn_type ) {
		$elmn_configs = apply_filters( 'lwwb/builder/elmn/config', array() );

		return $elmn_configs[ $elmn_type ]['controls'];
	}

	public static function _operators( $a, $operator, $b ) {
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

	public static function check_for_render_style( $control, $elmn_data ) {
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

			$should_render = self::_operators( $elmn_data[ $dp['control'] ], $dp['operator'], $dp['value'] ) ? true : false;
			if ( ! $should_render ) {
				return false;
			}
		}

		return $should_render;
	}

	public static function replace_value( $data, $css ) {
		$style = $css;

		preg_match_all( '/{{(.+?)}}/', $style, $matches );
		if ( is_array( $data ) ) {
			$devices = array(
				'desktop',
				'tablet',
				'mobile'
			);
			foreach ( $data as $device => $device_data ) {
				if ( in_array( $device, $devices ) ) {
					foreach ( $device_data as $key => $value ) {
						foreach ( $matches[0] as $match ) {
							preg_match_all( '/{{(.+?)}}/', $match, $key_match );
							if ( trim( $key_match[1][0] ) == strtoupper( $key ) ) {
								$style = str_replace( $match, $value, $style );
							}
						}
					}
				} else {
					foreach ( $matches[0] as $match ) {
						preg_match_all( '/{{(.+?)}}/', $match, $key_match );
						if ( trim( $key_match[1][0] ) == strtoupper( $device ) ) {
							$style = str_replace( $match, $device_data, $style );
						}
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

	public static function minify_css( $css = '' ) {

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

	public static function get_elmn_style( $page_id, $elmn ) {
		$style = '';

		if ( isset( $elmn['elmn_data'] ) && ! empty( $elmn['elmn_data'] ) ) {

			$config_array = self::get_elmn_config( $elmn['elmn_type'] );
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
								$style .= self::generate_style( $elmn['elmn_data'], $elmn['elmn_id'], $control, $data, $page_id );
							}
						}
					}
				}
			}

		}

		if ( ! empty( $elmn['elmn_child'] ) ) {
			$style .= self::get_elmn_child_style( $page_id, $elmn['elmn_child'] );
		}

		return $style;
	}

	public static function generate_style( $elmn_data, $elmn_id, $control, $data, $page_id ) {
		$style = '';

		if ( ! self::check_for_render_style( $control, $elmn_data ) ) {
			return $style;
		}

		$css                   = str_replace( 'ELMN_WRAPPER', '.lwwb-elmn-' . $elmn_id, $control['css_format'] );
		$settings              = get_option( 'lwwb_settings' );
		$responsive_breakpoint = $settings['responsive_breakpoint'];


		if ( isset( $elmn_data['classes'] ) && strpos( $elmn_data['classes'], 'is-narrow' ) > - 1 ) {
			$css = '.is-narrow' . $css;
		}

		if ( strpos( $control['css_format'], 'ELMN_WRAPPER' ) > - 1 ) {
			$css = '.lwwb_website_page_builder ' . $css;
		}
		if ( isset( $control['on_device'] ) ) {
			$device            = $control['on_device'];
			$mobile_breakpoint = $responsive_breakpoint['mobile'];
			$tablet_breakpoint = $responsive_breakpoint['tablet'];
			if ( $device === 'desktop' ) {
				$css = '@media screen and (min-width:' . $tablet_breakpoint . 'px){' . $css . '}';
			}
			if ( $device === 'tablet' ) {
				$css = '@media screen and (max-width:' . intval($tablet_breakpoint - 1) . 'px) and (min-width:' . intval($mobile_breakpoint) . 'px){' . $css . '}';
			}
			if ( $device === 'mobile' ) {
				$css = '@media screen and (max-width:' . $mobile_breakpoint . 'px){' . $css . '}';
			}
		}


		if ( ! is_array( $data ) && $data != '' ) {
			$style .= self::replace_value( $data, $css );
		} else {
			$style .= self::replace_value( $data, $css );
		}

		return $style;
	}

	public static function get_elmn_child_style( $page_id, $elmns ) {
		$style = '';
		foreach ( $elmns as $elmn ) {
			$style .= self::get_elmn_style( $page_id, $elmn );
		}

		return $style;
	}

	public static function get_font_data( $elmn ) {
		$elmn_configs = apply_filters( 'lwwb/builder/elmn/config', array() );
		$fonts        = array();

		if ( isset( $elmn['elmn_data'] ) && ! empty( $elmn['elmn_data'] ) && empty( $elmn['elmn_child'] ) ) {
			$config_array = $elmn_configs[ $elmn['elmn_type'] ]['controls'];
			if ( ! empty( $config_array ) ) {
				$controls = array();
				foreach ( $config_array as $config ) {
					if ( isset( $config['fields'] ) ) {
						$controls = array_merge( $controls, $config['fields'] );
					}
				}
				foreach ( $elmn['elmn_data'] as $key => $data ) {
					if ( ! is_array( $data ) && $data != '' ) {
						foreach ( $controls as $k => $control ) {
							if ( isset( $control['id'] ) && isset( $control['css_format'] ) ) {
								if ( $control['id'] == $key ) {
									if ( strpos( $control['css_format'], 'font-family' ) ) {
										$fonts[] = $data;
									}
								}
							}
						}
					}
				}
			}
		}
		if ( ! empty( $elmn['elmn_child'] ) ) {
			$elmn_fonts = $elmn['elmn_child'];
			foreach ( $elmn_fonts as $elmn_font ) {
				$fonts = array_merge( self::get_font_data( $elmn_font ), $fonts );
			}
		}

		return $fonts;

	}

	public static function get_data_by_id( $id ) {
		$post = get_post( $id );

		$decode_data = array();
		$result      = '';
		if ( $post ) {
			if ( 'publish' !== get_post_status( $id ) ) {
				return false;
			}
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
}