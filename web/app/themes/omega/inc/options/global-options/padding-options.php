<?php
/**
 * Padding element options
 *
 * @package Omega
 * @subpackage Admin
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.14
 */

return array(
    array(
        'name'    => __('Margin Top', 'omega-admin-td'),
        'desc'    => __('Amount of space to add above this element.', 'omega-admin-td'),
        'id'      => 'margin_top',
        'default' => 'short-top',
        'options' => array(
            'no-top'     => __('No Margin (0px)', 'omega-admin-td'),
            'short-top'  => __('Short (24px)', 'omega-admin-td'),
            'medium-top' => __('Medium (48px)', 'omega-admin-td'),
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
            'medium-bottom' => __('Medium (48px)', 'omega-admin-td'),
            'normal-bottom' => __('Normal (72px)', 'omega-admin-td'),
            'tall-bottom'   => __('Tall (96px)', 'omega-admin-td'),
        ),
        'type' => 'select',
    )
);
