<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    lwwb
 * @subpackage lwwb/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb;

use Lwwb\Base\Base_Manager;

final class Init extends Base_Manager {
	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	public function get_services() {

		return [
			Admin\Dashboard_Manager::class,
			Modules\Modules_Manager::class,
			Customizer\Customizer_Manager::class,
			Builder\Builder_Manager::class,
			Frontend\Frontend_Manager::class
		];
	}
}