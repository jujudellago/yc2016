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

class OxygennaZipCheck extends OxygennaSystemCheck
{
    private $args;

    public function __construct($args)
    {
        $this->args = $args;
        parent::__construct($this->args['name'], 'warning');
    }

    public function check()
    {
        $this->ok = false;
        $this->value = 'disabled';
        $this->info = $this->args['fail_message'];

        if (function_exists('unzip_file') === true || class_exists('ZipArchive') === true) {
            $this->info = $this->args['ok_message'];
            $this->ok = true;
            $this->value = 'enabled';
        }
    }
}
