<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */
$get_options  = get_option( 'lwwb_settings' );

if(!isset($get_options['role'])){
	update_option('lwwb_settings',wp_parse_args($get_options,array('role'=>array())));
}
?>
<form id="lwwb-settings-form" method="post" action="options.php">
    <input type="hidden" name="admin_page" value="role" />
	<?php settings_errors(); ?>
    <div class="form-wrap">
		<?php
		settings_fields( 'lwwb_role_general' );
		do_settings_sections( 'lwwb-role' );
		submit_button();
		?>
    </div>
</form>
