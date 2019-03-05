<?php
	/**
	 *
	 * @link       laserwp.com/contact
	 * @since      1.0.0
	 * @package    laserbase
	 * @subpackage laserbase/
	 * @author     Laser WordPress Team <contact@laserwp.com>
	 */

	class Export_Controls {
		function __construct() {

		}


		public function csv_to_array( $filename = '', $delimiter = ',' ) {
			$filename = get_stylesheet_directory() . '/data/' . $filename;

			if ( ! file_exists( $filename ) || ! is_readable( $filename ) ) {
				return false;
			}

			$header = null;
			$data   = array();
			if ( ( $handle = fopen( $filename, 'r' ) ) !== false ) {
				while ( ( $row = fgetcsv( $handle, 1000, $delimiter ) ) !== false ) {
					if ( ! $header ) {
						$header = $row;
					} else {
						$data[] = array_combine( $header, $row );
					}
				}
				fclose( $handle );
			}

			return $data;
		}

		public function get_control_config( $row ) {
			$default = array(
				"array(",
				( $row['type'] != '' ) ? " 'type' => Control::" . $row['type'] . "," : '',
				( $row['label'] != '' ) ? "    'label'=> esc_html__('" . $row['label'] . "','lwwb')" . "," : '',
				( $row['description'] != '' ) ? "  'description'=> esc_html__('" . $row['description'] . "','lwwb')" . "," : '',
				( $row['id'] != '' ) ? "   'id' => '" . $row['id'] . "'," : '',
				( $row['keywords'] != '' ) ? " 'keywords' => '" . $row['keywords'] . "'," : '',
				( $row['choices'] != '' ) ? ( strpos( $row['choices'], '()' ) ) ? "  'choices' => static::" . $row['choices'] . "," : "  'choices' => " . $row['choices'] . "," : '',
				( $row['control_layout'] != '' ) ? "   'control_layout' =>'" . $row['control_layout'] . "'," : '',
				( $row['display_type'] != '' ) ? "    'display_type' =>'" . $row['display_type'] . "'," : '',
				( $row['on_device'] != '' ) ? "    'on_device' =>'" . $row['on_device'] . "'," : '',
				($row['type'] === 'RESPONSIVE_SWITCHER') ? " 'device_config' => array( 'desktop'=>'desktop','tablet'=>'tablet','mobile'=>'mobile', )," : '',
				( $row['dependencies'] != '' ) ? "  '" . $row['dependencies'] . "," : '',
				( $row['input_type'] != '' ) ? "    'input_type' =>'" . $row['input_type'] . "'," : '',
				( $row['default'] != '' ) ? (strpos($row['default'],'array') > -1) ? ( $row['default'] ==='""' ) ? '""' : "    'default' =>" . $row['default'] . "," : "    'default' =>'" . $row['default'] . "'," : '',
				( $row['input_attrs'] != '' ) ? "   " . $row['input_attrs'] . "," : '',
				( $row['placeholder'] != '' ) ? "  'placeholder' => ' " . $row['placeholder'] . "'," : '',
				( $row['unit'] != '' ) ? "    '" . $row['unit'] . "," : '',
				( $row['css_format'] != '' ) ? "   '" . $row['css_format'] . "," : '',
				($row['type'] === 'DIMENSIONS' ) ? " 'options' => array('top'    => esc_html__('Top', 'lwwb'),'right'  => esc_html__('Right', 'lwwb'),'bottom' => esc_html__('Bottom', 'lwwb'),'left'   => esc_html__('Left', 'lwwb'),)," : '',
				($row['type'] !== 'MODAL' ) ? " )," : '',


			);

			return join( '', $default );

		}

		public function xlsx_to_array( $filename = '' ) {
			$filename = get_stylesheet_directory() . '/' . $filename;
			if ( $xlsx = SimpleXLSX::parse( $filename ) ) {
				return $xlsx->rows( 1 );
			} else {
				echo SimpleXLSX::parseError();
			}
		}

		public function get_group_control( $row, $sheet ) {
			$controls_data = "
					 public function get_background_group_control()
					    {
					        return
					        array(
					            'id'           => 'lwwb_background_group_control',
					            'label'        => __('Background', 'lwwb'),
					            'type'         => Control::GROUP,
					            'dependencies' => array(
					                array(
					                    'control'  => 'lwwb_tab_control',
					                    'operator' => '===',
					                    'value'    => 'style',
					                ),
					            ),
					            'fields'       => static::get_background_controls(),
					        );
					    }
					
					    public static function get_background_controls()
					    {
					        return array(
					        
					            );
					    }
			";
			foreach ( $row as $index => $item ) {
				$header   = $sheet[0][ $index ];
				$data_key = strtolower( str_replace( ' ', '_', $header ) );

				if ( $item != '' ) {
					$controls_data .= "'" . $data_key . "'=>" . $item . '';
				}

			}

			return $controls_data;
		}

		public function get_controls( $row, $sheet ) {
			$controls_data = 'array(';

			for ( $i = 1; $i < sizeof( $row ); $i ++ ) {
				$item     = $row[ $i ];
				$header   = $sheet[0][ $i ];
				$data_key = strtolower( str_replace( ' ', '_', $header ) );

				if ( $item != '' ) {
					if ( $data_key === 'choices' || $data_key === 'unit' || $data_key === 'input_attrs' ) {
						if ( strpos( $item, '()' ) > - 1 ) {
							$controls_data .= " '" . $data_key . "'=> static::" . $item . ",";
						} else {
							$controls_data .= " '" . $data_key . "'=>" . $item . ",";
						}
					} elseif ( $data_key === 'dependencies' ) {
						$controls_data .= " '" . $item . "',";
					} elseif ( $data_key === 'label' ) {
						$controls_data .= " '" . $data_key . "'=> esc_html__('" . $item . "','lwwb'),";
					} elseif ( $data_key === 'type' ) {

						$controls_data .= " '" . $data_key . "'=> Control::" . $item . ",";

					} else {
						$controls_data .= " '" . $data_key . "'=>'" . $item . "',";
					}

					if ( $item === 'RESPONSIVE_SWITCHER' ) {

						$controls_data .= " 'device_config' => array(
                                                'desktop' => 'desktop',
                                                'tablet'  => 'tablet',
                                                'mobile'  => 'mobile',
                        )";
					}

				}
			}
			$controls_data .= '),';
			if ( $controls_data == 'array();' ) {
				return '';
			}
			$controls_data = str_replace( ',,', ',', $controls_data );

			return $controls_data;
		}

		/**
		 * Example
		 */

	}
