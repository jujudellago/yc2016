<?php
/**
 * Creates theme shortcode options
 *
 * @package Omega
 * @subpackage Admin
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.14.0
 */

global $oxy_theme;
if( isset( $oxy_theme ) ) {
    $shortcode_options = include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-options.php';    
    $oxy_theme->register_shortcode_options($shortcode_options);
}