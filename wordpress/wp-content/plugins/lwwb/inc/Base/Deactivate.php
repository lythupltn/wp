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


class Deactivate
{
	public static function deactivate() {
		flush_rewrite_rules();
		delete_option('lwwb_settings');
	}
}