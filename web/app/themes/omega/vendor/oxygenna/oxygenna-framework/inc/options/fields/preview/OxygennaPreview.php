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
 * @version 1.14.0
 */

/**
 * Simple Text Input Box
 */
class OxygennaPreview extends OxygennaOption
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
        $this->set_attr('value', esc_attr($value));
    }

    /**
     * Overrides super class render function
     *
     * @return string HTML for option
     *                @since 1.0
     **/
    public function render()
    {
        echo '<div '. $this->create_attributes() .'><h' . $this->_field['size'] . '>'.$this->_field['heading'].'</h' . $this->_field['size'] . '><p>' . $this->_field['default'] . '</p></div>';
    }
}
