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
	use Lwwb\Base\Assets\Assets_Base;
	use Lwwb\Base\Assets\Font_Icons;

	class Assets_Manager extends Base_Manager {
		public  function get_services()
		{
			return [
				Assets_Base::class,
				Font_Icons::class,
			];
		}
	}