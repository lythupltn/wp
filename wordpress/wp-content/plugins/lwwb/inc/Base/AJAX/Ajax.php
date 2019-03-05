<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    lwwb.core
 * @subpackage lwwb.core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Base\AJAX;

use Lwwb\Base\Base_Controller;

class Ajax extends Base_Controller {

//	protected $api_base_url = 'http://lwwb.core/wp-json/restapi/v2/';
	protected $api_base_url = 'http://laserbase/wp-json/restapi/v2/';
	protected $lwwb_api_request_body;
	protected $lwwb_api_request_body_default;


	public function register() {
		add_action( 'after_setup_theme', array( $this, 'get_templates_from_remote' ) );
		add_action( 'wp_ajax_get_page_template', array( $this, 'get_page_template' ) );
		add_action( 'wp_ajax_sync_library', array( $this, 'sync_library' ) );
		add_action( 'wp_ajax_get_content_template_by_id', array( $this, 'get_content_template_by_id' ) );
	}

	/**
	 * Load Template from Server with REST API
	 */
	public function get_templates_from_remote() {
		$this->lwwb_api_request_body_default = array(
			'request_from'         => 'lwwb',
			'request_lwwb_version' => LWWB_PLUGIN_VERSION,
		);
		$this->lwwb_api_request_body         = apply_filters( 'lwwb_api_request_body', array() );

		$apiUrl            = $this->api_base_url . 'templates';
		$post_args         = array( 'timeout' => 120 );
		$body_param        = array_merge( $this->lwwb_api_request_body_default, array( 'request_for' => 'get_templates' ) );
		$post_args['body'] = array_merge( $body_param, $this->lwwb_api_request_body );

		$tempalteRequest = wp_remote_post( $apiUrl, $post_args );
		if ( is_wp_error( $tempalteRequest ) || 200 !== (int) wp_remote_retrieve_response_code( $tempalteRequest ) ) {
			wp_send_json_error( array( 'messages' => $tempalteRequest->get_error_messages() ) );
		}
		$templateData = json_decode( $tempalteRequest['body'], true );


		$TemplateFile   = "lwwb-templates.json";
		$upload_dir     = wp_upload_dir();
		$dir            = trailingslashit( $upload_dir['basedir'] ) . 'laser/templates/';
		$file_path_name = $dir . $TemplateFile;
		if ( ! file_exists( $dir ) ) {
			mkdir( $dir, 0777, true );
		}
		file_put_contents( $file_path_name, json_encode( $templateData ) ); // Put template content to  directory

		return $templateData;

	}

	public function sync_library() {
		$template = $this->get_templates_from_remote();
		ob_start();
		$this->get_html_raw($template);
		$html = ob_get_clean();
		wp_send_json( array(
			'success'   => true,
			'data'      => $template,
			'html'      => $html
		) );

	}

	public function get_page_template() {
		$template_file = "lwwb-templates.json";
		$cache_time    = ( 60 * 60 * 24 * 7 ); //cached for 7 days

		$upload_dir     = wp_upload_dir();
		$dir            = trailingslashit( $upload_dir['basedir'] ) . 'laser/templates/';
		$file_path_name = $dir . $template_file;

		if ( file_exists( $file_path_name ) && ( filemtime( $file_path_name ) + $cache_time ) > time() ) {
			$getTemplates = file_get_contents( $file_path_name );
			$templateData = json_decode( $getTemplates, true );
			$cached_at    = 'Last cached: ' . human_time_diff( filemtime( $file_path_name ), current_time( 'timestamp' ) ) . ' ago';
			ob_start();
			$this->get_html_raw($templateData);
			$html = ob_get_clean();
			wp_send_json( array(
				'success'   => true,
				'cached_at' => $cached_at,
				'data'      => $templateData,
				'html'      => $html
			) );
		} else {
			wp_send_json( array(
				'success'   => false,
			) );
		}
	}

	public function get_content_template_by_id() {
		$data = array( 'success' => false );
		$id   = isset( $_POST['id'] ) ? $_POST['id'] : '';
		if ( $id == '' ) {
			return;
		}
		$this->lwwb_api_request_body_default = array(
			'request_from'         => 'lwwb',
			'request_lwwb_version' => LWWB_PLUGIN_VERSION,
		);

		$apiUrl            = $this->api_base_url . 'template';
		$post_args         = array( 'timeout' => 120 );
		$body_param        = array_merge( $this->lwwb_api_request_body_default, array(
			'request_for' => 'get_template',
			'post_id'     => $id
		) );
		$post_args['body'] = array_merge( $body_param, $this->lwwb_api_request_body );

		$tempalteRequest = wp_remote_post( $apiUrl, $post_args );
		if ( is_wp_error( $tempalteRequest ) ) {
			wp_send_json_error( array( 'messages' => $tempalteRequest->get_error_messages() ) );
		}
		$templateData = json_decode( $tempalteRequest['body'], true );


		$data = array(
			'success' => true,
			'data'    => $templateData
		);

		wp_send_json_success( $data );
	}

	public function get_content_modal( $templateData, $category ) {
		foreach ( $templateData as $tmpl ) {
			if ( $tmpl['category'] != $category ) {
				continue;
			}
			echo '<div class="item column is-4">';
			echo '<img src="' . $tmpl['preview_image'] . '"/>';
			echo '<a class="lwwb-library-importer" href="#" data-id="' . $tmpl['id'] . '">Import</a>';
			echo '<div>' . $tmpl['title'] . '</div>';
			echo '</div>';
		}
	}

	public function get_html_raw( $templateData ) {
		?>
        <div class="tabs is-centered" id="tab_header">
            <ul>
                <li class="item is-active" data-option="pages"><a>Pages</a></li>
                <li class="item" data-option="headers"><a>Headers</a></li>
                <li class="item" data-option="footers"><a>Footers</a></li>
                <li class="item" data-option="sections"><a>Sections</a></li>
            </ul>
        </div>
        <!-- Tab panes -->
        <div id="tab_container">
            <div class="container_item is-active" data-item="pages">
                <div class="library-content columns is-multiline">
					<?php $this->get_content_modal( $templateData, 'page' ); ?>
                </div>
            </div>
            <div class="container_item" data-item="headers">
                <div class="library-content columns is-multiline">
					<?php $this->get_content_modal( $templateData, 'header' ); ?>
                </div>
            </div>
            <div class="container_item" data-item="footers">
                <div class="library-content columns is-multiline">
					<?php $this->get_content_modal( $templateData, 'footer' ); ?>
                </div>
            </div>
            <div class="container_item" data-item="sections">
                <div class="library-content columns is-multiline">
					<?php $this->get_content_modal( $templateData, 'section' ); ?>
                </div>
            </div>
        </div>

		<?php
	}
}