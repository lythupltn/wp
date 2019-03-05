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

class Code_Editor extends Base_Control {
	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'lwwb-code-editor';

	public $input_type = 'text';

	public $input_attrs = '';
	public $code_type = 'css';

	public $editor_settings = array();

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 */
	public function to_json() {
		parent::to_json();

		$this->json['default']         = $this->setting->default;
		$this->json['value']           = $this->value();
		$this->json['link']            = $this->get_link();
		$this->json['code_type']       = $this->code_type;
		$this->json['editor_settings'] = $this->editor_settings;
		$this->json['input_attrs']     = $this->input_attrs;
		$this->json['placeholder']     = $this->placeholder;

	}

	public function enqueue() {
		$this->editor_settings = wp_enqueue_code_editor( array_merge(
			array(
				'type'       => $this->code_type,
				'codemirror' => array(
					'indentUnit' => 2,
					'tabSize'    => 2,
				),
			),
			$this->editor_settings
		) );

		wp_add_inline_script(
			'wp-codemirror',
			'window.CodeMirror = wp.CodeMirror;'
		);
	}

	protected function field_template() {
		?>
        <textarea id="{{ data.id }}<# if('undefined' !== typeof view) {#>{{ view.cid }}<# } #>"
                  class="code lwwb-input"
                  placeholder="{{ data.placeholder }}"
                  data-editor_settings="{{ JSON.stringify(  data.editor_settings) }}"
        <# if ( data.link ) { #> {{{ data.link }}} <# } #>
        >{{ data.value }}</textarea>

		<?php
	}
}