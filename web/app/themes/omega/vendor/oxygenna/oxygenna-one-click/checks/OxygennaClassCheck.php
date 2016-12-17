<?php
/**
 * One Click System Check
 *
 * @package One Click Installer
 * @subpackage Admin
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.14.0
 * @author Oxygenna.com
 */

require_once OXY_ONECLICK_DIR . 'inc/OxygennaSystemCheck.php';

class OxygennaClassCheck extends OxygennaSystemCheck
{
    private $args;

    public function __construct($args)
    {
        $this->args = $args;
        parent::__construct($this->args['name']);
    }

    public function check()
    {
        if ( class_exists($this->args['value']) ) {
            $this->info = $this->args['ok_message'];
            $this->value = 'enabled';
            $this->ok = true;
        }
        else {
            $this->info = $this->args['fail_message'];
            $this->value = 'disabled';
            $this->ok = false;
        }
    }
}
