<?php
/**
 * Main mega menu class
 *
 * @package Omega
 * @subpackage Admin
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.14
 * @author Oxygenna.com
 */

define('OXY_MEGA_MENU_DIR', OXY_THEME_DIR . 'vendor/oxygenna/oxygenna-mega-menu/');
define('OXY_MEGA_MENU_URI', OXY_THEME_URI . 'vendor/oxygenna/oxygenna-mega-menu/');

if (!class_exists('OxygennaMegaMenu')) {

    require_once(OXY_MEGA_MENU_DIR . 'inc/OxygennaMegaMenu.php');
    require_once(OXY_MEGA_MENU_DIR . 'walkers/FrontendBootstrapMegaMenuWalker.php');

    OxygennaMegaMenu::instance();
}
