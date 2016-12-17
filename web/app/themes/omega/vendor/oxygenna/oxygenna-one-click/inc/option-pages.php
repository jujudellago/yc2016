<?php
/**
 * Once Click Installer Option Pages
 *
 * @package Omega
 * @subpackage Admin
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.14.0
 * @author Oxygenna.com
 */

global $oxy_theme;
$installer_throttle = $oxy_theme->get_option('one_click_throttle', false);
$installer_throttle = false === $installer_throttle ? 2 : $installer_throttle;
$installer_throttle *= 1000;

$oxy_theme->register_option_page(array(
    'page_title' => __('Demo Content', 'omega-admin-td'),
    'menu_title' => __('Demo Content', 'omega-admin-td'),
    'slug'       => THEME_SHORT . '-oneclick',
    'main_menu'  => false,
    'icon'       => 'tools',
    'stylesheets' => array(
        array(
            'handle' => 'one_click_installer',
            'src'    => OXY_ONECLICK_URI . 'assets/stylesheets/one-click-installer.css',
            'deps'   => array('oxy-option-page'),
        ),
    ),
    'javascripts' => array(
        array(
            'handle' => 'one_click_installer',
            'src'    => OXY_ONECLICK_URI . 'assets/javascripts/install.js',
            'deps'   => array( 'jquery', 'jquery-ui-progressbar', 'jquery-ui-dialog' ),
            'localize' => array(
                'object_handle' => 'importInfo',
                'data'          => array(
                    'installThrottle' =>  $installer_throttle,
                    'ajaxURL'         => admin_url('admin-ajax.php'),
                    'importNonce'     => wp_create_nonce('oxy-importer'),
                    'themePackages'   => array_reverse(apply_filters('oxy_one_click_import_packages', array()))
                )
            ),
        ),
        array(
            'handle' => 'one_click_installer_checklist',
            'src'    => OXY_ONECLICK_URI . 'assets/javascripts/checklist.js',
            'deps'   => array('jquery'),
        ),
        array(
            'handle' => 'one_click_installer_packages',
            'src'    => OXY_ONECLICK_URI . 'assets/javascripts/packages.js',
            'deps'   => array('jquery'),
        ),
        array(
            'handle' => 'one_click_installer_complete',
            'src'    => OXY_ONECLICK_URI . 'assets/javascripts/complete.js',
            'deps'   => array('jquery'),
        ),
    ),
    'sections'   => array(
        'oneclick-setup' => array(
            'title'   => __('OneClick Installer', 'omega-admin-td'),
            'header'  => __('Make my site just like the demo site!', 'omega-admin-td'),
            'fields' => array(
                array(
                    'name'        => __('Install Demo Site Content', 'omega-admin-td'),
                    'button-text' => __('Make Me Beautiful', 'omega-admin-td'),
                    'desc'        => __('This button will setup your site to look just like the demo site.', 'omega-admin-td'),
                    'id'          => 'oneclick_setup',
                    'attr'        => array(
                        'class'   => 'one-click'
                    ),
                    'type'        => 'button',
                ),
            )
        )
    )
));
