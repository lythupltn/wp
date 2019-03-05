<?php
/**
 * Theme functions and definitions.
 */
function laserbase_child_enqueue_styles() {

	wp_enqueue_style( 'twentynineteen-style' , get_template_directory_uri() . '/style.css' );

    wp_enqueue_style( 'twentynineteen-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'twentynineteen-style' ),
        wp_get_theme()->get('Version')
    );

}

add_action(  'wp_enqueue_scripts', 'laserbase_child_enqueue_styles' );

	/**
	 * Customizer additions.
	 */
	require get_stylesheet_directory() . '/Export_Controls.php';
	require get_stylesheet_directory() . '/SimpleXLSX.php';

