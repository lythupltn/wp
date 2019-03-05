<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    lwwb.core
 * @subpackage lwwb.core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Frontend;

use Lwwb\Base\Base_Manager;
use Lwwb\Frontend\Base\Frontend_Base;
use Lwwb\Frontend\header\Header_Manager;

class Frontend_Manager extends Base_Manager {
	public  function get_services()
	{
		return [
//			Auto_Css::class,
			Enqueue_Frontend::class,
			Frontend_Base::class,
		];
	}
}