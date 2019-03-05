<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Builder\Base;

use Lwwb\Builder\Elmn_Manager as Elmn_Manager;

class Elmn_Parent extends Elmn {

	public $childs = array();

	public function __construct( $elmn = array() ) {
		parent::__construct( $elmn );
		if ( ! empty( $elmn ) ) {
			$this->childs = $elmn['elmn_child'];
		}
	}

	// Render template for builder
	public function content_template() {
	}

	public function get_elmn_content_class() {
		return '';
	}


	public function render_content() {
		if ( $this->get_elmn_content_class() ) {
			echo '<div class="' . $this->get_elmn_content_class() . '">';
		}
		$this->render_childs();
		if ( $this->get_elmn_content_class() ) {
			echo '</div>';
		}
	}

	public function render_childs() {
		foreach ( $this->childs as $elmn ) {
			$elmn = json_decode( json_encode( $elmn ), true );

			$elmn_keys = array_keys( Elmn_Manager::get_instance()->elmns );

			if ( in_array( $elmn['elmn_type'], $elmn_keys ) ) {

				$elmn_class = Elmn_Manager::get_instance()->elmns[ $elmn['elmn_type'] ]['class_name'];
				$elmn_obj   = new $elmn_class( $elmn );
				$elmn_obj->render();
			}
		}

	}

}
