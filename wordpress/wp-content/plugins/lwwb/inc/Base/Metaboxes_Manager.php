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

use Lwwb\Base\Metaboxes\Meta_Base;
use Lwwb\Base\Metaboxes\Meta_Content;

class Metaboxes_Manager extends Base_Manager {
	public  function get_services()
	{
		return [
			Meta_Base::class,
			Meta_Content::class,
		];
	}
}