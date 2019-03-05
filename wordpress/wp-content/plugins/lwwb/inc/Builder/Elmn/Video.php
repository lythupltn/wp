<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    lwwb.core
 * @subpackage lwwb.core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Builder\Elmn;

use Lwwb\Builder\Base\Elmn;
use Lwwb\Customizer\Control_Manager as Control;

class Video extends Elmn {
	public $type = 'video';
	public $label = 'Video';
	public $icon = 'fa fa-video-camera';
	public $key_words = 'image, video, vd, media';
	public $group = 'basic';
	public $control_groups = array(
		'content',
		'advanced',
		'style',
		'image_overlay',
		'background',
		'border',
		'shape',
		'typography',
		'custom_css',
	);

	public function __construct( array $elmn = array() ) {
		parent::__construct( $elmn );
		add_action( 'wp_ajax_get_video_via_ajax', array( $this, 'get_video_via_ajax' ) );
		add_action( 'customize_preview_init', array( $this, 'enqueue' ) );
	}

	public function enqueue() {
		wp_enqueue_style( 'magnific-popup' );
		wp_enqueue_script( 'magnific-popup' );
	}

	public function get_content_group_control() {
		return
			array(
				'id'           => 'lwwb_content_group_control',
				'label'        => __( 'Video', 'lwwb' ),
				'type'         => Control::GROUP,
				'dependencies' => array(
					array(
						'control'  => 'lwwb_tab_control',
						'operator' => '===',
						'value'    => 'content',
					),
				),
				'fields'       => static::get_content_controls(),
			);
	}

	public static function get_content_controls() {
		return array(
			array(
				'id'             => 'source_type',
				'label'          => __( 'Source', 'lwwb' ),
				'default'        => 'youtube',
				'control_layout' => 'inline',
				'keywords'       => 'source video vd type',
				'type'           => Control::SELECT,
				'choices'        => array(
					'youtube'     => esc_html__( 'Youtube', 'lwwb' ),
					'vimeo'       => esc_html__( 'Vimeo', 'lwwb' ),
					'dailymotion' => esc_html__( 'Dailymotion', 'lwwb' ),
					'self_hosted' => esc_html__( 'Self Hosted', 'lwwb' ),
				),

			),
			array(
				'id'           => 'youtube_link',
				'keywords'     => 'Youtube link url',
				'label'        => __( 'Link', 'lwwb' ),
				'type'         => Control::TEXT,
				'input_type'   => 'text',
				'placeholder'  => esc_html__( 'Insert link youtube video', 'lwwb' ),
				'dependencies' => array(
					array(
						'control'  => 'source_type',
						'operator' => '==',
						'value'    => 'youtube',
					),
				),
			),
			array(
				'id'           => 'vimeo_link',
				'keywords'     => 'Vimeo  link url',
				'label'        => __( 'Link', 'lwwb' ),
				'type'         => Control::TEXT,
				'input_type'   => 'text',
				'placeholder'  => esc_html__( 'Insert link Vimeo video', 'lwwb' ),
				'dependencies' => array(
					array(
						'control'  => 'source_type',
						'operator' => '==',
						'value'    => 'vimeo',
					),
				),
			),
			array(
				'id'           => 'dailymotion_link',
				'keywords'     => 'Dailymotion  link url',
				'label'        => __( 'Link', 'lwwb' ),
				'type'         => Control::TEXT,
				'input_type'   => 'text',
				'placeholder'  => esc_html__( 'Insert link dailymotion video', 'lwwb' ),
				'dependencies' => array(
					array(
						'control'  => 'source_type',
						'operator' => '==',
						'value'    => 'dailymotion',
					),
				),
			),
		);
	}

	public function get_image_overlay_group_control() {
		return
			array(
				'id'           => 'lwwb_image_overlay_group_control',
				'label'        => __( 'Image Overlay', 'lwwb' ),
				'type'         => Control::GROUP,
				'dependencies' => array(
					array(
						'control'  => 'lwwb_tab_control',
						'operator' => '===',
						'value'    => 'content',
					),
				),
				'fields'       => static::get_image_overlay_controls(),
			);
	}

