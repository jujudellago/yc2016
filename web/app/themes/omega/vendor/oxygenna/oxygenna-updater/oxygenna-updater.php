<?php
/**
 * Oxyggena Typography Module
 *
 * @package Omega
 * @subpackage Updater
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.12
 * @author Oxygenna.com
 */


define('OXY_UPDATER_DIR', OXY_THEME_DIR . 'vendor/oxygenna/oxygenna-updater/');
define('OXY_UPDATER_URI', OXY_THEME_URI . 'vendor/oxygenna/oxygenna-updater/');

if (!class_exists('OxygennaUpdater')) {
    require_once(OXY_UPDATER_DIR . 'inc/OxygennaUpdater.php');
    global $oxy_updater;
    $oxy_updater = OxygennaUpdater::instance();
}
