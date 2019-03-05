<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Builder\Base;

use Lwwb\Builder\Elmn\Menu;
use Lwwb\Customizer\Control_Manager as Control;

class Elmn {
	public static $_instance = null;
	protected $id = null;
	public $type = '';
	public $icon = '';
	public $label = '';
	public $keywords = '';
	public $group = 'extra';
	public $drag_droppable = true;
	public $controls = array();
	public $control_groups = array(
		'content',
		'style',
		'advanced',
		'background',
		'background_overlay',
		'border',
		'typography',
		'shape',
		'animation',
		'responsive',
		'custom_css',
	);

	private $data = array();

	public function __construct( $elmn = array() ) {
		$this->register_controls();
		if ( ! empty( $elmn ) ) {
			$this->id   = $elmn['elmn_id'];
			$this->data = $this->sanitize_data( $elmn['elmn_data'] );

		}
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

	}


	public function sanitize_data( $data ) {
		$return_data = array();
		$controls    = $this->controls;
		foreach ( $data as $key => $value ) {
			$control_key = array_search( $key, array_column( $controls, 'id' ) );
			$control     = $controls[ $control_key ];
			if ( isset( $control['sanitize_callback'] ) ) {

				$return_data[ $key ] = call_user_func( $control['sanitize_callback'], $value );
			} else {
				$return_data[ $key ] = $value;
			}

		}

		return $return_data;
	}

	public function register() {
		add_filter( 'lwwb/builder/elmn/config', array( $this, 'get_config' ) );
		add_action( 'customize_controls_print_scripts', array( $this, 'print_template' ) );
	}

	public function register_controls() {
		$this->add_control( $this->get_tab_control() );
		$this->add_control( $this->get_search_control() );

		foreach ( $this->control_groups as $control_group ) {
			$control_group_method = 'get_' . $control_group . '_group_control';
			if (
			method_exists( $this, $control_group_method ) ) {
				$this->add_control( $this->$control_group_method() );
			}
		}

	}

	public function enqueue() {

	}

	protected function get_data( $data_key = '' ) {

		if ( '' !== $data_key && isset( $this->data[ $data_key ] ) ) {
			return $this->data[ $data_key ];
		} else {
			return null;
		}
	}

	public function add_controls( $controls ) {
		foreach ( $controls as $control ) {
			$this->add_control( $control );
		}
	}

	public function add_control( $control ) {
		array_push( $this->controls, $control );
	}

	public function get_tab_control() {
		return array(
			'id'             => 'lwwb_tab_control',
			'label'          => '',
			'default'        => 'content',
			'type'           => Control::TAB,
			'save_on_change' => 'off',
			'choices'        => array(
				'content'  => __( 'Content', 'lwwb' ),
				'style'    => __( 'Style', 'lwwb' ),
				'advanced' => __( 'Advanced', 'lwwb' ),
			),

		);
	}

	public function get_search_control() {
		return array(
			'id'             => 'lwwb_search_control',
			'label'          => '',
			'type'           => Control::TEXT,
			'input_type'     => 'search',
			'save_on_change' => 'off',
			'placeholder'    => __( 'Control filter ..', 'lwwb' ),

		);
	}

