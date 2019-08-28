<?php
/**
 * Text option
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
 * Simple Text Input Box
 */
class OxygennaText extends OxygennaOption
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
        $this->set_attr('value', esc_attr($value));
    }

    /**
     * Overrides super class render function
     *
     * @return string HTML for option
     *                @since 1.0
     **/
    public function render($echo = true)
    {
        if (isset($this->_field['prefix'])) {
            echo $this->_field['prefix'];
        }
        echo '<input ' . $this->create_attributes() . ' />';
        if (isset($this->_field['postfix'])) {
            echo $this->_field['postfix'];
        }
    }
}
