<?php
/**
 * Radio Option
 *
 * @package ThemeFramework
 * @subpackage Options
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.18.12
 */

/**
 * Creates radio option using jquery ui
 */
class OxygennaImgradio extends OxygennaOption
{
    /**
     * Creates option
     *
     * @return void
     *              @since 1.0
     **/
    public function __construct($field, $value, $attr)
    {
        parent::__construct($field, $value, $attr);
        $this->set_attr('type', 'radio');
    }

    /**
     * Overrides super class render function
     *
     * @return string HTML for option
     * @since 1.0
     **/
    public function render($echo = true)
    {
        echo '<div class="ui-imgradio">';
        foreach ($this->_field['options'] as $key => $label) {
            // set radio options
            $this->set_attr('id', $this->_field['id'] . '_' . $key);
            $this->set_attr('value', $key);
            // create radio and label
            echo '<div class="imgradio-col col'.$this->_field['columns'].'">';
            echo '<input ' . $this->create_attributes() . checked($this->_value, $key, false) . ' />';
            echo '<label for="' . $this->_field['id'] . '_' . $key . '" style="background-image:url('.$label['image'].');">' . $label['name'] . '</label></div>';
        }
        echo '</div>';
    }

    public function enqueue()
    {
        parent::enqueue();
        // load styles
        wp_enqueue_style('jquery-oxygenna-ui-theme');
        // load scripts
        wp_enqueue_script('imgradio-field', OXY_TF_URI . 'inc/options/fields/imgradio/imgradio.js', array('jquery-ui-button'));
    }
}
