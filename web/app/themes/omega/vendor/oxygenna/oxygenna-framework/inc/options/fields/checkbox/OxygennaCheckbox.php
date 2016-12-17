<?php
/**
 * Textarea option
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
 * Simple Select option
 */
class OxygennaCheckbox extends OxygennaOption
{
    //private $checked;
    /**
     * Creates option
     *
     * @return void
     *              @since 1.0
     **/
    public function __construct($field, $value, $attr)
    {
        parent::__construct($field, $value, $attr);
         $this->set_attr('type', 'checkbox');
    }

    /**
     * Overrides super class set_value function
     *
     * @return string HTML for option
     *                @since 1.0
     **/
    //function set_value($value) {
       // $this->checked = ($value == 'on') || ($value == 'true');
    //}

    /**
     * Overrides super class render function
     *
     * @return string HTML for option
     *                @since 1.0
     **/
    public function render($echo = true)
    {
        if ($this->_value == 'on') {
            $this->set_attr('checked', 'checked');
        }

        echo '<input' . $this->create_attributes() .  '/>';
    }

    public function save($save_data)
    {
        $id = $this->_field['id'];
        if (isset($save_data[$id])) {
            return 'on';
        } else {
            return 'off';
        }
    }
}
