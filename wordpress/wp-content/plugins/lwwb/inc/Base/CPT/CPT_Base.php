<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Base\CPT;

use Lwwb\Base\Base_Controller;

class CPT_Base extends Base_Controller {

	public $ctp = array();
	public $post_type;
	public $ctp_taxonomy = array();
	public $taxonomy;

	public function register() {
		if ( ! empty( $this->ctp ) ) {
			add_action( 'init', array( $this, 'register_post_type' ) );
		}
		if ( ! empty( $this->ctp_taxonomy ) ) {
			add_action( 'init', array( $this, 'register_taxonomy' ) );
		}

	}

	// Register custom post type
	public function register_post_type() {
		register_post_type( $this->post_type, $this->ctp );
	}

	// Register custom taxonomy
	public function register_taxonomy() {
		register_taxonomy( $this->taxonomy, $this->post_type, $this->ctp_taxonomy );
	}

}