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

class OxygennaMaxExecTime extends OxygennaSystemCheck
{
    private $args;

    public function __construct($args)
    {
        $this->args = $args;
        parent::__construct(__('PHP', 'omega-admin-td') . ' - ' . 'max_execution_time');
    }

    public function check()
    {
        $this->value = ini_get('max_execution_time');
        // check for 0 as well for infinite time
        $this->ok = $this->value == 0 || $this->value >= $this->args['value'];
        // add extra info if not ok
        if (!$this->ok) {
             $this->info = sprintf(__('We recommend setting %s to at least %s. See: <a href="%s">Increasing memory allocated to PHP</a>', 'omega-admin-td'),'max_execution_time', $this->args['value'], 'http://php.net/manual/en/configuration.changes.php') . '</span>';
        }
    }
}
