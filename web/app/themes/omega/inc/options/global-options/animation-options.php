<?php
    /**
     * Options for on scroll animations
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
        'name'        => __('Scroll Animation', 'omega-admin-td'),
        'desc'        => __('Animation that will occur when the user scrolls onto the element.', 'omega-admin-td'),
        'id'          => 'scroll_animation',
        'type'        => 'select',
        'default'     => 'none',
        'options'     => include OXY_THEME_DIR . 'inc/options/global-options/animations.php',
    ),
    array(
        'name'    => __('Animation Delay', 'omega-admin-td'),
        'desc'    => __('Delay after scrolling onto the element before animation starts.', 'omega-admin-td'),
        'id'      => 'scroll_animation_delay',
        'type'    => 'slider',
        'default' => '0',
        'attr'    => array(
            'max'  => 4,
            'min'  => 0,
            'step' => 0.1
        )
    )
);
