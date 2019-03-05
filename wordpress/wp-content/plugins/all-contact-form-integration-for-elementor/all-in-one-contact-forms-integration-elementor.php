<?php
/**
 * Plugin Name: Contact Form Integration For Elementor (All in One)
 * Description: Integrate & style your Contact Form 7, Ninja Forms, Gravity Forms in Elementor visual editor.
 * Plugin URI: https://wordpress.org/plugins/all-contact-form-integration-for-elementor/
 * Author: innovsIT
 * Version: 1.0.4
 * Requires at least: 4.4
 * Tested up to: 5.0
 * Author URI: https://innovsit.com
 * Text Domain: all-elementor-forms
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Abort, if called directly.

define( 'ACFE_CONTACT_FORM_7_URL', plugins_url( '/', __FILE__ ) );
define( 'ACFE_CONTACT_FORM_7_PATH', plugin_dir_path( __FILE__ ) );
define( 'ACFE_GRAVITY_FORM_URL', plugins_url( '/', __FILE__ ) );
define( 'ACFE_GRAVITY_FORM_PATH', plugin_dir_path( __FILE__ ) );
define( 'Acfe_Ninja_Forms_Style_URL', plugins_url( '/', __FILE__ ) );
define( 'Acfe_Ninja_Forms_Style_PATH', plugin_dir_path( __FILE__ ) );


require_once ACFE_CONTACT_FORM_7_PATH.'includes/elementor-helper.php';
require_once ACFE_CONTACT_FORM_7_PATH.'includes/queries.php';
require_once ACFE_GRAVITY_FORM_PATH.'includes/elementor-helper.php';
require_once ACFE_GRAVITY_FORM_PATH.'includes/queries.php';
require_once Acfe_Ninja_Forms_Style_PATH.'includes/elementor-helper.php';
require_once Acfe_Ninja_Forms_Style_PATH.'includes/queries.php';

// Upsell
include_once dirname( __FILE__ ) . '/includes/acfe-cf7-upsell.php';
new acfe_Upsell('');

include_once dirname( __FILE__ ) . '/includes/acfe-gravity-form-upsell.php';
new Acfe_Gravity_Form_Upsell('');

include_once dirname( __FILE__ ) . '/includes/acfe-ninja-forms-upsell.php';
new Acfe_Ninja_Forms_Style_Upsell('');

/**
 * Load all-elementor-forms and css
 */

//Load IE Contact Form 7
function add_acfe_contact_form_7() {

  if ( function_exists( 'wpcf7' ) ) {
    require_once ACFE_CONTACT_FORM_7_PATH.'includes/contact-form-7.php';
  }

}
add_action('elementor/widgets/widgets_registered','add_acfe_contact_form_7');


//Load IE Gravity Forms
function add_acfe_gravity_form() {

  if ( class_exists( 'GFForms' ) ) {
    require_once ACFE_GRAVITY_FORM_PATH.'includes/gravity-form.php';
  }

}
add_action('elementor/widgets/widgets_registered','add_acfe_gravity_form');

//Load acfe Ninja Form
function add_Acfe_Ninja_Forms_Style() {

  if ( function_exists( 'Ninja_Forms' ) ) {
    require_once Acfe_Ninja_Forms_Style_PATH.'includes/ninja-forms.php';
  }

}
add_action('elementor/widgets/widgets_registered','add_Acfe_Ninja_Forms_Style');


// Load acfe Contact Form 7 CSS
function acfe_contact_form_7_enqueue() {

   wp_enqueue_style('innovs_element_elementor-cf7-css',ACFE_CONTACT_FORM_7_URL.'assets/css/all-elementor-forms.css');

}
add_action( 'wp_enqueue_scripts', 'acfe_contact_form_7_enqueue' );


// Load acfe Gravity Form CSS 
function acfe_gravity_form_enqueue() {

   wp_enqueue_style('innovs_element_all-elementor-forms-css',ACFE_GRAVITY_FORM_URL.'assets/css/all-elementor-forms.css');

}
add_action( 'wp_enqueue_scripts', 'acfe_gravity_form_enqueue' );


// Load acfe Ninja Form CSS
function Acfe_Ninja_Forms_Style_enqueue() {

   wp_enqueue_style('innovs_element_elementor-nf-css',Acfe_Ninja_Forms_Style_URL.'assets/css/all-elementor-forms.css');

}
add_action( 'wp_enqueue_scripts', 'Acfe_Ninja_Forms_Style_enqueue' );
