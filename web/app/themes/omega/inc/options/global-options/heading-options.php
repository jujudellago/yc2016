<?php
/**
 * Heading options
 *
 * @package Omega
 * @subpackage Admin
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.12
 */
return array(
     array(
        'name'        => __('Header Text', 'omega-admin-td'),
        'id'          => 'content',
        'type'        => 'text',
        'default'     => '',
        'desc'        => __('Text that will be used for the header.', 'omega-admin-td'),
        'admin_label' => true,
    ),
    array(
        'name'        => __('Sub Header Text', 'omega-admin-td'),
        'id'          => 'sub_header',
        'type'        => 'text',
        'default'     => '',
        'desc'        => __('Text that will be used below the main header.', 'omega-admin-td'),
        'admin_label' => true,
    ),
    array(
        'name'    => __('Header Type', 'omega-admin-td'),
        'desc'    => __('Choose the type of header you want to use', 'omega-admin-td'),
        'id'      => 'header_type',
        'type'    => 'select',
        'options' => array(
            'h1'      => __('h1', 'omega-admin-td'),
            'h2'      => __('h2', 'omega-admin-td'),
            'h3'      => __('h3', 'omega-admin-td'),
            'h4'      => __('h4', 'omega-admin-td'),
            'h5'      => __('h5', 'omega-admin-td'),
            'h6'      => __('h6', 'omega-admin-td')
        ),
        'default' => 'h1',
    ),
    array(
        'name'    => __('Override section swatch', 'PLUGIN_TD'),
        'desc'    => __('Set to On to override the swatch of the section', 'PLUGIN_TD'),
        'id'      => 'section_swatch_override',
        'type'    => 'select',
        'default' => 'off',
        'options' => array(
            'on'    => __('On', 'PLUGIN_TD'),
            'off'   => __('Off', 'PLUGIN_TD'),
        )
    ),
    array(
        'name'      => __('Heading Color', 'omega-admin-td'),
        'desc'      => __('Set the color of the heading', 'omega-admin-td'),
        'id'        => 'heading_colour',
        'type'      => 'colour',
        'default'   => '#000000'
    ),
    array(
        'name'    => __('Sub Header Font Size', 'omega-admin-td'),
        'desc'    => __('Choose size of the font to use in your sub header', 'omega-admin-td'),
        'id'      => 'sub_header_size',
        'type'    => 'select',
        'options' => array(
            'normal' => __('Normal Paragraph', 'omega-admin-td'),
            'lead'   => __('Lead Paragraph', 'omega-admin-td'),
        ),
        'default' => 'normal',
    ),
    array(
        'name'    => __('Header Font Size', 'omega-admin-td'),
        'desc'    => __('Choose size of the font to use in your header', 'omega-admin-td'),
        'id'      => 'header_size',
        'type'    => 'select',
        'options' => array(
            'normal' => __('Normal', 'omega-admin-td'),
            'big'    => __('Big (36px)', 'omega-admin-td'),
            'bigger' => __('Bigger (48px)', 'omega-admin-td'),
            'super'  => __('Super (60px)', 'omega-admin-td'),
            'hyper'  => __('Hyper (96px)', 'omega-admin-td'),
        ),
        'default' => 'normal',
    ),
    array(
        'name'    => __('Header Font Weight', 'omega-admin-td'),
        'desc'    => __('Choose weight of the font to use in the header', 'omega-admin-td'),
        'id'      => 'header_weight',
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
        'name' => __('Header Alignment', 'omega-admin-td'),
        'desc' => __('Align the text shown in the header left, right or center.', 'omega-admin-td'),
        'id'   => 'header_align',
        'type' => 'select',
        'default' => 'left',
        'options' => array(
            'default'   => __('Default alignment', 'omega-admin-td'),
            'left'   => __('Left', 'omega-admin-td'),
            'center' => __('Center', 'omega-admin-td'),
            'right'  => __('Right', 'omega-admin-td'),
            'justify'  => __('Justify', 'omega-admin-td')
        )
    ),
    array(
        'name'    => __('Header Condensed', 'omega-admin-td'),
        'desc'    => __('Adds padding to the sides of the heading creating a more condensed effect.', 'omega-admin-td'),
        'id'      => 'header_condensed',
        'default' => 'not-condensed',
        'type' => 'select',
        'options' => array(
            'not-condensed' => __('Not Condensed', 'omega-admin-td'),
            'condensed'     => __('Condensed', 'omega-admin-td'),
        )
    ),
    array(
        'name'    => __('Header Underline', 'omega-admin-td'),
        'desc'    => __('Adds an underline effect below the header.', 'omega-admin-td'),
        'id'      => 'header_underline',
        'default' => 'no-bordered-header',
        'type'    => 'select',
        'options' => array(
            'no-bordered-header' => __('Hide', 'omega-admin-td'),
            'bordered' => __('Show', 'omega-admin-td'),
        )
    ),
    array(
        'name'    => __('Underline Size', 'omega-admin-td'),
        'desc'    => __('Size of the underline.', 'omega-admin-td'),
        'id'      => 'header_underline_size',
        'default' => 'bordered-normal',
        'type'    => 'select',
        'options' => array(
            'bordered-normal' => __('Normal (72px)', 'omega-admin-td'),
            'bordered-small' => __('Small (48px)', 'omega-admin-td'),
        )
    ),
    array(
        'name'    => __('Fade out when leaving page', 'omega-admin-td'),
        'desc'    => __('Fades the heading out when the heading leaves the page.', 'omega-admin-td'),
        'id'      => 'header_fade_out',
        'default' => 'off',
        'type'    => 'select',
        'options' => array(
            'off' => __('Off', 'omega-admin-td'),
            'on'  => __('On', 'omega-admin-td'),
        )
    ),
    array(
        'name'        => __('Extra Classes', 'omega-admin-td'),
        'id'          => 'extra_classes',
        'type'        => 'text',
        'default'     => '',
        'desc'        => __('Space separated extra classes to add to the heading.', 'omega-admin-td'),
    ),
    array(
        'name'    => __('Margin Top', 'omega-admin-td'),
        'desc'    => __('Amount of space to add above this element.', 'omega-admin-td'),
        'id'      => 'margin_top',
        'default' => 'short-top',
        'options' => array(
            'no-top'     => __('No Margin (0px)', 'omega-admin-td'),
            'short-top'  => __('Short (24px)', 'omega-admin-td'),
            'medium-top'  => __('Medium (48px)', 'omega-admin-td'),
            'normal-top' => __('Normal (72px)', 'omega-admin-td'),
            'tall-top'   => __('Tall (96px)', 'omega-admin-td'),
        ),
        'type' => 'select',
    ),
    array(
        'name'    => __('Margin Bottom', 'omega-admin-td'),
        'desc'    => __('Amount of space to add below this element.', 'omega-admin-td'),
        'id'      => 'margin_bottom',
        'default' => 'short-bottom',
        'options' => array(
            'no-bottom'     => __('No Margin (0px)', 'omega-admin-td'),
            'short-bottom'  => __('Short (24px)', 'omega-admin-td'),
            'medium-bottom'  => __('Medium (48px)', 'omega-admin-td'),
            'normal-bottom' => __('Normal (72px)', 'omega-admin-td'),
            'tall-bottom'   => __('Tall (96px)', 'omega-admin-td'),
        ),
        'type' => 'select',
    ),

);