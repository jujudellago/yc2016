<?php
/**
 * Plugin installer
 *
 * @package Omega
 * @subpackage Admin
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.12
 * @author Oxygenna.com
 */

define('OXY_PLUGINS_INSTALLER_DIR', OXY_THEME_DIR . 'vendor/oxygenna/oxygenna-plugins/');
define('OXY_PLUGINS_INSTALLER_URI', OXY_THEME_URI . 'vendor/oxygenna/oxygenna-plugins/');

if (!class_exists('OxygennaPlugins')) {
    require_once(OXY_PLUGINS_INSTALLER_DIR . 'inc/OxygennaPlugins.php');

    OxygennaPlugins::instance();
}
