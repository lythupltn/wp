<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

$get_options           = get_option( 'lwwb_settings' );
$setting               = $get_options['settings'];
$css_print_options     = $get_options['css_print_method'];
$responsive_breakpoint = $get_options['responsive_breakpoint'];


if ( ! isset( $setting ) ) {
	$setting = array();
}

$hooks = new \Lwwb\Admin\Settings\Settings_Controller();
?>
<div class="wrap">
    <h1><?php echo esc_html__( 'Settings Laser WordPress Website Builder', 'lwwb' ) ?></h1>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#settings"><?php echo esc_html__( 'General', 'lwwb' ) ?></a></li>
        <li><a href="#style"><?php echo esc_html__( 'Style', 'lwwb' ) ?></a></li>
        <li><a href="#advanced"><?php echo esc_html__( 'Advanced', 'lwwb' ) ?></a></li>
    </ul>
    <div class="tab-content">
        <div id="settings" class="tab-pane active">
            <form id="lwwb-settings-form" method="post" action="options.php">
                <input type="hidden" name="admin_page" value="settings"/>
                <div class="lwwb-form-wrap">
					<?php do_settings_sections( 'lwwb-settings' ); ?>
                    <div class="lwwb-notice notice-warning is-dismissible">
                        <p>
                            <strong><?php echo esc_html__( 'Notice: ', 'lwwb' ); ?></strong><?php echo __( 'Enable Laser WordPress Website Builder for pages, posts and custom post types.', 'lwwb' ); ?>
                            <br>
                            <strong><?php echo esc_html__( 'Note: ', 'lwwb' ); ?></strong><?php echo esc_html__( 'By default Laser WordPress Website Builder is available for pages only.', 'lwwb' ); ?>
                        </p>
                    </div>

					<?php settings_errors(); ?>
					<?php
					settings_fields( 'lwwb_settings_general' );
					?>

					<?php

					$args       = array( 'public' => true );
					$output     = 'objects'; //'names'; // names or objects, note names is the default
					$operator   = 'and'; // 'and' or 'or'
					$post_types = get_post_types( $args, $output, $operator );

					foreach ( $post_types as $post_type => $value ) {
						if ( $post_type == 'attachment' ) {
							continue;
						}
						?>
                        <div class="settings-page-wrap">
                            <!-- Loop start -->
                            <div class="ui-toggle pd-checkbox">
                                <label for="<?php echo esc_attr( $post_type ); ?>" class="checkbox-label">
									<?php echo esc_attr( $value->label ); ?>
                                </label>
                                <input type="checkbox" id="<?php echo esc_attr( $post_type ); ?>"
                                       name="lwwb_settings[settings][]"
                                       value="<?php echo esc_attr( $post_type ); ?>"
                                       class="" <?php checked( in_array( $post_type, $setting, true ), true ); ?>>
                                <label for="<?php echo esc_attr( $post_type ); ?>">
                                    <div></div>
                                </label>
                            </div>
                            <!-- End start -->
                        </div>
						<?php
					}
					?>
					<?php
					submit_button();
					?>
                </div>
            </form>
        </div>
        <div id="style" class="tab-pane">
            <form id="lwwb-settings-form" method="post" action="options.php">
                <input type="hidden" name="admin_page" value="responsive_breakpoint"/>
                <div class="lwwb-form-wrap">
					<?php do_settings_sections( 'lwwb-settings' ); ?>
					<?php
					settings_fields( 'lwwb_responsive_breakpoint' );
					?>
                    <div class="settings-page-wrap ">
                        <div class="settings-breakpoint">
                            <label for="tablet-breakpoint"><?php echo esc_html__( 'Tablet Breakpoint', 'lwwb' ); ?></label>
                            <input type="number" class="input-text" id="tablet-breakpoint" placeholder="720"
                                   name="lwwb_settings[responsive_breakpoint][tablet]"
                                   value="<?php echo esc_attr( $responsive_breakpoint['tablet'] ); ?>"/>
                            <br>
                            <span><?php echo esc_html__( 'Set the breakpoint between desktop and tablet devices. Below this breakpoint tablet layout will appear (Default: 720px).', 'lwwb' ); ?></span>
                        </div>
                        <div class="settings-breakpoint">
                            <label for="mobile-breakpoint"><?php echo esc_html__( 'Mobile Breakpoint', 'lwwb' ); ?></label>
                            <input id="mobile-breakpoint" class="input-text" type="number"
                                   name="lwwb_settings[responsive_breakpoint][mobile]" placeholder="320"
                                   value="<?php echo esc_attr( $responsive_breakpoint['mobile'] ); ?>"/>
                            <br>
                            <span><?php echo esc_html__( 'Set the breakpoint between tablet and mobile devices. Below this breakpoint mobile layout will appear (Default: 320px).', 'lwwb' ); ?></span>
                        </div>
                    </div>
					<?php
					submit_button();
					?>
                </div>
            </form>
        </div>
        <div id="advanced" class="tab-pane">
            <form id="lwwb-settings-form" method="post" action="options.php">
                <input type="hidden" name="admin_page" value="css_print_method"/>
                <div class="lwwb-form-wrap">
					<?php do_settings_sections( 'lwwb-settings' ); ?>
					<?php
					settings_fields( 'lwwb_css_print_method' );
					?>
                    <div class="settings-page-wrap">
                        <h3> <?php echo esc_html__( 'CSS print method', 'lwwb' ); ?></h3>
                        <select name="lwwb_settings[css_print_method]">
                            <option value="external_file" <?php if ( $css_print_options == 'external_file' ) { ?> selected <?php }; ?>><?php echo esc_html__( 'External File', 'lwwb' ); ?></option>
                            <option value="internal" <?php if ( $css_print_options == 'internal' ) { ?> selected <?php }; ?> ><?php echo esc_html__( 'Internal Embedding', 'lwwb' ); ?></option>
                        </select>

                    </div>
					<?php
					submit_button();
					?>
                </div>
            </form>
        </div>
    </div>
</div>


