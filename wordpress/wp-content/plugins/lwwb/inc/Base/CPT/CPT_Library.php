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

class CPT_Library extends CPT_Base {
	public $taxonomy = 'lwwb_library_type';
	public $post_type = 'lwwb_library';

	public function register() {
		include( ABSPATH . "wp-includes/pluggable.php" );
//		if ( ! $this->check_role_user() ) {
//			return;
//		}
		$this->ctp          = $this->set_post_type();
		$this->ctp_taxonomy = $this->set_taxonomy();
		add_filter( 'the_content', array(
			$this,
			'builder_wrapper'
		), 9999999 ); // 9999999 = after preview->builder_wrapper
		add_action( 'template_redirect', array( $this, 'render_template_library' ) );
		parent::register(); // TODO: Change the autogenerated stub

	}

	public function check_role_user() {
		if ( is_user_logged_in() ) {
			$user    = wp_get_current_user();
			$role    = $user->roles;
			$options = get_option( 'lwwb_settings' );
			$roles   = isset( $options['role'] ) ? $options['role'] : array();
			if (!isset($role[0]) ){ return false;}
			if ( $role[0] == 'administrator' ) {
				return true;
			}
			if ( in_array( $role[0], $roles ) ) {
				return true;
			} else {
				return false;
			}
		}

	}

	public function set_post_type() {
		$labels = array(
			'name'               => _x( 'Library', 'Template Library', 'lwwb' ),
			'singular_name'      => _x( 'Template', 'Template Library', 'lwwb' ),
			'add_new'            => _x( 'Add New', 'Template Library', 'lwwb' ),
			'add_new_item'       => _x( 'Add New Template', 'Template Library', 'lwwb' ),
			'edit_item'          => _x( 'Edit Template', 'Template Library', 'lwwb' ),
			'new_item'           => _x( 'New Template', 'Template Library', 'lwwb' ),
			'all_items'          => _x( 'All Templates', 'Template Library', 'lwwb' ),
			'view_item'          => _x( 'View Template', 'Template Library', 'lwwb' ),
			'search_items'       => _x( 'Search Template', 'Template Library', 'lwwb' ),
			'not_found'          => _x( 'No Templates found', 'Template Library', 'lwwb' ),
			'not_found_in_trash' => _x( 'No Templates found in Trash', 'Template Library', 'lwwb' ),
			'parent_item_colon'  => '',
			'menu_name'          => _x( 'Library', 'Template Library', 'lwwb' ),
		);
		$arg    = array(
			'labels'              => $labels,
			'public'              => true,
			'rewrite'             => false,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'show_in_rest'        => true,
			'exclude_from_search' => true,
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'show_in_quick_edit'  => false,
			'hierarchical'        => false,
			'taxonomies'          => array( 'lwwb_library_type', 'post_tag' ),
			'supports'            => [ 'title', 'thumbnail', 'author', 'lwwb' ],
		);

		return $arg;
	}

	public function set_taxonomy() {
		$arg = array(
			'hierarchical'      => true,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
			'query_var'         => is_admin(),
			'rewrite'           => false,
			'public'            => false,
			'meta_box_cb'       => array( $this, 'dropdown_type' ),
			'label'             => _x( 'Type', 'Template Library', 'lwwb' ),
		);

		return $arg;
	}

	public function dropdown_type( $post, $box ) {
		$defaults = array( 'taxonomy' => 'category' );
		$taxonomy = 'lwwb_library_type';
		if ( ! isset( $box['args'] ) || ! is_array( $box['args'] ) ) {
			$args = array();
		} else {
			$args = $box['args'];
		}
		extract( wp_parse_args( $args, $defaults ), EXTR_SKIP );
		?>
        <div id="taxonomy-<?php echo $taxonomy; ?>" class="lwwb-taxonomy-field categorydiv">

			<?php
			$name = ( $taxonomy == 'category' ) ? 'post_category' : 'tax_input[' . $taxonomy . ']';
			echo "<input type='hidden' name='{$name}[]' value='0' />"; // Allows for an empty term set to be sent. 0 is an invalid Term ID and will be ignored by empty() checks.
			?>
			<?php $term_obj = wp_get_object_terms( $post->ID, $taxonomy ); //_log($term_obj[0]->term_id)?>
			<?php wp_dropdown_categories( array(
				'taxonomy'     => $taxonomy,
				'hide_empty'   => 0,
				'name'         => "{$name}[]",
				'class'        => 'lwwb_width_100',
				'orderby'      => 'name',
				'selected'     => isset( $term_obj[0]->term_id ) ? $term_obj[0]->term_id : '',
				'hierarchical' => 0,
				'required'     => true
			) ); ?>

        </div>
		<?php
	}

	public function render_template_library() {
		global $post;
		/* Checks for single template by post type */
		if ( ! isset( $post ) ) {
			return;
		}
		$post_type = get_post_type( $post->ID );
		$taxonomy  = wp_get_post_terms( $post->ID, $this->taxonomy );

		if ( $post_type == $this->post_type ) {
			if ( ( ! empty( $taxonomy ) && $taxonomy[0]->name === 'header' ) || ( isset( $_REQUEST['lwwb_library_type'] ) && $_REQUEST['lwwb_library_type'] == 'header' ) ) {
				add_action( 'get_header', array( $this, 'get_header' ) );
			} elseif ( ( ! empty( $taxonomy ) && $taxonomy[0]->name === 'footer' ) || ( isset( $_REQUEST['lwwb_library_type'] ) && $_REQUEST['lwwb_library_type'] == 'footer' ) ) {
				add_action( 'get_footer', array( $this, 'get_footer' ) );
			}
		}

	}

	public function builder_wrapper( $content ) {
		$post_id   = get_the_ID();
		$post_type = get_post_type( $post_id );
		$taxonomy  = wp_get_post_terms( $post_id, $this->taxonomy );

		if ( ( $post_type == $this->post_type && ! empty( $taxonomy ) && $taxonomy[0]->name === 'header' ) || $post_type == $this->post_type && ! empty( $taxonomy ) && $taxonomy[0]->name === 'footer' ) {

			$content = '<div class="lwwb-theme-content-area">' . esc_html__( 'Content Area', 'lwwb' ) . '</div>';
		}

		return $content;
	}

	public static function get_footer( $name ) {
		require LWWB_PLUGIN_DIR . '/inc/Admin/templates/library_footer.php';
		$templates = [];
		$name      = (string) $name;
		if ( '' !== $name ) {
			$templates[] = "footer-{$name}.php";
		}
		$templates[] = 'footer.php';

		ob_start();
		// It cause a `require_once` so, in the get_header it self it will not be required again.
		locate_template( $templates, true );
		ob_get_clean();
	}

	public static function get_header( $name ) {
		require LWWB_PLUGIN_DIR . '/inc/Admin/templates/library_header.php';

		$templates = [];
		$name      = (string) $name;
		if ( '' !== $name ) {
			$templates[] = "header-{$name}.php";
		}
		$templates[] = 'header.php';

		// Avoid running wp_head hooks again
		remove_all_actions( 'wp_head' );
		ob_start();
		// It cause a `require_once` so, in the get_header it self it will not be required again.
		locate_template( $templates, true );
		ob_get_clean();
	}


}