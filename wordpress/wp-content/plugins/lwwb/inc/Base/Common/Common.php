<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    lwwb.core
 * @subpackage lwwb.core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Base\Common;

class Common {

	/**
	 * builder from the wp $query
	 * !! has to be fired after 'template_redirect'
	 * Used on front ( not customizing preview )
	 *
	 * @return  array
	 */
	public static function get_current_page_id() {
		//don't call get_queried_object if the $query is not defined yet
		global $wp_the_query;
		if ( ! isset( $wp_the_query ) || empty( $wp_the_query ) ) {
			return array();
		}

		$current_obj     = get_queried_object();
		$current_page_id = false;


		if ( is_object( $current_obj ) ) {
			//post, custom post types, page
			if ( isset( $current_obj->post_type ) ) {
				$current_page_id = $current_obj->ID;
			}

			//taxinomies : tags, categories, custom tax type
			if ( isset( $current_obj->taxonomy ) && isset( $current_obj->term_id ) ) {
				$current_page_id = '_tax_' . $current_obj->taxonomy . '_' . $current_obj->term_id;
			}
		}

		//author archive page
		if ( is_author() ) {
			$current_page_id = '_author';
		}

		//post type archive object
		if ( is_post_type_archive() ) {
			$current_page_id = 'archive';
		}
		if ( is_404() ) {
			$current_page_id = '_404';
		}
		if ( is_search() ) {
			$current_page_id = '_search';
		}
		if ( is_date() ) {
			$current_page_id = '_date';
		}
		if ( self::is_real_home() ) {
			$current_page_id = '_home';
		}

		return $current_page_id;
	}

	static function is_real_home() {
		return ( is_home() && ( 'posts' == get_option( 'show_on_front' ) || '__nothing__' == get_option( 'show_on_front' ) ) )
		       || ( 0 == get_option( 'page_on_front' ) && 'page' == get_option( 'show_on_front' ) )
		       || is_front_page() && is_home() || is_home();
	}


	public static function get_template_builder_select( $hook ) {
		$templ  = array( '' => esc_html__( 'Select One', 'lwwb' ) );
		$uposts = get_posts(
			array(
				'post_type'   => 'lwwb_library',
				'numberposts' => - 1,
				'tax_query'   => array(
					array(
						'taxonomy' => 'lwwb_library_type',
						'field'    => 'slug',
						'terms'    => array( $hook ),
						'operator' => 'IN',
					)
				)
			)
		);
		foreach ( $uposts as $upost ) {
			$templ[ $upost->ID ] = $upost->post_title;
		}

		return $templ;
	}

}