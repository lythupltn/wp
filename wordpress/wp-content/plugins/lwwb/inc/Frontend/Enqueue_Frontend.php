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

class Enqueue_Frontend extends Base_Controller {

	public function register() {
		add_action( 'template_redirect', array( $this, 'enqueue' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_google_fonts' ) );
		add_filter( 'body_class', array( $this, 'add_body_classes' ) );

	}

	public function enqueue() {
		if ( isset( $_REQUEST['customize_changeset_uuid'] ) ) {
			add_action( 'wp_head', array( $this, 'add_css_to_head' ) );
		}
		$css_method = get_option( 'lwwb_settings' );
		if ( $css_method['css_print_method'] == 'external_file' ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_css_file' ) );
		} else {
			add_action( 'wp_head', array( $this, 'add_css_to_head' ) );
		}

	}

	public function enqueue_css_file() {
		$page_id     = Common::get_current_page_id();
		$page_data = self::get_data_by_page_id( );
		$data_arg  = json_decode( json_encode( $page_data ), true );

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
			if(isset($data_arg['header']) && $data_arg['header'] !=''){
				$file_header_url    = $upload_path['baseurl'] . '/laser/lwwb_' . $data_arg['header'] . '-style.css';
				wp_enqueue_style( 'lwwb_' . $data_arg['header'] . '-style', $file_header_url, array(), LWWB_PLUGIN_VERSION );
			}
			if(isset($data_arg['footer']) && $data_arg['footer'] !=''){
				$file_footer_url    = $upload_path['baseurl'] . '/laser/lwwb_' . $data_arg['footer'] . '-style.css';
				wp_enqueue_style( 'lwwb_' . $data_arg['footer'] . '-style', $file_footer_url, array(), LWWB_PLUGIN_VERSION );
			}

		}
	}


	public function add_google_fonts() {
		$fonts = array();
		$elmns = json_decode( json_encode( self::get_data_by_page_id() ), true );

		if ( isset($elmns['header'])  && $elmns['header'] != '' ) {
			$header_font = json_decode( json_encode( self::get_data_by_id( $elmns['header'] ) ), true );
			if($header_font){
				foreach ( $header_font as $data ) {
					$fonts = array_merge( $fonts, Generate_Style::get_font_data( $data ) );
				}
			}
		}
		if (isset($elmns['footer']) && $elmns['footer'] != '' ) {
			$footer_font = json_decode( json_encode( self::get_data_by_id( $elmns['footer'] ) ), true );
			if($footer_font) {
				foreach ( $footer_font as $data ) {
					$fonts = array_merge( $fonts, Generate_Style::get_font_data( $data ) );
				}
			}
		}
		if (isset($elmns['content']) && $elmns['content'] !='' ) {
			foreach ( $elmns['content'] as $elmn ) {
				$fonts = array_merge( $fonts, Generate_Style::get_font_data( $elmn ) );
			}
		}


		$url             = '//fonts.googleapis.com/css?family=';
		$font_fontweight = '';
		$i               = 0;
		if ( empty( $fonts ) ) {
			return;
		}
		foreach ( $fonts as $font ) {
			$i ++;
			$font       = str_replace( ' ', '+', $font );
			$fontweight = ':300,400,400i,500,600,700,800,900';
			( $i == count( $fonts ) ) ? ( $font_fontweight .= $font . $fontweight ) : ( $font_fontweight .= $font . $fontweight . '|' );
		}
		wp_enqueue_style( 'google-fonts', $url . $font_fontweight, array(), LWWB_PLUGIN_VERSION );
	}

	function add_body_classes( $classes ) {
		$page_id   = Common::get_current_page_id();
		$classes[] = 'lwwb_page_' . $page_id;
		$classes[] = 'lwwb_website_page_builder';

		return $classes;
	}

	// get css from db
	public function get_elmn_data_from_db() {
		$page_id   = Common::get_current_page_id();
		$page_data = self::get_data_by_id( $page_id );
		$data_arg  = json_decode( json_encode( $page_data ), true );
		$style     = '';
		if ( $data_arg ) {
			foreach ( $data_arg as $data ) {
				$style .= Generate_Style::get_elmn_style( $page_id, $data );
			}

		}

		return $style;
	}

	public function add_css_to_head() {
		$style = '';
		if ( ! isset( $_REQUEST['customize_messenger_channel'] ) ) {
			$style .= $this->get_elmn_data_from_db();
		}
		$style .= self::get_css_header_footer_from_db();
		echo '<style>' . $style . '</style>';
	}

	public static function get_data_by_id( $id ) {
		$post        = get_post( $id );
		$decode_data = array();
		$result      = '';
		if ( $post ) {
			if('publish' !== get_post_status($id)){
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

	public static function get_data_by_page_id() {
		$id          = Common::get_current_page_id();
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

	// get css header + footer from db

	public static function get_css_header_footer_from_db() {
		$style = '';
		$page_data = self::get_data_by_page_id();


		if (  isset($page_data->header) && $page_data->header !='' ) {
			$header_data = self::get_data_by_id( $page_data->header );
			$data_arg    = json_decode( json_encode( $header_data ), true );

			if ( $data_arg ) {
				foreach ( $data_arg as $data ) {
					$style .= Generate_Style::get_elmn_style( '', $data );
				}
			}
		}
		if ( isset($page_data->footer) && $page_data->footer !='' ) {
			$footer_data = self::get_data_by_id( $page_data->footer );
			$data_arg    = json_decode( json_encode( $footer_data ), true );
			if ( $data_arg ) {
				foreach ( $data_arg as $data ) {
					$style .= Generate_Style::get_elmn_style( '', $data );
				}

			}
		}

		return $style;
	}
}