	public function get_content_group_control() {
		return
			array(
				'id'           => 'lwwb_content_group_control',
				'label'        => __( 'Content', 'lwwb' ),
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
		return Default_Elmn_Controls::get_content_controls();
	}

	public function get_style_group_control() {
		return
			array(
				'id'           => 'lwwb_style_group_control',
				'label'        => __( 'Style', 'lwwb' ),
				'type'         => Control::GROUP,
				'dependencies' => array(
					array(
						'control'  => 'lwwb_tab_control',
						'operator' => '===',
						'value'    => 'style',
					),
				),
				'fields'       => static::get_style_controls(),
			);
	}

	public static function get_style_controls() {
		return Default_Elmn_Controls::get_style_controls();
	}

	public function get_advanced_group_control() {
		return
			array(
				'id'           => 'lwwb_advanced_group_control',
				'label'        => __( 'Advanced', 'lwwb' ),
				'type'         => Control::GROUP,
				'dependencies' => array(
					array(
						'control'  => 'lwwb_tab_control',
						'operator' => '===',
						'value'    => 'advanced',
					),
				),
				'fields'       => static::get_advanced_controls(),
			);
	}

	public static function get_advanced_controls() {
		return Default_Elmn_Controls::get_advanced_controls();
	}

	public function get_background_group_control() {
		return
			array(
				'id'           => 'lwwb_background_group_control',
				'label'        => __( 'Background', 'lwwb' ),
				'type'         => Control::GROUP,
				'dependencies' => array(
					array(
						'control'  => 'lwwb_tab_control',
						'operator' => '===',
						'value'    => 'advanced',
					),
				),
				'fields'       => static::get_background_controls(),
			);
	}

	public static function get_background_controls() {
		return Default_Elmn_Controls::get_background_controls();
	}

	public function get_background_overlay_group_control() {
		return
			array(
				'id'           => 'lwwb_background_overlay_group_control',
				'label'        => __( 'Background Overlay', 'lwwb' ),
				'type'         => Control::GROUP,
				'dependencies' => array(
					array(
						'control'  => 'lwwb_tab_control',
						'operator' => '===',
						'value'    => 'advanced',
					),
				),
				'fields'       => static::get_background_overlay_controls(),
			);
	}

	public static function get_background_overlay_controls() {
		return Default_Elmn_Controls::get_background_overlay_controls();
	}

	public function get_border_group_control() {
		return
			array(
				'id'           => 'lwwb_border_group_control',
				'label'        => __( 'Border', 'lwwb' ),
				'type'         => Control::GROUP,
				'dependencies' => array(
					array(
						'control'  => 'lwwb_tab_control',
						'operator' => '===',
						'value'    => 'advanced',
					),
				),
				'fields'       => static::get_border_controls(),
			);
	}

	public static function get_border_controls() {
		return Default_Elmn_Controls::get_border_controls();
	}

	public function get_typography_group_control() {
		return
			array(
				'id'           => 'lwwb_typography_group_control',
				'label'        => __( 'Typography', 'lwwb' ),
				'type'         => Control::GROUP,
				'dependencies' => array(
					array(
						'control'  => 'lwwb_tab_control',
						'operator' => '===',
						'value'    => 'advanced',
					),
				),
				'fields'       => static::get_typography_controls(),
			);
	}

	public static function get_typography_controls() {
		return Default_Elmn_Controls::get_typography_controls();
	}

	public function get_animation_group_control() {
		return
			array(
				'id'           => 'lwwb_animation_group_control',
				'label'        => __( 'Animation', 'lwwb' ),
				'type'         => Control::GROUP,
				'dependencies' => array(
					array(
						'control'  => 'lwwb_tab_control',
						'operator' => '===',
						'value'    => 'advanced',
					),
				),
				'fields'       => static::get_animation_controls(),
			);
	}

	public static function get_animation_controls() {
		return Default_Elmn_Controls::get_animation_controls();
	}

	public function get_responsive_group_control() {
		return
			array(
				'id'           => 'lwwb_responsive_group_control',
				'label'        => __( 'Responsive', 'lwwb' ),
				'type'         => Control::GROUP,
				'dependencies' => array(
					array(
						'control'  => 'lwwb_tab_control',
						'operator' => '===',
						'value'    => 'advanced',
					),
				),
				'fields'       => static::get_responsive_controls(),
			);
	}

	public static function get_responsive_controls() {
		return Default_Elmn_Controls::get_responsive_controls();
	}

	public function get_custom_css_group_control() {
		return
			array(
				'id'           => 'lwwb_custom_css_group_control',
				'label'        => __( 'Custom css', 'lwwb' ),
				'type'         => Control::GROUP,
				'dependencies' => array(
					array(
						'control'  => 'lwwb_tab_control',
						'operator' => '===',
						'value'    => 'advanced',
					),
				),
				'fields'       => static::get_custom_css_controls(),
			);
	}

	public static function get_custom_css_controls() {
		return Default_Elmn_Controls::get_custom_css_controls();
	}

	public function get_controls() {
		return $this->controls;
	}

	// Get config for builder
	public function get_config( $config ) {
		return array_merge( $config, array(
			$this->type => array(
				'controls' => $this->get_controls(),
				'default'  => $this->get_default_data(),
				'metas'    => $this->get_metas(),
			),
		) );
	}

	public function get_default_data() {
		return array();
	}

	// Get metas
	public function get_metas() {
		return array(
			'label'       => $this->label,
			'type'        => $this->type,
			'icon'        => $this->icon,
			'key_words'   => $this->key_words,
			'template_id' => $this->get_template_id(),
		);
	}

	// Get template id
	public function get_template_id() {
		return 'lwwb-elmn-' . $this->type . '-tmpl-content';
	}

	public function get_elmn_builder_control() {
		return array(
			'move',
			'edit',
			'clone',
			'remove',
		);
	}

	public function top_control_template() {
		if ( empty( $this->get_elmn_builder_control() ) ) {
			return;
		}
		?>
        <div class="lwwb-elmn-setting-list">
            <ul class="lwwb-elmn-settings lwwb-<?php echo esc_attr( $this->type ); ?>-settings">
				<?php foreach ( $this->get_elmn_builder_control() as $builder_control ): ?>
					<?php call_user_func( array( $this, 'render_' . $builder_control . '_control' ) ); ?>
				<?php endforeach ?>
            </ul>
        </div>
		<?php
	}

	public function bottom_control_template() {

	}

	public function render_move_control() {

		?>
        <li class="lwwb-elmn-setting lwwb-elmn-move" data-action="move" draggable="true"
            title="<?php echo __( 'Move', 'lwwb' ); ?> <?php echo esc_attr( $this->type ); ?>">
            <i class="fa fa-arrows" aria-hidden="true"></i><span
                    class="lwwb-control-label"><?php echo __( 'Move', 'lwwb' ); ?><?php echo esc_attr( $this->type ); ?></span>
        </li>
		<?php
	}

	public function render_edit_control() {
		?>
        <li class="lwwb-elmn-setting lwwb-elmn-edit" data-action="edit"
            title="<?php echo __( 'Edit', 'lwwb' ); ?> <?php echo esc_attr( $this->type ); ?>">
            <i class="fa fa-edit" aria-hidden="true"></i><span
                    class="lwwb-control-label"><?php echo __( 'Edit', 'lwwb' ); ?><?php echo esc_attr( $this->type ); ?></span>
        </li>

		<?php
	}

	public function render_add_control() {
		?>
        <li class="lwwb-elmn-setting lwwb-elmn-add" data-action="add"
            title="<?php echo __( 'Add', 'lwwb' ); ?> <?php echo esc_attr( $this->type ); ?>">
            <i class="fa fa-plus" aria-hidden="true"></i><span
                    class="lwwb-control-label"><?php echo __( 'Add', 'lwwb' ); ?><?php echo esc_attr( $this->type ); ?></span>
        </li>

		<?php
	}

	public function render_save_control() {
		?>
        <li class="lwwb-elmn-setting lwwb-elmn-save" data-action="save"
            title="<?php echo __( 'Save', 'lwwb' ); ?> <?php echo esc_attr( $this->type ); ?>">
            <i class="fa fa-save" aria-hidden="true"></i><span
                    class="lwwb-control-label"><?php echo __( 'Save as template', 'lwwb' ); ?><?php echo esc_attr( $this->type ); ?></span>
        </li>

		<?php
	}

	public function render_clone_control() {
		?>
        <li class="lwwb-elmn-setting lwwb-elmn-clone" data-action="clone"
            title="<?php echo __( 'Clone', 'lwwb' ); ?> <?php echo esc_attr( $this->type ); ?>">
            <i class="fa fa-clone" aria-hidden="true"></i><span
                    class="lwwb-control-label"><?php echo __( 'Clone ', 'lwwb' ); ?><?php echo esc_attr( $this->type ); ?></span>
        </li>

		<?php
	}

	public function render_remove_control() {
		?>
        <li class="lwwb-elmn-setting lwwb-elmn-remove" data-action="remove"
            title="<?php echo __( 'Remove', 'lwwb' ); ?> <?php echo esc_attr( $this->type ); ?>">
            <i class="fa fa-remove" aria-hidden="true"></i><span
                    class="lwwb-control-label"><?php echo __( 'Remove', 'lwwb' ); ?><?php echo esc_attr( $this->type ); ?></span>
        </li>

		<?php
	}

	// Render template for builder
	public function print_content_template() {
		echo '<div class="lwwb-elmn-content">';
		$this->content_template();
		echo '</div>';
	}

	public function content_template() {

	}

	final public function print_template() {
		?>
        <script type="text/html" id="tmpl-lwwb-elmn-<?php echo $this->type; ?>-content">
			<?php $this->top_control_template(); ?>
			<?php $this->print_content_template(); ?>
			<?php $this->bottom_control_template(); ?>
        </script>
		<?php
	}

	public function get_default_classes() {
		$classes = array(
			'lwwb-elmn',
			'lwwb-elmn-' . $this->id,
			' lwwb-elmn-' . $this->type,
			isset( $this->data['custom-classes'] ) ? esc_attr( $this->data['custom-classes'] ) : '',
			( isset( $this->data['hide-desktop'] ) && ( 'yes' === $this->data['hide-desktop'] ) ) ? 'is-hidden-desktop' : '',
			( isset( $this->data['hide-tablet'] ) && ( 'yes' === $this->data['hide-tablet'] ) ) ? 'is-hidden-tablet-only' : '',
			( isset( $this->data['hide-mobile'] ) && ( 'yes' === $this->data['hide-mobile'] ) ) ? 'is-hidden-mobile' : '',
		);

		return $classes;
	}

	public function get_elmn_classes() {
		$classes = $this->get_default_classes();

		return $classes;
	}

	public function get_elmn_id() {
		$id = $this->get_data('css_id') ? esc_attr( $this->get_data('css_id')) : '';

		return $id;
	}

	public function before_render() {
		$id      = $this->get_elmn_id() ? 'id="' . $this->get_elmn_id() . '"' : '';
		$classes = $this->get_elmn_classes();
		$class   = implode( ' ', array_filter( $classes ) );
		echo '<div ' . $id . ' class="' . $class . '">';
	}

	public function after_render() {
		echo '</div>';

	}

	public function render_elmn_background_overlay() {

		if ( ! is_null( $this->get_data( 'bg_overlay_state' ) ) ) {
			echo '<div class="lwwb-elmn-background-overlay">&nbsp;</div>';
		}
	}

	public function render_elmn_shape_top() {
		if ( ! is_null( $this->get_data( 'shape_top' ) ) ) {
			echo '<div class="lwwb-elmn-shape-top">&nbsp;</div>';
		}
	}

	public function render_elmn_shape_bottom() {
		if ( ! is_null( $this->get_data( 'shape_bottom' ) ) ) {
			echo '<div class="lwwb-elmn-shape-bottom">&nbsp;</div>';
		}
	}

	public function get_classes_content() {
		$classes = array();
		return $classes;
	}

	public function print_elmn_content() {

		$classes   = $this->get_classes_content();
		$classes[] = 'lwwb-elmn-content';
		echo '<div  class="' . implode( ' ', $classes ) . '">';
		$this->render_content();
		echo '</div>';
	}

	public function render_content() {
	}

	public function render() {

		$this->before_render();
		$this->render_elmn_background_overlay();
		$this->render_elmn_shape_top();
		$this->render_elmn_shape_bottom();
		$this->print_elmn_content();
		$this->after_render();

	}

}