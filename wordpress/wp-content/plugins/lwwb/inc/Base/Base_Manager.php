<?php
	/**
	 *
	 * @link       laserwp.com/contact
	 * @since      1.0.0
	 * @package    core
	 * @subpackage core/
	 * @author     Laser WordPress Team <contact@laserwp.com>
	 */

	namespace Lwwb\Base;

	class Base_Manager extends Base_Controller {

		/**
		 * Store all the classes inside an array
		 * @return array Full list of classes
		 */
		public function get_services()
		{
			return [
				Settings_Links::class,
				Assets_Manager::class,
				// Ajax_Manager::class,
				Hooks_Manager::class,
				CPT_Manager::class,
				Metaboxes_Manager::class,
			];
		}

		/**
		 * Loop through the classes, initialize theme,
		 * and call the register() method if it exists
		 * @return
		 */
		public function register_services()
		{

			foreach ($this->get_services() as $class) {
				$service = self::instantiate($class);
				if (method_exists($service, 'register')) {
					$service->register();
				}
				if (method_exists($service, 'register_services')) {
					$service->register_services();
				}
			}
		}

		/**
		 * Initialize the class
		 * @param  class $class    class from the services array
		 * @return class instance  new instance of the class
		 */
		private static function instantiate($class)
		{

			$service = new $class();

			return $service;
		}
	}