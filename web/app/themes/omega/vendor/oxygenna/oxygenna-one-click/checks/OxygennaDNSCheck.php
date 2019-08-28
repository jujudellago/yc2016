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

class OxygennaDNSCheck extends OxygennaSystemCheck
{
    private $args;

    public function __construct($args)
    {
        $this->args = $args;
        parent::__construct(esc_html__('DNS Lookup', 'omega-admin-td'), 'warning');
    }

    public function check()
    {
        if (function_exists('gethostbyname')) {
            $ip = gethostbyname($this->args['domain']);

            $this->ok = $ip !== $this->args['domain'];
            $this->value = $ip;
            if ($this->ok) {
                $this->info = esc_html__('Your server can lookup ' . $this->args['domain'], 'omega-admin-td');
            } else {
                $this->info = esc_html__('Your server can NOT lookup ' . $this->args['domain'], 'omega-admin-td');
            }
        }
    }
}
