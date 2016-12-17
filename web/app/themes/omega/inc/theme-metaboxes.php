<?php
/**
 * Creates all theme metaboxes
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

$heading_options = include OXY_THEME_DIR . 'inc/options/global-options/heading-options.php';
$section_options = include OXY_THEME_DIR . 'inc/options/global-options/section-options.php';
$override_header_options = array(
    array(
        'name' => __('Override Default Header', 'omega-admin-td'),
        'desc' => __('Disregard the default settings (in Pages option page) for this page and use custom options for the header', 'omega-admin-td'),
        'id'   => 'override_header',
        'type' => 'select',
        'default' => 'override',
        'options' => array(
            'default'  => __('Use Defaults', 'omega-admin-td'),
            'override' => __('Override Header Options', 'omega-admin-td'),
        ),
    )
);

/*  PAGE HEADER OPTIONS */
$oxy_theme->register_metabox(array(
    'id' => 'override_page_header',
    'title' => __('Header Override', 'omega-admin-td'),
    'priority' => 'high',
    'context' => 'advanced',
    'pages' => array('page', 'oxy_portfolio_image', 'oxy_staff', 'oxy_service'),
    'javascripts' => array(
        array(
            'handle' => 'header_options_script',
            'src'    => OXY_THEME_URI . 'inc/assets/js/metaboxes/header-options.js',
            'deps'   => array('jquery'),
            'localize' => array(
                'object_handle' => 'theme',
                'data'          => THEME_SHORT
            ),
        ),
    ),
    'fields' => $override_header_options
));

/*  PAGE HEADER SHOW / HIDE */
$oxy_theme->register_metabox(array(
    'id' => 'page_header_show',
    'title' => __('Toggle Header', 'omega-admin-td'),
    'priority' => 'high',
    'context' => 'advanced',
    'pages' => array('page', 'oxy_portfolio_image', 'oxy_staff', 'oxy_service'),
    'fields' => array(
        array(
            'name' => __('Show Header', 'omega-admin-td'),
            'desc' => __('Show or hide the header at the top of the page.', 'omega-admin-td'),
            'id'   => 'show_header',
            'type' => 'select',
            'default' => 'show',
            'options' => array(
                'hide' => __('Hide', 'omega-admin-td'),
                'show' => __('Show', 'omega-admin-td'),
            )
        )
    )
));

