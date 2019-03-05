<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Builder;

use Lwwb\Base\Base_Manager;

class Builder_Manager extends Base_Manager {
	public  function get_services()
	{
		return [
			Elmn_Manager::class,
		];
	}
}