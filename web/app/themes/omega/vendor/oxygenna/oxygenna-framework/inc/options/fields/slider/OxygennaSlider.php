<?php
/**
 * Slider Option
 *
 * @package ThemeFramework
 * @subpackage Options
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.18.14
 */

/**
 * Creates slider bar option
 */
class OxygennaSlider extends OxygennaOption
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
        $this->set_attr('type', 'text');
        $this->set_attr('class', 'slider-option');
        $this->set_attr('value', floatval($value));
    }

    /**
     * Overrides super class render function
     *
     * @return string HTML for option
     *                @since 1.0
     **/
    public function render($echo = true)
    {
        $output = '<div></div>';
        $output .= '<input ' . $this->create_attributes() . '/>';
        if (isset($this->_field['postfix'])) {
            $output .= ' <label>' . $this->_field['postfix'] . '</label>';
        }

        if ($echo) {
            echo $output;
        } else {
            return $output;
        }
    }

    public function enqueue()
    {
        parent::enqueue();
        // load styles
        wp_enqueue_style('jquery-oxygenna-ui-theme');
        // load scripts
        wp_enqueue_script('slider-field', OXY_TF_URI . 'inc/options/fields/slider/slider.js', array('jquery-ui-slider'));
    }
}
