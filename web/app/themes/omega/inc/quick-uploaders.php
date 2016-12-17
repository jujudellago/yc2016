<?php
/**
 * Stores options for themes quick uploaders
 *
 * @package Omega
 * @subpackage Admin
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.14.0
 */

return array(
    // slideshoe quick upload
    'oxy_slideshow_image' => array(
        'menu_title' => __('Quick Slideshow', 'omega-admin-td'),
        'page_title' => __('Quick Slideshow Creator', 'omega-admin-td'),
        'item_singular'  => __('Slideshow Image', 'omega-admin-td'),
        'item_plural'  => __('Slideshow Images', 'omega-admin-td'),
        'taxonomies' => array(
            'oxy_slideshow_categories'
        )
    ),
    // services quick upload
    'oxy_service' => array(
        'menu_title' => __('Quick Services', 'omega-admin-td'),
        'page_title' => __('Quick Services Creator', 'omega-admin-td'),
        'item_singular'  => __('Services', 'omega-admin-td'),
        'item_plural'  => __('Service', 'omega-admin-td'),
        'show_editor' => true,
    ),
    // portfolio quick upload
    'oxy_portfolio_image' => array(
        'menu_title' => __('Quick Portfolio', 'omega-admin-td'),
        'page_title' => __('Quick Portfolio Creator', 'omega-admin-td'),
        'item_singular'  => __('Portfolio Image', 'omega-admin-td'),
        'item_plural'  => __('Portfolio Images', 'omega-admin-td'),
        'show_editor' => true,
        'taxonomies' => array(
            'oxy_portfolio_categories'
        )
    ),
    // staff quick upload
    'oxy_staff' => array(
        'menu_title' => __('Quick Staff', 'omega-admin-td'),
        'page_title' => __('Quick Staff Creator', 'omega-admin-td'),
        'item_singular'  => __('Staff Member', 'omega-admin-td'),
        'item_plural'  => __('Staff', 'omega-admin-td'),
        'show_editor' => true,
        'taxonomies' => array(
            'oxy_staff_skills'
        )
    )
);