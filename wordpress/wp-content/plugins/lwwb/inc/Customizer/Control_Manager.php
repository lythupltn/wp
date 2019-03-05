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

use Lwwb\Base\Base_Controller;
use Lwwb\Customizer\Controls as Controls;

final class Control_Manager extends Base_Controller
{

    const TEXT           = 'lwwb-text';
    const TEXTAREA       = 'lwwb-textarea';
    const WYSIWYG        = 'lwwb-wysiwyg';
    const CODE_EDITOR    = 'lwwb-code-editor';
    const RADIO          = 'lwwb-radio';
    const RADIO_IMAGE    = 'lwwb-radio-image';
    const BUTTON_SET     = 'lwwb-button-set';
    const SELECT         = 'lwwb-select';
    const CHECKBOX       = 'lwwb-checkbox';
    const MEDIA_UPLOAD   = 'lwwb-media-upload';
    const DRAGGABLE_ICON = 'lwwb-draggable-icon';
    const SELECT2        = 'lwwb-select2';
    const DIMENSIONS     = 'lwwb-dimensions';
    const GROUP          = 'lwwb-group';
    const MODAL          = 'lwwb-modal';
    const REPEATER       = 'lwwb-repeater';
    const REPEATER_ITEM  = 'lwwb-repeater-item';
    // const TYPOGRAPHY    = 'lwwb-typography';
    // const BACKGROUND    = 'lwwb-background';
    // const BORDER        = 'lwwb-border';
    const HEADING             = 'lwwb-heading';
    const TAB                 = 'lwwb-tab';
    const DIVIDER             = 'lwwb-divider';
    const SWITCHER            = 'lwwb-switcher';
    const RESPONSIVE_SWITCHER = 'lwwb-responsive-switcher';
    const SLIDER              = 'lwwb-slider';
    const UNIT                = 'lwwb-unit';
    const COLOR_PICKER        = 'lwwb-color-picker';
    // const DATE          = 'lwwb-date';
    const ICON_PICKER = 'lwwb-icon-picker';
    const DATE_PICKER = 'lwwb-date-picker';

    public function register()
    {
        add_action('customize_register', array($this, 'register_controls'), 1);
    }

    //  Get Class Control + Register control
    public function register_controls($wp_customize)
    {
        foreach (static::get_controls() as $control) {
            $wp_customize->register_control_type($control);
        }
    }

    public static function get_controls()
    {
        return array(
            // Controls\Base\Base_Control::class,
            Controls\Builder_Panel::class,
            Controls\Text::class,
            Controls\Textarea::class,
            Controls\WYSIWYG::class,
            Controls\Radio::class,
            Controls\Radio_Image::class,
            Controls\Select::class,
            Controls\Select2::class,
            Controls\Tab::class,
            Controls\Group::class,
            Controls\Modal::class,
            Controls\Draggable_Icon::class,
            // Controls\Background\Background::class,
            Controls\Button_Set::class,
            Controls\Unit::class,
            Controls\Checkbox::class,
            Controls\Code_Editor::class,
            Controls\Color_Picker::class,
            Controls\Dimensions::class,
            Controls\Divider::class,
            Controls\Heading::class,
            Controls\Media_Upload::class,
            Controls\Image::class,
            Controls\Icon_Picker::class,
            // // Controls\Radio\Radio::class,
            // Controls\Radio_Image\Radio_Image::class,
            // // Controls\Range\Range::class,
            // // Controls\Select\Select::class,
            Controls\Slider::class,
            // // Controls\Text\Text::class,
            Controls\Switcher::class,
            Controls\Responsive_Switcher::class,
            // Controls\Typography\Typography::class,

            Controls\Date_Picker::class,
            Controls\Repeater::class,
            Controls\Repeater_Item::class,
        );
    }
}