	public function get_image_overlay_controls() {
		return array(
			array(
				'id'       => 'image_overlay_switch',
				'keywords' => 'show hide image overlay video media',
				'label'    => __( 'Image Overlay', 'lwwb' ),
				'type'     => Control::SWITCHER,
				'default'  => '',
			),
			array(
				'id'           => 'bg_overlay_img',
				'keywords'     => 'image, media background',
				'label'        => __( 'Image', 'lwwb' ),
				'type'         => Control::MEDIA_UPLOAD,
				'default'      => array(
					'url' => '',
					'id'  => '',
				),
				'dependencies' => array(
					array(
						'control'  => 'image_overlay_switch',
						'operator' => '===',
						'value'    => 'yes',
					),
				),
				'css_format'   => "ELMN_WRAPPER > .lwwb-elmn-content .lwwb-video-bg-overlay{ background-image:url({{ URL }}); }",
			),
			array(
				'id'           => 'switch_play_icon',
				'keywords'     => 'show hide image overlay video media',
				'label'        => __( 'Play Icon', 'lwwb' ),
				'type'         => Control::SWITCHER,
				'default'      => 'yes',
				'dependencies' => array(
					array(
						'control'  => 'image_overlay_switch',
						'operator' => '===',
						'value'    => 'yes',
					),
				),
			),
			array(
				'id'           => 'video_divider',
				'keywords'     => 'show hide image divider overlay video media',
				'type'         => Control::DIVIDER,
				'dependencies' => array(
					array(
						'control'  => 'image_overlay_switch',
						'operator' => '===',
						'value'    => 'yes',
					),
				),
			),
			array(
				'id'           => 'video_lightbox',
				'keywords'     => 'show hide image lightbox overlay video media',
				'label'        => __( 'Lightbox', 'lwwb' ),
				'type'         => Control::SWITCHER,
				'default'      => 'no',
				'dependencies' => array(
					array(
						'control'  => 'image_overlay_switch',
						'operator' => '===',
						'value'    => 'yes',
					),
				),
			),
		);
	}

	public function get_default_data() {
		return array(
            'bg_overlay_img' => array(
                'url'   =>'',
                'id'=>''
            ),
			'source_type'        => 'youtube',
			'youtube_link'       => 'https://www.youtube.com/watch?v=2Zt8va_6HRk',
			'image_overlay_switch' => 'no',
			'switch_play_icon'     => 'yes',
		);
	}

	public function render_content() {
		$video_w = 500;
		$video_h = $video_w / 1.61; //1.61 golden ratio
		/** @var WP_Embed $wp_embed */
		global $wp_embed;
		$embed = $link = $lightbox_class = $lightbox_data = '';
		if ( 'youtube' === $this->get_data( 'source_type' ) ) {
			$link = $this->get_data( 'youtube_link' );
		} elseif ( 'vimeo' === $this->get_data( 'source_type' ) ) {
			$link = $this->get_data( 'vimeo_link' );
		} elseif ( 'dailymotion' === $this->get_data( 'source_type' ) ) {
			$link = $this->get_data( 'dailymotion_link' );
		}

		if ( is_object( $wp_embed ) ) {
			$embed = $wp_embed->run_shortcode( '[embed width="' . $video_w . '"' . $video_h . ']' . $link . '[/embed]' );
		}
		if ( 'yes' === $this->get_data( 'video_lightbox' ) ) {
			$lightbox_data = 'data-popup = yes';
			$lightbox_class = 'show-lightbox';
		}
		echo '<div class="lwwb-video-wrapper">' . $embed . '</div>';
		?>
		<?php if ( $this->get_data( 'image_overlay_switch' ) === 'yes' ) { ?>
            <div class="lwwb-video-bg-overlay <?php echo esc_attr( $lightbox_class ); ?>">
				<?php if ( $this->get_data( 'switch_play_icon' ) === 'yes' ) { ?>
                    <a class="lwwb-play-icon"  role="button" <?php echo esc_attr( $lightbox_data ); ?>
                       href="<?php echo esc_url( $link ); ?>" title="<?php echo get_bloginfo(); ?>">
                        <i class="fa fa-play-circle-o" aria-hidden="true"></i>
                    </a>
				<?php } ?>
            </div>
		<?php } ?>
		<?php
	}

	public function content_template() {
		?>
        <# let videoClass = ''; #>
        <# if('yes' === elmn_data.video_lightbox) {
            videoClass = 'show-lightbox';
        } #>

        <div class="lwwb-video-wrapper"></div>
        <div class="lwwb-video-bg-overlay {{ videoClass }}">
            <div class="lwwb-play-icon" ><i class="fa fa-play-circle-o" aria-hidden="true"></i></div>
        </div>
		<?php

	}

	public function get_video_via_ajax() {
		$link    = isset( $_POST['link'] ) ? $_POST['link'] : '';
		$result  = array(
			'success' => false,
			'html'    => ''
		);
		$video_w = 500;
		$video_h = $video_w / 1.61; //1.61 golden ratio
		/** @var WP_Embed $wp_embed */
		global $wp_embed;

		if ( is_object( $wp_embed ) ) {
			$html = $wp_embed->run_shortcode( '[embed width="' . $video_w . '"' . $video_h . ']' . $link . '[/embed]' );
		}
		$result = array(
			'success' => true,
			'html'    => $html
		);
		wp_send_json( $result );

	}
}