/*  PAGE HEADER HEADING OPTIONS */
$oxy_theme->register_metabox( array(
    'id' => 'page_header_heading',
    'title' => __('Header Options', 'omega-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'pages' => array('page', 'oxy_portfolio_image', 'oxy_staff', 'oxy_service'),
    'fields' => $heading_options
));

/*  SECTION HEADER HEADING OPTIONS */
$oxy_theme->register_metabox( array(
    'id' => 'page_header_section',
    'title' => __('Header Section Options', 'omega-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'pages' => array('page', 'oxy_portfolio_image', 'oxy_staff', 'oxy_service'),
    'fields' => $section_options
));

// Page sidebar option
$oxy_theme->register_metabox( array(
    'id' => 'page_sidebar_swatch',
    'title' => __('Sidebar Template Options', 'omega-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'pages' => array('page', 'oxy_service'),
    'javascripts' => array(
        array(
            'handle' => 'sidebar_swatch',
            'src'    => OXY_THEME_URI . 'inc/assets/js/metaboxes/sidebar-options.js',
            'deps'   => array( 'jquery'),
        ),
    ),
    'fields' => array(
        array(
            'name'    => __('Page Swatch', 'omega-admin-td'),
            'desc'    => __('Select the colour scheme to use for this page and sidebar.', 'omega-admin-td'),
            'id'      => 'sidebar_page_swatch',
            'type' => 'select',
            'default' => 'swatch-white',
            'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
        ),
    )
));

$oxy_theme->register_metabox( array(
    'id'       => 'page_bullet_nav',
    'title'    => __('Extra Page Options', 'omega-admin-td'),
    'priority' => 'default',
    'context'  => 'advanced',
    'pages'    => array('page'),
    'fields'   => array(
        array(
            'name'    => __('Bullet Navigation', 'omega-admin-td'),
            'id'      => 'bullet_nav',
            'desc'    => __('Display a bullet-style scroll navigation.', 'omega-admin-td'),
            'default' => 'hide',
            'type'    => 'select',
            'options' => array(
                'show'    => __('Show', 'omega-admin-td'),
                'hide'    => __('Hide', 'omega-admin-td'),
            )
        ),
        array(
            'name'    => __('Bullet Show Tooltips', 'omega-admin-td'),
            'id'      => 'bullet_nav_tooltips',
            'desc'    => __('Display the section label when you hover over a bullet.', 'omega-admin-td'),
            'default' => 'off',
            'type'    => 'select',
            'options' => array(
                'on'    => __('Show', 'omega-admin-td'),
                'off'   => __('Hide', 'omega-admin-td'),
            )
        ),
    )
));

/*  PAGE HEADER OPTIONS */
$default_swatches = include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php';
$oxy_theme->register_metabox( array(
    'id' => 'page_site_overrides',
    'title' => __('Site Overrides', 'omega-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'pages' => array('page'),
    'fields' => array(
        array(
            'name'    => __('Show Top Bar', 'omega-admin-td'),
            'desc'    => __('Show or hide the sites top bar (ideal for landing pages).', 'omega-admin-td'),
            'id'      => 'site_top_bar',
            'type' => 'select',
            'default' => 'show',
            'options' => array(
                'show' => __('Show Top Bar', 'omega-admin-td'),
                'hide' => __('Hide Top Bar', 'omega-admin-td'),
            )
        ),
        array(
            'name'    => __('Show Menu', 'omega-admin-td'),
            'desc'    => __('Show or hide the sites top navigation menu (ideal for landing pages).', 'omega-admin-td'),
            'id'      => 'site_top_nav',
            'type' => 'select',
            'default' => 'show',
            'options' => array(
                'show' => __('Show Top Nav', 'omega-admin-td'),
                'hide' => __('Hide Top Nav', 'omega-admin-td'),
            )
        ),
        array(
            'name'    => __('Override Menu Swatch', 'omega-admin-td'),
            'desc'    => __('Override the default site menu swatch (only for this page).', 'omega-admin-td'),
            'id'      => 'site_top_swatch',
            'type' => 'select',
            'default' => '',
            'options' => array_merge( array(
                '' => __('Default Menu Swatch', 'omega-admin-td'),
            ), $default_swatches )
        ),
        array(
            'name'    => __('Override Menu Swatch After Scroll Point', 'omega-admin-td'),
            'desc'    => __('Override the default site menu swatch after it crosses the scroll point (only for this page).', 'omega-admin-td'),
            'id'      => 'site_top_swatch_after_scroll',
            'type' => 'select',
            'default' => '',
            'options' => array_merge( array(
                '' => __('Default Menu After Scroll Swatch', 'omega-admin-td'),
            ), $default_swatches )
        ),
        array(
            'name'    => __('Top Navigation Transparency', 'omega-admin-td'),
            'desc'    => __('Make the sites top navigation transparent', 'omega-admin-td'),
            'id'      => 'site_top_nav_transparency',
            'type' => 'select',
            'default' => 'off',
            'options' => array(
                'on'    => __('On (Transparent)', 'omega-admin-td'),
                'off'   => __('Off (Opaque)', 'omega-admin-td'),
            )
        ),
        array(
            'name'    => __('Override Footer Swatch', 'omega-admin-td'),
            'desc'    => __('Override the default site footer swatch (only for this page).', 'omega-admin-td'),
            'id'      => 'site_footer_swatch',
            'type' => 'select',
            'default' => '',
            'options' => array_merge( array(
                '' => __('Default Footer Swatch', 'omega-admin-td'),
            ), $default_swatches )
        ),
    )
));

/* SWATCH METABOX */
$oxy_theme->register_metabox( array(
    'id'       => 'swatch_colours_metabox',
    'title'    => __('Swatch Colours', 'omega-admin-td'),
    'priority' => 'default',
    'context'  => 'advanced',
    'pages'    => array('oxy_swatch'),
    'fields'   => array(
        array(
            'name'    => __('Text Colour', 'omega-admin-td'),
            'id'      => 'text',
            'desc'    => __('Text colour to use for this swatch.', 'omega-admin-td'),
            'default' => '#4c4c4c',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Heading Colour', 'omega-admin-td'),
            'id'      => 'header',
            'desc'    => __('Colour of all headings in this swatch.', 'omega-admin-td'),
            'default' => '#1c1c1c',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Link Colour', 'omega-admin-td'),
            'id'      => 'link',
            'desc'    => __('Colour of all text links.', 'omega-admin-td'),
            'default' => '#82c9ed',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Link Colour Hover', 'omega-admin-td'),
            'id'      => 'link_hover',
            'desc'    => __('Colour of all text links on hover.', 'omega-admin-td'),
            'default' => '#4f9bc2',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Link Colour Active', 'omega-admin-td'),
            'id'      => 'link_active',
            'desc'    => __('Colour of all text links he moment it is clicked.', 'omega-admin-td'),
            'default' => '#4f9bc2',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Icon Colour', 'omega-admin-td'),
            'id'      => 'icon',
            'desc'    => __('Colour of all icons.', 'omega-admin-td'),
            'default' => '#4c4c4c',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Icon Background Colour', 'omega-admin-td'),
            'id'      => 'icon_background',
            'desc'    => __('Background colour of all icons.', 'omega-admin-td'),
            'default' => '#e9e9e9',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Background Colour', 'omega-admin-td'),
            'id'      => 'background',
            'desc'    => __('Background colour used for this swatch.', 'omega-admin-td'),
            'default' => '#ffffff',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Background Inverse Colour', 'omega-admin-td'),
            'id'      => 'background_inverse',
            'desc'    => __('Colour used to highight elements with a background.', 'omega-admin-td'),
            'default' => '#82c9ed',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Background Colour Complimentary', 'omega-admin-td'),
            'id'      => 'background_complimentary',
            'desc'    => __('Complimentary colour for use in combination with the background colour, e.g. complimentary colour is used in the panel body alongside background colour which is used for the header.', 'omega-admin-td'),
            'default' => '#e9e9e9',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Form Background Colour', 'omega-admin-td'),
            'id'      => 'form_background',
            'desc'    => __('Colour used for background of form elements.', 'omega-admin-td'),
            'default' => '#e9e9e9',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Form Text Colour', 'omega-admin-td'),
            'id'      => 'form_text',
            'desc'    => __('Colour used for text of form elements.', 'omega-admin-td'),
            'default' => '#4c4c4c',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Form Placeholder Colour', 'omega-admin-td'),
            'id'      => 'form_placeholder',
            'desc'    => __('Colour used for placeholder text of form elements.', 'omega-admin-td'),
            'default' => '#8c8c8c',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Form Active Colour', 'omega-admin-td'),
            'id'      => 'form_active',
            'desc'    => __('Colour used for border of an active input element.', 'omega-admin-td'),
            'default' => '#82c9ed',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Primary Button Colour', 'omega-admin-td'),
            'id'      => 'primary_button_background',
            'desc'    => __('Colour used for all primary buttons used in this swatch.', 'omega-admin-td'),
            'default' => '#82c9ed',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Primary Button Text Colour', 'omega-admin-td'),
            'id'      => 'primary_button_text',
            'desc'    => __('Colour used for all primary button text used in this swatch.', 'omega-admin-td'),
            'default' => '#ffffff',
            'type'    => 'colour',
        ),

        array(
            'name'    => __('Primary Button Icon Background Colour', 'omega-admin-td'),
            'id'      => 'primary_button_icon_colour',
            'desc'    => __('Background colour used in primary buttons with icons.', 'omega-admin-td'),
            'default' => '#ffffff',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Primary Button Icon Background Opacity %', 'omega-admin-td'),
            'desc'    => __('Opacity of background colour used in primary buttons with icons.', 'omega-admin-td'),
            'id'      => 'primary_button_icon_alpha',
            'type'    => 'slider',
            'default' => 30,
            'attr'    => array(
                'max'  => 100,
                'min'  => 0,
                'step' => 1
            )
        ),

    )
));
/* COLOUR SET METABOX */
$oxy_theme->register_metabox( array(
    'id'       => 'color_set_metabox',
    'title'    => __('Color Bundle Colors', 'omega-admin-td'),
    'priority' => 'high',
    'context'  => 'advanced',
    'pages'    => array('oxy_color_bundle'),
    'fields'   => array(
        array(
            'name'    => __('Color #1', 'omega-admin-td'),
            'id'      => 'set_color_1',
            'desc'    => __('Color to use for this color bundle.', 'omega-admin-td'),
            'default' => '#4c4c4c',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Enable Color #1', 'omega-admin-td'),
            'id'      => 'status_1',
            'desc'    => __('Turns the color on and off.', 'omega-admin-td'),
            'default' => 'off',
            'type'    => 'radio',
            'options' => array(
                'enable'  => __('Enable', 'omega-admin-td'),
                'disable'  => __('Disable', 'omega-admin-td'),
            ),
            'default' => 'disable',
        ),
        array(
            'name'    => __('Color #2', 'omega-admin-td'),
            'id'      => 'set_color_2',
            'desc'    => __('Color to use for this color bundle.', 'omega-admin-td'),
            'default' => '#4c4c4c',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Enable Color #2', 'omega-admin-td'),
            'id'      => 'status_2',
            'desc'    => __('Turns the color on and off.', 'omega-admin-td'),
            'default' => 'off',
            'type'    => 'radio',
            'options' => array(
                'enable'  => __('Enable', 'omega-admin-td'),
                'disable'  => __('Disable', 'omega-admin-td'),
            ),
            'default' => 'disable',
        ),
        array(
            'name'    => __('Color #3', 'omega-admin-td'),
            'id'      => 'set_color_3',
            'desc'    => __('Color to use for this color bundle.', 'omega-admin-td'),
            'default' => '#4c4c4c',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Enable Color #3', 'omega-admin-td'),
            'id'      => 'status_3',
            'desc'    => __('Turns the color on and off.', 'omega-admin-td'),
            'type'    => 'radio',
            'options' => array(
                'enable'  => __('Enable', 'omega-admin-td'),
                'disable'  => __('Disable', 'omega-admin-td'),
            ),
            'default' => 'disable',
        ),
        array(
            'name'    => __('Color #4', 'omega-admin-td'),
            'id'      => 'set_color_4',
            'desc'    => __('Color to use for this color bundle.', 'omega-admin-td'),
            'default' => '#4c4c4c',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Enable Color #4', 'omega-admin-td'),
            'id'      => 'status_4',
            'desc'    => __('Turns the color on and off.', 'omega-admin-td'),
            'type'    => 'radio',
            'options' => array(
                'enable'  => __('Enable', 'omega-admin-td'),
                'disable'  => __('Disable', 'omega-admin-td'),
            ),
            'default' => 'disable',
        ),
        array(
            'name'    => __('Color #5', 'omega-admin-td'),
            'id'      => 'set_color_5',
            'desc'    => __('Color to use for this color bundle.', 'omega-admin-td'),
            'default' => '#4c4c4c',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Enable Color #5', 'omega-admin-td'),
            'id'      => 'status_5',
            'desc'    => __('Turns the color on and off.', 'omega-admin-td'),
            'type'    => 'radio',
            'options' => array(
                'enable'  => __('Enable', 'omega-admin-td'),
                'disable'  => __('Disable', 'omega-admin-td'),
            ),
            'default' => 'disable',
        ),
        array(
            'name'    => __('Color #6', 'omega-admin-td'),
            'id'      => 'set_color_6',
            'desc'    => __('Color to use for this color bundle.', 'omega-admin-td'),
            'default' => '#4c4c4c',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Enable Color #6', 'omega-admin-td'),
            'id'      => 'status_6',
            'desc'    => __('Turns the color on and off.', 'omega-admin-td'),
            'type'    => 'radio',
            'options' => array(
                'enable'  => __('Enable', 'omega-admin-td'),
                'disable'  => __('Disable', 'omega-admin-td'),
            ),
            'default' => 'disable',
        ),
        array(
            'name'    => __('Color #7', 'omega-admin-td'),
            'id'      => 'set_color_7',
            'desc'    => __('Color to use for this color bundle.', 'omega-admin-td'),
            'default' => '#4c4c4c',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Enable Color #7', 'omega-admin-td'),
            'id'      => 'status_7',
            'desc'    => __('Turns the color on and off.', 'omega-admin-td'),
            'type'    => 'radio',
            'options' => array(
                'enable'  => __('Enable', 'omega-admin-td'),
                'disable'  => __('Disable', 'omega-admin-td'),
            ),
            'default' => 'disable',
        ),
        array(
            'name'    => __('Color #8', 'omega-admin-td'),
            'id'      => 'set_color_8',
            'desc'    => __('Color to use for this color bundle.', 'omega-admin-td'),
            'default' => '#4c4c4c',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Enable Color #8', 'omega-admin-td'),
            'id'      => 'status_8',
            'desc'    => __('Turns the color on and off.', 'omega-admin-td'),
            'type'    => 'radio',
            'options' => array(
                'enable'  => __('Enable', 'omega-admin-td'),
                'disable'  => __('Disable', 'omega-admin-td'),
            ),
            'default' => 'disable',
        ),
        array(
            'name'    => __('Color #9', 'omega-admin-td'),
            'id'      => 'set_color_9',
            'desc'    => __('Color to use for this color bundle.', 'omega-admin-td'),
            'default' => '#4c4c4c',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Enable Color #9', 'omega-admin-td'),
            'id'      => 'status_9',
            'desc'    => __('Turns the color on and off.', 'omega-admin-td'),
            'type'    => 'radio',
            'options' => array(
                'enable'  => __('Enable', 'omega-admin-td'),
                'disable'  => __('Disable', 'omega-admin-td'),
            ),
            'default' => 'disable',
        ),
        array(
            'name'    => __('Color #10', 'omega-admin-td'),
            'id'      => 'set_color_10',
            'desc'    => __('Color to use for this color bundle.', 'omega-admin-td'),
            'default' => '#4c4c4c',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Enable Color #10', 'omega-admin-td'),
            'id'      => 'status_10',
            'desc'    => __('Turns the color on and off.', 'omega-admin-td'),
            'type'    => 'radio',
            'options' => array(
                'enable'  => __('Enable', 'omega-admin-td'),
                'disable'  => __('Disable', 'omega-admin-td'),
            ),
            'default' => 'disable',
        ),
    )
));

$oxy_theme->register_metabox( array(
    'id'    => 'portfolio_type_metabox',
    'title' => __('Portfolio Post Type', 'omega-admin-td'),
    'priority' => 'high',
    'context'  => 'advanced',
    'pages'    => array( 'oxy_portfolio_image' ),
    'javascripts' => array(
        array(
            'handle' => 'portfolio_post_type',
            'src'    => OXY_THEME_URI . 'inc/assets/js/metaboxes/portfolio-post-type.js',
            'deps'   => array( 'jquery'),
            'localize' => array(
                'object_handle' => 'theme',
                'data'          => THEME_SHORT
            ),
        ),
    ),
    'fields'  => array(
        array(
            'name' => __('Post Type', 'omega-admin-td'),
            'desc' => __('Select what type of portfolio post this will be.', 'omega-admin-td'),
            'id'   => 'post_type',
            'type' => 'select',
            'options' => array(
                'standard' => __('Standard Post', 'omega-admin-td'),
                'video'    => __('Video Post', 'omega-admin-td'),
                'gallery'  => __('Gallery Post', 'omega-admin-td'),
            ),
            'default' => 'standard',
        ),
        array(
            'name'     => __('Popup Video Link', 'omega-admin-td'),
            'desc'     => __('Enter a youtube, vimeo or custom link to a video here.  This will appear in the items &quot;view larger&quot; popup.', 'omega-admin-td'),
            'id'       => 'post_video_link',
            'type'     => 'text',
            'default' =>  '',
        ),
        array(
            'name'     => __('Popup Gallery', 'omega-admin-td'),
            'desc'     => __('Create a gallery in the editor below (click add media -> create gallery).  This will appear in the items &quot;view larger&quot; popup.', 'omega-admin-td'),
            'id'       => 'post_gallery',
            'type'     => 'editor',
            'default' =>  '',
        ),
    ),
));

// swatch status metabox
$oxy_theme->register_metabox( array(
    'id'       => 'swatch_status_metabox',
    'title'    => __('Swatch Status', 'omega-admin-td'),
    'priority' => 'default',
    'context'  => 'side',
    'pages'    => array('oxy_swatch'),
    'fields'   => array(
        array(
            'name'    => __('Swatch Status', 'omega-admin-td'),
            'id'      => 'status',
            'desc'    => __('Turns the swatch on and off.', 'omega-admin-td'),
            'default' => 'active',
            'type'    => 'select',
            'options' => array(
                'enabled' => __('Enabled', 'omega-admin-td'),
                'disabled' => __('Disabled', 'omega-admin-td'),
            )
        ),
    )
));

$link_options = array(
    'id'    => 'link_metabox',
    'title' => __('Link', 'omega-admin-td'),
    'priority' => 'default',
    'context'  => 'advanced',
    'pages'    => array('oxy_service', 'oxy_staff', 'oxy_portfolio_image', 'oxy_testimonial'),
    'javascripts' => array(
        array(
            'handle' => 'slider_links_options_script',
            'src'    => OXY_THEME_URI . 'inc/assets/js/metaboxes/slider-links-options.js',
            'deps'   => array( 'jquery'),
            'localize' => array(
                'object_handle' => 'theme',
                'data'          => THEME_SHORT
            ),
        ),
    ),
    'fields'  => array(
        array(
            'name' => __('Link Type', 'omega-admin-td'),
            'desc' => __('Make this post link to something. Default link will link to the single item page.', 'omega-admin-td'),
            'id'   => 'link_type',
            'type' => 'select',
            'options' => array(
                'default'   => __('Default Link', 'omega-admin-td'),
                'page'      => __('Page', 'omega-admin-td'),
                'post'      => __('Post', 'omega-admin-td'),
                'portfolio' => __('Portfolio', 'omega-admin-td'),
                'category'  => __('Category', 'omega-admin-td'),
                'url'       => __('URL', 'omega-admin-td'),
                'no-link'   => __('No Link', 'omega-admin-td')
            ),
            'default' => 'default',
        ),
        array(
            'name'     => __('Page Link', 'omega-admin-td'),
            'desc'     => __('Choose a page to link this item to', 'omega-admin-td'),
            'id'       => 'page_link',
            'type'     => 'select',
            'options'  => 'taxonomy',
            'taxonomy' => 'pages',
            'default' =>  '',
        ),
        array(
            'name'     => __('Post Link', 'omega-admin-td'),
            'desc'     => __('Choose a post to link this item to', 'omega-admin-td'),
            'id'       => 'post_link',
            'type'     => 'select',
            'options'  => 'taxonomy',
            'taxonomy' => 'posts',
            'default' =>  '',
        ),
        array(
            'name'     => __('Portfolio Link', 'omega-admin-td'),
            'desc'     => __('Choose a portfolio item to link this item to', 'omega-admin-td'),
            'id'       => 'portfolio_link',
            'type'     => 'select',
            'options'  => 'taxonomy',
            'taxonomy' => 'oxy_portfolio_image',
            'default' =>  '',
        ),
        array(
            'name'     => __('Category Link', 'omega-admin-td'),
            'desc'     => __('Choose a category list to link this item to', 'omega-admin-td'),
            'id'       => 'category_link',
            'type'     => 'select',
            'options'  => 'categories',
            'default' =>  '',
        ),
        array(
            'name'    => __('URL Link', 'omega-admin-td'),
            'desc'     => __('Choose a URL to link this item to', 'omega-admin-td'),
            'id'      => 'url_link',
            'type'    => 'text',
            'default' =>  '',
        ),
        array(
            'name'    => __('Open Link In', 'omega-admin-td'),
            'id'      => 'target',
            'type'    => 'select',
            'default' => '_self',
            'options' => array(
                '_self'   => __('Same page as it was clicked ', 'omega-admin-td'),
                '_blank'  => __('Open in new window/tab', 'omega-admin-td'),
                '_parent' => __('Open the linked document in the parent frameset', 'omega-admin-td'),
                '_top'    => __('Open the linked document in the full body of the window', 'omega-admin-td')
            ),
            'desc'    => __('Where the link will open.', 'omega-admin-td'),
        ),
    ),
);

$oxy_theme->register_metabox( $link_options );

// modify link options metabox for slideshow image before registering
$link_options['fields'][0]['default'] = 'no-link';
$link_options['pages'] = array('oxy_slideshow_image');
$link_options['id'] = 'slide_link_metabox';
$link_options['fields'][6]['options']['magnific'] = __('Open in magnific popup', 'omega-admin-td');

$oxy_theme->register_metabox( $link_options );


$oxy_theme->register_metabox( array(
    'id' => 'Citation',
    'title' => __('Citation', 'omega-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'pages' => array('oxy_testimonial'),
    'fields' => array(
        array(
            'name'    => __('Citation', 'omega-admin-td'),
            'desc'    => __('Reference to the source of the quote', 'omega-admin-td'),
            'id'      => 'citation',
            'type'    => 'text',
        ),
    )
));
$oxy_theme->register_metabox( array(
    'id' => 'services_icon_metabox',
    'title' => __('Service Image & Icon', 'omega-admin-td'),
    'priority' => 'core',
    'context' => 'advanced',
    'pages' => array('oxy_service'),
    'fields' => array(
        array(
            'name'    => __('Font Awesome Icon', 'omega-admin-td'),
            'desc'    => __('Select a font awesome icon that will appear in your service shape.', 'omega-admin-td'),
            'id'      => 'fa_icon',
            'type'    => 'select',
            'options' => include OXY_THEME_DIR . 'inc/options/global-options/fontawesome.php',
            'default' => ''
        ),
        array(
            'name'      => __('SVG Icon', 'omega-admin-td'),
            'desc'      => __('Select a svg icon that will appear in your service shape.', 'omega-admin-td'),
            'id'        => 'svg_icon',
            'type'    => 'select',
            'options' => include OXY_THEME_DIR . 'inc/options/global-options/svgs.php',
            'default' => '',
        ),
    )
));

$oxy_theme->register_metabox( array(
    'id' => 'staff_info',
    'title' => __('Personal Details', 'omega-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'pages' => array('oxy_staff'),
    'fields' => array(
        array(
            'name'    => __('Job Title', 'omega-admin-td'),
            'desc'    => __('Sub header that is shown below the staff members name.', 'omega-admin-td'),
            'id'      => 'position',
            'type'    => 'text',
        ),
    )
));

$staff_social = array();
for( $i = 0 ; $i < 5 ; $i++ ) {
    $staff_social[] =
        array(
            'name' => __('Social Icon', 'omega-admin-td') . ' ' . ($i+1),
            'desc' => __('Social Network Icon to show for this Staff Member', 'omega-admin-td'),
            'id'   => 'icon' . $i,
            'type' => 'select',
            'options' => 'icons',
        );
    $staff_social[] =
        array(
            'name'  => __('Social Link', 'omega-admin-td'). ' ' . ($i+1),
            'desc' => __('Add the url to the staff members social network here.', 'omega-admin-td'),
            'id'    => 'link' . $i,
            'type'  => 'text',
            'std'   => '',
        );
}

$oxy_theme->register_metabox( array(
    'id' => 'staff_social',
    'title' => __('Social', 'omega-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'pages' => array('oxy_staff'),
    'fields' => $staff_social,
));

$oxy_theme->register_metabox( array(
    'id' => 'portfolio_masonry_metabox',
    'title' => __('Portfolio Masonry Options', 'omega-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'pages' => array('oxy_portfolio_image'),
    'fields' => array(
        array(
            'name'    => __('Masonry Image Width ', 'omega-admin-td'),
            'desc'    => __('Select the width that the masonry portfolio shortcode will use for this item (normal 1 column wide 2 columns)', 'omega-admin-td'),
            'id'      => 'masonry_width',
            'type'    => 'select',
            'options' => array(
                'normal'    => __('Normal', 'omega-admin-td'),
                'wide'   => __('Wide', 'omega-admin-td'),
            ),
            'default' => 'normal',
        ),
    )
));

$oxy_theme->register_metabox( array(
    'id'       => 'service_template_metabox',
    'title'    => __('Service Template', 'omega-admin-td'),
    'priority' => 'default',
    'context'  => 'advanced',
    'pages'    => array('oxy_service'),
    'fields'   => array(
        array(
            'name'    => __('Service Page Template', 'omega-admin-td'),
            'id'      => 'template',
            'desc'    => __('Select a page template to use for this service', 'omega-admin-td'),
            'type'    => 'select',
            'options' => array(
                'page.php'                  => __('Full Width', 'omega-admin-td'),
                'template-leftsidebar.php'  => __('Left Sidebar', 'omega-admin-td'),
                'template-rightsidebar.php' => __('Right Sidebar', 'omega-admin-td'),
            ),
            'default' => 'page.php',
        ),
    )
));

$oxy_theme->register_metabox( array(
    'id'       => 'post_masonry_options',
    'title'    => __('Post Masonry', 'omega-admin-td'),
    'priority' => 'default',
    'context'  => 'advanced',
    'pages'    => array('post'),
    'fields'   => array(
        array(
            'name'    => __('Masonry Image', 'omega-admin-td'),
            'id'      => 'masonry_image',
            'desc'    => __('An image that will be used for this post in the masonry list view.', 'omega-admin-td'),
            'store'   => 'url',
            'type'    => 'upload',
            'default' => '',
        ),
        array(
            'name'    => __('Masonry Image Width ', 'omega-admin-td'),
            'desc'    => __('Select the width that the masonry portfolio shortcode will use for this item (normal 1 column wide 2 columns)', 'omega-admin-td'),
            'id'      => 'masonry_width',
            'type'    => 'select',
            'options' => array(
                'normal' => __('Normal', 'omega-admin-td'),
                'wide'   => __('Wide', 'omega-admin-td'),
            ),
            'default' => 'normal',
        ),
    )
));


$product_category_options = array(
    array(
        'name'    => __('Product Columns', 'omega-admin-td'),
        'desc'    => __('Number of columns to use for products on this page.', 'omega-admin-td'),
        'id'      => 'product_columns',
        'type'    => 'select',
        'default' => 3,
        'options'    => array(
            '2'  => __('2 Columns', 'omega-admin-td'),
            '3'  => __('3 Columns', 'omega-admin-td'),
            '4'  => __('4 Columns', 'omega-admin-td'),
            '5'  => __('5 Columns', 'omega-admin-td')
        )
    ),
);

$oxy_theme->register_metabox( array(
    'id' => 'category_header',
    'title' => __('Category Header Type', 'omega-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'taxonomies' => array('product_cat'),
    'fields' => array_merge( $product_category_options, $override_header_options, $heading_options, $section_options )
));

$oxy_theme->register_metabox( array(
    'id' => 'tag_header',
    'title' => __('Product Tag Header Type', 'omega-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'taxonomies' => array('product_tag'),
    'fields' => array_merge( $product_category_options, $override_header_options, $heading_options, $section_options )
));

$oxy_theme->register_metabox(array(
    'id' => 'post_modal_options',
    'title' => __('Modal Options', 'omega-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'pages' => array('oxy_modal'),
    'fields' => array(
        array(
            'name' => __('Fade Modal', 'omega-admin-td'),
            'desc' => __('Apply a CSS fade transition to the modal.', 'omega-admin-td'),
            'id'   => 'fade_modal',
            'type' => 'select',
            'default' => 'fade',
            'options' => array(
                'fade'    => __('On', 'omega-admin-td'),
                'no-fade' => __('Off', 'omega-admin-td'),
            )
        ),
        array(
            'name' => __('Modal Size', 'omega-admin-td'),
            'desc' => __('Modal size can be large, normal or small.', 'omega-admin-td'),
            'id'   => 'modal_size',
            'type' => 'select',
            'options' => array(
                'modal-lg' => __('Large Modal', 'omega-admin-td'),
                'modal-nm' => __('Normal Modal', 'omega-admin-td'),
                'modal-sm' => __('Small Modal', 'omega-admin-td'),
            ),
            'default' => 'modal-nm',
        ),
    )
));
