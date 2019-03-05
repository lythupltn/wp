<?php
/**
 *
 * @link       laserwp.com/contact
 * @since      1.0.0
 * @package    core
 * @subpackage core/
 * @author     Laser WordPress Team <contact@laserwp.com>
 */

namespace Lwwb\Customizer;

class Sanizite_Callback
{

    public static function dimensions($dimensions)
    {

        $return_dimensions = array(
            'desktop-top'    => '',
            'desktop-right'  => '',
            'desktop-bottom' => '',
            'desktop-left'   => '',
            'tablet-top'     => '',
            'tablet-right'   => '',
            'tablet-bottom'  => '',
            'tablet-left'    => '',
            'mobile-top'     => '',
            'mobile-right'   => '',
            'mobile-bottom'  => '',
            'mobile-left'    => '',
            'unit'           => '',
        );

        $units = array('px', '%', 'vh', 'vw', 'rem', 'em');

        if (is_array($dimensions)) {
            foreach ($return_dimensions as $dimension => $value) {
                if (isset($dimensions[$dimension])) {

                    if ('unit' == $dimension) {

                        $return_dimensions[$dimension] = in_array($dimensions[$dimension], $units) ? $dimensions[$dimension] : '';

                    } else {

                        $return_dimensions[$dimension] = static::number($dimensions[$dimension]);
                    }
                }
            }
        }

        return $return_dimensions;
    }

    public static function image($image)
    {

        $return_image = array(
            'url'          => '',
            'size'         => '',
            'alignment'    => '',
            'caption_type' => '',
            'caption'      => '',
            'link_to'      => '',
            'light_box'    => '',
        );

        if (is_array($image)) {
            foreach ($return_image as $key => $value) {
                if (isset($image[$key])) {

                    if ('url' == $key) {
                        $return_image[$key] = esc_url_raw($image[$key]);
                    } else if ('light_box' == $key) {
                        $return_image[$key] = static::checkbox($image[$key]);
                    } else {
                        $return_image[$key] = sanitize_text_field($image[$key]);
                    }
                }
            }
        }

        return $return_image;
    }

    public static function background($background)
    {

        $return_background = array(
            'background-type-normal'                => '',
            'background-color-normal'               => '',
            'background-image-normal'               => '',
            'background-position-normal'            => '',
            'background-attachment-normal'          => '',
            'background-repeat-normal'              => '',
            'background-size-normal'                => '',
            'gradient-first-color-normal'           => '',
            'gradient-first-color-location-normal'  => '',
            'gradient-second-color-normal'          => '',
            'gradient-second-color-location-normal' => '',
            'gradient-type-normal'                  => '',
            'background-angle-normal'               => '',

            'video-url'                             => '',
            'video-start-timme'                     => '',
            'video-end-timme'                       => '',
            'video-background-falback'              => '',

            'background-type-hover'                 => '',
            'background-color-hover'                => '',
            'background-image-hover'                => '',
            'background-position-hover'             => '',
            'background-attachmentn-hover'          => '',
            'background-repeat-hover'               => '',
            'background-size-hover'                 => '',
            'gradient-first-color-hover'            => '',
            'gradient-first-color-location-hover'   => '',
            'gradient-second-color-hover'           => '',
            'gradient-second-color-location-hover'  => '',
            'gradient-type-hover'                   => '',
            'background-angle-hover'                => '',
        );

        if (is_array($background)) {
            foreach ($return_background as $key => $value) {
                if (isset($background[$key])) {

                    if ('background-image-normal' == $key || 'background-image-hover' == $key || 'video-url' == $key || 'video-background-falback' == $key) {

                        $return_background[$key] = esc_url_raw($background[$key]);

                    } else if ('video-start-timme' == $key || 'video-end-timme' == $key) {

                        $return_background[$key] = static::number($background[$key]);

                    } else {

                        $return_background[$key] = sanitize_text_field($background[$key]);
                        
                    }
                }
            }
        }

        return $return_background;
    }

    public static function checkbox($checked)
    {

        return ((isset($checked) && 'true' == $checked) ? 'true' : 'false');

    }

    public static function multicheck($values)
    {
        $multi_values = !is_array($values) ? explode(',', $values) : $values;
        return !empty($multi_values) ? array_map('sanitize_text_field', $multi_values) : array();
    }

    public static function color($color)
    {
        if (empty($color) || is_array($color)) {
            return '';
        }

        if (false === strpos($color, 'rgba')) {
            return sanitize_hex_color($color);
        }

        $color = str_replace(' ', '', $color);
        sscanf($color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha);

        return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';
    }

    public static function multi_choices($input, $setting)
    {
        $choices    = $setting->manager->get_control($setting->id)->choices;
        $input_keys = $input;

        foreach ($input_keys as $key => $value) {
            if (!array_key_exists($value, $choices)) {
                unset($input[$key]);
            }
        }

        return (is_array($input) ? $input : $setting->default);
    }

    // public static function image( $image, $setting ) {
    //     $mimes = array(
    //         'jpg|jpeg|jpe' => 'image/jpeg',
    //         'gif'          => 'image/gif',
    //         'png'          => 'image/png',
    //         'bmp'          => 'image/bmp',
    //         'tif|tiff'     => 'image/tiff',
    //         'ico'          => 'image/x-icon'
    //     );
    //     $file = wp_check_filetype( $image, $mimes );
    //     return ( $file['ext'] ? $image : $setting->default );
    // }

    public static function number($val)
    {
        return is_numeric($val) ? $val : 0;
    }

    public static function number_blank($val)
    {
        return is_numeric($val) ? $val : '';
    }

    public static function select($input, $setting)
    {
        $input = sanitize_key($input);

        $choices = $setting->manager->get_control($setting->id)->choices;

        return (array_key_exists($input, $choices) ? $input : $setting->default);
    }
	public static function sanitize_repeater_setting( $value ) {
		if ( ! is_array( $value ) ) {
			$value = json_decode( urldecode( $value ) );
		}
		if ( empty( $value ) || ! is_array( $value ) ) {
			$value = array();
		}

		// Make sure that every row is an array, not an object.
		foreach ( $value as $key => $val ) {
			$value[ $key ] = (array) $val;
			if ( empty( $val ) ) {
				unset( $value[ $key ] );
			}
		}

		// Reindex array.
		if ( is_array( $value ) ) {
			$value = array_values( $value );
		}

		return $value;
	}
}
