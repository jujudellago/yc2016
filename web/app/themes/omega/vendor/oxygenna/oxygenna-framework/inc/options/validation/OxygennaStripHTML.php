<?php
/**
 * Removes all html tags
 *
 * @package Omega
 * @subpackage Core
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.18.14
 */

/**
 * Removes all HTML
 *
 * @package Omega
 * @since 1.0
 **/
class OxygennaStripHTML
{
    /**
     * Validates the option data
     *
     * @return validated options array
     *                   @since 1.0
     **/
    public function validate($field, $options, $new_options)
    {
        $options[$field['id']] = strip_tags($new_options[$field['id']]);

        return $options;
    }
}
