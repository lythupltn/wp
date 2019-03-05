<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */
?>
<div class="wrap">
    <h1><?php echo esc_html__( 'Laser WordPress Website Builder', 'lwwb' ) ?></h1>
	<?php settings_errors(); ?>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#general"><?php echo esc_html__( 'General', 'lwwb' ) ?></a></li>
        <li><a href="#integrations"><?php echo esc_html__( 'Integrations', 'lwwb' ) ?></a></li>
        <li><a href="#document"><?php echo esc_html__( 'Document', 'lwwb' ) ?></a></li>
        <li><a href="#system-info"><?php echo esc_html__( 'System Info', 'lwwb' ) ?></a></li>
        <li><a href="#support"><?php echo esc_html__( 'Support', 'lwwb' ) ?></a></li>
    </ul>
    <div class="tab-content">
        <div id="general" class="tab-pane active">
            <h2>Info</h2>
        </div>
        <div id="integrations" class="tab-pane">
            <form id="lwwb-settings-form" method="post" action="options.php">
                <input type="hidden" name="admin_page" value="integrations"/>
				<?php
				settings_fields( 'lwwb_integrations_general' );
				do_settings_sections( 'lwwb' );
				submit_button();
				?>
            </form>

        </div>
        <div id="document" class="tab-pane">
            <h2>Document</h2>
        </div>
        <div id="system-info" class="tab-pane">
            <div class="wrap system-info">
                <h3><?php echo esc_html__( 'System Info', 'lwwb' ); ?></h3>
                <div class="wrap-header">
                    <div class="heading">
                        <div>
                            <strong><?php _e( 'Please include your system informations when posting support requests.', 'lwwb' ) ?></strong>
                        </div>
						<?php _e( 'To copy the system infos, click below then press Ctrl + C (PC) or Cmd + C (Mac)', 'lwwb' ); ?>
                    </div>
                    <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post">
                        <input type="hidden" name="action" value="system_info_download_file">
                        <input type="submit" class="button button-primary"
                               value="<?php echo __( 'Download System Info', 'lwwb' ); ?>">
                    </form>
                </div>
                <textarea readonly="readonly" onclick="this.focus();this.select()" id="system-info-textarea"
                          name="system-info-textarea"
                          title="<?php _e( 'To copy the system infos, click below then press Ctrl + C (PC) or Cmd + C (Mac).', 'lwwb' ); ?>">
                    <?php echo $this->system_infos(); ?>
                </textarea>

            </div>
        </div>
        <div id="support" class="tab-pane">
            <h3>Support</h3>
        </div>
    </div>
</div>
