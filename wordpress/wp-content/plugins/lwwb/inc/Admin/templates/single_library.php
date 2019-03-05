<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    lwwb.core
 * @subpackage lwwb.core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

$tax = isset( $_REQUEST['lwwb_library_type'] ) ? $_REQUEST['lwwb_library_type'] : '';


if ( 'header' === $tax ) {
	require LWWB_PLUGIN_DIR . '/inc/Admin/templates/library_header.php';

	$templates = [];

	$templates[] = 'header.php';

	// Avoid running wp_head hooks again
	remove_all_actions( 'wp_head' );
	ob_start();
	// It cause a `require_once` so, in the get_header it self it will not be required again.
	locate_template( $templates, true );
	ob_get_clean();

} elseif ( 'footer' === $tax ) {
	require LWWB_PLUGIN_DIR . '/inc/Admin/templates/library_footer.php';

	$templates[] = 'footer.php';

	ob_start();
	// It cause a `require_once` so, in the get_header it self it will not be required again.
	locate_template( $templates, true );
	ob_get_clean();
}else{
	require get_template_directory() . '/page.php';
	$templates[] = 'page.php';

	ob_start();
	// It cause a `require_once` so, in the get_header it self it will not be required again.
	locate_template( $templates, true );
	ob_get_clean();
}
