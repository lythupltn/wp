<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Customizer\Controls;
class Builder_Panel extends Base_Control {
	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'lwwb-panel';
	/**
	 * Button labels
	 */
	public $button_labels = array();

	public $elements = array();
	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 */
	public function to_json() {
		parent::to_json();
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding WP_Customize_Control::to_json().
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @since 4.1.0
	 */
	protected function content_template() {
		?>
        <div id="lwwb-control-container" class="lwwb-control-container">
        </div>
		<?php
	}
}