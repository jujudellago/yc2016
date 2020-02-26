<?php
/**
 * Date Option
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
 * Creates a date picker option
 */
class OxygennaDate extends OxygennaOption
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
        $this->set_attr('class', 'oxy-date-field');
        $this->set_attr('value', $value);
    }

    /**
     * Overrides super class render function
     *
     * @return string HTML for option
     *                @since 1.0
     **/
    public function render($echo = true)
    {
        $output = '<input ' . $this->create_attributes() . ' />';
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
        wp_enqueue_script('date-field', OXY_TF_URI . 'inc/options/fields/date/date.js', array('jquery-ui-datepicker'));
    }
}
