<?php
	/**
	 *
	 * @link       laserwp.com/contact
	 * @since      1.0.0
	 * @package    lwwb
	 * @subpackage lwwb/
	 * @author     Laser WordPress Team <contact@laserwp.com>
	 */

	namespace Lwwb\Base;

	use Lwwb\Base\Hooks\Hook_Base;

	class Hooks_Manager extends Base_Manager {
		public  function get_services()
		{
			return [
				Hook_Base::class
			];
		}
	}