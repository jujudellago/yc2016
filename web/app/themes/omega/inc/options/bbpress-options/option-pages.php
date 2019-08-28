<?php
/**
 * Options for BBPres
 *
 * @package Omega
 * @subpackage Admin
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.12
 */

$bbpress_header_options = include OXY_THEME_DIR . 'inc/options/global-options/heading-options.php';
$bbpress_header_section_options = include OXY_THEME_DIR . 'inc/options/global-options/section-options.php';

// remove header text and subtitle
unset($bbpress_header_options[0]);
unset($bbpress_header_options[1]);

// set defaults for blog heading and section
// set default heading to my blog
$bbpress_header_options[4]['default'] = 'super';
$bbpress_header_options[5]['default'] = 'light';
$bbpress_header_options[11]['default'] = 'medium-top';
$bbpress_header_options[12]['default'] = 'medium-bottom';
// set default swatch to blue
$bbpress_header_section_options[0]['default'] = 'swatch-blue';


global $oxy_theme;
$oxy_theme->register_option_page(array(
    'menu_title' => __('BBPress', 'omega-admin-td'),
    'page_title' => __('BBPress Theme Settings', 'omega-admin-td'),
    'slug'       => THEME_SHORT . '-bbpress',
    'main_menu'  => false,
    'icon'       => 'tools',
    'sections'   => array(
        'bbpress-general' => array(
            'title'   => __('General BBPress Options', 'omega-admin-td'),
            'header'  => __('', 'omega-admin-td'),
            'fields' => array(
                array(
                    'name'    => __('BBPress Page Style', 'omega-admin-td'),
                    'desc'    => __('Select a layout style to use for your blog pages.', 'omega-admin-td'),
                    'id'      => 'bbpress_style',
                    'type'    => 'imgradio',
                    'columns' => '5',
                    'options' => array(
                        'right' => array(
                            'name' => __('Right Sidebar', 'omega-admin-td'),
                            'image' => OXY_THEME_URI . 'inc/assets/images/blog-rightsidebar.png',
                        ),
                        'left' => array(
                            'name' => __('Left Sidebar', 'omega-admin-td'),
                            'image' => OXY_THEME_URI . 'inc/assets/images/blog-leftsidebar.png',
                        ),
                        'fullwidth' => array(
                            'name' => __('Full Width', 'omega-admin-td'),
                            'image' => OXY_THEME_URI . 'inc/assets/images/blog-wide.png',
                        ),
                    ),
                    'default' => 'right',
                ),
                array(
                    'name'    => __('BBPres Swatch', 'omega-admin-td'),
                    'desc'    => __('Choose a color swatch for the BBPress pages', 'omega-admin-td'),
                    'id'      => 'bbpress_swatch',
                    'type'    => 'select',
                    'default' => 'swatch-white',
                    'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                ),
            )
        ),
        'bbpress-header-text' => array(
            'title'   => __('BBPress Header Titles', 'omega-admin-td'),
            'header'  => __('Change the text for some of your BBPress page headings.', 'omega-admin-td'),
            'fields'  => array(
                array(
                    'name' => __('Forums Title', 'omega-admin-td'),
                    'desc' => __('Title that is shown on the main forums archive page.', 'omega-admin-td'),
                    'id'   => 'bbpress_header_forums',
                    'type' => 'text',
                    'default' => __('Forums', 'omega-admin-td')
                ),
                array(
                    'name' => __('Topics Title', 'omega-admin-td'),
                    'desc' => __('Title that is shown on the main topics archive page.', 'omega-admin-td'),
                    'id'   => 'bbpress_header_topics',
                    'type' => 'text',
                    'default' => __('Topics', 'omega-admin-td')
                )
            )
        ),
        'bbpress-header-options' => array(
            'title'   => __('BBPress Header Options', 'omega-admin-td'),
            'header'  => __('Change how your BBPress headers look.', 'omega-admin-td'),
            'fields'  => array_merge(
                array(
                    array(
                        'name' => __('Show Header', 'omega-admin-td'),
                        'desc' => __('Show or hide the header at the top of the page.', 'omega-admin-td'),
                        'id'   => 'bbpress_header_show_header',
                        'type' => 'select',
                        'default' => 'show',
                        'options' => array(
                            'hide' => __('Hide', 'omega-admin-td'),
                            'show' => __('Show', 'omega-admin-td'),
                        ),
                    )
                ),
                array(
                    array(
                        'name' => __('Show Breadcrumbs', 'omega-admin-td'),
                        'desc' => __('Show or hide the breadcrumbs in the header', 'omega-admin-td'),
                        'id'   => 'bbpress_header_show_breadcrumbs',
                        'type' => 'select',
                        'default' => 'show',
                        'options' => array(
                            'hide' => __('Hide', 'omega-admin-td'),
                            'show' => __('Show', 'omega-admin-td'),
                        ),
                    )
                )
            )
        ),
        'bbpress-header-heading' => array(
            'title'   => __('BBPress Header Heading', 'omega-admin-td'),
            'header'  => __('Change the text of your BBPress heading here.', 'omega-admin-td'),
            'fields'  => oxy_prefix_options_id( 'bbpress_header', $bbpress_header_options ),
        ),
        'bbpress-header-section' => array(
            'title'   => __('BBPress Header Section', 'omega-admin-td'),
            'header'  => __('Change the appearance of your BBPress header section.', 'omega-admin-td'),
            'fields'  => oxy_prefix_options_id( 'bbpress_header', $bbpress_header_section_options )
        ),
    )
));
