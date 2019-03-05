<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Base\Hooks;

use Lwwb\Admin\Base\Base_Admin_Controller;
use Lwwb\Base\Base_Controller;
use Lwwb\Base\Common\Common;
use Lwwb\Base\CPT\CPT_Library;
use Lwwb\Frontend\Generate_Style;

class Hook_Base extends Base_Controller {

	public function register() {
		add_filter( 'the_content', array( $this, 'extra_content' ), 999, 1 );
		add_action( 'template_redirect', array( $this, 'enable_hook_builder' ) );
		add_action( 'template_redirect', array( $this, 'add_hooks' ) );

	}

	public function add_hooks() {

		if ( is_customize_preview() && isset( $_REQUEST['customize_messenger_channel'] ) ) {

			if ( isset( $_REQUEST['lwwb_library_type'] ) && ( $_REQUEST['lwwb_library_type'] == 'header' || $_REQUEST['lwwb_library_type'] == 'footer' ) ) {
				add_action( 'lwwb_theme_header', array( $this, 'render_header_builder' ) );
				add_action( 'lwwb_theme_footer', array( $this, 'render_footer_builder' ) );

				return;
			}
			$decode_data = $this->get_data();
			$all_hooks = array_keys(self::get_builder_hooks());
			$hooks_exclude = array();
		
			if(isset($decode_data->hooks)){
				if(is_array($decode_data->hooks)){  $decode_data->hooks = json_encode($decode_data->hooks); }
				$hooks_exclude = ( !empty($decode_data->hooks) ) ? json_decode($decode_data->hooks) : $hooks_exclude;
			}

			$hooks = array_diff($all_hooks,$hooks_exclude);

			foreach ( $hooks as $hook ) {
				add_action( $hook, function () use ( $hook ) {
					if ( ! is_singular() && ( $hook == 'lwwb_before_content' || $hook == 'lwwb_after_content' ) ) {
						return;
					}
					echo '<div id="lwwb-content-wrapper-' . $hook . '">
					        <div class="lwwb-content-wrapper lwwb-content-wrapper-' . $hook . ' ui-sortable"><h1>End</h1></div>
					    </div>';
				} );
			}
		}
	}


	public function enable_hook_builder() {
		$decode_data = $this->get_data();
		if ( ! $decode_data || ( isset( $_REQUEST['lwwb_library_type'] ) && ( ( $_REQUEST['lwwb_library_type'] === 'footer' ) || ( 'header' === $_REQUEST['lwwb_library_type'] ) ) ) ) {
			return;
		}
		if ( isset( $decode_data->header ) && $decode_data->header != '' ) {
			$header_data = Generate_Style::get_data_by_id($decode_data->header);
			if($header_data){
				add_action( 'get_header', array( CPT_Library::class, 'get_header' ) );
			}
		}
		if ( isset( $decode_data->footer ) && $decode_data->footer != '' ) {
			$footer_id = $decode_data->footer ;
			if('publish' === get_post_status($footer_id)){
				add_action( 'get_footer', array( CPT_Library::class, 'get_footer' ) );
			}
		}
	}


	public function extra_content( $content ) {
		ob_start();
		do_action( 'lwwb_before_content' );
		echo get_the_content();
		do_action( 'lwwb_after_content' );
		$content = ob_get_clean();

		return $content;
	}


	public function render_header_builder() {
		echo '<div id="lwwb-content-wrapper-lwwb_theme_header">
			        <div class="lwwb-content-wrapper lwwb-content-wrapper-header-builder ui-sortable"><h1>Content Header</h1></div>
			    </div>';
	}

	public function render_footer_builder() {
		echo '<div id="lwwb-content-wrapper-lwwb_theme_footer">
			        <div class="lwwb-content-wrapper lwwb-content-wrapper-footer-builder ui-sortable"><h1>Content Footer</h1></div>
			    </div>';
	}


	public static function get_builder_hooks() {
		$default_hook = array(
			'loop_start'          => esc_html__( 'Loop Start', 'lwwb' ),
			'loop_end'            => esc_html__( 'Loop End', 'lwwb' ),
			'lwwb_before_content' => esc_html__( 'Before Content', 'lwwb' ),
			'lwwb_after_content'  => esc_html__( 'After Content', 'lwwb' ),
		);

		$hooks = apply_filters( 'lwwb_builder_hooks', array() );

		return array_merge( $default_hook, $hooks );

	}
	public function get_data() {
		$page_id     = Common::get_current_page_id();
		$post        = get_post( $page_id );
		$decode_data = array();
		if ( $post ) {
			$data        = get_post_meta( $page_id, '_lwwb_data', true );
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
					if ( $meta_key == $page_id ) {
						$data        = get_post_meta( $post->ID, '_lwwb_data', true );
						$decode_data = json_decode( $data );
					}
				}
			}
		}

		return $decode_data;
	}

}