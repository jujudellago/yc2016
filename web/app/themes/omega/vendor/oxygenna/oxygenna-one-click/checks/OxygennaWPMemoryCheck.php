<?php
/**
 * One Click System Check
 *
 * @package One Click Installer
 * @subpackage Admin
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.12
 * @author Oxygenna.com
 */

require_once OXY_ONECLICK_DIR . 'inc/OxygennaSystemCheck.php';

class OxygennaWPMemoryCheck extends OxygennaSystemCheck
{
    private $wanted_limit;
    private $actual_limit;

    public function __construct($args)
    {
        $this->wanted_limit = $this->ini_to_num($args['limit']);
        parent::__construct(esc_html__('WP Memory Limit', 'omega-admin-td'));
    }

    public function check()
    {
        $this->actual_limit = $this->ini_to_num(WP_MEMORY_LIMIT);
        $this->value = WP_MEMORY_LIMIT;
        $this->ok = $this->actual_limit >= $this->wanted_limit;
        // add extra info if not ok
        if (!$this->ok) {
             $this->info = sprintf(__('We recommend setting memory to at least %s. See: <a href="%s">Increasing memory allocated to PHP</a>', 'omega-admin-td'), size_format($this->wanted_limit), 'http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP') . '</span>';
        }
    }
}
