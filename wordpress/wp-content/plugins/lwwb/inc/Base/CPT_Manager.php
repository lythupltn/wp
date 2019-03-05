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

use Lwwb\Base\CPT\CPT_Base;
use Lwwb\Base\CPT\CPT_External_Post;
use Lwwb\Base\CPT\CPT_Library;

class CPT_Manager extends Base_Manager {
	public  function get_services()
	{
		return [
			CPT_Base::class,
			CPT_Library::class,
			CPT_External_Post::class,
		];
	}
}