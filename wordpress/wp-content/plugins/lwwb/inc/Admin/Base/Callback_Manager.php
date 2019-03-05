<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Admin\Base;

class Callback_Manager extends \Lwwb\Base\Base_Manager {

	public function options_sanitize( $input ) {
		$output = get_option( 'lwwb_settings' );

		foreach ( $output as $key => $value ) {
			if ( isset( $_POST['admin_page'] ) && $_POST['admin_page'] == $key ) {

				if ( isset( $input[ $key ] ) && count( $input[ $key ] ) === 0 ) {
					$output[ $key ] = array();

					return $output;
				}

				$output[ $key ] = $input[ $key ];
			}
		}

		return $output;
	}

	public function checkbox_sanitize( $input ) {
		$output = array();
		foreach ( $this->managers as $key => $value ) {
			$output[ $key ] = isset( $input[ $key ] ) ? true : false;
		}

		return $output;
	}

	public function admin_section_manager() {
		echo esc_html__( 'This Section is disable', 'lwwb' );
	}

	public function checkbox_field( $args ) {
		$name         = $args['label_for'];
		$option_name  = $args['option_name'];
		$option_slug  = $args['option_slug'];
		$get_options  = get_option( $option_name );
		$lwwb_options = $get_options[ $option_slug ];
		if ( ! isset( $lwwb_options ) ) {
			$lwwb_options = array();
		}
		?>
        <div class="ui-toggle mb-10">
            <input type="checkbox" id="<?php echo esc_attr( $name ); ?>"
                   name="<?php echo 'lwwb_settings[' . $option_slug . '][]'; ?>"
                   value="<?php echo esc_attr( $name ); ?>"
                   class="" <?php checked( in_array( $name, $lwwb_options, true ), true ); ?> >
            <label for="<?php echo esc_attr( $name ); ?>">
                <div></div>
            </label>
        </div>
		<?php
	}

	public function textbox_field( $args ) {
		$name        = $args['label_for'];
		$option_name = $args['option_name'];
		$option_slug = $args['option_slug'];
		$description = isset( $args['description'] ) ? $args['description'] : '';
		$get_options = get_option( $option_name );
		if ( $option_slug ) {
		    if (isset($get_options[ $option_slug ])){
			    $lwwb_options = $get_options[ $option_slug ];
		    }
		}
		if ( ! isset( $lwwb_options ) ) {
			$lwwb_options = array();
		}
		$allow_html = array(
			'a'  => array( 'href' => array(), 'target' => array() ),
			'br' => array()
		);
		?>
        <div class="lwwb-setting-input mb-10">
            <input type="text" id="<?php echo esc_attr( $name ); ?>"
                   name="<?php echo 'lwwb_settings[' . $option_slug . '][' . $name . ']'; ?>"
                   value="<?php if ( isset( $lwwb_options[ $name ] ) ) : echo esc_attr( $lwwb_options[ $name ] ); endif; ?>">
        </div>
		<?php if ( $description ) :
            echo '<div class="lwwb-setting-description">';
			echo wp_kses( $description, $allow_html );
			echo '</div>';
		endif; ?>
		<?php
	}
}