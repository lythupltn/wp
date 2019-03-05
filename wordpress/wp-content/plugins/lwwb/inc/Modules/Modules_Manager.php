<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    lwwb.core
 * @subpackage lwwb.core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Modules;

use Lwwb\Base\Base_Manager;
use Lwwb\Builder\Elmn\Menu;

class Modules_Manager extends Base_Manager {
	public function get_services() {
		return [
			Menu::class
		];
	}
}