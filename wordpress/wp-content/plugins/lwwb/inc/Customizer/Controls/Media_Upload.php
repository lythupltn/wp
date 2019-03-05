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

class Media_Upload extends Base_Control
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-media-upload';

    public $media_type = 'image';

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     *
     * @access public
     */
    public function to_json()
    {
        parent::to_json();
        $this->json['default'] = $this->setting->default;
        $this->json['value']   = $this->value();
        $this->json['media_type']   = $this->media_type;
        $this->json['link']    = $this->get_link();
    }

    protected function field_template()
    {

        ?>
        <# data.media_type = data.media_type || 'image'; #>
        <div class="lwwb-media-upload-control">
            <div class="attachment-media-view {{{ data.media_type }}}-upload">
                <# if ( data.value['url']) { #>
                    <div class="thumbnail thumbnail-{{{ data.media_type }}}">
                        <img src="{{ data.value['url'] }}" alt=""/>
                    </div>
                <# } else { #>
                <div class="placeholder"><?php echo __('No File Selected', 'lwwb') ?></div>
                <# } #>
                <div class="actions">
                    <button class="button {{{ data.media_type }}}-upload-remove-button<# if ( ! data.value['url'] ) { #> hidden <# } #>"><?php echo __('Remove', 'lwwb') ?></button>
                    <button type="button" class="button {{{ data.media_type }}}-upload-button"><?php echo __('Select File', 'lwwb') ?></button>
                </div>
                <input type="hidden" class="lwwb-input" data-key="url" value="{{ data.value['url'] }}" >
                <input type="hidden" class="lwwb-input" data-key="id" value="{{ data.value['id'] }}" >
                <input type="hidden" class="{{{ data.media_type }}}-hidden-value" value="{{ data.value }}" <# if ( data.link ) { #> {{{ data.link }}} <# } #>>

            </div>
        </div>
        <?php
}

}