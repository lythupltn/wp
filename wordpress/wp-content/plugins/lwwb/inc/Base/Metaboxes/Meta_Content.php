<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    lwwb.core
 * @subpackage lwwb.core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Base\Metaboxes;

class Meta_Content extends Meta_Base {
	public function register() {
		parent::register();
		if ( class_exists( 'WPSEO_Options' )  ) {
			add_action( 'init', array( $this, 'yoast_seo_enqueue' ) );
		}
	}

	public function yoast_seo_enqueue() {
		$post = isset($_GET['post']) ? $_GET['post'] : '';
		$value = get_post_meta( $post, 'lwwb_meta_content', true );
		// Send list of fields to JavaScript.
		wp_localize_script( $this->plugin_prefix . '-dashboard', 'LWWBYoastSEO',array(
			'content' => $value
		) );
	}

	public function get_data_metabox() {
		if ( class_exists( 'WPSEO_Options' )  ) {
			$post_types = get_post_types();
			return array(
				'id'            => 'lwwb_meta_content',
				'title'         => 'Lwwb Content for Yoast SEO',
				'screen'        => $post_types,
				'callback'      => array( $this, 'meta_box_content' ),
				'context'       => 'normal',
				'priority'      => 'default',
				'callback_args' => null,
			);
		}
	}

	public function meta_box_content( $post ) {
		$data = $this->get_data_metabox();
		// Add a nonce field so we can check for it later.
		wp_nonce_field( 'lwwb_metabox_nonce', 'lwwb_metabox_nonce' );

		$value = get_post_meta( $post->ID, $data['id'], true );

		echo '<textarea  id="' . $data['id'] . '"> ' . esc_attr( $value ) . ' </textarea>';
	}


}