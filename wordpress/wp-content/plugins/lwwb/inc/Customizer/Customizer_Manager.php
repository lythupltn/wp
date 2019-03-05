<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Customizer;

use Lwwb\Base\Assets\Font_Families;
use Lwwb\Base\Assets\Font_Icons;
use Lwwb\Base\Base_Manager;
use Lwwb\Base\Common\Common;
use Lwwb\Base\Hooks\Hook_Base;
use Lwwb\Builder\Base\Default_Elmn_Controls;
use Lwwb\Builder\Elmn_Manager;

final class Customizer_Manager extends Base_Manager {
	/**
	 * Post ID.
	 *
	 * Holds the ID of the current post being edited.
	 *
	 * @since  1.0.0
	 * @access private
	 *
	 * @var int Post ID.
	 */
	private $current_page_id;
	private $config_data;

	public function register_services() {
		parent::register_services();
		add_action( 'customize_register', array( $this, 'add_actions' ) );
	}

	public function get_services() {
		return [
			Control_Manager::class,
			Dynamic_Settings::class,
			Plugin_Customizer::class,
		];
	}

	public function add_actions() {
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control' ) );
		add_action( 'customize_preview_init', array( $this, 'enqueue_preview' ) );
		add_action( 'customize_preview_init', array( $this, 'add_footer_data' ) );
		add_action( 'template_redirect', array( $this, 'set_current_page_id' ), 1 );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'print_icon_template' ) );

	}

	// Enqueue Previewer

	public function enqueue_control() {
		$settings                             = get_option( 'lwwb_settings' );
		$elmns_config                         = apply_filters( 'lwwb/builder/elmn/manager/config', array( 'no config' ) );
		$elmns_config['reponsive_breakpoint'] = $settings['responsive_breakpoint'];

		wp_enqueue_script( 'backbone.marionette' );
		wp_enqueue_script( 'backbone.radio' );

		wp_enqueue_style( $this->plugin_prefix . '-customizer' );
		wp_enqueue_script( $this->plugin_prefix . '-customizer' );
		$mobile_max_width = $elmns_config['reponsive_breakpoint']['mobile'];
		$responsive_switcher_css = '.preview-tablet .wp-full-overlay-main {
                    width: ' . intval($mobile_max_width + 1) . 'px;
                    margin:  auto 0 auto -' . intval( $mobile_max_width / 2 ) . 'px
                  }';

		wp_add_inline_style( $this->plugin_prefix . '-customizer', $responsive_switcher_css );

		$headers          = Common::get_template_builder_select( 'header' );
		$footers          = Common::get_template_builder_select( 'footer' );
		$hooks            = Hook_Base::get_builder_hooks();
		$arg_tmpl_builder = array(
			'header' => $headers,
			'footer' => $footers,
			'hooks'  => $hooks
		);
		wp_scripts()->add_data( $this->plugin_prefix . '-builder-control', 'data', sprintf( 'var _lwwb_tmplCustomize = %s;', wp_json_encode( $arg_tmpl_builder ) ) );

		wp_localize_script( $this->plugin_prefix . '-builder-control', '_lwwbConfig', $elmns_config );
		wp_enqueue_script( $this->plugin_prefix . '-builder-control' );

	}

	public function set_current_page_id() {
		$this->current_page_id = Common::get_current_page_id();
	}

	public function enqueue_preview() {
		wp_enqueue_media();
		wp_enqueue_style( $this->plugin_prefix . '-builder' );

		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_enqueue_script( 'jquery-ui-droppable' );
		wp_enqueue_script( "jquery-ui-sortable" );
		wp_enqueue_script( "jquery-ui-resizable" );
		wp_enqueue_editor();
		wp_enqueue_script( 'backbone.marionette' );
		wp_enqueue_script( 'backbone.radio' );
		wp_enqueue_script( 'wow' );
		wp_enqueue_style( 'animated' );
		wp_enqueue_style( 'animations.min' );
		wp_enqueue_script( $this->plugin_prefix . '-builder-preview' );
		wp_add_inline_script( $this->plugin_prefix . '-builder-preview',
			'window.lwwb = window.lwwb || {};
			window.lwwb.Radio = window.lwwb.Radio || {};
			 var _channel = new Backbone.Radio.channel("lwwb:radio:channel");
			 _.extend(window.lwwb.Radio, {
			 	channel: _channel
			 });'
		);

	}

	public function add_footer_data() {
		add_action( 'wp_footer', array( $this, 'set_data' ) );
	}

	private function process_data( $post_meta ) {
		$header_id      = '';
		$footer_id      = '';
		$header_content = '';
		$footer_content = '';
		$page_content   = '';
		$hooks          = '';

		if ( ! empty( $post_meta ) ) {

			$data_config = json_decode( $post_meta );
			$header_id   = isset( $data_config->header ) ? $data_config->header : '';
			$footer_id   = isset( $data_config->footer ) ? $data_config->footer : '';
			if ( $header_id ) {
				$header_data    = get_post_meta( $header_id, '_lwwb_data', true );
				$header_decode  = json_decode( $header_data );
				$header_content = isset( $header_decode->content ) ? $header_decode->content : array();
			}
			if ( $footer_id ) {
				$footer_data    = get_post_meta( $footer_id, '_lwwb_data', true );
				$footer_decode  = json_decode( $footer_data );
				$footer_content = isset( $footer_decode->content ) ? $footer_decode->content : array();
			}
			$page_content = isset( $data_config->content ) ? $data_config->content : array();
			$new_hooks    = Hook_Base::get_builder_hooks();

			foreach ( $new_hooks as $hook => $value ) {
				if ( ! empty( $data_config->content ) ) {
					$key = array_search( $hook, array_column( $data_config->content, 'elmn_id' ) );
					if ( $key !== false ) {
						continue;
					}
					$page_content[] = array(
						'elmn_id'    => $hook,
						'elmn_type'  => $hook,
						'elmn_data'  => array(),
						'elmn_child' => array(),
					);
				}

			}

			$hooks = isset( $data_config->hooks ) ? $data_config->hooks : array();
		}

		return array(
			'header_id'      => $header_id,
			'footer_id'      => $footer_id,
			'header_content' => $header_content,
			'footer_content' => $footer_content,
			'page_content'   => $page_content,
			'hooks'          => $hooks,
		);
	}

	public function set_data() {
		$post = get_post( $this->current_page_id );
		if ( $post ) {
			$post_meta = get_post_meta( $this->current_page_id, '_lwwb_data', true );
			$data      = $this->process_data( $post_meta );

		} else {
			$posts = get_posts( [
				'post_type'   => 'lwwb_external_post',
				'post_status' => 'publish',
				'numberposts' => - 1,
			] );
			if ( ! empty( $posts ) ) {
				foreach ( $posts as $post ) {
					$meta_key = get_post_meta( $post->ID, '_lwwb_id', true );
					if ( $meta_key == $this->current_page_id ) {
						$post_meta = get_post_meta( $post->ID, '_lwwb_data', true );
						$data      = $this->process_data( $post_meta );

					}
				}
			}
		}

		if ( empty( $data['page_content'] ) ) {
			if ( isset( $_REQUEST['lwwb_library_type'] ) && ( 'header' == $_REQUEST['lwwb_library_type'] || 'footer' == $_REQUEST['lwwb_library_type'] ) ) {
				if ( 'header' == $_REQUEST['lwwb_library_type'] ) {
					$data['page_content'] = $this->get_default_header();
				} elseif ( 'footer' == $_REQUEST['lwwb_library_type'] ) {
					$data['page_content'] = $this->get_default_footer();
				}
			} else {
				$data['header_id']      = '';
				$data['footer_id']      = '';
				$data['header_content'] = '';
				$data['footer_content'] = '';
				$data['hooks']          = array();
				$data['page_content']   = $this->get_default_data();
			}
		}

		$config = array(
			'header' => array(
				'id'      => $data['header_id'],
				'content' => $data['header_content'],
			),
			'footer' => array(
				'id'      => $data['footer_id'],
				'content' => $data['footer_content'],
			),
			'hooks'  => $data['hooks'],
			'page'   => array(
				'id'      => $this->current_page_id,
				'content' => $data['page_content'],
			),
		);
		$config = array_merge( $config, $this->get_frontend_config() );
		wp_localize_script( LWWB_PLUGIN_PREFIX . '-builder-preview', '_lwwbData', $config );
	}

	public function get_frontend_config() {
		$elmns    = apply_filters( 'lwwb/builder/elmn/manager/config', array( 'no config' ) );
		$settings = get_option( 'lwwb_settings' );

		$config = array(
			'ajaxUrl'               => admin_url( 'admin-ajax.php' ),
			'assetsPath'            => LWWB_PLUGIN_DIR . 'assets/',
			'assetsUrl'             => LWWB_PLUGIN_URI . 'assets/',
			'animationConfig'       => Default_Elmn_Controls::get_entrance_animation(),
			'builderHooks'          => Hook_Base::get_builder_hooks(),
			'elmnGroups'            => Elmn_Manager::get_instance()->group,
			'responsiveBreakpoints' => $settings['responsive_breakpoint'],
			'googleFonts'           => Font_Families::get_google_fonts()
		);

		return array(
			'config' => array_merge( $config, $elmns ),
		);
	}

	public function print_icon_template() {
		$icons = Font_Icons::get_font_icons( 'font-awesome' );
		?>
        <div id="lwwb-sidebar-icons">
            <div class="lwwb-sidebar-header">
                <a class="customize-controls-icon-close" href="#">
                    <span class="screen-reader-text"><?php _e( 'Cancel', 'lwwb' ); ?></span>
                </a>
                <div class="lwwb-icon-type-inner">
                    <select id="lwwb-sidebar-icon-type">
                        <option value="all"><?php _e( 'All Icon Types', 'lwwb' ); ?></option>
						<?php foreach ( $icons as $key => $arg_icon ): ?>
                            <option value="<?php echo esc_attr( $key ) ?>"><?php echo esc_attr( $arg_icon['name'] ) ?></option>
						<?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="lwwb-sidebar-search">
                <input type="text" id="lwwb-icon-search"
                       placeholder="<?php esc_attr_e( 'Type icon name', 'lwwb' ) ?>">
            </div>
            <div id="lwwb-icon-browser">
				<?php foreach ( $icons as $key => $arg_icon ): ?>
                    <ul class="lwwb-list-icons icon-<?php echo esc_attr( $key ); ?>"
                        data-type="<?php echo esc_attr( $key ) ?>">
						<?php foreach ( $arg_icon['icons'] as $k => $val ):
							if ( $arg_icon['class_config'] ) {
								$class_name = str_replace( '__icon_name__', $val, $arg_icon['class_config'] );
							} else {
								$class_name = $val;
							}
							?>
                            <li title="<?php echo esc_attr( $val ); ?>"
                                data-type="<?php echo esc_attr( $key ); ?>"
                                data-icon="<?php echo esc_attr( $class_name ); ?>">
					                                            <span class="module-icon-wrapper"><i
                                                                            class="<?php echo esc_attr( $class_name ); ?>"></i></span>
                            </li>
						<?php endforeach; ?>
                    </ul>
				<?php endforeach; ?>
            </div>
        </div>
		<?php
	}

	public function get_default_data() {
		$hooks      = Hook_Base::get_builder_hooks();
		$data_hooks = array();
		foreach ( $hooks as $hook => $vlue ) {
			$data_hooks[] = array(
				'elmn_id'    => $hook,
				'elmn_type'  => $hook,
				'elmn_data'  => array(),
				'elmn_child' => array(),
			);
		}

		return $data_hooks;
	}

	public function get_default_header() {
		return array(
			array(
				'elmn_id'    => 'lwwb_theme_header',
				'elmn_type'  => 'lwwb_theme_header',
				'elmn_data'  => array(),
				'elmn_child' => array(),
			),
		);
	}

	public function get_default_footer() {
		return array(
			array(
				'elmn_id'    => 'lwwb_theme_footer',
				'elmn_type'  => 'lwwb_theme_footer',
				'elmn_data'  => array(),
				'elmn_child' => array(),
			),
		);
	}

}