<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    lwwb.core
 * @subpackage lwwb.core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Base;

use Lwwb\Base\AJAX\Ajax;

class Ajax_Manager extends Base_Manager{
	public  function get_services()
	{
		return [
			Ajax::class,
		];
	}
}