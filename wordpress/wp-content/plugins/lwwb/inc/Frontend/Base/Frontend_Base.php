<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    lwwb.core
 * @subpackage lwwb.core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Frontend\Base;

use Lwwb\Base\Base_Controller;
use Lwwb\Base\Common\Common;
use Lwwb\Base\Hooks\Hook_Base;
use Lwwb\Builder\Elmn_Manager as Elmn_Manager;
use Lwwb\Frontend\Generate_Style;

class Frontend_Base extends Base_Controller {
	public $data;

	public function register() {
		add_action( 'template_redirect', array( $this, 'add_hooks' ) );

	}

	// get hooks
	public function get_hooks() {
		$id          = Common::get_current_page_id();
		$post        = get_post( $id );
		$decode_data = array();
		$result      = array();
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

		if ( isset( $decode_data->hooks ) && ! empty( $decode_data->hooks ) ) {
			$result = $decode_data->hooks;
		}

		return $result;
	}

	// get_data
	public function get_data() {
		$id          = Common::get_current_page_id();
		$post        = get_post( $id );
		$decode_data = array();
		$result      = array();
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


		if ( ! empty( $decode_data->content ) ) {
			$result = $decode_data->content;
		}
		if ( ! empty( $decode_data ) && $decode_data->header ) {
			$header_data = Generate_Style::get_data_by_id( $decode_data->header ) ;

			if($header_data){
				$result = array_merge( $result, Generate_Style::get_data_by_id( $decode_data->header ) );
			}
		}

		if ( ! empty( $decode_data ) && $decode_data->footer ) {
			$footer_data = Generate_Style::get_data_by_id( $decode_data->footer );
			if($footer_data){
				$result = array_merge( $result, Generate_Style::get_data_by_id( $decode_data->footer ) );
			}
		}


		return $result;
	}

	// add_hooks
	public function add_hooks() {
		$this->add_header_footer_hooks();
		if ( isset( $_REQUEST['customize_messenger_channel'] ) ) {
			return;
		}
		wp_dequeue_style( $this->plugin_prefix . '-builder' );
		$data = $this->get_data();

		$all_hooks     = array_keys( Hook_Base::get_builder_hooks() );
		$hooks_exclude = $this->get_hooks();
		$hooks         = array_diff( $all_hooks, $hooks_exclude );

		foreach ( $hooks as $hook ) {

			add_action( $hook, function () use ( $hook, $data ) {
				if ( ! is_singular() && ( $hook == 'lwwb_before_content' || $hook == 'lwwb_after_content' ) ) {
					return;
				}
				$key = array_search( $hook, array_column( $data, 'elmn_id' ) );
				if ( $key === false ) {
					return;
				}

				$this->render_elmn( $data, $key );
			} );
		}

	}

	public function add_header_footer_hooks() {
		if ( isset( $_REQUEST['lwwb_library_type'] ) && ( $_REQUEST['lwwb_library_type'] == 'header' || $_REQUEST['lwwb_library_type'] == 'footer' ) ) {
			return;
		}

		$data     = $this->get_data();
		$data_arg = json_decode( json_encode( $data ), true );



		foreach ( $data_arg as $data_hook ) {

			if ( isset($data_hook['elmn_type']) && !empty($data_hook['elmn_type']) && $data_hook['elmn_type'] == 'lwwb_theme_header' ) {
				add_action( 'lwwb_theme_header', array( $this, 'render_lwwb_theme_header' ) );
			}
			if ( isset($data_hook['elmn_type']) && !empty($data_hook['elmn_type']) && $data_hook['elmn_type'] == 'lwwb_theme_footer' ) {
				add_action( 'lwwb_theme_footer', array( $this, 'render_lwwb_theme_footer' ) );
			}
		}
	}

	public function render_lwwb_theme_header() {
		$data = $this->get_data();
		$key  = array_search( 'lwwb_theme_header', array_column( $data, 'elmn_id' ) );
		if ( $key === false ) {
			return;

		}

		$this->render_elmn( $data, $key );
		// Data hook: lwwb_theme_header   $data[$key]
	}

	public function render_lwwb_theme_footer() {
		$data = $this->get_data();
		$key  = array_search( 'lwwb_theme_footer', array_column( $data, 'elmn_id' ) );
		if ( $key === false ) {
			return;
		}

		$this->render_elmn( $data, $key );
		// Data hook: lwwb_theme_footer   $data[$key]
	}

	public function render_elmn( $data, $key ) {

		foreach ( $data[ $key ]->elmn_child as $elmn ) {
			$elmn      = json_decode( json_encode( $elmn ), true );
			$elmn_keys = array_keys( Elmn_Manager::get_instance()->elmns );

			if ( in_array( $elmn['elmn_type'], $elmn_keys ) ) {
				$elmn_class = Elmn_Manager::get_instance()->elmns[ $elmn['elmn_type'] ]['class_name'];
				$elmn_obj   = new $elmn_class( $elmn );
				if(method_exists($elmn_obj,'custom_enqueue')){
					$elmn_obj->custom_enqueue();
				}
				$elmn_obj->render();
			}

		}
	}

}