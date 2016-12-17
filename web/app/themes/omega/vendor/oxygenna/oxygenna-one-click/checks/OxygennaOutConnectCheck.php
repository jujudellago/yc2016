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

class OxygennaOutConnectCheck extends OxygennaSystemCheck
{
    public function __construct($args)
    {
        $this->args = $args;
        parent::__construct(__('Outgoing HTTP Connections', 'omega-admin-td'), 'warning');
    }

    public function check()
    {
        $response = wp_remote_head($this->args['domain']);
        $this->ok = !is_wp_error($response);
        if ($this->ok) {
            $this->info = __('Your server can connect to the themes demo content data', 'omega-admin-td');
            $this->value = $response['response']['code'] . ' - ' . $response['response']['message'];
        } else {
            $this->info = __('Your server can not connect to the themes demo content data', 'omega-admin-td');
            $this->value = $response->get_error_message();
        }
    }
}
