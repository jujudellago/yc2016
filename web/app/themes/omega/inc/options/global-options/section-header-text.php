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
 * @version 1.18.14
 */

return array(
    array(
        'name'        => __('Title', 'omega-admin-td'),
        'id'          => 'title',
        'type'        => 'text',
        'default'     => __('Blog', 'omega-admin-td'),
        'desc'        => __('Main Blog Title text', 'omega-admin-td'),
        'admin_label' => true,
    ),
    array(
        'name'    => __('Title Font Size', 'omega-admin-td'),
        'desc'    => __('Choose size of the font to use in your header', 'omega-admin-td'),
        'id'      => 'title_size',
        'type'    => 'select',
        'options' => array(
            'big'       => __('Normal', 'omega-admin-td'),
            'bigger'    => __('Bigger (48px)', 'omega-admin-td'),
            'super'     => __('Super (60px)', 'omega-admin-td'),
            'hyper'     => __('Hyper (96px)', 'omega-admin-td'),
        ),
        'default' => 'normal',
    ),
    array(
        'name'    => __('Title Font Weight', 'omega-admin-td'),
        'desc'    => __('Choose weight of the font to use in the title', 'omega-admin-td'),
        'id'      => 'title_weight',
        'type'    => 'select',
        'options' => array(
            'regular'  => __('Regular', 'omega-admin-td'),
            'black'    => __('Black', 'omega-admin-td'),
            'bold'     => __('Bold', 'omega-admin-td'),
            'light'    => __('Light', 'omega-admin-td'),
            'hairline' => __('Hairline', 'omega-admin-td'),
        ),
        'default' => 'regular',
    ),
    array(
        'name' => __('Title Alignment', 'omega-admin-td'),
        'desc' => __('Align the text shown in the header left, right or center.', 'omega-admin-td'),
        'id'   => 'title_align',
        'type' => 'select',
        'default' => 'center',
        'options' => array(
            'default'   => __('Default alignment', 'omega-admin-td'),
            'center' => __('Center', 'omega-admin-td'),
            'left'   => __('Left', 'omega-admin-td'),
            'right'  => __('Right', 'omega-admin-td'),
            'justify'  => __('Justify', 'omega-admin-td')
        ),
    ),
    array(
        'name'    => __('Title Font Colour', 'omega-admin-td'),
        'desc'    => __('Choose colour of the font to use in your header', 'omega-admin-td'),
        'id'      => 'title_colour',
        'default' => '#FFF',
        'type'    => 'colour'
    ),
    array(
        'name'    => __('Background Header Colour', 'omega-admin-td'),
        'desc'    => __('Choose colour of the background of your header', 'omega-admin-td'),
        'id'      => 'background_title_colour',
        'default' => '#9bd6f3',
        'type'    => 'colour'
    )
);