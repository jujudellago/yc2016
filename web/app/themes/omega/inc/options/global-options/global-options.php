<?php
/**
 * Themes shortcode options go here
 *
 * @package Omega
 * @subpackage Core
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.18.12
 */
$animation_options = include OXY_THEME_DIR . 'inc/options/global-options/animation-options.php';
$padding_options = include OXY_THEME_DIR . 'inc/options/global-options/padding-options.php';

$extra_classes = array(
    array(
        'name'    => __('Extra Classes', 'omega-admin-td'),
        'desc'    => __('Add any extra classes you need to add to this element. ( space separated )', 'omega-admin-td'),
        'id'      => 'extra_classes',
        'default'     =>  '',
        'type'        => 'text',
    )
);

return array_merge( $padding_options, $animation_options, $extra_classes );