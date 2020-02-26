<?php
/**
 * Boostrap code for typography module
 *
 * @package Omega
 * @subpackage Typography
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.14
 * @author Oxygenna.com
 */


define('OXY_TYPOGRAPHY_DIR', OXY_THEME_DIR . 'vendor/oxygenna/oxygenna-typography/');
define('OXY_TYPOGRAPHY_URI', OXY_THEME_URI . 'vendor/oxygenna/oxygenna-typography/');

if (!class_exists('OxygennaTypography')) {
    require_once(OXY_TYPOGRAPHY_DIR . 'inc/OxygennaTypography.php');
    global $oxy_typography;
    $oxy_typography = OxygennaTypography::instance();
}
