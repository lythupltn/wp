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

class Select2 extends Select
{
    /**
     * The control type.
     *
     * @access public
     * @var string
     */
    public $type = 'lwwb-select2';

    public $option_groups = array();
    public $multiple      = '';
    public $choices       = array();

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     *
     * @access public
     */
    public function to_json()
    {
        parent::to_json();

        $this->json['default']       = $this->setting->default;
        $this->json['value']         = $this->value();
        $this->json['option_groups'] = $this->option_groups;
        $this->json['choices']       = $this->choices;
        $this->json['multiple']      = $this->multiple;
        $this->json['link']          = $this->get_link();

    }

    protected function field_template()
    {
        ?>
            <select name="{{{ data.id }}}" class="lwwb-select" <# if(data.multiple){ #> multiple="multiple" <# } #> style="width: 100%" data-key="{{{ data.id }}}" <# if ( data.link ) { #> {{{ data.link }}} <# } #> >
                <# if(data.option_groups){ #>
                    <# _.each( data.option_groups, function(option_group, key ){ #>
                        <optgroup label="{{{ option_group.label }}}">
                            <# _.each(option_group.choices, function(key, val){ #>
                                <option value="{{ val }}" <# if( data.value === val ){ #> selected <# } #> >{{{ key }}}</option>
                            <# }); #>
                        </optgroup>
                    <# }) #>
                <# }else{ #>
                    <# _.each(data.choices, function(key, val){ #>
                        <option value="{{ val }}" <# if( data.value === val ){ #> selected <# } #> >{{{ key }}}</option>
                    <# }); #>
                <# } #>
            </select>
        <?php
}
}