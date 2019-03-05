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

use Lwwb\Base\Base_Controller;

class Meta_Base extends Base_Controller {

	public function register() {
		add_action( 'add_meta_boxes', array( $this, 'register_metabox' ) );
		add_action( 'save_post', array( $this, 'save_meta_box_data' ) );
	}

	public function get_data_metabox() {
		return array(
			'id'            => '',
			'title'         => '',
			'screen'        => null,
			'callback'      => array( $this, 'metabox_callback' ),
			'context'       => 'advanced',
			'priority'      => 'default',
			'callback_args' => null,
		);
	}

	public function register_metabox() {
		$data = $this->get_data_metabox();
		add_meta_box(
			$data['id'],
			$data['title'],
			$data['callback'],
			$data['screen'],
			$data['context'],
			$data['priority'],
			$data['callback_args']
		);
	}

	function metabox_callback( $post ) {
		$data = $this->get_data_metabox();
		// Add a nonce field so we can check for it later.
		wp_nonce_field( 'lwwb_metabox_nonce', 'lwwb_metabox_nonce' );
		$value = get_post_meta( $post->ID, $data['id'], true );
		echo '<input  value="'.esc_attr( $value ).'" type="text" style="width:100%" id="' . $data['id'] . '" name="' . $data['id'] . '">';
	}

	/**
	 * When the post is saved, saves our custom data.
	 *
	 * @param int $post_id
	 */
	function save_meta_box_data( $post_id ) {
		$data = $this->get_data_metabox();
		// Check if our nonce is set.
		if ( ! isset( $_POST['lwwb_metabox_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['lwwb_metabox_nonce'], 'lwwb_metabox_nonce' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		/* OK, it's safe for us to save the data now. */

		// Make sure that it is set.
		if ( ! isset( $_POST[ $data['id'] ] ) ) {
			return;
		}

		// Sanitize user input.
		$metabox_data = sanitize_text_field( $_POST[ $data['id'] ] );

		// Update the meta field in the database.
		update_post_meta( $post_id, $data['id'], $metabox_data );
	}


}