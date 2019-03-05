<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    lwwb
 * @subpackage lwwb/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Builder;

use Lwwb\Base\Base_Manager;

class Elmn_Manager extends Base_Manager {
	public $elmns = array();
	public $group = array();
	public static $_instance = null;


	const SECTION = 'section';
	const COLUMN = 'column';
	const HEADING = 'heading';
	const TEXT = 'text';
	const IMAGE = 'image';
	const VIDEO = 'video';
	const BUTTON = 'button';
	const DIVIDER = 'divider';
//	const SECTION = 'icon';
//	const SECTION = 'spacer';

	public function get_default_group() {
		return array(
			'basic'    => esc_html__( 'Basic', 'lwwb' ),
			'advanced' => esc_html__( 'Advanced', 'lwwb' ),
			'extra'    => esc_html__( 'Extra', 'lwwb' ),
		);
	}

	public function get_services() {
		return [
			'section'    => Elmn\Section::class,
			'column'     => Elmn\Column::class,
			'image'      => Elmn\Image::class,
			'text'       => Elmn\Text::class,
			'heading'    => Elmn\Heading::class,
			'menu'       => Elmn\Menu::class,
			'wp_menu'    => Elmn\WP_Menu::class,
			'video'      => Elmn\Video::class,
			'button'     => Elmn\Button::class,
			'accordion'  => Elmn\Accordion::class,
			'divider'    => Elmn\Divider::class,
			'spacer'     => Elmn\Spacer::class,
			'icon'       => Elmn\Icon::class,
			'google_map' => Elmn\Google_Map::class,
			'google_map' => Elmn\Price_Table::class,
		];
	}

	static function get_instance() {
		if ( is_null( static::$_instance ) ) {
			static::$_instance = new self();
			static::$_instance->register();
			static::$_instance->register_services();

		}

		return static::$_instance;
	}

	public function register() {
		$this->group = $this->get_default_group();
		add_filter( 'lwwb/builder/elmn/manager/config', array( $this, 'get_elmns_config' ) );
	}

	public function get_elmns_config() {
		return array(
			'elmns' => apply_filters( 'lwwb/builder/elmn/config', array() )
		);
	}

	public function add_group( $group = array() ) {
		$this->group = array_merge( $this->group, $group );
	}

	public function get_elmn_by_group( $group_name ) {
		$elmns = array_filter( $this->elmns, function ( $elmn, $key ) use ( $group_name ) {

			return ( $elmn['group'] === $group_name && $elmn['drag_droppable'] == true );
		}, ARRAY_FILTER_USE_BOTH );


		return array_values( $elmns );
	}

	public function register_elmn( $elmn_name, $elmn_class ) {
		$elmn_obj = new $elmn_class();
		$elmn_obj->register();
		$this->elmns[ $elmn_name ] = array(
			'class_name'     => $elmn_class,
			'label'          => $elmn_obj->label,
			'icon'           => $elmn_obj->icon,
			'type'           => $elmn_obj->type,
			'group'          => $elmn_obj->group,
			'keywords'       => $elmn_obj->keywords,
			'drag_droppable' => $elmn_obj->drag_droppable,
		);

	}


	public function register_services() {
		foreach ( $this->get_services() as $elmn_name => $elmn_class ) {
			$this->register_elmn( $elmn_name, $elmn_class );

		}
	}
}