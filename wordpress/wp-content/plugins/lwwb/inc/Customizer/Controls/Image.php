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

use Lwwb\Customizer\Control_Manager as Control_Mannager;

class Image extends Group
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-image';

    public $fields = array();

    public function to_json()
    {
        parent::to_json();

        $this->json['default'] = $this->setting->default;
        $this->json['value']   = $this->value();
        $this->json['link']    = $this->get_link();
        $this->json['fields']  = array_merge($this->get_fields(), $this->fields);

    }

    protected function field_header()
    {}

    protected function get_fields()
    {
        return array(
            array(
                'label'      => __('Image', 'lwwb'),
                'type'       => Control_Mannager::MEDIA_UPLOAD,
                'id'         => 'image',
                'default'    => array(
                    'url' => '',
                    'id'  => '',
                ),
                'media_type' => 'image',
            ),
            array(
                'label'   => __('Caption', 'lwwb'),
                'type'    => Control_Mannager::SELECT,
                'id'      => 'caption',
                'default' => 'none',
                'choices' => array(
                    'none'               => __('None', 'lwwb'),
                    'attachment_caption' => __('Attachment caption', 'lwwb'),
                    'custom_caption'     => __('Custom caption', 'lwwb'),
                ),
            ),
            array(
                'label'   => __('Link to', 'lwwb'),
                'type'    => Control_Mannager::SELECT,
                'id'      => 'link-to',
                'default' => 'none',
                'choices' => array(
                    'none'       => __('None', 'lwwb'),
                    'media_file' => __('Media file', 'lwwb'),
                    'custom_url' => __('Custom url', 'lwwb'),
                ),
            ),
        );
    }

    protected function field_template()
    {
        ?>
        <div class="widget-top">
            <div class="widget-title-action">
                <button type="button" class="widget-action hide-if-no-js" aria-expanded="false">
                    <span class="screen-reader-text">{{{ data.label }}}</span>
                    <span class="toggle-indicator" aria-hidden="true"></span>
                </button>
            </div>
            <div class="widget-title"><h3>{{{ data.label }}}</h3></div>
        </div>

        <div class="widget-inside" style="display: block;">
            <div class="widget-content">
            </div>
        </div>
        <?php
}

}