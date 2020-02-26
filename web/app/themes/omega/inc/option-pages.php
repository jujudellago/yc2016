<?php
/**
 * Registers all theme option pages
 *
 * @package Omega
 * @subpackage Admin
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.14
 */


// change defaults
global $oxy_theme;
if( isset($oxy_theme) ) {
    $oxy_theme->register_option_page( array(
        'page_title' => __('General', 'omega-admin-td'),
        'menu_title' => __('General', 'omega-admin-td'),
        'slug'       => THEME_SHORT . '-general',
        'main_menu'  => true,
        'main_menu_title' => THEME_NAME,
        'main_menu_icon'  => 'dashicons-marker',
        'icon'       => 'tools',
        'sections'   => array(
            'logo-section' => array(
                'title'   => __('Logo', 'omega-admin-td'),
                'header'  => __('These options allow you to configure the site logo, you can select a logo type and then create a text logo, image logo or both image and text.  There is also an option to use retina sized images.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Logo Text', 'omega-admin-td'),
                        'desc'    => __('Add your logo text here works with Logo Type (Text, Text & Image)', 'omega-admin-td'),
                        'id'      => 'logo_text',
                        'type'    => 'text',
                        'default' => 'Omega',
                    ),
                    array(
                        'name'    => __('Logo Image', 'omega-admin-td'),
                        'desc'    => __('Upload a logo for your site, works with Logo Type (Image, Text & Image)', 'omega-admin-td'),
                        'id'      => 'logo_image',
                        'store'   => 'url',
                        'type'    => 'upload',
                        'default' => OXY_THEME_URI . 'assets/images/omega.gif',
                    ),
                    array(
                        'name'    => __('Logo Transparent Image', 'omega-admin-td'),
                        'desc'    => __('Upload an image to use as the sites logo when page has a transparent header.', 'omega-admin-td'),
                        'id'      => 'logo_image_trans',
                        'store'   => 'url',
                        'type'    => 'upload',
                        'default' => '',
                    ),
                )
            ),
            'loader-section' => array(
                'title'  => __('Page Loader', 'omega-admin-td'),
                'header' => __('Toggle an animation when each page loads.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Loading Animation', 'omega-admin-td'),
                        'desc'      => __('Show a loader whenever a page is loaded', 'omega-admin-td'),
                        'id'        => 'site_loader',
                        'type'      => 'radio',
                        'options'   => array(
                            'on'    => __('Enable', 'omega-admin-td'),
                            'off'   => __('Disable', 'omega-admin-td'),
                        ),
                        'default'   => 'off',
                    ),
                    array(
                        'name'    => __('Page Loader Style', 'omega-admin-td'),
                        'desc'    => __('Choose a style of page loader to show at the start of loading a page', 'omega-admin-td'),
                        'id'      => 'site_loader_style',
                        'type'    => 'radio',
                        'options' => array(
                            'dot'     => __('Dot', 'omega-admin-td'),
                            'minimal' => __('Minimal', 'omega-admin-td'),
                            'counter' => __('Counter', 'omega-admin-td'),
                        ),
                        'default' => 'minimal',
                    )
                )
            ),
            'header-section' => array(
                'title'   => __('Header Options', 'omega-admin-td'),
                'header'  => __('This section will allow you to setup your site header.  You can choose from three different types of header to use on your site, and adjust the header height to allow room for your logo.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Header Type', 'omega-admin-td'),
                        'desc'    => __("Sets the type of header to use at the top of your site and its behaviour.  <a href='http://angle.oxygenna.com/header-options/'>See this page for more details</a>", 'omega-admin-td'),
                        'id'      => 'header_type',
                        'type'    => 'select',
                        'options' => array(
                            'navbar-sticky'     => __('Nav Bar Fixed - Navigation bar that scrolls with the page.', 'omega-admin-td'),
                            'navbar-not-sticky' => __('Nav Bar Static - Navigation bar with regular scrolling.', 'omega-admin-td'),
                        ),
                        'default' => 'navbar-sticky',
                    ),
                    array(
                        'name'      => __('Menu Height', 'omega-admin-td'),
                        'desc'      => __('Use this slider to adjust the menu height.  Ideal if you want to adjust the height to fit your logo.', 'omega-admin-td'),
                        'id'        => 'navbar_height',
                        'type'      => 'slider',
                        'default'   => 90,
                        'attr'      => array(
                            'max'       => 300,
                            'min'       => 24,
                            'step'      => 1
                        )
                    ),
                    array(
                        'name'      => __('Sub Menu Width', 'omega-admin-td'),
                        'desc'      => __('Use this to adjust the width of your drop down menus.  Ideal if you have pages with large names.', 'omega-admin-td'),
                        'id'        => 'navbar_sub_width',
                        'type'      => 'slider',
                        'default'   => 220,
                        'attr'      => array(
                            'max'       => 450,
                            'min'       => 220,
                            'step'      => 1
                        )
                    ),
                    array(
                        'name'    => __('Menu Swatch', 'omega-admin-td'),
                        'desc'    => __('Choose a color swatch for the menu.', 'omega-admin-td'),
                        'id'      => 'menu_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-white',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'    => __('Top Bar Swatch', 'omega-admin-td'),
                        'desc'    => __('Choose a color swatch for the Top Bar when you have a Header Type Top Bar or Combo', 'omega-admin-td'),
                        'id'      => 'top_bar_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-white',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'    => __('Capitalization', 'omega-admin-td'),
                        'desc'    => __('Enable-disable automatic capitalization in header logo and menus', 'omega-admin-td'),
                        'id'      => 'menu_capitalization',
                        'type'    => 'radio',
                        'options' => array(
                            'text-caps'      => __('Force Uppercase', 'omega-admin-td'),
                            'text-lowercase' => __('Force Lowercase', 'omega-admin-td'),
                            'text-none' => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'text-none',
                    ),
                    array(
                        'name'    => __('Menu Underline', 'omega-admin-td'),
                        'desc'    => __('Underline of the menu items when selected', 'omega-admin-td'),
                        'id'      => 'underline_menu',
                        'type'    => 'radio',
                        'options' => array(
                            'underline'  => __('On', 'omega-admin-td'),
                            'no-underline'     => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'underline',
                    ),
                    array(
                        'name'      => __('Menu Change Scroll Point', 'omega-admin-td'),
                        'desc'      => __('Point in pixels after the page scrolls that will trigger the menu to change shape / colour.', 'omega-admin-td'),
                        'id'        => 'navbar_scrolled_point',
                        'type'      => 'slider',
                        'default'   => 200,
                        'attr'      => array(
                            'max'       => 1000,
                            'min'       => 0,
                            'step'      => 1
                        )
                    ),
                    array(
                        'name'    => __('Menu Swatch After Scroll Point', 'omega-admin-td'),
                        'desc'    => __('Choose a color swatch for the menu after the scroll point.', 'omega-admin-td'),
                        'id'      => 'menu_swatch_after_scroll',
                        'type'    => 'select',
                        'default' => 'swatch-white',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'      => __('Menu Height After Scroll Point', 'omega-admin-td'),
                        'desc'      => __('Use this slider to adjust the menu height after menu has scrolled.', 'omega-admin-td'),
                        'id'        => 'navbar_scrolled',
                        'type'      => 'slider',
                        'default'   => 70,
                        'attr'      => array(
                            'max'       => 300,
                            'min'       => 24,
                            'step'      => 1
                        )
                    ),
                    array(
                        'name'    => __('Hover Menu', 'omega-admin-td'),
                        'desc'    => __('Choose between menu that will open when you click or hover (desktop only option since mobile devices will always use touch)', 'omega-admin-td'),
                        'id'      => 'hover_menu',
                        'type'    => 'radio',
                        'options' => array(
                            'off' => __('Click', 'omega-admin-td'),
                            'on'  => __('Hover', 'omega-admin-td'),
                        ),
                        'default' => 'off',
                    ),
                    array(
                        'name'    => __('Hover Menu Delay', 'omega-admin-td'),
                        'desc'    => __('Delay in seconds before the hover menu closes after moving mouse off the menu.', 'omega-admin-td'),
                        'id'      => 'hover_menu_delay',
                        'type'      => 'slider',
                        'default'   => 200,
                        'attr'      => array(
                            'max'       => 1000,
                            'min'       => 0,
                            'step'      => 1
                        )
                    ),
                    array(
                        'name'    => __('Hover Menu Fade Delay', 'omega-admin-td'),
                        'desc'    => __('Delay of the Fade In/Fade Out animation .', 'omega-admin-td'),
                        'id'      => 'hover_menu_fade_delay',
                        'type'      => 'slider',
                        'default'   => 200,
                        'attr'      => array(
                            'max'       => 1000,
                            'min'       => 0,
                            'step'      => 1
                        )
                    ),
                    array(
                        'name'    => __('Full Width Menu', 'omega-admin-td'),
                        'desc'    => __('Choose between normal or fullwidth menu', 'omega-admin-td'),
                        'id'      => 'fullwidth_menu',
                        'type'    => 'radio',
                        'options' => array(
                            'container'           => __('Normal', 'omega-admin-td'),
                            'container-fullwidth' => __('Full Width', 'omega-admin-td'),
                        ),
                        'default' => 'container',
                    )
                )
            ),
            'layout-options' => array(
                'title'   => __('Layout Options', 'omega-admin-td'),
                'header'  => __('This section will allow you to setup the layout of your site.', 'omega-admin-td'),
                'fields' => array(
                    array(
                         'name'    => __('Layout Type', 'omega-admin-td'),
                         'desc'    => __('Sets the site layout (Normal - site will use all the width of the page, Boxed - Site will be surrounded by a background )', 'omega-admin-td'),
                         'id'      => 'layout_type',
                         'type'    => 'radio',
                         'options' => array(
                            'normal' => __('Normal', 'omega-admin-td'),
                            'boxed'  => __('Boxed', 'omega-admin-td'),
                        ),
                        'default' => 'normal',
                    )
                )
            ),
            'comments-options' => array(
                'title'   => __('Comments Options', 'omega-admin-td'),
                'header'  => __('This section will allow you to setup the comments for your site.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Show Comments On', 'omega-admin-td'),
                        'desc'    => __('Where to allow comments. All (show all), Pages (only on pages), Posts (only on posts), Portfolio Items (only on portfolio items), Off (all comments are off)', 'omega-admin-td'),
                        'id'      => 'site_comments',
                        'type'    => 'radio',
                        'options' => array(
                            'all'       => __('All', 'omega-admin-td'),
                            'pages'     => __('Pages', 'omega-admin-td'),
                            'posts'     => __('Posts', 'omega-admin-td'),
                            'portfolio' => __('Portfolio Items', 'omega-admin-td'),
                            'Off'       => __('Off', 'omega-admin-td')
                        ),
                        'default' => 'posts',
                    ),
                    array(
                        'name'    => __('Page Comments Section Swatch', 'omega-admin-td'),
                        'desc'    => __('Choose a color swatch for the comments section of your pages.', 'omega-admin-td'),
                        'id'      => 'page_comments_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-gray',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'    => __('Portfolio Item Comments Section Swatch', 'omega-admin-td'),
                        'desc'    => __('Choose a color swatch for the comments section of your portfolio items.', 'omega-admin-td'),
                        'id'      => 'portfolio_comments_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-gray',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                )
            ),
            'upper-footer-section' => array(
                'title'   => __('Upper Footer', 'omega-admin-td'),
                'header'  => __('This footer is above the bottom footer of your site.  Here you can set the footer to use 1-4 columns, you can add Widgets to your footer in the Appearance -> Widgets page', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Upper Footer Columns', 'omega-admin-td'),
                        'desc'    => __('Select how many columns will the upper footer consist of.', 'omega-admin-td'),
                        'id'      => 'upper_footer_columns',
                        'type'    => 'radio',
                        'options' => array(
                            1  => __('1', 'omega-admin-td'),
                            2  => __('2', 'omega-admin-td'),
                            3  => __('3', 'omega-admin-td'),
                            4  => __('4', 'omega-admin-td'),
                        ),
                        'default' => 4,
                    ),
                    array(
                        'name'    => __('Upper Footer Swatch', 'omega-admin-td'),
                        'desc'    => __('Choose a color swatch for the upper footer', 'omega-admin-td'),
                        'id'      => 'upper_footer_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-black',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'    => __('Upper Footer Height', 'omega-admin-td'),
                        'desc'    => __('Choose the amount of padding added to the height of the Upper Footer', 'omega-admin-td'),
                        'id'      => 'upper_footer_height',
                        'type'    => 'select',
                        'options' => array(
                            'normal' => __('Big Padding(72px)', 'omega-admin-td'),
                            'short'  => __('Small Padding(24px)', 'omega-admin-td'),
                        ),
                        'default' => 'normal',
                    )
                )
            ),
            'footer-section' => array(
                'title'   => __('Footer', 'omega-admin-td'),
                'header'  => __('The footer is the bottom bar of your site.  Here you can set the footer to use 1-4 columns, you can add Widgets to your footer in the Appearance -> Widgets page', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Footer Columns', 'omega-admin-td'),
                        'desc'    => __('Select how many columns will the footer consist of.', 'omega-admin-td'),
                        'id'      => 'footer_columns',
                        'type'    => 'radio',
                        'options' => array(
                            1  => __('1', 'omega-admin-td'),
                            2  => __('2', 'omega-admin-td'),
                            3  => __('3', 'omega-admin-td'),
                            4  => __('4', 'omega-admin-td'),
                        ),
                        'default' => 4,
                    ),
                    array(
                        'name'    => __('Footer Swatch', 'omega-admin-td'),
                        'desc'    => __('Choose a color swatch for the footer', 'omega-admin-td'),
                        'id'      => 'footer_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-black',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'    => __('Footer Height', 'omega-admin-td'),
                        'desc'    => __('Choose the amount of padding added to the height of the Footer', 'omega-admin-td'),
                        'id'      => 'footer_height',
                        'type'    => 'select',
                        'options' => array(
                            'normal' => __('Big Padding(72px)', 'omega-admin-td'),
                            'short'  => __('Small Padding(24px)', 'omega-admin-td'),
                        ),
                        'default' => 'normal',
                    ),
                    array(
                        'name'    => __('Back to top', 'omega-admin-td'),
                        'desc'    => __('Enable the back-to-top button', 'omega-admin-td'),
                        'id'      => 'back_to_top',
                        'type'    => 'radio',
                        'options' => array(
                            'enable'  => __('Enable', 'omega-admin-td'),
                            'disable'  => __('Disable', 'omega-admin-td'),
                        ),
                        'default' => 'enable',
                    ),
                    array(
                        'name'    => __('Back to top shape', 'omega-admin-td'),
                        'desc'    => __('Shape of the back to top button. Square or circle', 'omega-admin-td'),
                        'id'      => 'back_to_top_shape',
                        'type'    => 'radio',
                        'options' => array(
                            'square' => __('Square', 'omega-admin-td'),
                            'circle'  => __('Circle', 'omega-admin-td'),
                        ),
                        'default' => 'square'
                    )
                )
            ),
            '404-section' => array(
                'title'   => __('404 Page', 'omega-admin-td'),
                'header'  => __('Pick the page that you want to be used as the 404 page.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'     => __('Page Link', 'omega-admin-td'),
                        'desc'     => __('Choose a page to link this item to', 'omega-admin-td'),
                        'id'       => '404_page',
                        'type'     => 'select',
                        'options'  => 'taxonomy',
                        'taxonomy' => 'pages',
                        'default' =>  '',
                    ),
                )
            ),
            'google-map-section' => array(
                'title'   => __('Google Maps API key', 'omega-admin-td'),
                'header'  => __('Activates the Google Maps JavaScript API. Create an API key as instructed <a href="https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key" target="_blank">here</a> to enable Google Maps on your pages.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'     => __('Google Maps API key', 'omega-admin-td'),
                        'desc'     => __(' <strong>Necessary</strong> for the Google Map shortcode.', 'omega-admin-td'),
                        'id'       => 'api_key',
                        'type'     => 'text',
                        'default' =>  '',
                    ),
                )
            ),
        )
    ));

    $blog_header_options = include OXY_THEME_DIR . 'inc/options/global-options/heading-options.php';
    $blog_header_section_options = include OXY_THEME_DIR . 'inc/options/global-options/section-options.php';

    // set defaults for blog heading and section
    // set default heading to my blog
    $blog_header_options[0]['default'] = __('My Blog', 'omega-admin-td');
    $blog_header_options[4]['default'] = 'super';
    $blog_header_options[5]['default'] = 'light';
    $blog_header_options[11]['default'] = 'medium-top';
    $blog_header_options[12]['default'] = 'medium-bottom';
    // set default swatch to blue
    $blog_header_section_options[0]['default'] = 'swatch-blue';

    $oxy_theme->register_option_page( array(
        'page_title' => __('Blog', 'omega-admin-td'),
        'menu_title' => __('Blog', 'omega-admin-td'),
        'slug'       => THEME_SHORT . '-blog',
        'main_menu'  => false,
        'icon'       => 'tools',
        'sections'   => array(
            'blog-header-options' => array(
                'title'   => __('Blog Header Options', 'omega-admin-td'),
                'header'  => __('Change how your blog header looks.', 'omega-admin-td'),
                'fields'  => array_merge(
                    array(
                        array(
                            'name' => __('Show Header', 'omega-admin-td'),
                            'desc' => __('Show or hide the header at the top of the page.', 'omega-admin-td'),
                            'id'   => 'blog_header_show_header',
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
                            'id'   => 'blog_header_show_breadcrumbs',
                            'type' => 'select',
                            'default' => 'show',
                            'options' => array(
                                'hide' => __('Hide', 'omega-admin-td'),
                                'show' => __('Show', 'omega-admin-td'),
                            ),
                        ),
                        array(
                            'name' => __('Breadcrumb Text Capitalisation', 'omega-admin-td'),
                            'desc' => __('Decides the case of the breadcrumbs.', 'omega-admin-td'),
                            'id'   => 'blog_header_breadcrumbs_case',
                            'type' => 'select',
                            'options' => array(
                                'text-caps'      => __('Force Uppercase', 'omega-admin-td'),
                                'text-lowercase' => __('Force Lowercase', 'omega-admin-td'),
                                'text-none' => __('Off', 'omega-admin-td'),
                            ),
                            'default' => 'text-lowercase',
                        )
                    )
                )
            ),
            'blog-header-heading' => array(
                'title'   => __('Blog Header Heading', 'omega-admin-td'),
                'header'  => __('Change the text of your blog heading here.', 'omega-admin-td'),
                'fields'  => oxy_prefix_options_id( 'blog_header', $blog_header_options ),
            ),
            'blog-header-section' => array(
                'title'   => __('Blog Header Section', 'omega-admin-td'),
                'header'  => __('Change the appearance of your blog header section.', 'omega-admin-td'),
                'fields'  => oxy_prefix_options_id( 'blog_header', $blog_header_section_options )
            ),
            'blog-section' => array(
                'title'   => __('General Blog Options', 'omega-admin-td'),
                'header'  => __('Here you can setup the blog options that are used on all the main blog list pages', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Blog Style', 'omega-admin-td'),
                        'desc'    => __('Select a layout style to use for your blog pages.', 'omega-admin-td'),
                        'id'      => 'blog_style',
                        'type'    => 'imgradio',
                        'columns' => '5',
                        'options' => array(
                            'right-sidebar' => array(
                                'name' => __('Right Sidebar', 'omega-admin-td'),
                                'image' => OXY_THEME_URI . 'inc/assets/images/blog-rightsidebar.png',
                            ),
                            'left-sidebar' => array(
                                'name' => __('Left Sidebar', 'omega-admin-td'),
                                'image' => OXY_THEME_URI . 'inc/assets/images/blog-leftsidebar.png',
                            ),
                            'no-sidebar-normal' => array(
                                'name' => __('No Sidebar (Normal Article)', 'omega-admin-td'),
                                'image' => OXY_THEME_URI . 'inc/assets/images/blog-normal.png',
                            ),
                            'no-sidebar-narrow' => array(
                                'name' => __('No Sidebar (Narrow Article)', 'omega-admin-td'),
                                'image' => OXY_THEME_URI . 'inc/assets/images/blog-narrow.png',
                            ),
                            'no-sidebar-wide' => array(
                                'name' => __('No Sidebar (Wide Article)', 'omega-admin-td'),
                                'image' => OXY_THEME_URI . 'inc/assets/images/blog-wide.png',
                            ),
                        ),
                        'default' => 'right-sidebar',
                    ),
                    array(
                        'name'    => __('Show Post Icons', 'omega-admin-td'),
                        'desc'    => __('This option will show or hide all icons on both the blog list page and the blog single page.', 'omega-admin-td'),
                        'id'      => 'blog_post_icons',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'omega-admin-td'),
                            'off'  => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name'    => __('Show Read More', 'omega-admin-td'),
                        'desc'    => __('Show or hide the readmore link in list view', 'omega-admin-td'),
                        'id'      => 'blog_show_readmore',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'omega-admin-td'),
                            'off'  => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name' => __('Blog read more link', 'omega-admin-td'),
                        'desc' => __('The text that will be used for your read more links', 'omega-admin-td'),
                        'id' => 'blog_readmore',
                        'type' => 'text',
                        'default' => 'read more',
                    ),
                    array(
                        'name'    => __('Read more style', 'omega-admin-td'),
                        'desc'    => __('Display the readmore as button or simple link', 'omega-admin-td'),
                        'id'      => 'blog_readmore_style',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('Button', 'omega-admin-td'),
                            'off'  => __('Simple Link', 'omega-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name'    => __('Strip teaser', 'omega-admin-td'),
                        'desc'    => __('Strip the content before the <--more--> tag in single post view', 'omega-admin-td'),
                        'id'      => 'blog_stripteaser',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'omega-admin-td'),
                            'off'  => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'off',
                    ),
                    array(
                        'name'    => __('Pagination Style', 'omega-admin-td'),
                        'desc'    => __('How your pagination will be shown', 'omega-admin-td'),
                        'id'      => 'blog_pagination',
                        'type'    => 'radio',
                        'options' => array(
                            'pages'     => __('Pages', 'omega-admin-td'),
                            'next_prev' => __('Next & Previous', 'omega-admin-td'),
                        ),
                        'default' => 'pages',
                    ),
                )
            ),
            'masonry-blog-section' => array(
                'title'   => __('Masonry Blog Page', 'omega-admin-td'),
                'header'  => __('This section allows you to set up how your masonry blog page will look.', 'omega-admin-td'),
                'fields'  => array(
                    array(
                        'name'    => __('Use Masonry On Posts Page', 'omega-admin-td'),
                        'desc'    => __('Blog list pages will use a masonry style.', 'omega-admin-td'),
                        'id'      => 'blog_masonry',
                        'type'    => 'imgradio',
                        'columns' => '5',
                        'options' => array(
                            'no-masonry' => array(
                                'name' => __('No Masonry', 'omega-admin-td'),
                                'image' => OXY_THEME_URI . 'inc/assets/images/blog-rightsidebar.png',
                            ),
                            'normal-masonry' => array(
                                'name' => __('Normal Masonry', 'omega-admin-td'),
                                'image' => OXY_THEME_URI . 'inc/assets/images/blog-masonry.png',
                            ),
                            'left-sidebar-masonry' => array(
                                'name' => __('Left Sidebar Masonry', 'omega-admin-td'),
                                'image' => OXY_THEME_URI . 'inc/assets/images/blog-masonry-left.png',
                            ),
                            'right-sidebar-masonry' => array(
                                'name' => __('Right Sidebar Masonry', 'omega-admin-td'),
                                'image' => OXY_THEME_URI . 'inc/assets/images/blog-masonry-right.png',
                            ),
                            'wide-masonry' => array(
                                'name' => __('Wide Masonry', 'omega-admin-td'),
                                'image' => OXY_THEME_URI . 'inc/assets/images/blog-masonrywide.png',
                            ),
                        ),
                        'default' => 'no-masonry',
                    ),
                    array(
                        'name'      => __('Masonry Items Padding', 'omega-admin-td'),
                        'desc'      => __('Space to add between blog items in pixels.', 'omega-admin-td'),
                        'id'        => 'blog_masonry_item_padding',
                        'type'      => 'slider',
                        'default'   => 20,
                        'attr'      => array(
                            'max'       => 100,
                            'min'       => 0,
                            'step'      => 1
                        )
                    ),
                    array(
                        'name'    => __('Masonry Section Background Image', 'omega-admin-td'),
                        'desc'    => __('Upload an image as your masonry blog section background.', 'omega-admin-td'),
                        'id'      => 'blog_masonry_section_background',
                        'type'    => 'upload',
                        'store'   => 'url',
                        'default' => '',
                    ),
                    array(
                        'name'    => __('Masonry Section Transparent', 'omega-admin-td'),
                        'desc'    => __('Makes the masonry blog section transparent.', 'omega-admin-td'),
                        'id'      => 'blog_masonry_section_transparent',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'omega-admin-td'),
                            'off'  => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'off',
                    ),
                ),
            ),
            'blog-single-section' => array(
                'title'   => __('Blog Single Page', 'omega-admin-td'),
                'header'  => __('This section allows you to set up how your single post will look.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Display date', 'omega-admin-td'),
                        'desc'    => __('Toggle date on/off in post', 'omega-admin-td'),
                        'id'      => 'blog_date',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'omega-admin-td'),
                            'off'  => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name'    => __('Display author', 'omega-admin-td'),
                        'desc'    => __('Toggle author on/off in post', 'omega-admin-td'),
                        'id'      => 'blog_author',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'omega-admin-td'),
                            'off'  => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name'    => __('Display categories', 'omega-admin-td'),
                        'desc'    => __('Toggle categories on/off in post', 'omega-admin-td'),
                        'id'      => 'blog_categories',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'omega-admin-td'),
                            'off'  => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name'    => __('Display tags', 'omega-admin-td'),
                        'desc'    => __('Toggle tags on/off in post', 'omega-admin-td'),
                        'id'      => 'blog_tags',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'omega-admin-td'),
                            'off'  => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name'    => __('Author bio', 'omega-admin-td'),
                        'desc'    => __('Display/hide the authors bio after the post', 'omega-admin-td'),
                        'id'      => 'author_bio',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'omega-admin-td'),
                            'off'  => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'off',
                    ),
                    array(
                        'name'    => __('Display avatar in Author bio', 'omega-admin-td'),
                        'desc'    => __('Toggle avatars on/off in Author Bio Section', 'omega-admin-td'),
                        'id'      => 'author_bio_avatar',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'omega-admin-td'),
                            'off'  => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name'    => __('Display comment count', 'omega-admin-td'),
                        'desc'    => __('Toggle comment count on/off in post', 'omega-admin-td'),
                        'id'      => 'blog_comment_count',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'omega-admin-td'),
                            'off'  => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name'    => __('Social Networks', 'omega-admin-td'),
                        'desc'    => __('Select which social networks you would like to share posts on. If you need more than one, hold down Ctrl button and select as many as you like. ', 'omega-admin-td'),
                        'id'      => 'blog_social_networks',
                        'default' =>  array( 'facebook', 'twitter', 'google', 'pinterest', 'linkedin', 'none' ),
                        'type'    => 'select',
                        'attr' => array(
                            'multiple' => '',
                            'style' => 'height:110px'
                        ),
                        'options' => array(
                            'facebook'  => __('Facebook', 'omega-admin-td'),
                            'twitter'   => __('Twitter', 'omega-admin-td'),
                            'google'    => __('Google+', 'omega-admin-td'),
                            'pinterest' => __('Pinterest', 'omega-admin-td'),
                            'linkedin' => __('LinkedIn', 'omega-admin-td'),
                            'none' => __('None', 'omega-admin-td'),
                        )
                    ),
                    array(
                        'name'    => __('Show related posts', 'omega-admin-td'),
                        'desc'    => __('Show Related Posts after the post content', 'omega-admin-td'),
                        'id'      => 'related_posts',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'omega-admin-td'),
                            'off'  => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name'    => __('Number of related posts', 'omega-admin-td'),
                        'desc'    => __('Choose how many related posts are displayed in the related posts section after the post content', 'omega-admin-td'),
                        'id'      => 'related_posts_count',
                        'type'      => 'slider',
                        'default'   => 3,
                        'attr'      => array(
                            'max'       => 8,
                            'min'       => 3,
                            'step'      => 1
                        )
                    ),
                    array(
                        'name'    => __('Number of related posts columns', 'omega-admin-td'),
                        'desc'    => __('Choose how many columns are displayed in the related posts section after the post content', 'omega-admin-td'),
                        'id'      => 'related_posts_columns',
                        'type'    => 'radio',
                        'options' => array(
                            '3'   => __('3', 'omega-admin-td'),
                            '4'   => __('4', 'omega-admin-td')
                        ),
                        'default' => '3',
                    ),
                    array(
                        'name'    => __('Open Featured Image in Magnific Popup', 'omega-admin-td'),
                        'desc'    => __('Featured image in single post view will open in a large preview popup', 'omega-admin-td'),
                        'id'      => 'blog_fancybox',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'omega-admin-td'),
                            'off'  => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                )
            ),
            'swatches-section' => array(
                'title'   => __('Swatches', 'omega-admin-td'),
                'header'  => __('Choose a swatch for your Blog.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Blog Swatch', 'omega-admin-td'),
                        'desc'    => __('Choose a color swatch for the Blog page', 'omega-admin-td'),
                        'id'      => 'blog_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-white',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'    => __('Masonry Items Swatch', 'omega-admin-td'),
                        'desc'    => __('Choose a color swatch for all the items if you use a masonry blog layout.', 'omega-admin-td'),
                        'id'      => 'masonry_items_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-blue',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'    => __('Related Section Swatch', 'omega-admin-td'),
                        'desc'    => __('Choose a swatch to colour the related section with.', 'omega-admin-td'),
                        'id'      => 'related_portfolio_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-blue',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                )
            )
        )
    ));

    $page_header_options = include OXY_THEME_DIR . 'inc/options/global-options/heading-options.php';
    $page_header_section_options = include OXY_THEME_DIR . 'inc/options/global-options/section-options.php';

    // remove text from default page options
    unset($page_header_options[0]);
    unset($page_header_options[1]);

    $oxy_theme->register_option_page(array(
        'page_title' => __('Pages', 'omega-admin-td'),
        'menu_title' => __('Pages', 'omega-admin-td'),
        'slug'       => THEME_SHORT . '-pages',
        'main_menu'  => false,
        'icon'       => 'tools',
        'sections'   => array(
            'page-header-options' => array(
                'title'   => __('Default Page Header', 'omega-admin-td'),
                'header'  => __('Change if the page header will appear by default.', 'omega-admin-td'),
                'fields'  => array(
                    array(
                        'name' => __('Show Header', 'omega-admin-td'),
                        'desc' => __('Show or hide the header at the top of the page.', 'omega-admin-td'),
                        'id'   => 'page_header_show_header',
                        'type' => 'select',
                        'default' => 'show',
                        'options' => array(
                            'hide' => __('Hide', 'omega-admin-td'),
                            'show' => __('Show', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name' => __('Show Breadcrumbs', 'omega-admin-td'),
                        'desc' => __('Show or hide the breadcrumbs in the header', 'omega-admin-td'),
                        'id'   => 'page_header_show_breadcrumbs',
                        'type' => 'select',
                        'default' => 'hide',
                        'options' => array(
                            'hide' => __('Hide', 'omega-admin-td'),
                            'show' => __('Show', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name' => __('Breadcrumb Text Capitalisation', 'omega-admin-td'),
                        'desc' => __('Decides the case of the breadcrumbs.', 'omega-admin-td'),
                        'id'   => 'page_header_breadcrumbs_case',
                        'type' => 'select',
                        'options' => array(
                            'text-caps'      => __('Force Uppercase', 'omega-admin-td'),
                            'text-lowercase' => __('Force Lowercase', 'omega-admin-td'),
                            'text-none' => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'text-lowercase',
                    )
                )
            ),
            'default-page-header-heading' => array(
                'title'   => __('Default Page Header Heading', 'omega-admin-td'),
                'header'  => __('Change the text of your blog heading here.', 'omega-admin-td'),
                'fields'  => oxy_prefix_options_id('page_header', $page_header_options),
            ),
            'default-page-header-section' => array(
                'title'   => __('Default Page Header Section', 'omega-admin-td'),
                'header'  => __('Change the appearance of your page header section.', 'omega-admin-td'),
                'fields'  => oxy_prefix_options_id('page_header', $page_header_section_options)
            ),
        )
    ));
    $oxy_theme->register_option_page( array(
        'page_title' => __('Flexslider Options', 'omega-admin-td'),
        'menu_title' => __('Flexslider', 'omega-admin-td'),
        'slug'       => THEME_SHORT . '-flexslider',
        'header'  => __('Global options for flexsliders used in the site (gallery posts, gallery portfolio items).', 'omega-admin-td'),
        'main_menu'  => false,
        'icon'       => 'tools',
        'sections'   => array(
            'slider-section' => array(
                'title' => __('Slideshow', 'omega-admin-td'),
                'header'  => __('Setup your global default flexslider options.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'      =>  __('Animation style', 'omega-admin-td'),
                        'desc'      =>  __('Select how your slider animates', 'omega-admin-td'),
                        'id'        => 'animation',
                        'type'      => 'select',
                        'options'   =>  array(
                            'slide' => __('Slide', 'omega-admin-td'),
                            'fade'  => __('Fade', 'omega-admin-td'),
                        ),
                        'attr'      =>  array(
                            'class'    => 'widefat',
                        ),
                        'default'   => 'slide',
                    ),
                    array(
                        'name'      => __('Speed', 'omega-admin-td'),
                        'desc'      => __('Set the speed of the slideshow cycling, in milliseconds', 'omega-admin-td'),
                        'id'        => 'speed',
                        'type'      => 'slider',
                        'default'   => 7000,
                        'attr'      => array(
                            'max'       => 15000,
                            'min'       => 2000,
                            'step'      => 1000
                        )
                    ),
                    array(
                        'name'      => __('Duration', 'omega-admin-td'),
                        'desc'      => __('Set the speed of animations', 'omega-admin-td'),
                        'id'        => 'duration',
                        'type'      => 'slider',
                        'default'   => 600,
                        'attr'      => array(
                            'max'       => 1500,
                            'min'       => 200,
                            'step'      => 100
                        )
                    ),
                    array(
                        'name'      => __('Auto start', 'omega-admin-td'),
                        'id'        => 'autostart',
                        'type'      => 'radio',
                        'default'   =>  'true',
                        'desc'    => __('Start slideshow automatically', 'omega-admin-td'),
                        'options' => array(
                            'true'  => __('On', 'omega-admin-td'),
                            'false' => __('Off', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Show navigation arrows', 'omega-admin-td'),
                        'id'        => 'directionnav',
                        'type'      => 'radio',
                        'desc'    => __('Shows the navigation arrows at the sides of the flexslider.', 'omega-admin-td'),
                        'default'   =>  'hide',
                        'options' => array(
                            'hide' => __('Hide', 'omega-admin-td'),
                            'show' => __('Show', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Show controls', 'omega-admin-td'),
                        'id'        => 'showcontrols',
                        'type'      => 'radio',
                        'default'   =>  'show',
                        'desc'    => __('If you choose hide the option below will be ignored', 'omega-admin-td'),
                        'options' => array(
                            'hide' => __('Hide', 'omega-admin-td'),
                            'show' => __('Show', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Choose the place of the controls', 'omega-admin-td'),
                        'id'        => 'controlsposition',
                        'type'      => 'radio',
                        'default'   =>  'inside',
                        'desc'    => __('Choose the position of the navigation controls', 'omega-admin-td'),
                        'options' => array(
                            'inside'    => __('Inside', 'omega-admin-td'),
                            'outside'   => __('Outside', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      =>  __('Choose the alignment of the controls', 'omega-admin-td'),
                        'id'        => 'controlsalign',
                        'type'      => 'radio',
                        'desc'    => __('Choose the alignment of the navigation controls', 'omega-admin-td'),
                        'options'   =>  array(
                            'center' => __('Center', 'omega-admin-td'),
                            'left'   => __('Left', 'omega-admin-td'),
                            'right'  => __('Right', 'omega-admin-td'),
                        ),
                        'attr'      =>  array(
                            'class'    => 'widefat',
                        ),
                        'default'   => 'center',
                    )
                )
            ),
            'captions-section' => array(
                'title' => __('Captions', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Show Captions', 'omega-admin-td'),
                        'id'        => 'captions',
                        'type'      => 'radio',
                        'default'   =>  'hide',
                        'desc'    => __('If you choose hide the options below will be ignored', 'omega-admin-td'),
                        'options' => array(
                            'hide' => __('Hide', 'omega-admin-td'),
                            'show' => __('Show', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Captions Horizontal Position', 'omega-admin-td'),
                        'desc'      => __('Choose among left, right and alternate positioning', 'omega-admin-td'),
                        'id'        => 'captions_horizontal',
                        'type'      => 'select',
                        'default'   =>  'left',
                        'options' => array(
                            'left'      => __('Left', 'omega-admin-td'),
                            'right'     => __('Right', 'omega-admin-td'),
                            'alternate' => __('Alternate', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Show Tooltip', 'omega-admin-td'),
                        'id'        => 'tooltip',
                        'type'      => 'select',
                        'default'   =>  'hide',
                        'desc'    => __('Show tooltip if Item width option is set', 'omega-admin-td'),
                        'options' => array(
                            'show'  => __('Show', 'omega-admin-td'),
                            'hide'  => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                )
            ),
        )
    ));
    $oxy_theme->register_option_page( array(
        'page_title' => __('Portfolio Options', 'omega-admin-td'),
        'menu_title' => __('Portfolio', 'omega-admin-td'),
        'slug'       => THEME_SHORT . '-portfolio',
        'main_menu'  => false,
        'sections'   => array(
            'portfolio-options-section' => array(
                'title'   => __('Portfolio List Options', 'omega-admin-td'),
                'header'  => __('Customise your portfolio list.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Zoom Button Text', 'omega-admin-td'),
                        'id'      => 'portfolio_button_text_zoom',
                        'type'    => 'text',
                        'default' => __('View Larger', 'omega-admin-td'),
                        'desc'    => __('This text will be shown in the portfolio item zoom button.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Link Button Text', 'omega-admin-td'),
                        'id'      => 'portfolio_button_text_details',
                        'type'    => 'text',
                        'default' => __('More Details', 'omega-admin-td'),
                        'desc'    => __('This text will be shown below the portfolio item link button.', 'omega-admin-td'),
                    ),
                )
            ),
            'portfolio-single-section' => array(
                'title'   => __('Portfolio Single Page', 'omega-admin-td'),
                'header'  => __('Customise your portfolio single page here.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Portfolio Page', 'omega-admin-td'),
                        'desc'      => __('Set the page that the icon at the top of the single page will link to.', 'omega-admin-td'),
                        'id'        => 'portfolio_page',
                        'type'      => 'select',
                        'options'  => 'taxonomy',
                        'taxonomy' => 'pages',
                        'default' =>  '',
                        'blank' => __('None', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Show related items', 'omega-admin-td'),
                        'desc'    => __('Show related portfolio items after the post content', 'omega-admin-td'),
                        'id'      => 'related_portfolio_items',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'omega-admin-td'),
                            'off'  => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name'    => __('Related Section Title Text', 'omega-admin-td'),
                        'desc'    => __('The text that will be shown above the related portfolio items.', 'omega-admin-td'),
                        'id'      => 'related_portfolio_text',
                        'type'    => 'text',
                        'default' => __('Other related items', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Related Section Title Font Weight', 'omega-admin-td'),
                        'desc'    => __('Choose weight of the font to use for the related post text', 'omega-admin-td'),
                        'id'      => 'related_portfolio_text_weight',
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
                        'name'    => __('Number of related items', 'omega-admin-td'),
                        'desc'    => __('Choose how many related posts are displayed in the related posts section after the post content', 'omega-admin-td'),
                        'id'      => 'related_portfolio_count',
                        'type'      => 'slider',
                        'default'   => 3,
                        'attr'      => array(
                            'max'       => 8,
                            'min'       => 3,
                            'step'      => 1
                        )
                    ),
                    array(
                        'name'    => __('Number of related item columns', 'omega-admin-td'),
                        'desc'    => __('Choose how many columns are displayed in the related items section after the portfolio content', 'omega-admin-td'),
                        'id'      => 'related_portfolio_columns',
                        'type'    => 'radio',
                        'options' => array(
                            '3'   => __('3', 'omega-admin-td'),
                            '4'   => __('4', 'omega-admin-td')
                        ),
                        'default' => '3',
                    ),
                )
            ),
            'portfolio-size-section' => array(
                'title'   => __('Portfolio Image Sizes', 'omega-admin-td'),
                'header'  => __('When your portfolio images are uploaded they will be automatially saved using these dimensions.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Image Width', 'omega-admin-td'),
                        'desc'    => __('Width of each portfolio item', 'omega-admin-td'),
                        'id'      => 'portfolio_item_width',
                        'type'    => 'slider',
                        'default'   => 800,
                        'attr'      => array(
                            'max'       => 1200,
                            'min'       => 50,
                            'step'      => 1
                        )
                    ),
                    array(
                        'name'    => __('Image Height', 'omega-admin-td'),
                        'desc'    => __('Height of each portfolio item', 'omega-admin-td'),
                        'id'      => 'portfolio_item_height',
                        'type'    => 'slider',
                        'default'   => 600,
                        'attr'      => array(
                            'max'       => 800,
                            'min'       => 50,
                            'step'      => 1
                        )
                    ),
                    array(
                        'name'      => __('Image Cropping', 'omega-admin-td'),
                        'id'        => 'portfolio_item_crop',
                        'type'      => 'radio',
                        'default'   =>  'on',
                        'desc'    => __('Crop images to the exact proportions', 'omega-admin-td'),
                        'options' => array(
                            'on' => __('Crop Images', 'omega-admin-td'),
                            'off' => __('Do not crop', 'omega-admin-td'),
                        ),
                    ),
                )
            ),
        )
    ));
    $oxy_theme->register_option_page( array(
        'page_title' => __('Post Types', 'omega-admin-td'),
        'menu_title' => __('Post Types', 'omega-admin-td'),
        'slug'       => THEME_SHORT . '-post-types',
        'main_menu'  => false,
        'sections'   => array(
            'permalinks-section' => array(
                'title'   => __('Configure your permalinks here', 'omega-admin-td'),
                'header'  => __('Some of the custom single pages ( Portfolios, Services, Staff ) can be configured to use their own special url.  This helps with SEO.  Set your permalinks here, save and then navigate to one of the items and you will see the url in the format below.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'prefix'  => '<code>' . get_site_url() . '/</code>',
                        'postfix' => '<code>/my-portfolio-item</code>',
                        'name'    => __('Portfolio URL slug', 'omega-admin-td'),
                        'desc'    => __('Choose the url you would like your portfolios to be shown on', 'omega-admin-td'),
                        'id'      => 'portfolio_slug',
                        'type'    => 'text',
                        'default' => 'portfolio',
                    ),
                    array(
                        'prefix'  => '<code>' . get_site_url() . '/</code>',
                        'postfix' => '<code>/my-service</code>',
                        'name'    => __('Service URL slug', 'omega-admin-td'),
                        'desc'    => __('Choose the url you would like your services to use', 'omega-admin-td'),
                        'id'      => 'services_slug',
                        'type'    => 'text',
                        'default' => 'our-services',
                    ),
                    array(
                        'prefix'  => '<code>' . get_site_url() . '/</code>',
                        'postfix' => '<code>/our-team</code>',
                        'name'    => __('Staff URL slug', 'omega-admin-td'),
                        'desc'    => __('Choose the url you would like your staff pages to use', 'omega-admin-td'),
                        'id'      => 'staff_slug',
                        'type'    => 'text',
                        'default' => 'our-team',
                    ),
                )
            ),
            'posttypes-archives-section' => array(
                'title'   => __('Post Types Archive Pages', 'omega-admin-td'),
                'header'  => __('Set your post types archives pages here', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Portfolio Archive Page', 'omega-admin-td'),
                        'desc'      => __('Set the archive page for the portfolio post type', 'omega-admin-td'),
                        'id'        => 'portfolio_archive_page',
                        'type'      => 'select',
                        'options'  => 'taxonomy',
                        'taxonomy' => 'pages',
                        'default' =>  '',
                        'blank' => __('None', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Services Archive Page', 'omega-admin-td'),
                        'desc'      => __('Set the archive page for the services post type', 'omega-admin-td'),
                        'id'        => 'services_archive_page',
                        'type'      => 'select',
                        'options'  => 'taxonomy',
                        'taxonomy' => 'pages',
                        'default' =>  '',
                        'blank' => __('None', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Staff Archive Page', 'omega-admin-td'),
                        'desc'      => __('Set the archive page for the staff post type', 'omega-admin-td'),
                        'id'        => 'staff_archive_page',
                        'type'      => 'select',
                        'options'  => 'taxonomy',
                        'taxonomy' => 'pages',
                        'default' =>  '',
                        'blank' => __('None', 'omega-admin-td'),
                    ),
                )
            ),
        )
    ));
    $oxy_theme->register_option_page( array(
        'page_title' => __('Advanced Theme Options', 'omega-admin-td'),
        'menu_title' => __('Advanced', 'omega-admin-td'),
        'slug'       => THEME_SHORT . '-advanced',
        'main_menu'  => false,
        'javascripts' => array(
            array(
                'handle' => 'default-swatches',
                'src'    => OXY_THEME_URI . 'inc/options/javascripts/pages/advanced-options.js',
                'deps'   => array( 'jquery' ),
                'localize' => array(
                    'object_handle' => 'localData',
                    'data' => array(
                        'ajaxurl' => admin_url( 'admin-ajax.php' ),
                        'installDefaultsNonce'  => wp_create_nonce( 'install-default-vc' )
                    )
                ),
            ),
        ),

        'sections'   => array(
            'css-section' => array(
                'title'   => __('CSS', 'omega-admin-td'),
                'header'  => __('Here you can modify the themes advanced CSS options.</br> Please ensure that the CSS added here is valid. You can copy / paste your CSS <a href="https://jigsaw.w3.org/css-validator/#validate_by_input" target="_blank">here</a> to validate it.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Extra CSS (loaded last in the header)', 'omega-admin-td'),
                        'desc'    => __('Add extra CSS rules to be included in all pages that will be loaded in the header.  This will allow you to override some of the default styling of the theme.', 'omega-admin-td'),
                        'id'      => 'extra_css',
                        'type'    => 'textarea',
                        'attr'    => array( 'rows' => '10', 'style' => 'width:100%' ),
                        'default' => '',
                    ),
                    array(
                        'name'    => __('Swatch CSS Loading', 'omega-admin-td'),
                        'desc'    => __('Defines where the dynamic swatch css that is created by your swatch options is saved. If you are using a lot of swatches it is recommended to save them to a file.  If you dont have access to the filesystem you can save them in WP and inject them into the head', 'omega-admin-td'),
                        'id'      => 'swatch_css_save',
                        'on_change' => 'oxy_resave_swatches_update_complete',
                        'type'    => 'select',
                        'options' => array(
                            'file'  => __('Save to a file (assets/css/swatches.css)', 'omega-admin-td'),
                            'head' => __('Save to DB and inject into head', 'omega-admin-td'),
                        ),
                        'default' => 'head',
                    ),
                )
            ),
            'js-section' => array(
                'title'   => __('Javascript', 'omega-admin-td'),
                'header'  => __('Here you can modify the themes advanced JS options', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Extra Javascript (loaded last in the header)', 'omega-admin-td'),
                        'desc'    => __('Add extra Javascript rules to be included in all pages that will be loaded in the header.  Code will be wrapped in script tags by default.', 'omega-admin-td'),
                        'id'      => 'extra_js',
                        'type'    => 'textarea',
                        'attr'    => array( 'rows' => '10', 'style' => 'width:100%' ),
                        'default' => '',
                    ),
                )
            ),
            'assets-section' => array(
                'title'   => __('Assets', 'omega-admin-td'),
                'header'  => __('Here you can choose the type of asset files enqueued by the theme.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Load Minified CSS and JS Assets', 'omega-admin-td'),
                        'desc'    => __('Choose between minified and not minified theme CSS and Javascript files. Minified files are smaller and faster to load, while non-minified are easier to edit and mofify because they are more readable. Minified assets are enqueued by default.', 'omega-admin-td'),
                        'id'      => 'minified_assets',
                        'type'    => 'radio',
                        'options' => array(
                            'on'  => __('On', 'omega-admin-td'),
                            'off' => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                )
            ),
            'atom-section' => array(
                'title'   => __('Enable Atom Meta', 'omega-admin-td'),
                'header'  => __('Here you can enable atom meta for posts author, title and date (used by search engines).', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Author', 'omega-admin-td'),
                        'desc'    => __('Enable atom meta for posts author', 'omega-admin-td'),
                        'id'      => 'atom_author',
                        'type'    => 'radio',
                        'options' => array(
                            'on'  => __('On', 'omega-admin-td'),
                            'off' => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name'    => __('Title', 'omega-admin-td'),
                        'desc'    => __('Enable atom meta for posts title', 'omega-admin-td'),
                        'id'      => 'atom_title',
                        'type'    => 'radio',
                        'options' => array(
                            'on'  => __('On', 'omega-admin-td'),
                            'off' => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name'    => __('Date', 'omega-admin-td'),
                        'desc'    => __('Enable atom meta for posts date', 'omega-admin-td'),
                        'id'      => 'atom_date',
                        'type'    => 'radio',
                        'options' => array(
                            'on'  => __('On', 'omega-admin-td'),
                            'off' => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'on',
                    )
                )
            ),
            'favicon-section' => array(
                'title'   => __('Site Fav Icon', 'omega-admin-td'),
                'header'  => __('The site Fav Icon is the icon that appears in the top corner of the browser tab, it is also used when saving bookmarks.  Upload your own custom Fav Icon here, recommended resolutions are 16x16 or 32x32.', 'omega-admin-td'),
                'fields' => array(
                    array(
                      'name' => __('Fav Icon', 'omega-admin-td'),
                      'id'   => 'favicon',
                      'type' => 'upload',
                      'store' => 'url',
                      'desc' => __('Upload a Fav Icon for your site here', 'omega-admin-td'),
                      'default' => OXY_THEME_URI . 'assets/images/favicons/favicon.ico',
                    ),
                )
            ),
            'apple-section' => array(
                'title'   => __('Apple Icons', 'omega-admin-td'),
                'header'  => __('If someone saves a bookmark to their desktop on an Apple device this is the icon that will be used.  Here you can upload the icon you would like to be used on the various Apple devices.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name' => __('iPhone Icon (57x57)', 'omega-admin-td'),
                        'id'   => 'iphone_icon',
                        'type' => 'upload',
                        'store' => 'url',
                        'desc' => __('Upload an icon to be used by iPhone as a bookmark (57 x 57 pixels)', 'omega-admin-td'),
                        'default' => OXY_THEME_URI . 'assets/images/favicons/apple-touch-icon-precomposed.png',
                    ),
                    array(
                      'name' => __('iPhone Retina Icon (114x114)', 'omega-admin-td'),
                      'id'   => 'iphone_retina_icon',
                      'type' => 'upload',
                      'store' => 'url',
                      'desc' => __('Upload an icon to be used by iPhone Retina as a bookmark (114 x 114 pixels)', 'omega-admin-td'),
                      'default' => OXY_THEME_URI . 'assets/images/favicons/apple-touch-icon-114x114-precomposed.png',
                    ),
                    array(
                      'name' => __('iPad Icon (72x72)', 'omega-admin-td'),
                      'id'   => 'ipad_icon',
                      'type' => 'upload',
                      'store' => 'url',
                      'desc' => __('Upload an icon to be used by iPad as a bookmark (72 x 72 pixels)', 'omega-admin-td'),
                      'default' => OXY_THEME_URI . 'assets/images/favicons/apple-touch-icon-72x72-precomposed.png',
                    ),
                    array(
                      'name' => __('iPad Retina Icon (144x144)', 'omega-admin-td'),
                      'id'   => 'ipad_icon_retina',
                      'type' => 'upload',
                      'store' => 'url',
                      'desc' => __('Upload an icon to be used by iPad Retina as a bookmark (144 x 144 pixels)', 'omega-admin-td'),
                      'default' => OXY_THEME_URI . 'assets/images/favicons/apple-touch-icon-144x144-precomposed.png',
                    ),
                )
            ),
            'mobile-section' => array(
                'title'   => __('Mobile', 'omega-admin-td'),
                'header'  => __('Here you can configure settings targeted at mobile devices', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Background Videos', 'omega-admin-td'),
                        'desc'    => __('Here you can enable section background videos for mobile. By default it is set to off in order to save bandwidth. Section background image will be displayed as a fallback', 'omega-admin-td'),
                        'id'      => 'mobile_videos',
                        'type'    => 'radio',
                        'options' => array(
                            'on'  => __('On', 'omega-admin-td'),
                            'off' => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'off',
                    ),
                )
            ),
            'svg-section' => array(
                'title'   => __('SVG Icons', 'omega-admin-td'),
                'header'  => __('Here you can enable SVG uploads', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Enable SVG uploads', 'omega-admin-td'),
                        'desc'    => __('Here you can enable SVG uploads. By default it is set to off to avoid security hazards.', 'omega-admin-td'),
                        'id'      => 'enable_svg',
                        'type'    => 'radio',
                        'options' => array(
                            'on'  => __('On', 'omega-admin-td'),
                            'off' => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'off',
                    ),
                )
            ),
            'google-anal-section' => array(
                'title'   => __('Google Analytics', 'omega-admin-td'),
                'header'  => __('Set your Google Analytics Tracker and keep track of visitors to your site.', 'omega-admin-td'),
                'fields' => array(
                    'google_anal' => array(
                        'name' => __('Google Analytics', 'omega-admin-td'),
                        'desc' => __('Paste your google analytics code here', 'omega-admin-td'),
                        'id' => 'google_anal',
                        'type' => 'text',
                        'default' => 'UA-XXXXX-X',
                    )
                )
            ),
            'advanced-menu-section' => array(
                'title'   => __('Menus', 'omega-admin-td'),
                'header'  => __('Set up advanced menu options.', 'omega-admin-td'),
                'fields' => array(
                    'ajax_menu_save' => array(
                        'name' => __('Save Menus Using Ajax ( allows saving menus with > 90 menu items )', 'omega-admin-td'),
                        'desc' => __('This feature will make WordPress menus save using ajax instead of the default PHP save.  This gets around a bug in WordPress that stops large menus from saving (see https://core.trac.wordpress.org/ticket/14134).', 'omega-admin-td'),
                        'id' => 'ajax_menu_save',
                        'type'    => 'radio',
                        'options' => array(
                            'on'  => __('On', 'omega-admin-td'),
                            'off' => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'on',
                    )
                )
            ),
            'advanced-visual-composer-section' => array(
                'title'   => __('Visual Composer', 'omega-admin-td'),
                'header'  => __('Set up advanced visual composer options.', 'omega-admin-td'),
                'fields' => array(
                    'ajax_menu_save' => array(
                        'name'        => __('Install Default Visual Composer Templates', 'omega-admin-td'),
                        'desc'        => __('This will install some default visual composer templates.', 'omega-admin-td'),
                        'id'          => 'visual_composer_templates',
                        'type'        => 'button',
                        'button-text' => __('Install Templates', 'omega-admin-td'),
                        'attr'        => array(
                            'id'    => 'install-default-vc-templates',
                            'class' => 'button button-primary'
                        ),
                    )
                )
            ),
            'advanced-menu-section' => array(
                'title'   => __('Menus', 'omega-admin-td'),
                'header'  => __('Set up advanced menu options.', 'omega-admin-td'),
                'fields' => array(
                    'ajax_menu_save' => array(
                        'name' => __('Save Menus Using Ajax ( allows saving menus with > 90 menu items )', 'omega-admin-td'),
                        'desc' => __('This feature will make WordPress menus save using ajax instead of the default PHP save.  This gets around a bug in WordPress that stops large menus from saving (see https://core.trac.wordpress.org/ticket/14134).', 'omega-admin-td'),
                        'id' => 'ajax_menu_save',
                        'type'    => 'radio',
                        'options' => array(
                            'on'  => __('On', 'omega-admin-td'),
                            'off' => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'on',
                    )
                )
            ),
            'import-export' => array(
                'title'   => __('Import / Export', 'omega-admin-td'),
                'header'  => __('Here you can import/export the theme options', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Export Data', 'omega-admin-td'),
                        'id'      => 'data_export',
                        'type'    => 'export',
                        'attr'    => array( 'rows' => '10', 'style' => 'width:100%' ),
                        'default' => '',
                    ),
                    array(
                        'name'    => __('Import Data', 'omega-admin-td'),
                        'id'      => 'data_import',
                        'type'    => 'import',
                        'attr'    => array( 'rows' => '10', 'style' => 'width:100%' ),
                        'default' => '',
                    )
                )
            )
        )
    ));

    $oxy_theme->register_option_page( array(
        'page_title' => __('WooCommerce', 'omega-admin-td'),
        'menu_title' => __('WooCommerce', 'omega-admin-td'),
        'slug'       => THEME_SHORT . '-woocommerce',
        'main_menu'  => false,
        'icon'       => 'tools',
        'sections'   => array(
            'woo-general' => array(
                'title'   => __('General WooCommerce Page Options', 'omega-admin-td'),
                'header'  => __('Change the way your shop page looks with these options.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('General Shop Swatch', 'omega-admin-td'),
                        'desc'    => __('Choose a general colour scheme to use for your WooCommerce site.', 'omega-admin-td'),
                        'id'      => 'woocom_general_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-white',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                )
            ),
            'woo-shop-section' => array(
                'title'   => __('Shop Page', 'omega-admin-td'),
                'header'  => __('Setup the layout of your Shop.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Shop Layout', 'omega-admin-td'),
                        'desc'    => __('Layout of your shop page. Choose among right sidebar, left sidebar, fullwidth layout', 'omega-admin-td'),
                        'id'      => 'shop_layout',
                        'type'    => 'radio',
                        'options' => array(
                            'sidebar-right' => __('Right Sidebar', 'omega-admin-td'),
                            'full-width'    => __('Full Width', 'omega-admin-td'),
                            'sidebar-left'  => __('Left Sidebar', 'omega-admin-td'),
                        ),
                        'default' => 'full-width',
                    )
                )
            ),
            'woo-shop-checkout-sidebar' => array(
                'title'   => __('Checkout Sidebar', 'omega-admin-td'),
                'header'  => __('Change the way your sidebar looks with these options.', 'omega-admin-td'),
                'fields' => array(
                     array(
                        'name'      => __('Sidebar Enabled', 'omega-admin-td'),
                        'id'        => 'woo_cart_popup',
                        'type'      => 'radio',
                        'default'   =>  'show',
                        'desc'    => __('When you click on the cart widget the sidebar will appear, if disabled you will be taken to the cart page.', 'omega-admin-td'),
                        'options' => array(
                            'hide' => __('Disabled', 'omega-admin-td'),
                            'show' => __('Enabled', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Checkout Slide Sidebar Swatch', 'omega-admin-td'),
                        'desc'    => __('Choose a color swatch for the cart that slides in from the side.', 'omega-admin-td'),
                        'id'      => 'pageslide_cart_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-white',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                )
            ),
            'woo-single-product-page' => array(
                'title'  => __('Product Details', 'omega-admin-td'),
                'header' => __('Setup your products page details', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Social Networks', 'omega-admin-td'),
                        'desc'    => __('Select which social networks you would like to share products on.', 'omega-admin-td'),
                        'id'      => 'woo_social_networks',
                        'default' =>  array( 'facebook', 'twitter', 'google', 'pinterest' ),
                        'type'    => 'select',
                        'attr' => array(
                            'multiple' => '',
                            'style' => 'height:100px'
                        ),
                        'options' => array(
                            'facebook'  => __('Facebook', 'omega-admin-td'),
                            'twitter'   => __('Twitter', 'omega-admin-td'),
                            'google'    => __('Google+', 'omega-admin-td'),
                            'pinterest' => __('Pinterest', 'omega-admin-td'),
                            'none'      => __('None', 'omega-admin-td'),
                        )
                    ),
                ),
            ),
        )
    ));
    $oxy_theme->register_option_page( array(
        'page_title' => __('Default Site Colours', 'omega-admin-td'),
        'menu_title' => __('Colours', 'omega-admin-td'),
        'slug'       => THEME_SHORT . '-default-colours',
        'main_menu'  => false,
        'icon'       => 'tools',
        'javascripts' => array(
            array(
                'handle' => 'default-swatches',
                'src'    => OXY_THEME_URI . 'inc/options/javascripts/pages/default-swatches.js',
                'deps'   => array( 'jquery' ),
                'localize' => array(
                    'object_handle' => 'localData',
                    'data' => array(
                        'ajaxurl' => admin_url( 'admin-ajax.php' ),
                        'installDefaultsNonce'  => wp_create_nonce( 'install-defaults' )
                    )
                ),
            ),
        ),
        'sections'   => array(
            'default-swatch-section' => array(
                'title' => __('Default Swatches Install', 'omega-admin-td'),
                'header'  => __('Re-install the themes default swatches here. <strong>Warning this will remove any modifications you have made to the default swatches</strong>', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'      =>  __('Re-install Default Swatches', 'omega-admin-td'),
                        'button-text' => __('Install Defaults', 'omega-admin-td'),
                        'desc'    => __('This button will reinstall all the default swatches for the site.', 'omega-admin-td'),
                        'id'        => 'install_defaults',
                        'type'      => 'button',
                        'attr'        => array(
                            'id'    => 'install-default-swatches',
                            'class' => 'button button-primary'
                        ),
                    ),
                )
            ),
            'save-all-swatch-section' => array(
                'title' => __('Save all swatches', 'omega-admin-td'),
                'header'  => __('This option will re-save all your enabled swatches.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'      =>  __('Save All Swatches', 'omega-admin-td'),
                        'button-text' => __('Save Swatches', 'omega-admin-td'),
                        'desc'    => __('This button will re-save all swatches.', 'omega-admin-td'),
                        'id'        => 'save_all_swatches',
                        'type'      => 'button',
                        'attr'        => array(
                            'id'    => 'save-all-swatches',
                            'class' => 'button button-primary'
                        ),
                    ),
                )
            ),
            'default-button-colours-section' => array(
                'title'   => __('Default Contextual Colours', 'omega-admin-td'),
                'header'  => __('Set the default bootstrap context colours here. For example see buttons <a target="_blank" href="http://getbootstrap.com/css/#buttons">Bootstrap docs here</a>.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Text Colour', 'omega-admin-td'),
                        'id'      => 'default_css_default_button_text',
                        'desc'    => __('Text colour to use for the default context.', 'omega-admin-td'),
                        'default' => '#FFF',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Background Colour', 'omega-admin-td'),
                        'id'      => 'default_css_default_button_background',
                        'desc'    => __('Background colour to use for the default context.', 'omega-admin-td'),
                        'default' => '#6C6C6A',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Background Hover Colour', 'omega-admin-td'),
                        'id'      => 'default_css_default_button_background_hover',
                        'desc'    => __('Background colour when user hovers over the default context.', 'omega-admin-td'),
                        'default' => '#404040',
                        'type'    => 'colour',
                    ),
                )
            ),
            'warning-button-colours-section' => array(
                'title'   => __('Warning Button Colours', 'omega-admin-td'),
                'header'  => __('Set the warning bootstrap context colours here. For example see buttons <a target="_blank" href="http://getbootstrap.com/css/#buttons">Bootstrap docs here</a>.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Warning Context - Text Colour', 'omega-admin-td'),
                        'id'      => 'default_css_warning_button_text',
                        'desc'    => __('Text colour to use for the warning context.', 'omega-admin-td'),
                        'default' => '#FFFFFF',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Warning Context - Background Colour', 'omega-admin-td'),
                        'id'      => 'default_css_warning_button_background',
                        'desc'    => __('Background colour to use for the warning context.', 'omega-admin-td'),
                        'default' => '#f0ad4e',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Warning Context - Background Hover Colour', 'omega-admin-td'),
                        'id'      => 'default_css_warning_button_background_hover',
                        'desc'    => __('Background colour when user hovers over the warning context.', 'omega-admin-td'),
                        'default' => '#ed9c28',
                        'type'    => 'colour',
                    ),
                )
            ),
            'danger-button-colours-section' => array(
                'title'   => __('Danger Button Colours', 'omega-admin-td'),
                'header'  => __('Set the danger bootstrap context colours here. For example see buttons <a target="_blank" href="http://getbootstrap.com/css/#buttons">Bootstrap docs here</a>.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Danger Context - Text Colour', 'omega-admin-td'),
                        'id'      => 'default_css_danger_button_text',
                        'desc'    => __('Text colour to use for the danger context.', 'omega-admin-td'),
                        'default' => '#FFFFFF',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Danger Context - Background Colour', 'omega-admin-td'),
                        'id'      => 'default_css_danger_button_background',
                        'desc'    => __('Background colour to use for the danger context.', 'omega-admin-td'),
                        'default' => '#e74c3c',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Danger Context - Background Hover Colour', 'omega-admin-td'),
                        'id'      => 'default_css_danger_button_background_hover',
                        'desc'    => __('Background colour when user hovers over the danger context.', 'omega-admin-td'),
                        'default' => '#d62c1a',
                        'type'    => 'colour',
                    ),
                )
            ),
            'success-button-colours-section' => array(
                'title'   => __('Success Button Colours', 'omega-admin-td'),
                'header'  => __('Set the success bootstrap context colours here. For example see buttons <a target="_blank" href="http://getbootstrap.com/css/#buttons">Bootstrap docs here</a>.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Success Context - Text Colour', 'omega-admin-td'),
                        'id'      => 'default_css_success_button_text',
                        'desc'    => __('Text colour to use for the success context.', 'omega-admin-td'),
                        'default' => '#FFFFFF',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Success Context - Background Colour', 'omega-admin-td'),
                        'id'      => 'default_css_success_button_background',
                        'desc'    => __('Background colour to use for the success context.', 'omega-admin-td'),
                        'default' => '#a3c36f',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Success Context - Background Hover Colour', 'omega-admin-td'),
                        'id'      => 'default_css_success_button_background_hover',
                        'desc'    => __('Background colour when user hovers over the success context.', 'omega-admin-td'),
                        'default' => '#b7d685',
                        'type'    => 'colour',
                    ),
                )
            ),
            'info-button-colours-section' => array(
                'title'   => __('Info Button Colours', 'omega-admin-td'),
                'header'  => __('Set the info bootstrap context colours here. For example see buttons <a target="_blank" href="http://getbootstrap.com/css/#buttons">Bootstrap docs here</a>.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Info Context - Text Colour', 'omega-admin-td'),
                        'id'      => 'default_css_info_button_text',
                        'desc'    => __('Text colour to use for the info context.', 'omega-admin-td'),
                        'default' => '#FFF',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Info Context - Background Colour', 'omega-admin-td'),
                        'id'      => 'default_css_info_button_background',
                        'desc'    => __('Background colour to use for the info context.', 'omega-admin-td'),
                        'default' => '#5d89ac',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Info Context - Background Hover Colour', 'omega-admin-td'),
                        'id'      => 'default_css_info_button_background_hover',
                        'desc'    => __('Background colour when user hovers over the info context.', 'omega-admin-td'),
                        'default' => '#486f8e',
                        'type'    => 'colour',
                    ),
                )
            ),
            'icon-button-colours-section' => array(
                'title'   => __('Button Icon Colours', 'omega-admin-td'),
                'header'  => __('Set the colours used for icons when used in buttons.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Button Icon Colour', 'omega-admin-td'),
                        'id'      => 'default_css_button_icon',
                        'desc'    => __('Text colour to use for icons when used inside buttons.', 'omega-admin-td'),
                        'default' => '#FFFFFF',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Button Icon Background Colour', 'omega-admin-td'),
                        'id'      => 'default_css_button_icon_background',
                        'desc'    => __('Background colour to be used in fancy buttons.', 'omega-admin-td'),
                        'default' => '#FFF',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Button icon Background Opacity %', 'omega-admin-td'),
                        'desc'    => __('How see through is the overlay in percentage.', 'omega-admin-td'),
                        'id'      => 'default_css_button_icon_background_alpha',
                        'type'    => 'slider',
                        'default' => 20,
                        'attr'    => array(
                            'max'  => 100,
                            'min'  => 0,
                            'step' => 1
                        )
                    ),
                )
            ),
            'overlays-colours-section' => array(
                'title'   => __('Overlay Colours', 'omega-admin-td'),
                'header'  => __('Set the colours used in overlay areas.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Overlay Text', 'omega-admin-td'),
                        'id'      => 'default_css_overlay',
                        'desc'    => __('Text colour to text inside overlay areas.', 'omega-admin-td'),
                        'default' => '#FFF',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Overlay Background Colour', 'omega-admin-td'),
                        'id'      => 'default_css_overlay_background',
                        'desc'    => __('Background colour to be used in overlay areas.', 'omega-admin-td'),
                        'default' => '#000',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Overlay Background Opacity %', 'omega-admin-td'),
                        'desc'    => __('How see through is the overlay in percentage.', 'omega-admin-td'),
                        'id'      => 'default_css_overlay_background_alpha',
                        'type'    => 'slider',
                        'default' => 50,
                        'attr'    => array(
                            'max'  => 100,
                            'min'  => 0,
                            'step' => 1
                        )
                    ),

                )
            ),
            'magnific-colours-section' => array(
                'title'   => __('Magnific (image lightbox) Colours ', 'omega-admin-td'),
                'header'  => __('Set the colours used in overlay when an image preview is clicked.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Preview Background Colour', 'omega-admin-td'),
                        'id'      => 'default_css_magnific_background',
                        'desc'    => __('Background colour to be used in overlay areas.', 'omega-admin-td'),
                        'default' => '#FFF',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Preview Background Opacity %', 'omega-admin-td'),
                        'desc'    => __('How see through is the overlay in percentage.', 'omega-admin-td'),
                        'id'      => 'default_css_magnific_background_alpha',
                        'type'    => 'slider',
                        'default' => 95,
                        'attr'    => array(
                            'max'  => 100,
                            'min'  => 0,
                            'step' => 1
                        )
                    ),
                    array(
                        'name'    => __('Close Button Icon Colour', 'omega-admin-td'),
                        'id'      => 'default_css_magnific_close_icon',
                        'desc'    => __('Text colour to use for preview close button icon.', 'omega-admin-td'),
                        'default' => '#FFF',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Close Button Icon Background Colour', 'omega-admin-td'),
                        'id'      => 'default_css_magnific_close_icon_background',
                        'desc'    => __('Background colour to be used for preview close button.', 'omega-admin-td'),
                        'default' => '#000000',
                        'type'    => 'colour',
                    ),
                )
            ),
            'portfolio-colours-section' => array(
                'title'   => __('Portfolio Hover Colours ', 'omega-admin-td'),
                'header'  => __('Set the colours used in portfolios when you hover over an item.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Hover Text', 'omega-admin-td'),
                        'id'      => 'default_css_portfolio_hover_text',
                        'desc'    => __('Text colour to use inside hover .', 'omega-admin-td'),
                        'default' => '#FFF',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Hover Background Colour', 'omega-admin-td'),
                        'id'      => 'default_css_portfolio_hover_background',
                        'desc'    => __('Background colour to be used when user hovers over item.', 'omega-admin-td'),
                        'default' => '#000',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Hover Background Opacity %', 'omega-admin-td'),
                        'desc'    => __('How see through is the hover overlay in percentage.', 'omega-admin-td'),
                        'id'      => 'default_css_portfolio_hover_background_alpha',
                        'type'    => 'slider',
                        'default' => 50,
                        'attr'    => array(
                            'max'  => 100,
                            'min'  => 0,
                            'step' => 1
                        )
                    ),
                    array(
                        'name'    => __('Hover Button Icon Colour', 'omega-admin-td'),
                        'id'      => 'default_css_portfolio_hover_button_icon',
                        'desc'    => __('Icon colour to use for bottom buttons shown on hover.', 'omega-admin-td'),
                        'default' => '#FFF',
                        'type'    => 'colour',
                    ),
                )
            ),
            'go-to-top-colours-section' => array(
                'title'   => __('Go to top button Colours ', 'omega-admin-td'),
                'header'  => __('Set the colours used in go to top button that appears on scrolling a page.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Button Icon Colour', 'omega-admin-td'),
                        'id'      => 'default_css_gototop_icon',
                        'desc'    => __('Icon colour to use for go to top button.', 'omega-admin-td'),
                        'default' => '#FFF',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Button Background Colour', 'omega-admin-td'),
                        'id'      => 'default_css_gototop_background',
                        'desc'    => __('Background colour to use for go to top button.', 'omega-admin-td'),
                        'default' => '#000000',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Button Background Opacity %', 'omega-admin-td'),
                        'desc'    => __('How see through is the go to top button in percentage.', 'omega-admin-td'),
                        'id'      => 'default_css_gototop_background_alpha',
                        'type'    => 'slider',
                        'default' => 100,
                        'attr'    => array(
                            'max'  => 100,
                            'min'  => 0,
                            'step' => 1
                        )
                    ),
                )
            ),
            'loader-colours-section' => array(
                'title'   => __('Loader Colours ', 'omega-admin-td'),
                'header'  => __('Set the colours of the loader.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Loader Colour', 'omega-admin-td'),
                        'id'      => 'loader_color',
                        'desc'    => __('Color of the loader', 'omega-admin-td'),
                        'default' => '#82c9ed',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Loader background', 'omega-admin-td'),
                        'id'      => 'loader_bg',
                        'desc'    => __('Background colour of the loader.', 'omega-admin-td'),
                        'default' => '#ffffff',
                        'type'    => 'colour',
                        'format'  => 'rgba'
                    )
                )
            ),
            'slideshow-colours-section' => array(
                'title'   => __('Slideshow Colours ', 'omega-admin-td'),
                'header'  => __('Set the colours used in carousel and flexslider.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Text & Controls Colour', 'omega-admin-td'),
                        'id'      => 'default_css_slideshow_text',
                        'desc'    => __('Colour to use for slideshow text & control icons.', 'omega-admin-td'),
                        'default' => '#FFF',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Text Shadow', 'omega-admin-td'),
                        'id'      => 'default_css_slideshow_text_shadow',
                        'desc'    => __('Shadow colour to use on the slideshow captions.', 'omega-admin-td'),
                        'default' => '#000000',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Text Shadow Opacity %', 'omega-admin-td'),
                        'desc'    => __('Opacity of shadow used on slideshow captions.', 'omega-admin-td'),
                        'id'      => 'default_css_slideshow_text_shadow_alpha',
                        'type'    => 'slider',
                        'default' => 20,
                        'attr'    => array(
                            'max'  => 100,
                            'min'  => 0,
                            'step' => 1
                        )
                    ),
                )
            )
        )
    ));
    $oxy_theme->register_option_page(array(
        'page_title' => __('Typography Settings', 'omega-admin-td'),
        'menu_title' => __('Typography', 'omega-admin-td'),
        'slug'       => THEME_SHORT . '-typography',
        'main_menu'  => false,
        'icon'       => 'tools',
        'stylesheets' => array(
            array(
                'handle' => 'typography-page',
                'src'    => OXY_THEME_URI . 'vendor/oxygenna/oxygenna-typography/assets/css/typography-page.css',
                'deps'   => array('oxy-typography-select2', 'thickbox'),
            ),
        ),
        'javascripts' => array(
            array(
                'handle' => 'typography-page',
                'src'    => OXY_THEME_URI . 'vendor/oxygenna/oxygenna-typography/assets/javascripts/typography-page.js',
                'deps'   => array('jquery', 'underscore', 'thickbox', 'oxy-typography-select2', 'jquery-ui-dialog'),
                'localize' => array(
                    'object_handle' => 'typographyPage',
                    'data' => array(
                        'ajaxurl' => admin_url('admin-ajax.php'),
                        'listNonce'  => wp_create_nonce('list-fontstack'),
                        'fontModal'  => wp_create_nonce('font-modal'),
                        'updateNonce'  => wp_create_nonce('update-fontstack'),
                        'defaultFontsNonce' => wp_create_nonce('default-fonts'),
                    )
                )
            ),
        ),
        // include a font stack option to enqueue select 2 ok
        'sections'   => array(
            'font-section' => array(
                'title'   => __('Fonts settings section', 'omega-admin-td'),
                'header'  => __('Setup Fonts settings here.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name' => __('Font Stack:', 'omega-admin-td'),
                        'id' => 'font_list',
                        'type' => 'fontlist',
                        'class-file' => OXY_THEME_DIR . 'vendor/oxygenna/oxygenna-typography/inc/options/font-list.php',
                    ),
                )
            )
        )
    ));

    $oxy_theme->register_option_page(array(
        'page_title' => __('Fonts', 'omega-admin-td'),
        'menu_title' => __('Fonts', 'omega-admin-td'),
        'slug'       => THEME_SHORT . '-fonts',
        'main_menu'  => false,
        'icon'       => 'tools',
        'sections'   => array(
            'google-fonts-section' => array(
                'title'   => __('Google Fonts', 'omega-admin-td'),
                // 'header'  => __('Setup Your Google Fonts Here.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'        => __('Fetch Google Fonts', 'omega-admin-td'),
                        'button-text' => __('Update Fonts', 'omega-admin-td'),
                        'id'          => 'google_update_fonts_button',
                        'type'        => 'button',
                        'desc'        => __('Click this button to fetch the latest fonts from Google and update your Google Fonts list.', 'omega-admin-td'),
                        'attr'        => array(
                            'id'    => 'google-update-fonts-button',
                            'class' => 'button button-primary'
                        ),
                        'javascripts' => array(
                            array(
                                'handle' => 'google-font-updater',
                                'src'    => OXY_THEME_URI . 'vendor/oxygenna/oxygenna-typography/assets/javascripts/options/google-font-updater.js',
                                'deps'   => array('jquery'),
                                'localize' => array(
                                    'object_handle' => 'googleUpdate',
                                    'data' => array(
                                        'ajaxurl'   => admin_url('admin-ajax.php'),
                                        // generate a nonce with a unique ID "myajax-post-comment-nonce"
                                        // so that you can check it later when an AJAX request is sent
                                        'nonce'     => wp_create_nonce('google-fetch-fonts-nonce'),
                                    )
                                )
                            ),
                        ),
                    )
                )
            ),
            'typekit-provider-options' => array(
                'title'   => __('TypeKit Fonts', 'omega-admin-td'),
                'header'  => __('If you have a TypeKit account and would like to use it in your site.  Enter your TypeKit API key below and then click the Update your kits button.', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name' => __('Typekit API Token', 'omega-admin-td'),
                        'desc' => __('Add your typekit api token here', 'omega-admin-td'),
                        'id'   => 'typekit_api_token',
                        'type' => 'text',
                        'attr'        => array(
                            'id'    => 'typekit-api-key',
                        )
                    ),
                    array(
                        'name'        => __('TypeKit Kits', 'omega-admin-td'),
                        'button-text' => __('Update your kits', 'omega-admin-td'),
                        'desc' => __('Click this button to update your typography list with the kits available from your TypeKit account.', 'omega-admin-td'),
                        'id'          => 'typekit_kits_button',
                        'type'        => 'button',
                        'attr'        => array(
                            'id'    => 'typekit-kits-button',
                            'class' => 'button button-primary'
                        ),
                        'javascripts' => array(
                            array(
                                'handle' => 'typekit-kit-updater',
                                'src'    => OXY_THEME_URI . 'vendor/oxygenna/oxygenna-typography/assets/javascripts/options/typekit-updater.js',
                                'deps'   => array('jquery' ),
                                'localize' => array(
                                    'object_handle' => 'typekitUpdate',
                                    'data' => array(
                                        'ajaxurl'   => admin_url('admin-ajax.php'),
                                        'nonce'     => wp_create_nonce('typekit-kits-nonce'),
                                    )
                                )
                            ),
                        ),
                    )
                )
            )
        )
    ));
}
