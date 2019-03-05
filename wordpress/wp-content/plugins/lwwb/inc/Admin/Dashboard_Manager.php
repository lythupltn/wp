<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Admin;

use Lwwb\Admin\Library\Library_Controller;
use Lwwb\Base\Base_Manager;
use Lwwb\Admin\Base\Base_Admin_Controller;
use Lwwb\Admin\Base\Callback_Manager;
use Lwwb\Admin\Dashboard\Dashboard_Controller;
use Lwwb\Admin\Role\Role_Controller;
use Lwwb\Admin\Settings\Settings_Controller;

class Dashboard_Manager extends Base_Manager{
	public  function get_services()
	{
		return [
			Callback_Manager::class,
			Base_Admin_Controller::class,
			Dashboard_Controller::class,
			Settings_Controller::class,
			Role_Controller::class,
			Library_Controller::class,
		];
	}
}