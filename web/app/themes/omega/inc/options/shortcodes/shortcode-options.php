<?php
/**
 * Sets up all theme shortcode options
 *
 * @package Omega
 * @subpackage Frontend
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.12
 */

// get available menus for menu shortcode
$menus_data = get_terms('nav_menu');
$menus = array();
$menus[''] = __('Please select a menu', 'omega-admin-td');
foreach ($menus_data as $single_menu) {
    $menus[$single_menu->slug] = $single_menu->name;
}

return array(
    // SECTION
    'vc_row' => array(
        'shortcode'     => 'vc_row',
        'title'         => __('Row', 'omega-admin-td'),
        'desc'          => __('A Horizontal section to add content to.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => true,
        'sections'      => array(
            array(
                'title' => __('Section', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/section-options.php'
            )
        )
    ),
    'vc_row_inner' => array(
        'shortcode'     => 'vc_row_inner',
        'title'         => __('Row', 'omega-admin-td'),
        'desc'          => __('A Horizontal section to add content to.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => true,
        'sections'      => array(
            array(
                'title' => __('General', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Extra Classes', 'omega-admin-td'),
                        'desc'    => __('Add any extra classes you need to add to this column. ( space separated )', 'omega-admin-td'),
                        'id'      => 'extra_classes',
                        'default'     =>  '',
                        'type'        => 'text',
                    ),
                )
            )
        )
    ),
    // SECTION
    'vc_column' => array(
        'shortcode'     => 'vc_column',
        'title'         => __('Column', 'omega-admin-td'),
        'desc'          => __('Column shortcode for use inside a row.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => true,
        'sections'      => array(
            array(
                'title' => __('General', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Column Alignment', 'omega-admin-td'),
                        'id'        => 'align',
                        'type'      => 'select',
                        'default'   => 'default',
                        'options' => array(
                            'Default' => __('Default (no class)', 'omega-admin-td'),
                            'left'    => __('Left', 'omega-admin-td'),
                            'center'  => __('Center', 'omega-admin-td'),
                            'right'   => __('Right', 'omega-admin-td'),
                        ),
                        'desc'    => __('Sets the alignment items in the column.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Column Background Color', 'omega-admin-td'),
                        'desc'      => __('Set the background color of the column', 'omega-admin-td'),
                        'id'        => 'column_colour',
                        'type'      => 'colour',
                        'format'    => 'rgba',
                        'default'   => '',
                        'attr'      => array(
                            'class' => 'allow-empty'
                        )
                    ),
                    array(
                        'name'      => __('Small screens Column Alignment', 'omega-admin-td'),
                        'id'        => 'align_sm',
                        'type'      => 'select',
                        'default'   => 'default',
                        'options' => array(
                            'Default' => __('Default (no class)', 'omega-admin-td'),
                            'left'    => __('Left', 'omega-admin-td'),
                            'center'  => __('Center', 'omega-admin-td'),
                            'right'   => __('Right', 'omega-admin-td'),
                        ),
                        'desc'    => __('Overrides the alignment in the column on small screens.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Mobile Column Span', 'omega-admin-td'),
                        'desc'      => __('Size of column to use on mobile sized displays (<768px) as a fraction of the 12-grid row', 'omega-admin-td'),
                        'id'        => 'xs_col',
                        'type'      => 'select',
                        'default'   => 'default',
                        'options'   => array(
                            'default' => __('Default', 'omega-admin-td'),
                            '1'       => __('1/12', 'omega-admin-td'),
                            '2'       => __('2/12', 'omega-admin-td'),
                            '3'       => __('3/12', 'omega-admin-td'),
                            '4'       => __('4/12', 'omega-admin-td'),
                            '5'       => __('5/12', 'omega-admin-td'),
                            '6'       => __('6/12', 'omega-admin-td'),
                            '7'       => __('7/12', 'omega-admin-td'),
                            '8'       => __('8/12', 'omega-admin-td'),
                            '9'       => __('9/12', 'omega-admin-td'),
                            '10'      => __('10/12', 'omega-admin-td'),
                            '11'      => __('11/12', 'omega-admin-td'),
                            '12'      => __('12/12', 'omega-admin-td')
                        ),
                    ),
                    array(
                        'name'      => __('Tablet Column Span', 'omega-admin-td'),
                        'desc'      => __('Size of column to use on tablet sized displays (>=768px <991px) as a fraction of the 12-grid row', 'omega-admin-td'),
                        'id'        => 'sm_col',
                        'type'      => 'select',
                        'default'   => 'default',
                        'options'   => array(
                            'default' => __('Default', 'omega-admin-td'),
                            '1'       => __('1/12', 'omega-admin-td'),
                            '2'       => __('2/12', 'omega-admin-td'),
                            '3'       => __('3/12', 'omega-admin-td'),
                            '4'       => __('4/12', 'omega-admin-td'),
                            '5'       => __('5/12', 'omega-admin-td'),
                            '6'       => __('6/12', 'omega-admin-td'),
                            '7'       => __('7/12', 'omega-admin-td'),
                            '8'       => __('8/12', 'omega-admin-td'),
                            '9'       => __('9/12', 'omega-admin-td'),
                            '10'      => __('10/12', 'omega-admin-td'),
                            '11'      => __('11/12', 'omega-admin-td'),
                            '12'      => __('12/12', 'omega-admin-td')
                        ),
                    ),
                    array(
                        'name'      => __('Large Desktop Column Span', 'omega-admin-td'),
                        'desc'      => __('Size of column to use on large desktop displays (>1200x) as a fraction of the 12-grid row', 'omega-admin-td'),
                        'id'        => 'lg_col',
                        'type'      => 'select',
                        'default'   => 'default',
                        'options'   => array(
                            'default' => __('Default', 'omega-admin-td'),
                            '1'       => __('1/12', 'omega-admin-td'),
                            '2'       => __('2/12', 'omega-admin-td'),
                            '3'       => __('3/12', 'omega-admin-td'),
                            '4'       => __('4/12', 'omega-admin-td'),
                            '5'       => __('5/12', 'omega-admin-td'),
                            '6'       => __('6/12', 'omega-admin-td'),
                            '7'       => __('7/12', 'omega-admin-td'),
                            '8'       => __('8/12', 'omega-admin-td'),
                            '9'       => __('9/12', 'omega-admin-td'),
                            '10'      => __('10/12', 'omega-admin-td'),
                            '11'      => __('11/12', 'omega-admin-td'),
                            '12'      => __('12/12', 'omega-admin-td')
                        ),
                    ),
                    array(
                        'name'    => __('Extra Classes', 'omega-admin-td'),
                        'desc'    => __('Add any extra classes you need to add to this column. ( space separated )', 'omega-admin-td'),
                        'id'      => 'extra_classes',
                        'default'     =>  '',
                        'type'        => 'text',
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/animation-options.php'
            )
        )
    ),
    'heading' => array(
        'shortcode'     => 'heading',
        'title'         => __('Heading', 'omega-admin-td'),
        'desc'          => __('Creates a heading and optional sub heading.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => true,
        'sections'      => array(
            array(
                'title' => __('Header', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/heading-options.php'
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/animation-options.php'
            )
        )
    ),
    'service' => array(
        'shortcode'     => 'service',
        'title'         => __('Single Service', 'omega-admin-td'),
        'desc'          => __('Displays a single service.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Services', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Service', 'omega-admin-td'),
                        'desc'    => __('Select a service post to show.', 'omega-admin-td'),
                        'id'      => 'service',
                        'default' =>  '',
                        'admin_label' => true,
                        'type'    => 'select',
                        'options' => 'custom_post_type',
                        'post_type' => 'oxy_service'
                    ),
                    array(
                        'name'      =>  __('Image Shape', 'omega-admin-td'),
                        'id'        => 'image_shape',
                        'type'      => 'select',
                        'admin_label' => true,
                        'options'   =>  array(
                            'round'  => __('Circle', 'omega-admin-td'),
                            'square' => __('Square', 'omega-admin-td'),
                            'rect'   => __('Rectangle', 'omega-admin-td'),
                        ),
                        'default'   => 'round',
                    ),
                    array(
                        'name'      =>  __('Shape Size', 'omega-admin-td'),
                        'id'        => 'image_size',
                        'type'      => 'select',
                        'options'   =>  array(
                            'big'    => __('Big', 'omega-admin-td'),
                            'huge'   => __('Huge', 'omega-admin-td'),
                            'normal' => __('Normal', 'omega-admin-td'),
                            'medium' => __('Medium', 'omega-admin-td'),
                            'small'  => __('Small', 'omega-admin-td'),
                        ),
                        'default'   => 'big',
                    ),
                    array(
                        'name'      => __('Icon Color', 'omega-admin-td'),
                        'desc'      => __('Set the color of the icon ( svg & font awesome icons )', 'omega-admin-td'),
                        'id'        => 'icon_colour',
                        'type'      => 'colour',
                        'default'   => '#000000',
                    ),
                    array(
                        'name'    => __('Icon Animation', 'omega-admin-td'),
                        'desc'    => __('Icon Animation that will occur when you hover over the service shape.', 'omega-admin-td'),
                        'id'      => 'icon_animation',
                        'type'    => 'select',
                        'default' => 'bounce',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/animations.php'
                    ),
                    array(
                        'name'      =>  __('Hover effect', 'omega-admin-td'),
                        'id'        => 'icon_effect',
                        'desc'      => __('Change the icon/background colors on hover', 'omega-admin-td'),
                        'type'      => 'select',
                        'options' => array(
                            'on'  => __('On', 'omega-admin-td'),
                            'off' => __('Off', 'omega-admin-td'),
                        ),
                        'default'   => 'on',
                    ),
                    array(
                        'name'      => __('Background Color', 'omega-admin-td'),
                        'desc'      => __('Set the color shape background.', 'omega-admin-td'),
                        'id'        => 'background_colour',
                        'type'      => 'colour',
                        'default'   => '#e9e9e9',
                    ),
                    array(
                        'name'      => __('Shape Background Grid', 'omega-admin-td'),
                        'desc'      => __('Adds a grid pattern to the shape background.', 'omega-admin-td'),
                        'id'        => 'overlay_grid',
                        'type'      => 'slider',
                        'default'   => '0',
                        'attr'      => array(
                            'max'       => 100,
                            'min'       => 0,
                            'step'      => 10,
                        )
                    ),
                    array(
                        'name'      => __('Show Image', 'omega-admin-td'),
                        'id'        => 'show_image',
                        'type'      => 'select',
                        'default'   =>  'show',
                        'options' => array(
                            'show'  => __('Show', 'omega-admin-td'),
                            'hide' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Link Image', 'omega-admin-td'),
                        'id'        => 'link_image',
                        'type'      => 'select',
                        'default'   =>  'on',
                        'options' => array(
                            'on'  => __('On', 'omega-admin-td'),
                            'off' => __('Off', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Show Titles', 'omega-admin-td'),
                        'id'        => 'show_title',
                        'type'      => 'select',
                        'default'   =>  'show',
                        'options' => array(
                            'show' => __('Show', 'omega-admin-td'),
                            'hide' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Link Title', 'omega-admin-td'),
                        'id'        => 'link_title',
                        'type'      => 'select',
                        'default'   =>  'on',
                        'options' => array(
                            'on'  => __('On', 'omega-admin-td'),
                            'off' => __('Off', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Link Font Size', 'omega-admin-td'),
                        'desc'    => __('Choose the size of the font to use in the title', 'omega-admin-td'),
                        'id'      => 'title_size',
                        'type'    => 'select',
                        'default'   =>  'normal',
                        'options' => array(
                            'normal'=> __('Normal', 'omega-admin-td'),
                            'big'   => __('Big (36px)', 'omega-admin-td'),
                            'bigger'=> __('Bigger (48px)', 'omega-admin-td'),
                            'super' => __('Super (60px)', 'omega-admin-td'),
                            'hyper' => __('Hyper (96px)', 'omega-admin-td'),
                        ),
                        'default' => 'normal',
                    ),
                    array(
                        'name'    => __('Title font Weight', 'omega-admin-td'),
                        'desc'    => __('Choose the weight of the font to use in the title', 'omega-admin-td'),
                        'id'      => 'title_weight',
                        'type'    => 'select',
                        'default'   =>  'regular',
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
                        'name'    => __('Underline', 'omega-admin-td'),
                        'desc'    => __('Underline the title.', 'omega-admin-td'),
                        'id'      => 'title_underline',
                        'type'    => 'select',
                        'default'   =>  'no-bordered',
                        'options' => array(
                            'bordered'    => __('Underline', 'omega-admin-td'),
                            'no-bordered' => __('No Underline', 'omega-admin-td')
                        ),
                    ),
                    array(
                        'name'    => __('Underline Size', 'omega-admin-td'),
                        'desc'    => __('Size of the underline.', 'omega-admin-td'),
                        'id'      => 'title_underline_size',
                        'default' => 'bordered-normal',
                        'type'    => 'select',
                        'options' => array(
                            'bordered-normal' => __('Normal (72px)', 'omega-admin-td'),
                            'bordered-small' => __('Small (48px)', 'omega-admin-td'),
                        )
                    ),
                    array(
                        'name'      => __('Show Excerpt', 'omega-admin-td'),
                        'id'        => 'show_excerpt',
                        'type'      => 'select',
                        'default'   =>  'show',
                        'options' => array(
                            'show' => __('Show', 'omega-admin-td'),
                            'hide' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Excerpt & More Text Alignment', 'omega-admin-td'),
                        'id'        => 'align',
                        'type'      => 'select',
                        'default'   => 'center',
                        'options' => array(
                            'default'   => __('Default alignment', 'omega-admin-td'),
                            'left'   => __('Left', 'omega-admin-td'),
                            'center' => __('Center', 'omega-admin-td'),
                            'right'  => __('Right', 'omega-admin-td'),
                            'justify'  => __('Justify', 'omega-admin-td')
                        ),
                        'desc'    => __('Sets the text alignment of the excerpt text and the read more link.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Show Readmore Link', 'omega-admin-td'),
                        'id'        => 'show_readmore',
                        'type'      => 'select',
                        'default'   =>  'hide',
                        'options' => array(
                            'hide' => __('Hide', 'omega-admin-td'),
                            'show' => __('Show', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Readmore Link Text', 'omega-admin-td'),
                        'id'      => 'readmore_text',
                        'type'    => 'text',
                        'default' => __('Read more', 'omega-admin-td'),
                        'desc'    => __('Customize your readmore link', 'omega-admin-td'),
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'services' =>array(
        'shortcode'     => 'services',
        'title'         => __('Services', 'omega-admin-td'),
        'desc'          => __('Displays a horizontal list of services.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Services', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Choose a category', 'omega-admin-td'),
                        'desc'    => __('Category of services to show', 'omega-admin-td'),
                        'id'      => 'category',
                        'default' =>  '',
                        'admin_label' => true,
                        'type'    => 'select',
                        'options' => 'taxonomy',
                        'taxonomy' => 'oxy_service_category',
                        'blank_label' => __('All Categories', 'omega-admin-td')
                    ),
                    array(
                        'name'    => __('Services Count', 'omega-admin-td'),
                        'desc'    => __('Number of services to show(set to 0 to show all)', 'omega-admin-td'),
                        'id'      => 'count',
                        'type'    => 'slider',
                        'default' => '3',
                        'admin_label' => true,
                        'attr'    => array(
                            'max'  => 30,
                            'min'  => 0,
                            'step' => 1
                        )
                    ),
                    array(
                        'name'    => __('Columns', 'omega-admin-td'),
                        'desc'    => __('Number of columns to show the services in', 'omega-admin-td'),
                        'id'      => 'columns',
                        'type'    => 'select',
                        'options' => array(
                            '2' => __('Two columns', 'omega-admin-td'),
                            '3' => __('Three columns', 'omega-admin-td'),
                            '4' => __('Four columns', 'omega-admin-td'),
                            '6' => __('Six columns', 'omega-admin-td'),
                        ),
                        'default' => '3',
                    ),
                    array(
                        'name'      =>  __('Image Shape', 'omega-admin-td'),
                        'id'        => 'image_shape',
                        'type'      => 'select',
                        'admin_label' => true,
                        'options'   =>  array(
                            'round'  => __('Circle', 'omega-admin-td'),
                            'square' => __('Square', 'omega-admin-td'),
                            'rect'   => __('Rectangle', 'omega-admin-td'),
                        ),
                        'default'   => 'round',
                    ),
                    array(
                        'name'      =>  __('Shape Size', 'omega-admin-td'),
                        'id'        => 'image_size',
                        'type'      => 'select',
                        'options'   =>  array(
                            'big'    => __('Big', 'omega-admin-td'),
                            'huge'   => __('Huge', 'omega-admin-td'),
                            'normal' => __('Normal', 'omega-admin-td'),
                            'medium' => __('Medium', 'omega-admin-td'),
                            'small'  => __('Small', 'omega-admin-td'),
                        ),
                        'default'   => 'big',
                    ),
                    array(
                        'name'      => __('Icon Color', 'omega-admin-td'),
                        'desc'      => __('Set the color of the icon ( svg & font awesome icons )', 'omega-admin-td'),
                        'id'        => 'icon_colour',
                        'type'      => 'colour',
                        'default'   => '#000000',
                    ),
                    array(
                        'name'    => __('Icon Animation', 'omega-admin-td'),
                        'desc'    => __('Icon Animation that will occur when you hover over the service shape.', 'omega-admin-td'),
                        'id'      => 'icon_animation',
                        'type'    => 'select',
                        'default' => 'bounce',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/animations.php'
                    ),
                    array(
                        'name'      =>  __('Hover effect', 'omega-admin-td'),
                        'id'        => 'icon_effect',
                        'desc'      => __('Change the icon/background colors on hover', 'omega-admin-td'),
                        'type'      => 'select',
                        'options' => array(
                            'on'  => __('On', 'omega-admin-td'),
                            'off' => __('Off', 'omega-admin-td'),
                        ),
                        'default'   => 'on',
                    ),
                    array(
                        'name'      => __('Background Color', 'omega-admin-td'),
                        'desc'      => __('Set the color shape background.', 'omega-admin-td'),
                        'id'        => 'background_colour',
                        'type'      => 'colour',
                        'default'   => '#e9e9e9',
                    ),
                    array(
                        'name'      => __('Shape Background Grid', 'omega-admin-td'),
                        'desc'      => __('Adds a grid pattern to the shape background.', 'omega-admin-td'),
                        'id'        => 'overlay_grid',
                        'type'      => 'slider',
                        'default'   => '0',
                        'attr'      => array(
                            'max'       => 100,
                            'min'       => 0,
                            'step'      => 10,
                        )
                    ),
                    array(
                        'name'      => __('Show Image', 'omega-admin-td'),
                        'id'        => 'show_image',
                        'type'      => 'select',
                        'default'   =>  'show',
                        'options' => array(
                            'show'  => __('Show', 'omega-admin-td'),
                            'hide' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Link Image', 'omega-admin-td'),
                        'id'        => 'link_image',
                        'type'      => 'select',
                        'default'   =>  'on',
                        'options' => array(
                            'on'  => __('On', 'omega-admin-td'),
                            'off' => __('Off', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Show Titles', 'omega-admin-td'),
                        'id'        => 'show_title',
                        'type'      => 'select',
                        'default'   =>  'show',
                        'options' => array(
                            'show' => __('Show', 'omega-admin-td'),
                            'hide' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Link Title', 'omega-admin-td'),
                        'id'        => 'link_title',
                        'type'      => 'select',
                        'default'   =>  'on',
                        'options' => array(
                            'on'  => __('On', 'omega-admin-td'),
                            'off' => __('Off', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Link Font Size', 'omega-admin-td'),
                        'desc'    => __('Choose the size of the font to use in the title', 'omega-admin-td'),
                        'id'      => 'title_size',
                        'type'    => 'select',
                        'default'   =>  'normal',
                        'options' => array(
                            'normal'=> __('Normal', 'omega-admin-td'),
                            'big'   => __('Big (36px)', 'omega-admin-td'),
                            'bigger'=> __('Bigger (48px)', 'omega-admin-td'),
                            'super' => __('Super (60px)', 'omega-admin-td'),
                            'hyper' => __('Hyper (96px)', 'omega-admin-td'),
                        ),
                        'default' => 'normal',
                    ),
                    array(
                        'name'    => __('Title font Weight', 'omega-admin-td'),
                        'desc'    => __('Choose the weight of the font to use in the title', 'omega-admin-td'),
                        'id'      => 'title_weight',
                        'type'    => 'select',
                        'default'   =>  'regular',
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
                        'name'    => __('Underline', 'omega-admin-td'),
                        'desc'    => __('Underline the title.', 'omega-admin-td'),
                        'id'      => 'title_underline',
                        'type'    => 'select',
                        'default'   =>  'no-bordered',
                        'options' => array(
                            'bordered'    => __('Underline', 'omega-admin-td'),
                            'no-bordered' => __('No Underline', 'omega-admin-td')
                        ),
                    ),
                    array(
                        'name'    => __('Underline Size', 'omega-admin-td'),
                        'desc'    => __('Size of the underline.', 'omega-admin-td'),
                        'id'      => 'title_underline_size',
                        'default' => 'bordered-normal',
                        'type'    => 'select',
                        'options' => array(
                            'bordered-normal' => __('Normal (72px)', 'omega-admin-td'),
                            'bordered-small' => __('Small (48px)', 'omega-admin-td'),
                        )
                    ),
                    array(
                        'name'      => __('Show Excerpt', 'omega-admin-td'),
                        'id'        => 'show_excerpt',
                        'type'      => 'select',
                        'default'   =>  'show',
                        'options' => array(
                            'show' => __('Show', 'omega-admin-td'),
                            'hide' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Excerpt & More Text Alignment', 'omega-admin-td'),
                        'id'        => 'align',
                        'type'      => 'select',
                        'default'   => 'center',
                        'options' => array(
                            'default'   => __('Default alignment', 'omega-admin-td'),
                            'left'   => __('Left', 'omega-admin-td'),
                            'center' => __('Center', 'omega-admin-td'),
                            'right'  => __('Right', 'omega-admin-td'),
                            'justify'  => __('Justify', 'omega-admin-td'),
                        ),
                        'desc'    => __('Sets the text alignment of the excerpt text and the read more link.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Show Readmore Link', 'omega-admin-td'),
                        'id'        => 'show_readmore',
                        'type'      => 'select',
                        'default'   =>  'hide',
                        'options' => array(
                            'hide' => __('Hide', 'omega-admin-td'),
                            'show' => __('Show', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Readmore Link Text', 'omega-admin-td'),
                        'id'      => 'readmore_text',
                        'type'    => 'text',
                        'default' => __('Read more', 'omega-admin-td'),
                        'desc'    => __('Customize your readmore link', 'omega-admin-td'),
                    ),
                    array(
                        'name'        => __('Order by', 'omega-admin-td'),
                        'desc'        => __('Choose the way service items will be ordered.', 'omega-admin-td'),
                        'id'          => 'orderby',
                        'type'        => 'select',
                        'default'     =>  'none',
                        'options'     => array(
                            'none'        => __('None', 'omega-admin-td'),
                            'title'       => __('Title', 'omega-admin-td'),
                            'date'        => __('Date', 'omega-admin-td'),
                            'ID'          => __('ID', 'omega-admin-td'),
                            'author'      => __('Author', 'omega-admin-td'),
                            'modified'    => __('Last Modified', 'omega-admin-td'),
                            'menu_order'  => __('Menu Order', 'omega-admin-td'),
                            'rand'        => __('Random', 'omega-admin-td'),
                        )
                    ),
                    array(
                        'name'        => __('Order', 'omega-admin-td'),
                        'desc'        => __('Choose how services will be ordered.', 'omega-admin-td'),
                        'id'          => 'order',
                        'type'        => 'select',
                        'default'     =>  'ASC',
                        'options'     => array(
                            'ASC'     => __('Ascending', 'omega-admin-td'),
                            'DESC'    => __('Descending', 'omega-admin-td'),
                        )
                    )
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
     // TESTIMONIALS SHORTCODE SECTION
    'testimonials' => array(
        'shortcode' => 'testimonials',
        'title'     => __('Testimonials', 'omega-admin-td'),
        'desc'      => __('Displays a list / slideshow of testimonials.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'has_content'   => false,
        'sections'   => array(
            array(
                'title' => __('Testimonials', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Choose a group', 'omega-admin-td'),
                        'desc'    => __('Group of testimonials to show', 'omega-admin-td'),
                        'id'      => 'group',
                        'default' =>  '',
                        'type'    => 'select',
                        'admin_label' => true,
                        'admin_label' => true,
                        'options' => 'taxonomy',
                        'taxonomy' => 'oxy_testimonial_group',
                        'blank_label' => __('All Testimonials', 'omega-admin-td')
                    ),
                    array(
                        'name'    => __('Number Of Testimonials', 'omega-admin-td'),
                        'desc'    => __('Number of Testimonials to display(set to 0 to show all)', 'omega-admin-td'),
                        'id'      => 'count',
                        'type'    => 'slider',
                        'admin_label' => true,
                        'default' => '3',
                        'attr'    => array(
                            'max'   => 10,
                            'min'   => 0,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'    => __('Show avatars', 'omega-admin-td'),
                        'desc'    => __('Display the featured image as avatar', 'omega-admin-td'),
                        'id'      => 'show_image',
                        'type'    => 'select',
                        'default' => 'show',
                        'options' => array(
                            'show' => __('Show', 'omega-admin-td'),
                            'hide' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Speed', 'omega-admin-td'),
                        'desc'      => __('Set the speed of the slideshow cycling, in milliseconds', 'omega-admin-td'),
                        'id'        => 'speed',
                        'type'      => 'slider',
                        'default'   => '7000',
                        'attr'      => array(
                            'max'       => 15000,
                            'min'       => 2000,
                            'step'      => 1000
                        )
                    ),
                    array(
                        'name'    => __('Randomize', 'omega-admin-td'),
                        'desc'    => __('Randomize the ordering of the testimonials', 'omega-admin-td'),
                        'id'      => 'randomize',
                        'type'    => 'select',
                        'default' => 'off',
                        'options' => array(
                            'on'   => __('On', 'omega-admin-td'),
                            'off'  => __('Off', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Text Align', 'omega-admin-td'),
                        'id'        => 'text_align',
                        'type'      => 'select',
                        'default'   => 'center',
                        'options' => array(
                            'left'   => __('Left', 'omega-admin-td'),
                            'center' => __('Center', 'omega-admin-td'),
                            'right'  => __('Right', 'omega-admin-td'),
                            'justify'  => __('Justify', 'omega-admin-td'),
                        ),
                        'desc'    => __('Sets the text alignment of the blockquote and citation of the testimonial', 'omega-admin-td'),
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
     // TESTIMONIALS LIST SHORTCODE SECTION
    'testimonials_list' => array(
        'shortcode' => 'testimonials_list',
        'title'     => __('Testimonials List', 'omega-admin-td'),
        'desc'      => __('Displays a list of testimonials.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'has_content'   => false,
        'sections'   => array(
            array(
                'title' => __('Testimonials', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Choose a group', 'omega-admin-td'),
                        'desc'    => __('Group of testimonials to show', 'omega-admin-td'),
                        'id'      => 'group',
                        'default' =>  '',
                        'type'    => 'select',
                        'admin_label' => true,
                        'admin_label' => true,
                        'options' => 'taxonomy',
                        'taxonomy' => 'oxy_testimonial_group',
                        'blank_label' => __('All Testimonials', 'omega-admin-td')
                    ),
                    array(
                        'name'    => __('Number Of Testimonials', 'omega-admin-td'),
                        'desc'    => __('Number of Testimonials to display(set to 0 to show all)', 'omega-admin-td'),
                        'id'      => 'count',
                        'type'    => 'slider',
                        'admin_label' => true,
                        'default' => '3',
                        'attr'    => array(
                            'max'   => 10,
                            'min'   => 0,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'    => __('List Columns', 'omega-admin-td'),
                        'desc'    => __('Number of columns to show testimonials in', 'omega-admin-td'),
                        'id'      => 'columns',
                        'type'    => 'select',
                        'admin_label' => true,
                        'options' => array(
                            '1' => __('One column', 'omega-admin-td'),
                            '2' => __('Two columns', 'omega-admin-td'),
                            '3' => __('Three columns', 'omega-admin-td'),
                            '4' => __('Four columns', 'omega-admin-td'),
                            '6' => __('Six columns', 'omega-admin-td'),
                        ),
                        'default' => '3',
                    ),
                    array(
                        'name'    => __('Show avatars', 'omega-admin-td'),
                        'desc'    => __('Display the featured image as avatar', 'omega-admin-td'),
                        'id'      => 'show_image',
                        'type'    => 'select',
                        'default' => 'show',
                        'options' => array(
                            'show' => __('Show', 'omega-admin-td'),
                            'hide' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Animation Timing', 'omega-admin-td'),
                        'desc'    => __('Will animate all testimonials at once or each one individually .', 'omega-admin-td'),
                        'id'      => 'testimonial_scroll_animation_timing',
                        'type'    => 'select',
                        'default' => 'staggered',
                        'options' => array(
                            'all-same'   => __('All items appear at same time', 'omega-admin-td'),
                            'staggered'  => __('Staggered over Animation Delay', 'omega-admin-td'),
                        ),
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
     /* Staff Shortcodes */
    'staff_list' =>  array(
        'shortcode'     => 'staff_list',
        'title'         => __('Staff List', 'omega-admin-td'),
        'desc'          => __('Displays a list of staff members in columns.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Staff members list', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Choose a department', 'omega-admin-td'),
                        'desc'    => __('Populate your list from a department', 'omega-admin-td'),
                        'id'      => 'department',
                        'default' =>  '',
                        'type'    => 'select',
                        'admin_label' => true,
                        'options' => 'taxonomy',
                        'taxonomy' => 'oxy_staff_department',
                        'blank_label' => __('Select a department', 'omega-admin-td')
                    ),
                    array(
                        'name'    => __('Number Of members', 'omega-admin-td'),
                        'desc'    => __('Number of members to display(set to 0 to show all)', 'omega-admin-td'),
                        'id'      => 'count',
                        'type'    => 'slider',
                        'admin_label' => true,
                        'default' => '3',
                        'attr'    => array(
                            'max'  => 30,
                            'min'  => 0,
                            'step' => 1
                        )
                    ),
                    array(
                        'name'    => __('List Columns', 'omega-admin-td'),
                        'desc'    => __('Number of columns to show staff in', 'omega-admin-td'),
                        'id'      => 'columns',
                        'type'    => 'select',
                        'admin_label' => true,
                        'options' => array(
                            '2' => __('Two columns', 'omega-admin-td'),
                            '3' => __('Three columns', 'omega-admin-td'),
                            '4' => __('Four columns', 'omega-admin-td'),
                            '6' => __('Six columns', 'omega-admin-td'),
                        ),
                        'default' => '3',
                    ),
                    array(
                        'name'    => __('Show Position', 'omega-admin-td'),
                        'desc'    => __('Display the staff position below the name', 'omega-admin-td'),
                        'id'      => 'show_position',
                        'type'    => 'select',
                        'default' => 'show',
                        'options' => array(
                            'show' => __('Show', 'omega-admin-td'),
                            'hide' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Show Social Links', 'omega-admin-td'),
                        'id'        => 'show_social',
                        'type'      => 'select',
                        'default'   => 'show',
                        'options' => array(
                            'show' => __('Show', 'omega-admin-td'),
                            'hide' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Item image size', 'omega-admin-td'),
                        'desc'    => __('Choose the size of images that will be loaded in the staff list', 'omega-admin-td'),
                        'id'      => 'item_size',
                        'type'    => 'select',
                        'default' => 'full',
                        'options' => array(
                            'thumbnail'       => __('Thumbnail', 'omega-admin-td'),
                            'medium'          => __('Medium', 'omega-admin-td'),
                            'large'           => __('Large', 'omega-admin-td'),
                            'full'            => __('Full', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Hover Overlay Type', 'omega-admin-td'),
                        'id'        => 'item_overlay',
                        'type'      => 'select',
                        'default'   => 'strip',
                        'options' => array(
                            'icon'         => __('Show Icon', 'omega-admin-td'),
                            'caption'      => __('Show Title & Caption', 'omega-admin-td'),
                            'strip'        => __('Show Title Strip & Caption', 'omega-admin-td'),
                            'none'         => __('No Hover Overlay', 'omega-admin-td'),
                        ),
                        'desc'    => __('Choose the type of hover overlay you would like to appear.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Hover Overlay Link Type', 'PLUGIN_TD'),
                        'desc'    => __('Select the link type to use for the item.', 'PLUGIN_TD'),
                        'id'      => 'item_link_type',
                        'type'    => 'select',
                        'default' => 'magnific',
                        'options' => array(
                            'magnific' => __('Magnific', 'PLUGIN_TD'),
                            'item'     => __('Link', 'PLUGIN_TD'),
                            'no-link'  => __('No Link ', 'PLUGIN_TD'),
                        ),
                    ),
                    array(
                        'name'    => __('Item Show Captions Below', 'omega-admin-td'),
                        'desc'    => __('Select a style to use for the staff list items.', 'omega-admin-td'),
                        'id'      => 'item_captions_below',
                        'type'    => 'select',
                        'default' => 'hide',
                        'options' => array(
                            'hide' => __('Image Only', 'omega-admin-td'),
                            'show' => __('Image + Captions Below', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Link Caption Title Below', 'omega-admin-td'),
                        'desc'    => __('Makes the Captions Below Title a link.', 'omega-admin-td'),
                        'id'      => 'captions_below_link_type',
                        'type'    => 'select',
                        'default' => 'item',
                        'options' => array(
                            'magnific' => __('Magnific', 'PLUGIN_TD'),
                            'item'     => __('Link', 'PLUGIN_TD'),
                            'no-link'  => __('No Link ', 'PLUGIN_TD'),
                        ),
                    ),
                    array(
                        'name'      => __('Item Caption Horizontal Alignment', 'omega-admin-td'),
                        'id'        => 'item_caption_align',
                        'type'      => 'select',
                        'default'   => 'center',
                        'options' => array(
                            'center' => __('Center', 'omega-admin-td'),
                            'left'   => __('Left', 'omega-admin-td'),
                            'right'  => __('Right', 'omega-admin-td'),
                            'justify' => __('Justify', 'omega-admin-td'),
                        ),
                        'desc'    => __('The text alignment of the caption text / title.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Item Overlay Caption Vertical Alignment', 'omega-admin-td'),
                        'id'        => 'item_caption_vertical',
                        'type'      => 'select',
                        'default'   => 'middle',
                        'options' => array(
                            'middle' => __('Middle', 'omega-admin-td'),
                            'top'    => __('Top', 'omega-admin-td'),
                            'bottom' => __('Bottom', 'omega-admin-td'),
                        ),
                        'desc'    => __('Vertical alignment of the caption title and text.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Item Overlay Hover Animation', 'omega-admin-td'),
                        'id'        => 'item_overlay_animation',
                        'type'        => 'select',
                        'default'     => 'fade-in',
                        'options'     => array(
                            'fade-in'     => __('Fade in', 'omega-admin-td'),
                            'fade-in from-top'    => __('Fade From Top', 'omega-admin-td'),
                            'fade-in from-bottom' => __('Fade From Bottom', 'omega-admin-td'),
                            'fade-in from-left'   => __('Fade From Left', 'omega-admin-td'),
                            'fade-in from-right'  => __('Fade From Right', 'omega-admin-td'),
                            'fade-none'        => __('No Animation', 'omega-admin-td'),
                        ),
                        'desc'    => __('What animation will be used to reveal the image hover overlay.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Image Hover Effects Filter', 'omega-admin-td'),
                        'id'      => 'item_hover_filter',
                        'type'    => 'select',
                        'default' => 'none',
                        'options' => array(
                            'none'      => __('None', 'omega-admin-td'),
                            'sepia'     => __('Sepia', 'omega-admin-td'),
                            'grayscale' => __('Grayscale', 'omega-admin-td'),
                            'blur'      => __('Blur', 'omega-admin-td'),
                        ),
                        'desc'    => __('Effects filter to apply to the image on hover.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Hover Effects Filter Behaviour', 'omega-admin-td'),
                        'id'      => 'hover_filter_invert',
                        'type'    => 'select',
                        'default' => 'image-filter-onhover',
                        'options' => array(
                            'image-filter-onhover'    => __('Apply Filter On Hover', 'omega-admin-td'),
                            'image-filter-invert'     => __('Apply Filter On Hover Out', 'omega-admin-td'),
                        ),
                        'desc'    => __('When to apply the Hover Effects Filter.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Item Overlay Grid', 'omega-admin-td'),
                        'desc'      => __('Grid pattern to apply over the image on hover.', 'omega-admin-td'),
                        'id'        => 'item_overlay_grid',
                        'type'      => 'slider',
                        'default'   => '0',
                        'attr'      => array(
                            'max'       => 100,
                            'min'       => 0,
                            'step'      => 10,
                        )
                    ),
                    array(
                        'name'      => __('Item Overlay Icon', 'omega-admin-td'),
                        'desc'      => __('Icon to show on the hover overlay.', 'omega-admin-td'),
                        'id'        => 'item_overlay_icon',
                        'type'    => 'select',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/svgs.php',
                        'default' => 'plus',
                    ),
                    array(
                        'name'    => __('Animation Timing', 'omega-admin-td'),
                        'desc'    => __('Will animate all staff at once or each one individually .', 'omega-admin-td'),
                        'id'      => 'item_scroll_animation_timing',
                        'type'    => 'select',
                        'default' => 'staggered',
                        'options' => array(
                            'all-same'   => __('All items appear at same time', 'omega-admin-td'),
                            'staggered'  => __('Staggered over Animation Delay', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'        => __('Order by', 'omega-admin-td'),
                        'desc'        => __('Choose the way staff items will be ordered.', 'omega-admin-td'),
                        'id'          => 'orderby',
                        'type'        => 'select',
                        'default'     =>  'none',
                        'options'     => array(
                            'none'        => __('None', 'omega-admin-td'),
                            'title'       => __('Title', 'omega-admin-td'),
                            'date'        => __('Date', 'omega-admin-td'),
                            'ID'          => __('ID', 'omega-admin-td'),
                            'author'      => __('Author', 'omega-admin-td'),
                            'modified'    => __('Last Modified', 'omega-admin-td'),
                            'menu_order'  => __('Menu Order', 'omega-admin-td'),
                            'rand'        => __('Random', 'omega-admin-td'),
                        )
                    ),
                    array(
                        'name'        => __('Order', 'omega-admin-td'),
                        'desc'        => __('Choose how staff will be ordered.', 'omega-admin-td'),
                        'id'          => 'order',
                        'type'        => 'select',
                        'default'     =>  'ASC',
                        'options'     => array(
                            'ASC'     => __('Ascending', 'omega-admin-td'),
                            'DESC'    => __('Descending', 'omega-admin-td'),
                        )
                    )
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        ),
    ),
    'staff_featured' => array(
        'shortcode'     => 'staff_featured',
        'title'         => __('Single Staff', 'omega-admin-td'),
        'desc'          => __('Displays a section about one member of staff.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Staff', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Featured member', 'omega-admin-td'),
                        'desc'    => __('Select the staff member that will be featured', 'omega-admin-td'),
                        'id'      => 'member',
                        'default' =>  '',
                        'type'    => 'select',
                        'options' => 'staff_featured',
                    ),
                    array(
                        'name'    => __('Show Position', 'omega-admin-td'),
                        'desc'    => __('Display the staff position below the name', 'omega-admin-td'),
                        'id'      => 'show_position',
                        'type'    => 'select',
                        'default' => 'show',
                        'options' => array(
                            'show' => __('Show', 'omega-admin-td'),
                            'hide' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Show Social Links', 'omega-admin-td'),
                        'id'        => 'show_social',
                        'type'      => 'select',
                        'default'   => 'show',
                        'options' => array(
                            'show' => __('Show', 'omega-admin-td'),
                            'hide' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Item image size', 'omega-admin-td'),
                        'desc'    => __('Choose the size of the image that will be loaded in the single-staff', 'omega-admin-td'),
                        'id'      => 'item_size',
                        'type'    => 'select',
                        'default' => 'full',
                        'options' => array(
                            'thumbnail'       => __('Thumbnail', 'omega-admin-td'),
                            'medium'          => __('Medium', 'omega-admin-td'),
                            'large'           => __('Large', 'omega-admin-td'),
                            'full'            => __('Full', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Hover Overlay Type', 'omega-admin-td'),
                        'id'        => 'item_overlay',
                        'type'      => 'select',
                        'default'   => 'strip',
                        'options' => array(
                            'icon'         => __('Show Icon', 'omega-admin-td'),
                            'caption'      => __('Show Title & Caption', 'omega-admin-td'),
                            'strip'        => __('Show Title Strip & Caption', 'omega-admin-td'),
                            'none'         => __('No Hover Overlay', 'omega-admin-td'),
                        ),
                        'desc'    => __('Choose the type of hover overlay you would like to appear.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Hover Overlay Link Type', 'PLUGIN_TD'),
                        'desc'    => __('Select the link type to use for the item.', 'PLUGIN_TD'),
                        'id'      => 'item_link_type',
                        'type'    => 'select',
                        'default' => 'magnific',
                        'options' => array(
                            'magnific' => __('Magnific', 'PLUGIN_TD'),
                            'item'     => __('Link', 'PLUGIN_TD'),
                            'no-link'  => __('No Link ', 'PLUGIN_TD'),
                        ),
                    ),
                    array(
                        'name'    => __('Item Show Captions Below', 'omega-admin-td'),
                        'desc'    => __('Select a style to use for the single-staff item.', 'omega-admin-td'),
                        'id'      => 'item_captions_below',
                        'type'    => 'select',
                        'default' => 'hide',
                        'options' => array(
                            'hide' => __('Image Only', 'omega-admin-td'),
                            'show' => __('Image + Captions Below', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Link Caption Title Below', 'omega-admin-td'),
                        'desc'    => __('Makes the Captions Below Title a link.', 'omega-admin-td'),
                        'id'      => 'captions_below_link_type',
                        'type'    => 'select',
                        'default' => 'item',
                        'options' => array(
                            'magnific' => __('Magnific', 'PLUGIN_TD'),
                            'item'     => __('Link', 'PLUGIN_TD'),
                            'no-link'  => __('No Link ', 'PLUGIN_TD'),
                        ),
                    ),
                    array(
                        'name'      => __('Item Caption Horizontal Alignment', 'omega-admin-td'),
                        'id'        => 'item_caption_align',
                        'type'      => 'select',
                        'default'   => 'center',
                        'options' => array(
                            'center' => __('Center', 'omega-admin-td'),
                            'left'   => __('Left', 'omega-admin-td'),
                            'right'  => __('Right', 'omega-admin-td'),
                            'justify' => __('Justify', 'omega-admin-td')
                        ),
                        'desc'    => __('The text alignment of the caption text / title.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Item Overlay Caption Vertical Alignment', 'omega-admin-td'),
                        'id'        => 'item_caption_vertical',
                        'type'      => 'select',
                        'default'   => 'middle',
                        'options' => array(
                            'middle' => __('Middle', 'omega-admin-td'),
                            'top'    => __('Top', 'omega-admin-td'),
                            'bottom' => __('Bottom', 'omega-admin-td'),
                        ),
                        'desc'    => __('Vertical alignment of the caption title and text.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Item Overlay Hover Animation', 'omega-admin-td'),
                        'id'        => 'item_overlay_animation',
                        'type'        => 'select',
                        'default'     => 'fade-in',
                        'options'     => array(
                            'fade-in'     => __('Fade in', 'omega-admin-td'),
                            'fade-in from-top'    => __('Fade From Top', 'omega-admin-td'),
                            'fade-in from-bottom' => __('Fade From Bottom', 'omega-admin-td'),
                            'fade-in from-left'   => __('Fade From Left', 'omega-admin-td'),
                            'fade-in from-right'  => __('Fade From Right', 'omega-admin-td'),
                            'fade-none'        => __('No Animation', 'omega-admin-td'),
                        ),
                        'desc'    => __('What animation will be used to reveal the image hover overlay.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Image Hover Effects Filter', 'omega-admin-td'),
                        'id'      => 'item_hover_filter',
                        'type'    => 'select',
                        'default' => 'none',
                        'options' => array(
                            'none'      => __('None', 'omega-admin-td'),
                            'sepia'     => __('Sepia', 'omega-admin-td'),
                            'grayscale' => __('Grayscale', 'omega-admin-td'),
                            'blur'      => __('Blur', 'omega-admin-td'),
                        ),
                        'desc'    => __('Effects filter to apply to the image on hover.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Hover Effects Filter Behaviour', 'omega-admin-td'),
                        'id'      => 'hover_filter_invert',
                        'type'    => 'select',
                        'default' => 'image-filter-onhover',
                        'options' => array(
                            'image-filter-onhover'    => __('Apply Filter On Hover', 'omega-admin-td'),
                            'image-filter-invert'     => __('Apply Filter On Hover Out', 'omega-admin-td'),
                        ),
                        'desc'    => __('When to apply the Hover Effects Filter.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Item Overlay Grid', 'omega-admin-td'),
                        'desc'      => __('Grid pattern to apply over the image on hover.', 'omega-admin-td'),
                        'id'        => 'item_overlay_grid',
                        'type'      => 'slider',
                        'default'   => '0',
                        'attr'      => array(
                            'max'       => 100,
                            'min'       => 0,
                            'step'      => 10,
                        )
                    ),
                    array(
                        'name'      => __('Item Overlay Icon', 'omega-admin-td'),
                        'desc'      => __('Icon to show on the hover overlay.', 'omega-admin-td'),
                        'id'        => 'item_overlay_icon',
                        'type'    => 'select',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/svgs.php',
                        'default' => 'plus',
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    // PORTFOLIO SHORTCODE OPTIONS
    'portfolio' => array(
        'shortcode'     => 'portfolio',
        'title'         => __('Portfolio', 'omega-admin-td'),
        'desc'          => __('Displays a set of portfolio items in columns.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Portfolio', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Category', 'omega-admin-td'),
                        'desc'    => __('Categories to show (leave blank to show all)', 'omega-admin-td'),
                        'id'      => 'categories',
                        'default' =>  '',
                        'type'    => 'select',
                        'options' => 'taxonomy',
                        'taxonomy' => 'oxy_portfolio_categories',
                        'admin_label' => true,
                        'attr' => array(
                            'multiple' => '',
                            'style' => 'height:100px'
                        )
                    ),
                    array(
                        'name'    => __('Portfolio Filters', 'omega-admin-td'),
                        'desc'    => __('Select which filters to show above the portfolio.', 'omega-admin-td'),
                        'id'      => 'filters',
                        'default' =>  '',
                        'type'    => 'select',
                        'options' => array(
                            'categories' => __('Category Filter', 'omega-admin-td'),
                            'sort'       => __('Sort Options', 'omega-admin-td'),
                            'order'      => __('Sort Order', 'omega-admin-td'),
                        ),
                        'attr' => array(
                            'multiple' => '',
                            'style' => 'height:100px'
                        )
                    ),
                    array(
                        'name'    => __('Portfolio items count', 'omega-admin-td'),
                        'desc'    => __('Number of portfolio items to display ( 0 for all )', 'omega-admin-td'),
                        'id'      => 'count',
                        'type'    => 'slider',
                        'default' => '0',
                        'attr'    => array(
                            'max'   => 100,
                            'min'   => 0,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'    => __('Mobile Columns', 'omega-admin-td'),
                        'desc'    => __('Number of columns to use on mobile sized displays (<768px)', 'omega-admin-td'),
                        'id'      => 'xs_col',
                        'type'    => 'slider',
                        'default' => '2',
                        'attr'    => array(
                            'max'   => 12,
                            'min'   => 1,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'    => __('Tablet Columns', 'omega-admin-td'),
                        'desc'    => __('Number of columns to use on tablet sized displays (>768px <992px)', 'omega-admin-td'),
                        'id'      => 'sm_col',
                        'type'    => 'slider',
                        'default' => '3',
                        'attr'    => array(
                            'max'   => 12,
                            'min'   => 1,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'    => __('Desktop Columns', 'omega-admin-td'),
                        'desc'    => __('Number of columns to use on regular desktop displays (>992px <1200px)', 'omega-admin-td'),
                        'id'      => 'md_col',
                        'type'    => 'slider',
                        'default' => '4',
                        'attr'    => array(
                            'max'   => 12,
                            'min'   => 1,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'    => __('Large Desktop Columns', 'omega-admin-td'),
                        'desc'    => __('Number of columns to use on large desktop displays (>1200x)', 'omega-admin-td'),
                        'id'      => 'lg_col',
                        'type'    => 'slider',
                        'default' => '5',
                        'attr'    => array(
                            'max'   => 12,
                            'min'   => 1,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'    => __('Layout Mode', 'omega-admin-td'),
                        'desc'    => __('Choose a method to layout the portfolio items in the list.', 'omega-admin-td'),
                        'id'      => 'layout_mode',
                        'type'    => 'select',
                        'default' => 'fitRows',
                        'options' => array(
                            'fitRows' => __('Align by Rows', 'omega-admin-td'),
                            'masonry' => __('Align Vertically', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Portfolio Items Padding', 'omega-admin-td'),
                        'desc'    => __('Space to add between portfolio items in pixels.', 'omega-admin-td'),
                        'id'      => 'item_padding',
                        'type'    => 'slider',
                        'default' => '15',
                        'attr'    => array(
                            'max'   => 80,
                            'min'   => 0,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'    => __('Pagination', 'omega-admin-td'),
                        'desc'    => __('Select type of pagination to use for this portfolio list.', 'omega-admin-td'),
                        'id'      => 'pagination',
                        'type'    => 'select',
                        'default' => 'none',
                        'options' => array(
                            'none'      => __('No Pagination', 'omega-admin-td'),
                            'next_prev' => __('Next and Previous Buttons', 'omega-admin-td'),
                            'pages'     => __('Page Numbers', 'omega-admin-td'),
                        ),
                    ),
                )
            ),
            array(
                'title' => __('Portfolio Items', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Item image size', 'omega-admin-td'),
                        'desc'    => __('Choose the size of images that will be loaded in the portfolio (Portfolio Size can be changed on Theme Portfolio Options Page)', 'omega-admin-td'),
                        'id'      => 'item_size',
                        'type'    => 'select',
                        'default' => 'portfolio-thumb',
                        'options' => array(
                            'portfolio-thumb' => __('Portfolio Size', 'omega-admin-td'),
                            'thumbnail'       => __('Thumbnail', 'omega-admin-td'),
                            'medium'          => __('Medium', 'omega-admin-td'),
                            'large'           => __('Large', 'omega-admin-td'),
                            'full'            => __('Full', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Hover Overlay Type', 'omega-admin-td'),
                        'id'        => 'item_overlay',
                        'type'      => 'select',
                        'default'   => 'icon',
                        'options' => array(
                            'icon'         => __('Show Icon', 'omega-admin-td'),
                            'caption'      => __('Show Title & Caption', 'omega-admin-td'),
                            'strip'        => __('Show Title Strip & Caption', 'omega-admin-td'),
                            'buttons'      => __('Show Title & Buttons', 'omega-admin-td'),
                            'buttons_only' => __('Buttons Only', 'omega-admin-td'),
                            'none'         => __('No Hover Overlay', 'omega-admin-td'),
                        ),
                        'desc'    => __('Choose the type of hover overlay you would like to appear.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Hover Overlay Link Type', 'PLUGIN_TD'),
                        'desc'    => __('Select the link type to use for the item.', 'PLUGIN_TD'),
                        'id'      => 'item_link_type',
                        'type'    => 'select',
                        'default' => 'magnific',
                        'options' => array(
                            'magnific'      => __('Magnific Single Item', 'PLUGIN_TD'),
                            'magnific-all'  => __('Magnific All Items', 'PLUGIN_TD'),
                            'item'          => __('Link', 'PLUGIN_TD'),
                            'no-link'       => __('No Link ', 'PLUGIN_TD'),
                        ),
                    ),
                    array(
                        'name'    => __('Item Show Captions Below', 'omega-admin-td'),
                        'desc'    => __('Select a portfolio style to use for the portfolio items.', 'omega-admin-td'),
                        'id'      => 'item_captions_below',
                        'type'    => 'select',
                        'default' => 'hide',
                        'options' => array(
                            'hide' => __('Image Only', 'omega-admin-td'),
                            'show' => __('Image + Captions Below', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Link Caption Title Below', 'omega-admin-td'),
                        'desc'    => __('Makes the Captions Below Title a link.', 'omega-admin-td'),
                        'id'      => 'captions_below_link_type',
                        'type'    => 'select',
                        'default' => 'item',
                        'options' => array(
                            'magnific' => __('Magnific', 'PLUGIN_TD'),
                            'item'     => __('Link', 'PLUGIN_TD'),
                            'no-link'  => __('No Link ', 'PLUGIN_TD'),
                        ),
                    ),
                    array(
                        'name'      => __('Item Caption Horizontal Alignment', 'omega-admin-td'),
                        'id'        => 'item_caption_align',
                        'type'      => 'select',
                        'default'   => 'center',
                        'options' => array(
                            'center' => __('Center', 'omega-admin-td'),
                            'left'   => __('Left', 'omega-admin-td'),
                            'right'  => __('Right', 'omega-admin-td'),
                            'justify'  => __('Justify', 'omega-admin-td')
                        ),
                        'desc'    => __('The text alignment of the caption text / title.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Item Overlay Caption Vertical Alignment', 'omega-admin-td'),
                        'id'        => 'item_caption_vertical',
                        'type'      => 'select',
                        'default'   => 'middle',
                        'options' => array(
                            'middle' => __('Middle', 'omega-admin-td'),
                            'top'    => __('Top', 'omega-admin-td'),
                            'bottom' => __('Bottom', 'omega-admin-td'),
                        ),
                        'desc'    => __('Vertical alignment of the caption title and text.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Item Overlay Hover Animation', 'omega-admin-td'),
                        'id'        => 'item_overlay_animation',
                        'type'        => 'select',
                        'default'     => 'fade-in',
                        'options'     => array(
                            'fade-in'     => __('Fade in', 'omega-admin-td'),
                            'fade-in from-top'    => __('Fade From Top', 'omega-admin-td'),
                            'fade-in from-bottom' => __('Fade From Bottom', 'omega-admin-td'),
                            'fade-in from-left'   => __('Fade From Left', 'omega-admin-td'),
                            'fade-in from-right'  => __('Fade From Right', 'omega-admin-td'),
                            'fade-none'        => __('No Animation', 'omega-admin-td'),
                        ),
                        'desc'    => __('What animation will be used to reveal the image hover overlay.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Image Hover Effects Filter', 'omega-admin-td'),
                        'id'      => 'item_hover_filter',
                        'type'    => 'select',
                        'default' => 'none',
                        'options' => array(
                            'none'      => __('None', 'omega-admin-td'),
                            'sepia'     => __('Sepia', 'omega-admin-td'),
                            'grayscale' => __('Grayscale', 'omega-admin-td'),
                            'blur'      => __('Blur', 'omega-admin-td'),
                        ),
                        'desc'    => __('Effects filter to apply to the image on hover.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Hover Effects Filter Behaviour', 'omega-admin-td'),
                        'id'      => 'hover_filter_invert',
                        'type'    => 'select',
                        'default' => 'image-filter-onhover',
                        'options' => array(
                            'image-filter-onhover'    => __('Apply Filter On Hover', 'omega-admin-td'),
                            'image-filter-invert'     => __('Apply Filter On Hover Out', 'omega-admin-td'),
                        ),
                        'desc'    => __('When to apply the Hover Effects Filter.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Item Overlay Grid', 'omega-admin-td'),
                        'desc'      => __('Grid pattern to apply over the image on hover.', 'omega-admin-td'),
                        'id'        => 'item_overlay_grid',
                        'type'      => 'slider',
                        'default'   => '0',
                        'attr'      => array(
                            'max'       => 100,
                            'min'       => 0,
                            'step'      => 10,
                        )
                    ),
                    array(
                        'name'      => __('Item Overlay Icon', 'omega-admin-td'),
                        'desc'      => __('Icon to show on the hover overlay.', 'omega-admin-td'),
                        'id'        => 'item_overlay_icon',
                        'type'    => 'select',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/svgs.php',
                        'default' => 'plus',
                    ),
                    array(
                        'name'        => __('Scroll Animation', 'omega-admin-td'),
                        'desc'        => __('Animation that will occur when the user scrolls onto the element.', 'omega-admin-td'),
                        'id'          => 'item_scroll_animation',
                        'type'        => 'select',
                        'default'     => 'none',
                        'options'     => include OXY_THEME_DIR . 'inc/options/global-options/animations.php',
                    ),
                    array(
                        'name'    => __('Animation Delay', 'omega-admin-td'),
                        'desc'    => __('Delay after scrolling onto the element before animation starts.', 'omega-admin-td'),
                        'id'      => 'item_scroll_animation_delay',
                        'type'    => 'slider',
                        'default' => '0',
                        'attr'    => array(
                            'max'  => 4,
                            'min'  => 0,
                            'step' => 0.1
                        )
                    ),
                    array(
                        'name'    => __('Animation Timing', 'omega-admin-td'),
                        'desc'    => __('Will load all portfolio items at once or each one individually .', 'omega-admin-td'),
                        'id'      => 'item_scroll_animation_timing',
                        'type'    => 'select',
                        'default' => 'staggered',
                        'options' => array(
                            'all-same'   => __('All items appear at same time', 'omega-admin-td'),
                            'staggered'  => __('Staggered over Animation Delay', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'        => __('Order by', 'omega-admin-td'),
                        'desc'        => __('Choose the way portfolio items will be ordered.', 'omega-admin-td'),
                        'id'          => 'orderby',
                        'type'        => 'select',
                        'default'     =>  'menu_order',
                        'options'     => array(
                            'none'        => __('None', 'omega-admin-td'),
                            'title'       => __('Title', 'omega-admin-td'),
                            'date'        => __('Date', 'omega-admin-td'),
                            'ID'          => __('ID', 'omega-admin-td'),
                            'author'      => __('Author', 'omega-admin-td'),
                            'modified'    => __('Last Modified', 'omega-admin-td'),
                            'menu_order'  => __('Menu Order', 'omega-admin-td'),
                            'rand'        => __('Random', 'omega-admin-td'),
                        )
                    ),
                    array(
                        'name'        => __('Order', 'omega-admin-td'),
                        'desc'        => __('Choose how portfolio will be ordered.', 'omega-admin-td'),
                        'id'          => 'order',
                        'type'        => 'select',
                        'default'     =>  'ASC',
                        'options'     => array(
                            'ASC'     => __('Ascending', 'omega-admin-td'),
                            'DESC'    => __('Descending', 'omega-admin-td'),
                        )
                    )
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/padding-options.php'
            )
        )
    ),
    // PORTFOLIO SHORTCODE OPTIONS
    'portfolio_masonry' => array(
        'shortcode'     => 'portfolio_masonry',
        'title'         => __('Masonry Portfolio', 'omega-admin-td'),
        'desc'          => __('Displays a set of portfolio items using a masonry style.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Portfolio', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Category', 'omega-admin-td'),
                        'desc'    => __('Categories to show (leave blank to show all)', 'omega-admin-td'),
                        'id'      => 'categories',
                        'default' =>  '',
                        'type'    => 'select',
                        'options' => 'taxonomy',
                        'taxonomy' => 'oxy_portfolio_categories',
                        'admin_label' => true,
                        'attr' => array(
                            'multiple' => '',
                            'style' => 'height:100px'
                        )
                    ),
                    array(
                        'name'    => __('Portfolio Filters', 'omega-admin-td'),
                        'desc'    => __('Select which filters to show above the portfolio.', 'omega-admin-td'),
                        'id'      => 'filters',
                        'default' =>  '',
                        'type'    => 'select',
                        'options' => array(
                            'categories' => __('Category Filter', 'omega-admin-td'),
                            'sort'       => __('Sort Options', 'omega-admin-td'),
                            'order'      => __('Sort Order', 'omega-admin-td'),
                        ),
                        'attr' => array(
                            'multiple' => '',
                            'style' => 'height:100px'
                        )
                    ),
                    array(
                        'name'    => __('Portfolio items count', 'omega-admin-td'),
                        'desc'    => __('Number of portfolio items to display ( 0 for all )', 'omega-admin-td'),
                        'id'      => 'count',
                        'type'    => 'slider',
                        'default' => '0',
                        'admin_label' => true,
                        'attr'    => array(
                            'max'   => 24,
                            'min'   => 0,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'    => __('Pagination', 'omega-admin-td'),
                        'desc'    => __('Select type of pagination to use for this portfolio list.', 'omega-admin-td'),
                        'id'      => 'pagination',
                        'type'    => 'select',
                        'default' => 'none',
                        'options' => array(
                            'none'      => __('No Pagination', 'omega-admin-td'),
                            'next_prev' => __('Next and Previous Buttons', 'omega-admin-td'),
                            'pages'     => __('Page Numbers', 'omega-admin-td'),
                        ),
                    ),
                )
            ),
            array(
                'title' => __('Portfolio Items', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Item image size', 'omega-admin-td'),
                        'desc'    => __('Choose the size of images that will be loaded in the portfolio (Portfolio Size can be changed on Theme Portfolio Options Page)', 'omega-admin-td'),
                        'id'      => 'item_size',
                        'type'    => 'select',
                        'default' => 'full',
                        'options' => array(
                            'portfolio-thumb' => __('Portfolio Size', 'omega-admin-td'),
                            'thumbnail'       => __('Thumbnail', 'omega-admin-td'),
                            'medium'          => __('Medium', 'omega-admin-td'),
                            'large'           => __('Large', 'omega-admin-td'),
                            'full'            => __('Full', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Portfolio Items Padding', 'omega-admin-td'),
                        'desc'    => __('Space to add between portfolio items in pixels.', 'omega-admin-td'),
                        'id'      => 'item_padding',
                        'type'    => 'slider',
                        'default' => '0',
                        'attr'    => array(
                            'max'   => 80,
                            'min'   => 0,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'      => __('Hover Overlay Type', 'omega-admin-td'),
                        'id'        => 'item_overlay',
                        'type'      => 'select',
                        'default'   => 'icon',
                        'options' => array(
                            'icon'         => __('Show Icon', 'omega-admin-td'),
                            'caption'      => __('Show Title & Caption', 'omega-admin-td'),
                            'strip'        => __('Show Title Strip & Caption', 'omega-admin-td'),
                            'buttons'      => __('Show Title & Buttons', 'omega-admin-td'),
                            'buttons_only' => __('Buttons Only', 'omega-admin-td'),
                            'none'         => __('No Hover Overlay', 'omega-admin-td'),
                        ),
                        'desc'    => __('Choose the type of hover overlay you would like to appear.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Hover Overlay Link Type', 'PLUGIN_TD'),
                        'desc'    => __('Select the link type to use for the item.', 'PLUGIN_TD'),
                        'id'      => 'item_link_type',
                        'type'    => 'select',
                        'default' => 'magnific',
                        'options' => array(
                            'magnific'      => __('Magnific Single Item', 'PLUGIN_TD'),
                            'magnific-all'  => __('Magnific All Items', 'PLUGIN_TD'),
                            'item'          => __('Link', 'PLUGIN_TD'),
                            'no-link'       => __('No Link ', 'PLUGIN_TD'),
                        ),
                    ),
                    array(
                        'name'    => __('Open Link In', 'omega-admin-td'),
                        'id'      => 'item_link_target',
                        'type'    => 'select',
                        'default' => '_self',
                        'options' => array(
                            '_self'   => __('Same page as it was clicked ', 'omega-admin-td'),
                            '_blank'  => __('Open in new window/tab', 'omega-admin-td'),
                        ),
                        'desc'    => __('Where the link will open.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Image Hover Effects Filter', 'omega-admin-td'),
                        'id'      => 'item_hover_filter',
                        'type'    => 'select',
                        'default' => 'none',
                        'options' => array(
                            'none'      => __('None', 'omega-admin-td'),
                            'sepia'     => __('Sepia', 'omega-admin-td'),
                            'grayscale' => __('Grayscale', 'omega-admin-td'),
                            'blur'      => __('Blur', 'omega-admin-td'),
                        ),
                        'desc'    => __('Effects filter to apply to the image on hover.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Hover Effects Filter Behaviour', 'omega-admin-td'),
                        'id'      => 'hover_filter_invert',
                        'type'    => 'select',
                        'default' => 'image-filter-onhover',
                        'options' => array(
                            'image-filter-onhover'    => __('Apply Filter On Hover', 'omega-admin-td'),
                            'image-filter-invert'     => __('Apply Filter On Hover Out', 'omega-admin-td'),
                        ),
                        'desc'    => __('When to apply the Hover Effects Filter.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Item Caption Overlay Horizontal Alignment', 'omega-admin-td'),
                        'id'        => 'item_caption_align',
                        'type'      => 'select',
                        'default'   => 'center',
                        'options' => array(
                            'center' => __('Center', 'omega-admin-td'),
                            'left'   => __('Left', 'omega-admin-td'),
                            'right'  => __('Right', 'omega-admin-td'),
                            'justify'  => __('Justify', 'omega-admin-td')
                        ),
                        'desc'    => __('The text alignment of the caption text / title.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Item Overlay Caption Vertical Alignment', 'omega-admin-td'),
                        'id'        => 'item_caption_vertical',
                        'type'      => 'select',
                        'default'   => 'middle',
                        'options' => array(
                            'middle' => __('Middle', 'omega-admin-td'),
                            'top'    => __('Top', 'omega-admin-td'),
                            'bottom' => __('Bottom', 'omega-admin-td'),
                        ),
                        'desc'    => __('Vertical alignment of the caption title and text.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Item Overlay Hover Animation', 'omega-admin-td'),
                        'id'        => 'item_overlay_animation',
                        'type'        => 'select',
                        'default'     => 'fade-in',
                        'options'     => array(
                            'fade-in'             => __('Fade in', 'omega-admin-td'),
                            'fade-in from-top'    => __('Fade From Top', 'omega-admin-td'),
                            'fade-in from-bottom' => __('Fade From Bottom', 'omega-admin-td'),
                            'fade-in from-left'   => __('Fade From Left', 'omega-admin-td'),
                            'fade-in from-right'  => __('Fade From Right', 'omega-admin-td'),
                            'fade-none'           => __('No Animation', 'omega-admin-td'),
                        ),
                        'desc'    => __('What animation will be used to reveal the image hover overlay.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Item Overlay Grid', 'omega-admin-td'),
                        'desc'      => __('Grid pattern to apply over the image on hover.', 'omega-admin-td'),
                        'id'        => 'item_overlay_grid',
                        'type'      => 'slider',
                        'default'   => '0',
                        'attr'      => array(
                            'max'       => 100,
                            'min'       => 0,
                            'step'      => 10,
                        )
                    ),
                    array(
                        'name'      => __('Item Overlay Icon', 'omega-admin-td'),
                        'desc'      => __('Icon to show on the hover overlay.', 'omega-admin-td'),
                        'id'        => 'item_overlay_icon',
                        'type'    => 'select',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/svgs.php',
                        'default' => 'plus',
                    ),
                    array(
                        'name'        => __('Scroll Animation', 'omega-admin-td'),
                        'desc'        => __('Animation that will occur when the user scrolls onto the element.', 'omega-admin-td'),
                        'id'          => 'item_scroll_animation',
                        'type'        => 'select',
                        'default'     => 'none',
                        'options'     => include OXY_THEME_DIR . 'inc/options/global-options/animations.php',
                    ),
                    array(
                        'name'    => __('Animation Delay', 'omega-admin-td'),
                        'desc'    => __('Delay after scrolling onto the element before animation starts.', 'omega-admin-td'),
                        'id'      => 'item_scroll_animation_delay',
                        'type'    => 'slider',
                        'default' => '0',
                        'attr'    => array(
                            'max'  => 4,
                            'min'  => 0,
                            'step' => 0.1
                        )
                    ),
                    array(
                        'name'    => __('Animation Timing', 'omega-admin-td'),
                        'desc'    => __('Will load all portfolio items at once or each one individually .', 'omega-admin-td'),
                        'id'      => 'item_scroll_animation_timing',
                        'type'    => 'select',
                        'default' => 'staggered',
                        'options' => array(
                            'all-same'   => __('All items appear at same time', 'omega-admin-td'),
                            'staggered'  => __('Staggered over Animation Delay', 'omega-admin-td'),
                        ),
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/padding-options.php'
            )
        )
    ),
    'recent_posts' => array(
        'shortcode' => 'recent_posts',
        'title'     => __('Recent Posts Masonry', 'omega-admin-td'),
        'desc'       => __('Displays a list of recent posts using Masonry.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'has_content'   => false,
        'sections'   => array(
            array(
                'title' => __('Recent Posts Masonry', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Number of posts', 'omega-admin-td'),
                        'desc'    => __('Total Number of posts to display.', 'omega-admin-td'),
                        'id'      => 'count',
                        'type'    => 'slider',
                        'default' => '3',
                        'attr'    => array(
                            'max'   => 50,
                            'min'   => 1,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'    => __('Post category', 'omega-admin-td'),
                        'desc'    => __('Choose posts from a specific category', 'omega-admin-td'),
                        'id'      => 'cat',
                        'default' =>  '',
                        'type'    => 'select',
                        'options' => 'categories',
                        'attr' => array(
                            'multiple' => '',
                            'style' => 'height:100px'
                        )
                    ),
                    array(
                        'name'    => __('Post Swatch', 'omega-admin-td'),
                        'desc'    => __('Choose a color swatch for the posts', 'omega-admin-td'),
                        'id'      => 'masonry_items_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-red-white',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'      => __('Masonry Items Padding', 'omega-admin-td'),
                        'desc'      => __('Space to add between Masonry items in pixels.', 'omega-admin-td'),
                        'id'        => 'masonry_items_padding',
                        'type'      => 'slider',
                        'default'   => '8',
                        'attr'      => array(
                            'max'       => 100,
                            'min'       => 0,
                            'step'      => 1
                        )
                    ),
                    array(
                        'name'    => __('Animation Timing', 'omega-admin-td'),
                        'desc'    => __('Will animate all posts at once or each one individually .', 'omega-admin-td'),
                        'id'      => 'scroll_animation_timing',
                        'type'    => 'select',
                        'default' => 'staggered',
                        'options' => array(
                            'all-same'   => __('All items appear at same time', 'omega-admin-td'),
                            'staggered'  => __('Staggered over Animation Delay', 'omega-admin-td'),
                        ),
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'recent_posts_simple' => array(
        'shortcode' => 'recent_posts_simple',
        'title'     => __('Recent Posts', 'omega-admin-td'),
        'desc'       => __('Displays a simple list of recent posts.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'has_content'   => false,
        'sections'   => array(
            array(
                'title' => __('Recent Posts', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Number of posts', 'omega-admin-td'),
                        'desc'    => __('Total Number of posts to display.', 'omega-admin-td'),
                        'id'      => 'count',
                        'type'    => 'slider',
                        'default' => '3',
                        'attr'    => array(
                            'max'   => 50,
                            'min'   => 1,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'    => __('Columns Per Row', 'omega-admin-td'),
                        'desc'    => __('Number of posts to display per row', 'omega-admin-td'),
                        'id'      => 'columns',
                        'type'    => 'select',
                        'options' => array(
                            '2' => __('Two columns', 'omega-admin-td'),
                            '3' => __('Three columns', 'omega-admin-td'),
                            '5' => __('Five columns', 'omega-admin-td'),
                            '4' => __('Four columns', 'omega-admin-td'),
                            '6' => __('Six columns', 'omega-admin-td'),
                        ),
                        'default' => '3',
                    ),
                    array(
                        'name'    => __('Post category', 'omega-admin-td'),
                        'desc'    => __('Choose posts from a specific category', 'omega-admin-td'),
                        'id'      => 'cat',
                        'default' =>  '',
                        'type'    => 'select',
                        'options' => 'categories',
                        'attr' => array(
                            'multiple' => '',
                            'style' => 'height:100px'
                        )
                    ),
                    array(
                        'name'    => __('Animation Timing', 'omega-admin-td'),
                        'desc'    => __('Will animate all posts at once or each one individually .', 'omega-admin-td'),
                        'id'      => 'scroll_animation_timing',
                        'type'    => 'select',
                        'default' => 'staggered',
                        'options' => array(
                            'all-same'   => __('All items appear at same time', 'omega-admin-td'),
                            'staggered'  => __('Staggered over Animation Delay', 'omega-admin-td'),
                        ),
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    // MAP SHORTCODE OPTIONS
    'map' => array(
        'shortcode'     => 'map',
        'title'         => __('Google Map', 'omega-admin-td'),
        'desc'          => __('Adds a Google Map to the page.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Map', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Map Type', 'omega-admin-td'),
                        'id'        => 'map_type',
                        'desc'    => __('Choose a type of map to show from Google Maps.', 'omega-admin-td'),
                        'type'      => 'select',
                        'default'   =>  'ROADMAP',
                        'options' => array(
                            'ROADMAP'   => __('Roadmap', 'omega-admin-td'),
                            'SATELLITE' => __('Satellite', 'omega-admin-td'),
                            'TERRAIN'   => __('Terrain', 'omega-admin-td'),
                            'HYBRID'    => __('Hybrid', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Map Style', 'omega-admin-td'),
                        'id'        => 'map_style',
                        'desc'    => __('Set a drawing style for the map.', 'omega-admin-td'),
                        'type'      => 'select',
                        'default'   =>  'regular',
                        'options' => array(
                            'blackwhite' => __('Black & White', 'omega-admin-td'),
                            'regular'    => __('Regular', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Center Map', 'omega-admin-td'),
                        'id'        => 'auto_center',
                        'type'      => 'select',
                        'default'   =>  'auto',
                        'desc'    => __('Sets the center the map automatically based on the markers, or manually.', 'omega-admin-td'),
                        'options' => array(
                            'auto'   => __('Auto center markers ', 'omega-admin-td'),
                            'manual' => __('I will tell you where to center map below', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Center Map Lat/Lng', 'omega-admin-td'),
                        'desc'    => __('Latitude and Longitude position to center the Map (separate lat and long with commas).', 'omega-admin-td'),
                        'id'      => 'center_latlng',
                        'default' =>  '',
                        'type'    => 'text',
                    ),
                    array(
                        'name'      => __('Map Zoom', 'omega-admin-td'),
                        'id'        => 'map_zoom',
                        'desc'    => __('Sets the zoom level of the map.  NOTE - will be overridden by the auto center map option', 'omega-admin-td'),
                        'type'      => 'slider',
                        'default' => '15',
                        'attr'    => array(
                            'max'   => 20,
                            'min'   => 1,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'      => __('Map Scrollable', 'omega-admin-td'),
                        'id'        => 'map_scrollable',
                        'desc'    => __('Toggles draggable scrolling of the map.', 'omega-admin-td'),
                        'type'      => 'select',
                        'default'   =>  'on',
                        'options' => array(
                            'on'  => __('On', 'omega-admin-td'),
                            'off' => __('Off', 'omega-admin-td'),
                        ),
                    ),
                )
            ),
            array(
                'title' => __('Marker', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Show Markers', 'omega-admin-td'),
                        'id'        => 'marker',
                        'type'      => 'select',
                        'default'   =>  'show',
                        'desc'    => __('Toggle showing or hiding the small marker points on your map.', 'omega-admin-td'),
                        'options' => array(
                            'hide' => __('Hide', 'omega-admin-td'),
                            'show' => __('Show', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Marker Labels', 'omega-admin-td'),
                        'desc'    => __('Labels to show above the marker. Divide labels with pipe character |', 'omega-admin-td'),
                        'id'      => 'label',
                        'default' =>  '',
                        'type'    => 'textarea',
                    ),
                    array(
                        'name'    => __('Marker Addresses', 'omega-admin-td'),
                        'desc'    => __('Addresses to show markers. Divide addresses with pipe character |', 'omega-admin-td'),
                        'id'      => 'address',
                        'default' =>  '',
                        'type'    => 'textarea',
                    ),
                    array(
                        'name'    => __('Markers Lat/Lng', 'omega-admin-td'),
                        'desc'    => __('Latitude and Longitude of markers(separate with commas), if you dont want to use address. Divide markers with pipe character |', 'omega-admin-td'),
                        'id'      => 'latlng',
                        'default' =>  '',
                        'type'    => 'textarea',
                    ),
                )
            ),
            array(
                'title' => __('Section', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Map Height', 'omega-admin-td'),
                        'id'        => 'height',
                        'desc'    => __('Map height in pixels.', 'omega-admin-td'),
                        'type'      => 'slider',
                        'default' => '500',
                        'attr'    => array(
                            'max'   => 800,
                            'min'   => 50,
                            'step'  => 1
                        )
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    // PIECHART SHORTCODE
    'pie' => array(
        'shortcode' => 'pie',
        'title'     => __('Pie Chart', 'omega-admin-td'),
        'desc'      => __('Creates a circular chart to show a % value.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'has_content'   => false,
        'sections'   => array(
            array(
                'title' => __('Pie Chart', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Track Colour', 'omega-admin-td'),
                        'desc'    => __('Choose the chart track colour', 'omega-admin-td'),
                        'id'      => 'track_colour',
                        'default' =>  '',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Bar Colour', 'omega-admin-td'),
                        'desc'    => __('Choose the chart bar colour', 'omega-admin-td'),
                        'id'      => 'bar_colour',
                        'default' =>  '',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Icon', 'omega-admin-td'),
                        'desc'    => __('Choose a chart icon', 'omega-admin-td'),
                        'id'      => 'icon',
                        'default' =>  '',
                        'type'    => 'select',
                        'options' => 'icons',
                    ),
                    array(
                        'name'    => __('Icon Animation', 'omega-admin-td'),
                        'desc'    => __('Choose an icon animation', 'omega-admin-td'),
                        'id'      => 'icon_animation',
                        'type'    => 'select',
                        'default' => 'none',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/animations.php'
                    ),
                    array(
                        'name'    => __('Percentage', 'omega-admin-td'),
                        'desc'    => __('Percentage of the pie chart', 'omega-admin-td'),
                        'id'      => 'percentage',
                        'admin_label' => true,
                        'type'    => 'slider',
                        'default' => '50',
                        'attr'    => array(
                            'max'   => 100,
                            'min'   => 1,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'    => __('Size', 'omega-admin-td'),
                        'desc'    => __('Set the size of the chart', 'omega-admin-td'),
                        'id'      => 'size',
                        'type'    => 'slider',
                        'default' => '200',
                        'attr'    => array(
                            'max'   => 400,
                            'min'   => 50,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'    => __('Line Width', 'omega-admin-td'),
                        'desc'    => __('Set the width of the charts line', 'omega-admin-td'),
                        'id'      => 'line_width',
                        'type'    => 'slider',
                        'default' => '20',
                        'attr'    => array(
                            'max'   => 30,
                            'min'   => 5,
                            'step'  => 1
                        )
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
     // COUNTER SHORTCODE
    'counter' => array(
        'shortcode' => 'counter',
        'title'     => __('Counter', 'omega-admin-td'),
        'desc'      => __('Creates a circular counter to show an integer value.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'has_content'   => false,
        'sections'   => array(
            array(
                'title' => __('Counter', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Initial Value', 'omega-admin-td'),
                        'desc'    => __('Starting value of the circular counter before the animation.', 'omega-admin-td'),
                        'id'      => 'initvalue',
                        'admin_label' => true,
                        'default'     =>  '0',
                        'type'        => 'text',
                    ),
                    array(
                        'name'    => __('End Value', 'omega-admin-td'),
                        'desc'    => __('Value of the circular counter', 'omega-admin-td'),
                        'id'      => 'value',
                        'admin_label' => true,
                        'default'     =>  '',
                        'type'        => 'text',
                    ),
                    array(
                        'name'      => __('Number Format', 'omega-admin-td'),
                        'id'        => 'format',
                        'type'      => 'select',
                        'default'   => '(,ddd)',
                        'options' => array(
                            '(,ddd)'    => '12,345,678',
                            '(,ddd).dd' => '12,345,678.09',
                            '(.ddd),dd' => '12.345.678,09',
                            '( ddd),dd' => '12 345 678,09',
                            'd'         => '12345678',
                        ),
                        'desc'    => __('Sets format that the number in the counter will use.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Text Alignment', 'omega-admin-td'),
                        'id'        => 'align',
                        'type'      => 'select',
                        'default'   => 'center',
                        'options' => array(
                            'default'   => __('Default alignment', 'omega-admin-td'),
                            'left'      => __('Left', 'omega-admin-td'),
                            'center'    => __('Center', 'omega-admin-td'),
                            'right'     => __('Right', 'omega-admin-td'),
                            'justify'   => __('Justify', 'omega-admin-td')
                        ),
                        'desc'    => __('Sets the text alignment of the lead text.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Counter Font Size', 'omega-admin-td'),
                        'desc'    => __('Choose the size of the font to use in the counter', 'omega-admin-td'),
                        'id'      => 'counter_size',
                        'type'    => 'select',
                        'options' => array(
                            'normal'      => __('Normal', 'omega-admin-td'),
                            'super' => __('Super (60px)', 'omega-admin-td'),
                            'hyper' => __('Hyper (96px)', 'omega-admin-td'),
                        ),
                        'default' => 'normal',
                    ),
                    array(
                        'name'    => __('Counter Font Weight', 'omega-admin-td'),
                        'desc'    => __('Choose the weight of the font to use in the counter', 'omega-admin-td'),
                        'id'      => 'counter_weight',
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
                        'name'    => __('Underline', 'omega-admin-td'),
                        'desc'    => __('Underline the number.', 'omega-admin-td'),
                        'id'      => 'underline',
                        'type'    => 'select',
                        'options' => array(
                            'bordered'    => __('Underline', 'omega-admin-td'),
                            'no-bordered' => __('No Underline', 'omega-admin-td')
                        ),
                        'default' => 'bordered',
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'pricing' => array(
        'title'       => __('Pricing Column', 'omega-admin-td'),
        'desc'        => __('Displays a price info column.', 'omega-admin-td'),
        'shortcode'   => 'pricing',
        'insert_with' => 'dialog',
        'has_content' => false,
        'sections'   => array(
            array(
                'title' => __('Pricing Table', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'        => __('Heading', 'omega-admin-td'),
                        'desc'        => __('Heading text of the column', 'omega-admin-td'),
                        'id'          => 'heading',
                        'admin_label' => true,
                        'default'     =>  '',
                        'type'        => 'text',
                    ),
                    array(
                        'name'      => __('Featured Column', 'omega-admin-td'),
                        'id'        => 'featured',
                        'type'      => 'select',
                        'default'   =>  'false',
                        'options' => array(
                            'false' => __('Not Featured', 'omega-admin-td'),
                            'true'  => __('Featured', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Background Color', 'omega-admin-td'),
                        'id'        => 'pricing_background_colour',
                        'desc'      => __('Set the background color of the Pricing Column', 'omega-admin-td'),
                        'type'      => 'colour',
                        'default'   => '#82c9ed',
                    ),
                    array(
                        'name'      => __('Foreground Color', 'omega-admin-td'),
                        'id'        => 'pricing_foreground_colour',
                        'desc'      => __('Set the foreground color of the Pricing Column', 'omega-admin-td'),
                        'type'      => 'colour',
                        'default'   => '#FFFFFF',
                    ),
                    array(
                        'name'      => __('Show price', 'omega-admin-td'),
                        'id'        => 'show_price',
                        'type'      => 'select',
                        'default'   =>  'true',
                        'options' => array(
                            'true' => __('Show', 'omega-admin-td'),
                            'false' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Price Color', 'omega-admin-td'),
                        'id'        => 'pricing_colour',
                        'desc'      => __('Set the color of the Price', 'omega-admin-td'),
                        'type'      => 'colour',
                        'default'   => '#FFFFFF',
                    ),
                    array(
                        'name'      => __('Price background', 'omega-admin-td'),
                        'id'        => 'pricing_background',
                        'desc'      => __('Set the background of the Price', 'omega-admin-td'),
                        'type'      => 'colour',
                        'default'   => '#82c9ed',
                    ),
                    array(
                        'name'    => __('Price', 'omega-admin-td'),
                        'desc'    => __('Price to show at top of the column.', 'omega-admin-td'),
                        'id'      => 'price',
                        'default' =>  '',
                        'type'    => 'text',
                    ),
                    array(
                        'name'    => __('Price Currency', 'omega-admin-td'),
                        'desc'    => __('Price currency to show next to the price.', 'omega-admin-td'),
                        'id'      => 'currency',
                        'default' =>  '&#36;',
                        'type'    => 'select',
                        'options' => array(
                            '&#36;'   => __('Dollar', 'omega-admin-td'),
                            '&#128;'  => __('Euro', 'omega-admin-td'),
                            '&#163;'  => __('Pound', 'omega-admin-td'),
                            '&#165;'  => __('Yen', 'omega-admin-td'),
                            'custom' => __('Custom', 'omega-admin-td'),
                        )
                    ),
                    array(
                        'name'    => __('Custom Currency', 'omega-admin-td'),
                        'desc'    => __('If custom currency selected enter the html code here. e.g. <code>&#8359;</code>', 'omega-admin-td'),
                        'id'      => 'custom_currency',
                        'default' =>  '',
                        'type'    => 'text',
                    ),
                    array(
                        'name'    => __('After Price Text', 'omega-admin-td'),
                        'desc'    => __('Text to show after the price.', 'omega-admin-td'),
                        'id'      => 'per',
                        'default' =>  '',
                        'type'    => 'text',
                    ),
                    array(
                        'name'    => __('Item List', 'omega-admin-td'),
                        'desc'    => __('List of items to put in the column under the price. Divide categories with linebreaks (Enter)', 'omega-admin-td'),
                        'id'      => 'list',
                        'default' =>  '',
                        'type'    => 'exploded_textarea',
                    ),
                    array(
                        'name'      => __('Show button', 'omega-admin-td'),
                        'id'        => 'show_button',
                        'type'      => 'select',
                        'default'   =>  'true',
                        'options' => array(
                            'true' => __('Show', 'omega-admin-td'),
                            'false' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Button Text', 'omega-admin-td'),
                        'desc'    => __('Text to inside the button at the bottom of the column.', 'omega-admin-td'),
                        'id'      => 'button_text',
                        'default' =>  '',
                        'type'    => 'text',
                    ),
                    array(
                        'name'    => __('Button Link', 'omega-admin-td'),
                        'desc'    => __('Link that the button will point to.', 'omega-admin-td'),
                        'id'      => 'button_link',
                        'default' =>  '',
                        'type'    => 'text',
                    ),
                    array(
                        'name'      => __('Button background Color', 'omega-admin-td'),
                        'id'        => 'button_background_colour',
                        'desc'      => __('Set the background color of the button', 'omega-admin-td'),
                        'type'      => 'colour',
                        'default'   => '#FFFFFF',
                    ),
                    array(
                        'name'      => __('Button text Color', 'omega-admin-td'),
                        'id'        => 'button_foreground_colour',
                        'desc'      => __('Set the foreground color of the button', 'omega-admin-td'),
                        'type'      => 'colour',
                        'default'   => '#82c9ed',
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        ),
    ),
    'features_list' => array(
        'shortcode'   => 'features_list',
        'title'       => __('Features List', 'omega-admin-td'),
        'desc'        => __('Displays a list of features.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'has_content'   => false,
        'sections'    => array(
            array(
                'title'   => 'general',
                'fields'  => array(
                    array(
                        'name'      => __('Show Connections', 'omega-admin-td'),
                        'id'        => 'show_connections',
                        'type'      => 'select',
                        'default'   =>  'hide',
                        'options' => array(
                            'hide' => __('Hide', 'omega-admin-td'),
                            'show' => __('Show', 'omega-admin-td'),
                        ),
                        'desc'    => __('Show / Hide a connecting dotted line between features.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Connection Line Color', 'omega-admin-td'),
                        'desc'      => __('Set the colour of the connection dotted line.', 'omega-admin-td'),
                        'id'        => 'connection_line_colour',
                        'type'      => 'colour',
                        'default'   => '#82c9ed',
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'feature' => array(
        'shortcode'   => 'feature',
        'title'       => __('Feature', 'omega-admin-td'),
        'desc'        => __('Displays a shape with an icon alongside some text.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'has_content'   => false,
        'sections'    => array(
            array(
                'title'   => 'general',
                'fields'  => array(
                    array(
                        'name'      => __('Show Icon', 'omega-admin-td'),
                        'id'        => 'show_icon',
                        'type'      => 'select',
                        'default'   =>  'show',
                        'options' => array(
                            'show' => __('Show', 'omega-admin-td'),
                            'hide' => __('Hide', 'omega-admin-td'),
                        ),
                        'desc'    => __('Show / Hide the icon on the left.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Font Awesome Icon', 'omega-admin-td'),
                        'id'      => 'icon',
                        'desc'    => __('Select a font awesome icon that will appear in your features shape.', 'omega-admin-td'),
                        'id'      => 'fa_icon',
                        'type'    => 'select',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/fontawesome.php',
                        'default' => ''
                    ),
                    array(
                        'name'    => __('SVG Icon', 'omega-admin-td'),
                        'desc'    => __('Select a svg icon that will appear in your section shape.', 'omega-admin-td'),
                        'id'      => 'svg_icon',
                        'type'    => 'select',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/svgs.php',
                        'default' => '',
                    ),
                    array(
                        'name'      => __('Icon Colour', 'omega-admin-td'),
                        'desc'      => __('Set the colour of the icon ( svg & font awesome icons )', 'omega-admin-td'),
                        'id'        => 'icon_color',
                        'type'      => 'colour',
                        'default'   => '#FFFFFF',
                    ),
                    array(
                        'name'      => __('Background Colour', 'omega-admin-td'),
                        'desc'      => __('Set the colour shape background.', 'omega-admin-td'),
                        'id'        => 'background_color',
                        'type'      => 'colour',
                        'default'   => '#82c9ed',
                    ),
                    array(
                        'name'    => __('Hover Animation', 'PLUGIN_TD'),
                        'desc'    => __('Choose a hover animation for the feature icon.', 'PLUGIN_TD'),
                        'id'      => 'animation',
                        'type'    => 'select',
                        'default' => '',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/animations.php'
                    ),
                    array(
                        'name'        => __('Title', 'omega-admin-td'),
                        'id'          => 'title',
                        'type'        => 'text',
                        'admin_label' => true,
                        'default'     => '',
                        'desc'        => __('Choose a title for your featured item.', 'omega-admin-td'),
                    ),
                    array(
                        'name'        => __('Content', 'omega-admin-td'),
                        'id'          => 'content',
                        'type'        => 'textarea',
                        'default'     => '',
                        'desc'        => __('Content to show below title.', 'omega-admin-td'),
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'slideshow' => array(
        'shortcode'     => 'slideshow',
        'title'         => __('Slideshow', 'omega-admin-td'),
        'desc'          => __('Adds a Flexslider slideshow to the page.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Slideshow', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Choose a Flexslider', 'omega-admin-td'),
                        'desc'    => __('Populate your slider with one of the slideshows you created', 'omega-admin-td'),
                        'id'      => 'flexslider',
                        'default' =>  '',
                        'type'    => 'select',
                        'options' => 'slideshow',
                    ),
                    array(
                        'name'      =>  __('Animation style', 'omega-admin-td'),
                        'desc'      =>  __('Select how your slider animates', 'omega-admin-td'),
                        'id'        => 'animation',
                        'type'      => 'select',
                        'options'   =>  array(
                            'slide' => __('Slide', 'omega-admin-td'),
                            'fade'  => __('Fade', 'omega-admin-td'),
                        ),
                        'default'   => 'slide',
                    ),
                    array(
                        'name'      => __('Direction', 'omega-admin-td'),
                        'desc'      =>  __('Select the direction your slider slides', 'omega-admin-td'),
                        'id'        => 'direction',
                        'type'      => 'select',
                        'default'   =>  'horizontal',
                        'options' => array(
                            'horizontal' => __('Horizontal', 'omega-admin-td'),
                            'vertical'   => __('Vertical', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Duration', 'omega-admin-td'),
                        'desc'      => __('Select how long each color will stay, in milliseconds', 'omega-admin-td'),
                        'id'        => 'duration',
                        'type'      => 'slider',
                        'default'   => '600',
                        'attr'      => array(
                            'max'       => 1500,
                            'min'       => 200,
                            'step'      => 100
                        )
                    ),
                    array(
                        'name'      => __('Speed', 'omega-admin-td'),
                        'desc'      => __('Select how fast the colors will change, in milliseconds', 'omega-admin-td'),
                        'id'        => 'speed',
                        'type'      => 'slider',
                        'default'   => '7000',
                        'attr'      => array(
                            'max'       => 15000,
                            'min'       => 2000,
                            'step'      => 1000
                        )
                    ),
                    array(
                        'name'      => __('Auto start', 'omega-admin-td'),
                        'id'        => 'autostart',
                        'type'      => 'select',
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
                        'type'      => 'select',
                        'default'   =>  'hide',
                        'options' => array(
                            'show' => __('Show', 'omega-admin-td'),
                            'hide' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                     array(
                        'name'      => __('Item width', 'omega-admin-td'),
                        'desc'      => __('Set width of the slider items( leave blank for full )', 'omega-admin-td'),
                        'id'        => 'itemwidth',
                        'type'      => 'text',
                        'default'   => '',
                        'attr'      =>  array(
                            'size'    => 8,
                        ),
                    ),
                    array(
                        'name'      => __('Show controls', 'omega-admin-td'),
                        'id'        => 'showcontrols',
                        'type'      => 'select',
                        'default'   =>  'show',
                        'options' => array(
                            'show' => __('Show', 'omega-admin-td'),
                            'hide' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Choose the place of the controls', 'omega-admin-td'),
                        'id'        => 'controlsposition',
                        'type'      => 'select',
                        'default'   =>  'inside',
                        'options' => array(
                            'inside'    => __('Inside', 'omega-admin-td'),
                            'outside'   => __('Outside', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      =>  __('Choose the alignment of the controls', 'omega-admin-td'),
                        'id'        => 'controlsalign',
                        'type'      => 'select',
                        'default'   => 'center',
                        'options'   =>  array(
                            'center' => __('Center', 'omega-admin-td'),
                            'left'   => __('Left', 'omega-admin-td'),
                            'right'  => __('Right', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Controls Vertical Position', 'omega-admin-td'),
                        'id'        => 'controls_vertical',
                        'type'      => 'select',
                        'default'   =>  'bottom',
                        'options' => array(
                            'top'    => __('Top', 'omega-admin-td'),
                            'bottom' => __('Bottom', 'omega-admin-td'),
                        ),
                    ),
                )
            ),
            array(
                'title' => __('Captions', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Show Captions', 'omega-admin-td'),
                        'id'        => 'captions',
                        'type'      => 'select',
                        'default'   =>  'show',
                        'options' => array(
                            'show' => __('Show', 'omega-admin-td'),
                            'hide' => __('Hide', 'omega-admin-td'),
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
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'vc_single_image' => array(
        'shortcode'     => 'vc_single_image',
        'title'         => __('Image', 'omega-admin-td'),
        'desc'          => __('Displays an image.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Image', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Image Source', 'omega-admin-td'),
                        'id'      => 'image',
                        'type'    => 'upload',
                        'store'   => 'id',
                        'default' => '',
                        'desc'    => __('Place the source path of the image here', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Image size', 'omega-admin-td'),
                        'desc'    => __('Select the dimensions of the image that will be used.  See Settings -> Media for sizes.', 'omega-admin-td'),
                        'id'      => 'size',
                        'type'    => 'select',
                        'default' => 'medium',
                        'options' => array(
                            'thumbnail' => __('Thumbnail', 'omega-admin-td'),
                            'medium'    => __('Medium', 'omega-admin-td'),
                            'large'     => __('Large', 'omega-admin-td'),
                            'full'      => __('Full', 'omega-admin-td')
                        ),
                    ),
                    array(
                        'name'    => __('Image stretch', 'omega-admin-td'),
                        'desc'    => __('Allows you to make the image stretch to fit its container.', 'omega-admin-td'),
                        'id'      => 'image_stretch',
                        'type'    => 'select',
                        'default' => 'normalwidth',
                        'options' => array(
                            'normalwidth' => __("Don't Stretch", 'omega-admin-td'),
                            'fullwidth'    => __('Stretch Full Width', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Image Alt', 'omega-admin-td'),
                        'id'      => 'alt',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('Place the alt of the image here', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Image Title', 'omega-admin-td'),
                        'id'      => 'title',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('Place the title attribute of the image here', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Hover Overlay Type', 'omega-admin-td'),
                        'id'        => 'overlay',
                        'type'      => 'select',
                        'default'   => 'icon',
                        'options' => array(
                            'icon'         => __('Show Icon', 'omega-admin-td'),
                            'caption'      => __('Show Title & Caption', 'omega-admin-td'),
                            'strip'        => __('Show Title Strip & Caption', 'omega-admin-td'),
                            'buttons'      => __('Show Title & Buttons', 'omega-admin-td'),
                            'buttons_only' => __('Buttons Only', 'omega-admin-td'),
                            'none'         => __('No Hover Overlay', 'omega-admin-td'),
                        ),
                        'desc'    => __('Choose the type of hover overlay you would like to appear.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Hover Overlay Link Type', 'PLUGIN_TD'),
                        'desc'    => __('Select the link type to use for the item.', 'PLUGIN_TD'),
                        'id'      => 'item_link_type',
                        'type'    => 'select',
                        'default' => 'magnific',
                        'options' => array(
                            'magnific' => __('Magnific', 'PLUGIN_TD'),
                            'item'     => __('Link', 'PLUGIN_TD'),
                            'no-link'  => __('No Link ', 'PLUGIN_TD'),
                        ),
                    ),
                    array(
                        'name'    => __('Link', 'omega-admin-td'),
                        'id'      => 'link',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('Link that the item will link to if you select link in Item Link Type', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Open Link In', 'omega-admin-td'),
                        'id'      => 'link_target',
                        'type'    => 'select',
                        'default' => '_self',
                        'options' => array(
                            '_self'   => __('Same page as it was clicked ', 'omega-admin-td'),
                            '_blank'  => __('Open in new window/tab', 'omega-admin-td'),
                        ),
                        'desc'    => __('Where the link will open.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Show Captions Below', 'omega-admin-td'),
                        'desc'    => __('Show captions below image.', 'omega-admin-td'),
                        'id'      => 'captions_below',
                        'type'    => 'select',
                        'default' => 'hide',
                        'options' => array(
                            'hide' => __('Hide Captions', 'omega-admin-td'),
                            'show' => __('Show Captions', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Link Caption Title Below', 'omega-admin-td'),
                        'desc'    => __('Makes the Captions Below Title a link.', 'omega-admin-td'),
                        'id'      => 'captions_below_link_type',
                        'type'    => 'select',
                        'default' => 'item',
                        'options' => array(
                            'magnific' => __('Magnific', 'PLUGIN_TD'),
                            'item'     => __('Link', 'PLUGIN_TD'),
                            'no-link'  => __('No Link ', 'PLUGIN_TD'),
                        ),
                    ),
                    array(
                        'name'    => __('Caption Title', 'omega-admin-td'),
                        'id'      => 'caption_title',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('This text will be used for the caption title.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Caption', 'omega-admin-td'),
                        'id'      => 'caption_text',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('This text will be shown below the caption title.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Caption Text Alignment', 'omega-admin-td'),
                        'id'        => 'caption_align',
                        'type'      => 'select',
                        'default'   => 'center',
                        'options' => array(
                            'left'   => __('Left', 'omega-admin-td'),
                            'center' => __('Center', 'omega-admin-td'),
                            'right'  => __('Right', 'omega-admin-td'),
                            'justify'  => __('Justify', 'omega-admin-td')
                        ),
                        'desc'    => __('The text alignment of the caption text / title.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Hover Effects Filter', 'omega-admin-td'),
                        'id'      => 'hover_filter',
                        'type'    => 'select',
                        'default' => 'none',
                        'options' => array(
                            'none'      => __('None', 'omega-admin-td'),
                            'sepia'     => __('Sepia', 'omega-admin-td'),
                            'grayscale' => __('Grayscale', 'omega-admin-td'),
                            'blur'      => __('Blur', 'omega-admin-td'),
                        ),
                        'desc'    => __('Effects filter to apply to the image on hover.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Hover Effects Filter Behaviour', 'omega-admin-td'),
                        'id'      => 'hover_filter_invert',
                        'type'    => 'select',
                        'default' => 'image-filter-onhover',
                        'options' => array(
                            'image-filter-onhover'    => __('Apply Filter On Hover', 'omega-admin-td'),
                            'image-filter-invert'     => __('Apply Filter On Hover Out', 'omega-admin-td'),
                        ),
                        'desc'    => __('When to apply the Hover Effects Filter.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Zoom Button Text', 'omega-admin-td'),
                        'id'      => 'button_text_zoom',
                        'type'    => 'text',
                        'default' => __('View Larger', 'omega-admin-td'),
                        'desc'    => __('This text will be shown in the zoom button.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Link Button Text', 'omega-admin-td'),
                        'id'      => 'button_text_details',
                        'type'    => 'text',
                        'default' => __('More Details', 'omega-admin-td'),
                        'desc'    => __('This text will be shown below the link button.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Overlay Caption Vertical Alignment', 'omega-admin-td'),
                        'id'        => 'overlay_caption_vertical',
                        'type'      => 'select',
                        'default'   => 'middle',
                        'options' => array(
                            'top'    => __('Top', 'omega-admin-td'),
                            'middle' => __('Middle', 'omega-admin-td'),
                            'bottom' => __('Bottom', 'omega-admin-td'),
                        ),
                        'desc'    => __('Vertical alignment of the caption title and text.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Overlay Animation', 'omega-admin-td'),
                        'id'      => 'overlay_animation',
                        'type'    => 'select',
                        'default' => 'fade-in',
                        'options' => array(
                            'fade-in'             => __('Fade in', 'omega-admin-td'),
                            'fade-in from-top'    => __('Fade From Top', 'omega-admin-td'),
                            'fade-in from-bottom' => __('Fade From Bottom', 'omega-admin-td'),
                            'fade-in from-left'   => __('Fade From Left', 'omega-admin-td'),
                            'fade-in from-right'  => __('Fade From Right', 'omega-admin-td'),
                            'preview-bottom'      => __('Caption band at bottom of image', 'omega-admin-td'),
                            'fade-none'           => __('No Animation', 'omega-admin-td'),
                        ),
                        'desc'    => __('What animation will be used to reveal the image hover overlay.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Overlay Grid', 'omega-admin-td'),
                        'desc'      => __('Grid pattern to apply over the image on hover.', 'omega-admin-td'),
                        'id'        => 'overlay_grid',
                        'type'      => 'slider',
                        'default'   => '0',
                        'attr'      => array(
                            'max'       => 100,
                            'min'       => 0,
                            'step'      => 10,
                        )
                    ),
                    array(
                        'name'      => __('Overlay Icon', 'omega-admin-td'),
                        'desc'      => __('Icon to show on the hover overlay.', 'omega-admin-td'),
                        'id'        => 'overlay_icon',
                        'type'    => 'select',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/svgs.php',
                        'default' => 'link',
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'shapedimage' => array(
        'shortcode'     => 'shapedimage',
        'title'         => __('Shaped Image', 'omega-admin-td'),
        'desc'          => __('Displays an image that is clipped to a shape.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Image', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Image Source', 'omega-admin-td'),
                        'id'      => 'image',
                        'type'    => 'upload',
                        'store'   => 'id',
                        'default' => '',
                        'desc'    => __('Choose an image to use.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Image size', 'omega-admin-td'),
                        'desc'    => __('Choose the size that the image will have', 'omega-admin-td'),
                        'id'      => 'shape_size',
                        'type'    => 'select',
                        'default' => 'medium',
                        'admin_label' => true,
                        'options' => array(
                            'normal' => __('Normal', 'omega-admin-td'),
                            'mini'   => __('Mini', 'omega-admin-td'),
                            'small'  => __('Small', 'omega-admin-td'),
                            'medium' => __('Medium', 'omega-admin-td'),
                            'big'    => __('Big', 'omega-admin-td'),
                            'huge'   => __('Huge', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Shape', 'omega-admin-td'),
                        'desc'    => __('Choose if the image will be rounded or not', 'omega-admin-td'),
                        'id'      => 'shape',
                        'type'    => 'select',
                        'default' => 'round',
                        'options'    => array(
                            'square' => __('Square', 'omega-admin-td'),
                            'round'  => __('Circle', 'omega-admin-td'),
                        )
                    ),
                    array(
                        'name'    => __('Hover Animation', 'PLUGIN_TD'),
                        'desc'    => __('Choose a hover animation', 'PLUGIN_TD'),
                        'id'      => 'animation',
                        'type'    => 'select',
                        'default' => 'none',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/animations.php'
                    ),
                    array(
                        'name'    => __('Open In Magnific Popup', 'PLUGIN_TD'),
                        'desc'    => __('Open the original image in magnific on click (overrides link option)', 'PLUGIN_TD'),
                        'id'      => 'magnific',
                        'type'    => 'select',
                        'default' => 'off',
                        'options' => array(
                            'on'    => __('On', 'PLUGIN_TD'),
                            'off'   => __('Off', 'PLUGIN_TD'),
                        ),
                    ),
                    array(
                        'name'    => __('Image Alt', 'omega-admin-td'),
                        'id'      => 'alt',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('Place the alt of the image here', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Image Title', 'omega-admin-td'),
                        'id'      => 'title',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('Place the title attribute of the image here', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Link', 'omega-admin-td'),
                        'id'      => 'link',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('Place a link here', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Open Links In', 'omega-admin-td'),
                        'id'      => 'link_target',
                        'type'    => 'select',
                        'default' => '_self',
                        'options' => array(
                            '_self'   => __('Same page as it was clicked ', 'omega-admin-td'),
                            '_blank'  => __('Open in new window/tab', 'omega-admin-td'),
                        ),
                        'desc'    => __('Where the link will open.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Hover Grid', 'omega-admin-td'),
                        'desc'      => __('Adds an overlay pattern image when you hover over the image.', 'omega-admin-td'),
                        'id'        => 'overlay_grid',
                        'type'      => 'slider',
                        'default'   => '0',
                        'attr'      => array(
                            'max'       => 100,
                            'min'       => 0,
                            'step'      => 10,
                        )
                    ),
                    array(
                        'name'      => __('Background Colour', 'omega-admin-td'),
                        'desc'      => __('Set the colour shape background (will be seen if transparant images are used)', 'omega-admin-td'),
                        'id'        => 'background_colour',
                        'type'      => 'colour',
                        'default'   => '#e9e9e9',
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'featuredicon' => array(
        'shortcode'     => 'featuredicon',
        'title'         => __('Featured Icon', 'omega-admin-td'),
        'desc'          => __('Creates a shape with an Font Awesome icon in the middle.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Icon', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Icon', 'omega-admin-td'),
                        'id'      => 'icon',
                        'type'    => 'select',
                        'options' => 'icons',
                        'default' => 'glass',
                        'admin_label' => true,
                        'desc'    => __('Choose an icon to use in your featured icon', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Featured Icon Size', 'omega-admin-td'),
                        'desc'    => __('Choose the size that the image will have', 'omega-admin-td'),
                        'id'      => 'shape_size',
                        'type'    => 'select',
                        'default' => 'medium',
                        'admin_label' => true,
                        'options' => array(
                            'normal' => __('Normal', 'omega-admin-td'),
                            'mini'   => __('Mini', 'omega-admin-td'),
                            'small'  => __('Small', 'omega-admin-td'),
                            'medium' => __('Medium', 'omega-admin-td'),
                            'big'    => __('Big', 'omega-admin-td'),
                            'huge'   => __('Huge', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'        => __('Shape', 'omega-admin-td'),
                        'desc'        => __('Choose if the image will be roundrd or not', 'omega-admin-td'),
                        'id'          => 'shape',
                        'type'        => 'select',
                        'default'     => 'round',
                        'admin_label' => true,
                        'options'     => array(
                            'rect'   => __('Rectangle', 'omega-admin-td'),
                            'square' => __('Square', 'omega-admin-td'),
                            'round'  => __('Circle', 'omega-admin-td'),
                        )
                    ),
                    array(
                        'name'    => __('Icon Link', 'PLUGIN_TD'),
                        'desc'    => __('Make the icon link to a web url.', 'PLUGIN_TD'),
                        'id'      => 'link',
                        'type'    => 'text',
                        'default' => '',
                    ),
                    array(
                        'name'    => __('Hover Animation', 'PLUGIN_TD'),
                        'desc'    => __('Choose an icon animation', 'PLUGIN_TD'),
                        'id'      => 'animation',
                        'type'    => 'select',
                        'default' => '',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/animations.php'
                    ),
                    array(
                        'name'      => __('Background Grid', 'omega-admin-td'),
                        'desc'      => __('Adds an overlay pattern to the shape background.', 'omega-admin-td'),
                        'id'        => 'overlay_grid',
                        'type'      => 'slider',
                        'default'   => '0',
                        'attr'      => array(
                            'max'       => 100,
                            'min'       => 0,
                            'step'      => 10,
                        )
                    ),
                    array(
                        'name'      => __('Icon Colour', 'omega-admin-td'),
                        'desc'      => __('Set the colour of the icon', 'omega-admin-td'),
                        'id'        => 'icon_colour',
                        'type'      => 'colour',
                        'default'   => '#000000',
                    ),
                    array(
                        'name'      => __('Background Colour', 'omega-admin-td'),
                        'desc'      => __('Set the colour shape background.', 'omega-admin-td'),
                        'id'        => 'background_colour',
                        'type'      => 'colour',
                        'default'   => '#e9e9e9',
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'svgfeaturedicon' => array(
        'shortcode'     => 'svgfeaturedicon',
        'title'         => __('Featured SVG Icon', 'omega-admin-td'),
        'desc'          => __('Creates a shape with an svg icon in the middle.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Icon', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Icon', 'omega-admin-td'),
                        'id'      => 'icon',
                        'type'    => 'select',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/svgs.php',
                        'default' => 'link',
                        'desc'    => __('Choose an icon to use in your featured icon', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Featured Icon Size', 'omega-admin-td'),
                        'desc'    => __('Choose the size that the image will have', 'omega-admin-td'),
                        'id'      => 'shape_size',
                        'type'    => 'select',
                        'default' => 'medium',
                        'admin_label' => true,
                        'options' => array(
                            'normal' => __('Normal', 'omega-admin-td'),
                            'mini'   => __('Mini', 'omega-admin-td'),
                            'small'  => __('Small', 'omega-admin-td'),
                            'medium' => __('Medium', 'omega-admin-td'),
                            'big'    => __('Big', 'omega-admin-td'),
                            'huge'   => __('Huge', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'        => __('Shape', 'omega-admin-td'),
                        'desc'        => __('Choose if the image will be roundrd or not', 'omega-admin-td'),
                        'id'          => 'shape',
                        'type'        => 'select',
                        'default'     => 'round',
                        'admin_label' => true,
                        'options'     => array(
                            'rect'   => __('Rectangle', 'omega-admin-td'),
                            'square' => __('Square', 'omega-admin-td'),
                            'round'  => __('Circle', 'omega-admin-td'),
                        )
                    ),
                    array(
                        'name'    => __('Icon Link', 'PLUGIN_TD'),
                        'desc'    => __('Make the icon link to a web url.', 'PLUGIN_TD'),
                        'id'      => 'link',
                        'type'    => 'text',
                        'default' => '',
                    ),
                    array(
                        'name'    => __('Hover Animation', 'PLUGIN_TD'),
                        'desc'    => __('Choose an icon animation', 'PLUGIN_TD'),
                        'id'      => 'animation',
                        'type'    => 'select',
                        'default' => '',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/animations.php'
                    ),
                    array(
                        'name'      => __('Background Grid', 'omega-admin-td'),
                        'desc'      => __('Adds an overlay pattern to the shape background.', 'omega-admin-td'),
                        'id'        => 'overlay_grid',
                        'type'      => 'slider',
                        'default'   => '0',
                        'attr'      => array(
                            'max'       => 100,
                            'min'       => 0,
                            'step'      => 10,
                        )
                    ),
                    array(
                        'name'      => __('Icon Colour', 'omega-admin-td'),
                        'desc'      => __('Set the colour of the icon', 'omega-admin-td'),
                        'id'        => 'icon_colour',
                        'type'      => 'colour',
                        'default'   => '#000000',
                    ),
                    array(
                        'name'      => __('Background Colour', 'omega-admin-td'),
                        'desc'      => __('Set the colour shape background.', 'omega-admin-td'),
                        'id'        => 'background_colour',
                        'type'      => 'colour',
                        'default'   => '#e9e9e9',
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'icon' => array(
        'shortcode'   => 'icon',
        'title'       => __('Icon', 'PLUGIN_TD'),
        'desc'        => __('Displays a Font Awesome icon.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => 'General',
                'fields'  => array(
                    array(
                        'name'    => __('Font Size', 'PLUGIN_TD'),
                        'desc'    => __('Size of font to use for icon ( set to 0 to inhertit font size from container )', 'PLUGIN_TD'),
                        'id'      => 'size',
                        'type'    => 'slider',
                        'default' => '16',
                        'attr'    => array(
                            'max'  => 48,
                            'min'  => 0,
                            'step' => 1
                        )
                    ),
                )
            ),
            array(
                'title'   => 'Icon',
                'fields'  => array(
                    array(
                        'name'    => __('Icon', 'PLUGIN_TD'),
                        'desc'    => __('Type of button to display', 'PLUGIN_TD'),
                        'id'      => 'content',
                        'type'    => 'select',
                        'options' => 'icons',
                        'default' => 'glass',
                        'admin_label' => true
                    )
                ),
            ),
        ),
    ),
    'button' =>  array(
        'shortcode'   => 'button',
        'title'       => __('Button', 'PLUGIN_TD'),
        'desc'        => __('Creates a fancy call to action button with or without an icon.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => 'General',
                'fields'  => array(
                    array(
                        'name'    => __('Button type', 'PLUGIN_TD'),
                        'desc'    => __('Type of button to display', 'PLUGIN_TD'),
                        'id'      => 'type',
                        'type'    => 'select',
                        'default' => 'default',
                        'admin_label' => true,
                        'options' => array(
                            'default' => __('Default', 'PLUGIN_TD'),
                            'primary' => __('Primary', 'PLUGIN_TD'),
                            'info'    => __('Info', 'PLUGIN_TD'),
                            'success' => __('Success', 'PLUGIN_TD'),
                            'warning' => __('Warning', 'PLUGIN_TD'),
                            'danger'  => __('Danger', 'PLUGIN_TD'),
                            'link'    => __('Link', 'PLUGIN_TD'),
                        ),
                    ),
                    array(
                        'name'    => __('Button size', 'PLUGIN_TD'),
                        'desc'    => __('Size of button to display', 'PLUGIN_TD'),
                        'id'      => 'size',
                        'type'    => 'select',
                        'default' => 'normal',
                        'options' => array(
                            'normal'      => __('Default', 'PLUGIN_TD'),
                            'lg' => __('Large', 'PLUGIN_TD'),
                            'sm'      => __('Small', 'PLUGIN_TD'),
                        ),
                    ),
                    array(
                        'name'    => __('Text', 'PLUGIN_TD'),
                        'id'      => 'label',
                        'type'    => 'text',
                        'admin_label' => true,
                        'default' => __('My button', 'PLUGIN_TD'),
                        'desc'    => __('Add a label to the button', 'PLUGIN_TD'),
                    ),
                    array(
                        'name'        => __('Open Modal', 'omega-admin-td'),
                        'desc'        => __('Select the modal to open on click(overrides the link option)', 'omega-admin-td'),
                        'id'          => 'modal',
                        'type'        => 'select',
                        'default'     => '',
                        'blank'       => __('None', 'omega-admin-td'),
                        'options'     => 'custom_post_id',
                        'post_type'   => 'oxy_modal',
                    ),
                    array(
                        'name'    => __('Link', 'PLUGIN_TD'),
                        'id'      => 'link',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('Where the button links to', 'PLUGIN_TD'),
                    ),
                )
            ),
            array(
                'title'   => 'Advanced',
                'fields'  => array(
                    array(
                        'name'    => __('Extra classes', 'PLUGIN_TD'),
                        'id'      => 'xclass',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('Add an extra class to the button', 'PLUGIN_TD'),
                    ),
                    array(
                        'name'    => __('Open Link In', 'PLUGIN_TD'),
                        'id'      => 'link_open',
                        'type'    => 'select',
                        'default' => '_self',
                        'options' => array(
                            '_self'   => __('Same page as it was clicked ', 'PLUGIN_TD'),
                            '_blank'  => __('Open in new window/tab', 'PLUGIN_TD'),
                            '_parent' => __('Open the linked document in the parent frameset', 'PLUGIN_TD'),
                            '_top'    => __('Open the linked document in the full body of the window', 'PLUGIN_TD')
                        ),
                        'desc'    => __('Where the button link opens to', 'PLUGIN_TD'),
                    ),
                )
            ),
            array(
                'title'   => 'Icon',
                'fields'  => array(
                    array(
                        'name'    => __('Icon Position', 'PLUGIN_TD'),
                        'desc'    => __('Which side of the button to show the icon.', 'PLUGIN_TD'),
                        'id'      => 'icon_position',
                        'type'    => 'select',
                        'default' => 'left',
                        'options' => array(
                            'left'  => __('Left', 'PLUGIN_TD'),
                            'right' => __('Right', 'PLUGIN_TD'),
                        ),
                    ),
                    array(
                        'name'    => __('Icon Animation', 'PLUGIN_TD'),
                        'desc'    => __('Choose an icon animation', 'PLUGIN_TD'),
                        'id'      => 'animation',
                        'type'    => 'select',
                        'default' => 'none',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/animations.php'
                    ),
                    array(
                        'name'    => __('Icon', 'PLUGIN_TD'),
                        'desc'    => __('Icon to display', 'PLUGIN_TD'),
                        'id'      => 'icon',
                        'admin_label' => true,
                        'type'    => 'select',
                        'options' => 'icons',
                        'default' => ''
                    ),
                    array(
                        'name'      => __('Custom Color', 'omega-admin-td'),
                        'desc'      => __('Sets custom colors for the button', 'omega-admin-td'),
                        'id'        => 'custom_color',
                        'type'      => 'select',
                        'options'   => array(
                            'true'  => __('On', 'omega-admin-td'),
                            'false' => __('Off', 'omega-admin-td'),
                        ),
                        'default'   =>  'false',
                    ),
                    array(
                        'name'      => __('Button Background Color', 'omega-admin-td'),
                        'desc'      => __('Change the background color of the button', 'omega-admin-td'),
                        'id'        => 'background_color',
                        'type'      => 'colour',
                        'default'   => '#82c9ed',
                    ),
                    array(
                        'name'      => __('Text Font Color', 'omega-admin-td'),
                        'desc'      => __('Change the font color of the text on the button', 'omega-admin-td'),
                        'id'        => 'text_font_color',
                        'type'      => 'colour',
                        'default'   => '#fff',
                    ),
                ),
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        ),
    ),
    'vc_jumbotron' => array(
        'shortcode'   => 'vc_jumbotron',
        'title'       => __('Jumbotron', 'PLUGIN_TD'),
        'desc'          => __('Creates a Jumbotron bootstrap component.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => __('General', 'PLUGIN_TD'),
                'fields'  => array(
                    array(
                        'name'    => __('Title', 'PLUGIN_TD'),
                        'id'      => 'title',
                        'type'    => 'text',
                        'holder'  => 'h1',
                        'default' => __('', 'PLUGIN_TD'),
                        'desc'    => __('The title of the jumbotron', 'PLUGIN_TD'),
                    ),
                    array(
                        'name'    => __('Main Text', 'PLUGIN_TD'),
                        'id'      => 'content',
                        'type'    => 'textarea_html',
                        'default' => __('This is a simple hero unit.', 'PLUGIN_TD'),
                        'desc'    => __('Main text that will appear in the jumbotron', 'PLUGIN_TD'),
                    )
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        ),
    ),
    'vc_message' => array(
        'shortcode'   => 'vc_message',
        'title'       => __('Alert', 'PLUGIN_TD'),
        'desc'          => __('Creates a Bootstrap Alert box.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => __('General', 'PLUGIN_TD'),
                'fields'  => array(
                    array(
                        'name'    => __('Alert type', 'PLUGIN_TD'),
                        'desc'    => __('Type of alert to display', 'PLUGIN_TD'),
                        'id'      => 'color',
                        'type'    => 'select',
                        'default' => 'alert-success',
                        'options' => array(
                            'alert-success' => __('Success', 'PLUGIN_TD'),
                            'alert-info'    => __('Information', 'PLUGIN_TD'),
                            'alert-warning' => __('Warning', 'PLUGIN_TD'),
                            'alert-danger'  => __('Danger', 'PLUGIN_TD'),
                        ),
                    ),
                    array(
                        'name'    => __('Title', 'PLUGIN_TD'),
                        'id'      => 'title',
                        'type'    => 'text',
                        'holder'  => 'h2',
                        'default' => __('Watch Out!', 'PLUGIN_TD'),
                        'desc'    => __('The bold text that appears first in the alert', 'PLUGIN_TD'),
                    ),
                    array(
                        'name'    => __('Main Text', 'PLUGIN_TD'),
                        'id'      => 'content',
                        'type'    => 'text',
                        'holder'  => 'div',
                        'default' => __('Change a few things up and try submitting again.', 'PLUGIN_TD'),
                        'desc'    => __('Main text that will appear in the alert box', 'PLUGIN_TD'),
                    ),
                    array(
                        'name'    => __('Dismissable', 'PLUGIN_TD'),
                        'id'      => 'dismissable',
                        'type'    => 'select',
                        'default' => 'false',
                        'desc'    => __('Defines if the alert can be removed using an x in the corner.', 'PLUGIN_TD'),
                        'options' => array(
                            'true'  => __('Closable', 'PLUGIN_TD'),
                            'false' => __('Not Closable', 'PLUGIN_TD'),
                        ),
                    )
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        ),
    ),
    'carousel' => array(
        'shortcode'     => 'carousel',
        'title'         => __('Carousel', 'omega-admin-td'),
        'desc'          => __('Adds a Carousel slideshow to the page.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Carousel', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Choose a slideshow', 'omega-admin-td'),
                        'desc'    => __('Populate your slider with one of the slideshows you created', 'omega-admin-td'),
                        'id'      => 'carousel',
                        'default' =>  '',
                        'type'    => 'select',
                        'options' => 'slideshow',
                    ),
                    array(
                        'name'    => __('Carousel Count', 'omega-admin-td'),
                        'desc'    => __('Number of slides to show, set to 0 to show all', 'omega-admin-td'),
                        'id'      => 'count',
                        'type'    => 'slider',
                        'default' => '0',
                        'admin_label' => true,
                        'attr'    => array(
                            'max'  => 30,
                            'min'  => 0,
                            'step' => 1
                        )
                    ),
                    array(
                        'name'      => __('Show navigation arrows', 'omega-admin-td'),
                        'id'        => 'directionnav',
                        'type'      => 'select',
                        'default'   =>  'show',
                        'options' => array(
                            'show' => __('Show', 'omega-admin-td'),
                            'hide' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Show controls', 'omega-admin-td'),
                        'id'        => 'showcontrols',
                        'type'      => 'select',
                        'default'   =>  'show',
                        'options' => array(
                            'show' => __('Show', 'omega-admin-td'),
                            'hide' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                )
            ),
            array(
                'title' => __('Captions', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Show Captions', 'omega-admin-td'),
                        'id'        => 'captions',
                        'type'      => 'select',
                        'default'   =>  'show',
                        'options' => array(
                            'show' => __('Show', 'omega-admin-td'),
                            'hide' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'panel' => array(
        'shortcode' => 'panel',
        'title'     => __('Panel', 'PLUGIN_TD'),
        'desc'      => __('Creates a Bootstrap Panel with a title and some content.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => __('General', 'PLUGIN_TD'),
                'fields'  => array(
                    array(
                        'name'    => __('Title', 'PLUGIN_TD'),
                        'id'      => 'title',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('The title of the panel.', 'PLUGIN_TD'),
                    ),
                    array(
                        'name'    => __('Panel Style', 'PLUGIN_TD'),
                        'desc'    => __('Style of panel to display', 'PLUGIN_TD'),
                        'id'      => 'style',
                        'type'    => 'select',
                        'default' => 'panel-default',
                        'options' => array(
                            'panel-default' => __('Default', 'PLUGIN_TD'),
                            'panel-primary'  => __('Primary', 'PLUGIN_TD'),
                            'panel-info'     => __('Info', 'PLUGIN_TD'),
                            'panel-success'  => __('Success', 'PLUGIN_TD'),
                            'panel-warning'  => __('Warning', 'PLUGIN_TD'),
                            'panel-danger'   => __('Danger', 'PLUGIN_TD'),
                        )
                    )
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        ),
    ),
    'progress' =>    array(
        'shortcode'   => 'progress',
        'title'       => __('Progress Bar', 'PLUGIN_TD'),
        'desc'        => __('Creates a Bootstrap progress bar with a % value.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => 'general',
                'fields'  => array(
                    array(
                        'name'    => __('Percentage', 'PLUGIN_TD'),
                        'desc'    => __('Percentage of the progress bar', 'PLUGIN_TD'),
                        'id'      => 'percentage',
                        'type'    => 'slider',
                        'default' => '50',
                        'attr'    => array(
                            'max'  => 100,
                            'min'  => 1,
                            'step' => 1
                        )
                    ),
                    array(
                        'name'    => __('Progress Bar Text', 'PLUGIN_TD'),
                        'desc'    => __('Text to be displayed on the progress bar', 'PLUGIN_TD'),
                        'id'      => 'progress_text',
                        'type'    => 'text',
                        'holder'  => 'h3',
                        'default' => ''
                    ),
                    array(
                        'name'    => __('Bar Type', 'PLUGIN_TD'),
                        'desc'    => __('Type of bar to display', 'PLUGIN_TD'),
                        'id'      => 'type',
                        'type'    => 'select',
                        'default' => 'progress',
                        'options' => array(
                            'progress'                        => __('Normal', 'PLUGIN_TD'),
                            'progress progress-striped'       => __('Striped', 'PLUGIN_TD'),
                            'progress progress-striped active'=> __('Animated', 'PLUGIN_TD'),
                        ),
                    ),
                    array(
                        'name'    => __('Bar Style', 'PLUGIN_TD'),
                        'desc'    => __('Style of bar to display', 'PLUGIN_TD'),
                        'id'      => 'style',
                        'type'    => 'select',
                        'default' => 'progress-bar-info',
                        'options' => array(
                            'progress-bar-primary'  => __('Primary', 'PLUGIN_TD'),
                            'progress-bar-info'     => __('Info', 'PLUGIN_TD'),
                            'progress-bar-success'  => __('Success', 'PLUGIN_TD'),
                            'progress-bar-warning'  => __('Warning', 'PLUGIN_TD'),
                            'progress-bar-danger'   => __('Danger', 'PLUGIN_TD'),
                        ),
                    ),
                ),
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        ),
    ),
    'lead' => array(
        'shortcode'   => 'lead',
        'title'       => __('Lead Paragraph', 'PLUGIN_TD'),
        'desc'        => __('Adds a lead paragraph, with slightly larger and bolder text.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => 'general',
                'fields'  => array(
                    array(
                        'name'      => __('Text Alignment', 'omega-admin-td'),
                        'id'        => 'align',
                        'type'      => 'select',
                        'default'   => 'center',
                        'options' => array(
                            'default'   => __('Default alignment', 'omega-admin-td'),
                            'left'   => __('Left', 'omega-admin-td'),
                            'center' => __('Center', 'omega-admin-td'),
                            'right'  => __('Right', 'omega-admin-td'),
                            'justify'  => __('Justify', 'omega-admin-td')
                        ),
                        'desc'    => __('Sets the text alignment of the lead text.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Lead Text', 'omega-admin-td'),
                        'holder'    => 'p',
                        'id'        => 'content',
                        'type'      => 'textarea',
                        'default'   => '',
                        'desc'    => __('Text to show in the lead text paragraph.', 'omega-admin-td'),
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'blockquote' => array(
        'shortcode'   => 'blockquote',
        'title'       => __('Blockquote', 'PLUGIN_TD'),
        'desc'        => __('Creates a quotation.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => 'general',
                'fields'  => array(
                    array(
                        'name'      => __('Text Alignment', 'omega-admin-td'),
                        'id'        => 'align',
                        'type'      => 'select',
                        'default'   => 'left',
                        'options' => array(
                            'default'   => __('Default alignment', 'omega-admin-td'),
                            'left'   => __('Left', 'omega-admin-td'),
                            'right'  => __('Right', 'omega-admin-td'),
                            'center'  => __('Center', 'omega-admin-td'),
                            'justify'  => __('Justify', 'omega-admin-td')
                        ),
                        'desc'    => __('Sets the text alignment of blockquote.', 'omega-admin-td'),
                    ),
                    array(
                        'name'      => __('Quote Text', 'omega-admin-td'),
                        'holder'    => 'p',
                        'id'        => 'content',
                        'type'      => 'textarea',
                        'default'   => '',
                        'desc'    => __('Text to show in the quote.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Who?', 'PLUGIN_TD'),
                        'id'      => 'who',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('Who said the quote.', 'PLUGIN_TD'),
                    ),
                    array(
                        'name'    => __('Citation', 'PLUGIN_TD'),
                        'id'      => 'cite',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('Citation of the quote (i.e the source).', 'PLUGIN_TD'),
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'code' => array(
        'shortcode'   => 'code',
        'title'       => __('Code', 'PLUGIN_TD'),
        'desc'        => __('For use adding source code to a page.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => 'general',
                'fields'  => array(
                    array(
                        'name'      => __('Source Code', 'omega-admin-td'),
                        'holder'    => 'p',
                        'id'        => 'content',
                        'type'      => 'textarea',
                        'default'   => '',
                        'desc'    => __('Source code to display.', 'omega-admin-td'),
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'countdown' => array(
        'shortcode'   => 'countdown',
        'title'       => __('Countdown Timer', 'PLUGIN_TD'),
        'desc'        => __('Adds a countdown timer for coming soon pages.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => 'general',
                'fields'  => array(
                    array(
                        'name'      => __('Countdown Date', 'omega-admin-td'),
                        'id'        => 'date',
                        'type'      => 'text',
                        'default'   => '',
                        'admin_label' => true,
                        'desc'    => __('Date to countdown to in the format YYYY/MM/DD HH:MM.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Number Font Size', 'omega-admin-td'),
                        'desc'    => __('Choose size of the font to use for the countdown numbers.', 'omega-admin-td'),
                        'id'      => 'number_size',
                        'type'    => 'select',
                        'options' => array(
                            'normal' => __('Normal', 'omega-admin-td'),
                            'super'  => __('Super (60px)', 'omega-admin-td'),
                            'hyper'  => __('Hyper (96px)', 'omega-admin-td'),
                        ),
                        'default' => 'normal',
                    ),
                    array(
                        'name'    => __('Number Font Weight', 'omega-admin-td'),
                        'desc'    => __('Choose weight of the font of the countdown numbers.', 'omega-admin-td'),
                        'id'      => 'number_weight',
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
                        'name'    => __('Number Underline', 'omega-admin-td'),
                        'desc'    => __('Adds an underline effect below the countdown numbers.', 'omega-admin-td'),
                        'id'      => 'number_underline',
                        'default' => 'bordered',
                        'type' => 'select',
                        'options' => array(
                            'bordered'    => __('Show', 'omega-admin-td'),
                            'no-underline' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'vc_scroll' => array(
        'shortcode'   => 'vc_scroll',
        'title'       => __('Scroll to button', 'PLUGIN_TD'),
        'desc'          => __('Creates a link for scrolling to other places in your page.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => __('General', 'PLUGIN_TD'),
                'fields'  => array(
                    array(
                        'name'    => __('Link', 'PLUGIN_TD'),
                        'id'      => 'link',
                        'type'    => 'text',
                        'holder'  => 'a',
                        'default' => __('#id', 'PLUGIN_TD'),
                        'desc'    => __('The link for the scroll button', 'PLUGIN_TD'),
                    ),
                    array(
                        'name'      => __('Arrow for the scroll to link', 'omega-admin-td'),
                        'id'        => 'icon',
                        'type'      => 'select',
                        'default'   =>  'down',
                        'options' => array(
                            'down' => __('Down', 'omega-admin-td'),
                            'up' => __('Up', 'omega-admin-td'),
                            'left' => __('Left', 'omega-admin-td'),
                            'right' => __('Right', 'omega-admin-td')
                        ),
                    ),
                    array(
                        'name'    => __('Place to the bottom', 'omega-admin-td'),
                        'desc'    => __('Place the button to the bottom of the section', 'omega-admin-td'),
                        'id'      => 'place_bottom',
                        'default' => '',
                        'type' => 'select',
                        'options' => array(
                            'on'  => __('Yes', 'omega-admin-td'),
                            '' => __('No', 'omega-admin-td')
                        ),
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        ),
    ),
    'tags' => array(
        'shortcode'   => 'tags',
        'title'       => __('Tags', 'PLUGIN_TD'),
        'desc'        => __('Adds a list of tags', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => 'general',
                'fields'  => array(
                    array(
                        'name'    => __('Tag List', 'PLUGIN_TD'),
                        'id'      => 'tags',
                        'type'    => 'text',
                        'admin_label' => true,
                        'default' => __('Web Design, Logo Design, CSS Animations', 'PLUGIN_TD'),
                        'desc'    => __('Comma seperated values that will be inserted in the tag list', 'PLUGIN_TD'),
                    ),
                    array(
                        'name'    => __('Size', 'omega-admin-td'),
                        'desc'    => __('Choose size of the tag list.', 'omega-admin-td'),
                        'id'      => 'size',
                        'type'    => 'select',
                        'options' => array(
                            'normal' => __('Normal', 'omega-admin-td'),
                            'lg'     => __('Large', 'omega-admin-td'),
                            'sm'     => __('Mini', 'omega-admin-td'),
                        ),
                        'default' => 'normal',
                    ),
                    array(
                        'name'    => __('Style', 'omega-admin-td'),
                        'desc'    => __('Choose the style of the tag list.', 'omega-admin-td'),
                        'id'      => 'style',
                        'default' => 'tag-list',
                        'type' => 'select',
                        'options' => array(
                            'tag-list'        => __('Block', 'omega-admin-td'),
                            'tag-list-inline' => __('Inline-Block', 'omega-admin-td'),
                        ),
                    ),
                ),
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        ),
    ),
    'vc_video' => array(
        'shortcode'     => 'vc_video',
        'title'         => __('Video Player', 'omega-admin-td'),
        'desc'          => __('Adds a video player.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Video Options', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Video URL', 'omega-admin-td'),
                        'id'        => 'src',
                        'type'      => 'text',
                        'default'   =>  '',
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'vc_column_text' => array(
        'shortcode'     => 'vc_column_text',
        'title'         => __('Text Block', 'omega-admin-td'),
        'desc'          => __('A block of text with WYSIWYG editor.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Video Options', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Text', 'omega-admin-td'),
                        'id'        => 'content',
                        'type'      => 'textarea_html',
                        'holder'    => 'div',
                        'default'   =>  '<p>I am text block. Click edit button to change this text.</p>',
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'sharing' => array(
        'shortcode'   => 'sharing',
        'title'       => __('Social Sharing Icons', 'PLUGIN_TD'),
        'desc'        => __('Adds Social Sharing icons to your pages', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => __('General', 'omega-admin-td'),
                'fields'  => array(
                    array(
                        'name'      => __('Title', 'omega-admin-td'),
                        'id'        => 'title',
                        'type'      => 'text',
                        'desc'      => __('Title that will appear above the social share icons.', 'omega-admin-td'),
                        'default'   => '',
                    ),
                    array(
                        'name'    => __('Social Networks', 'omega-admin-td'),
                        'desc'    => __('Select which social networks you would like to share on.', 'omega-admin-td'),
                        'id'      => 'social_networks',
                        'default' =>  'facebook,twitter,google,pinterest,linkedin',
                        'type'    => 'select',
                        'admin_label' => true,
                        'attr' => array(
                            'multiple' => '',
                            'style' => 'height:100px'
                        ),
                        'options' => array(
                            'facebook'  => __('Facebook', 'omega-admin-td'),
                            'twitter'   => __('Twitter', 'omega-admin-td'),
                            'google'    => __('Google+', 'omega-admin-td'),
                            'pinterest' => __('Pinterest', 'omega-admin-td'),
                            'linkedin' => __('LinkedIn', 'omega-admin-td'),
                        )
                    ),
                    array(
                        'name'    => __('Icon Size', 'omega-admin-td'),
                        'desc'    => __('Size of the social icons.', 'omega-admin-td'),
                        'id'      => 'icon_size',
                        'default' => 'sm',
                        'type' => 'select',
                        'options' => array(
                            'sm' => __('Small', 'omega-admin-td'),
                            'lg' => __('Large', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Show Background', 'omega-admin-td'),
                        'desc'    => __('Show a coloured background behind the social icon.', 'omega-admin-td'),
                        'id'      => 'background_show',
                        'default' => 'background',
                        'type' => 'select',
                        'options' => array(
                            'background' => __('Show', 'omega-admin-td'),
                            'simple'     => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Background Shape', 'omega-admin-td'),
                        'desc'    => __('Shape of coloured background behind the social icon.', 'omega-admin-td'),
                        'id'      => 'background_shape',
                        'default' => 'circle',
                        'type' => 'select',
                        'options' => array(
                            'circle' => __('Circle', 'omega-admin-td'),
                            'rect'   => __('Square', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Background Shape Colour', 'omega-admin-td'),
                        'desc'      => __('Colour of background behind the social icon.', 'omega-admin-td'),
                        'id'        => 'background_colour',
                        'type'      => 'colour',
                        'format'    => 'rgba',
                       'default'   => '',
                       'attr'      => array(
                           'class' => 'allow-empty'
                        ),
                    )
                ),
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'socialicons' => array(
        'shortcode'   => 'socialicons',
        'title'       => __('Social Icons', 'PLUGIN_TD'),
        'desc'        => __('Adds Social icons to your pages', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => __('General', 'omega-admin-td'),
                'fields'  => array(
                    array(
                        'name'      => __('Title', 'omega-admin-td'),
                        'id'        => 'title',
                        'type'      => 'text',
                        'desc'      => __('Title that will appear above the social icons.', 'omega-admin-td'),
                        'default'   => '',
                    ),
                    array(
                        'name'    => __('Icon Size', 'omega-admin-td'),
                        'desc'    => __('Size of the social icons.', 'omega-admin-td'),
                        'id'      => 'icon_size',
                        'default' => 'sm',
                        'type' => 'select',
                        'options' => array(
                            'sm' => __('Small', 'omega-admin-td'),
                            'lg' => __('Large', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Show Background', 'omega-admin-td'),
                        'desc'    => __('Show a coloured background behind the social icon.', 'omega-admin-td'),
                        'id'      => 'background_show',
                        'default' => 'background',
                        'type' => 'select',
                        'options' => array(
                            'background' => __('Show', 'omega-admin-td'),
                            'simple'     => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Background Shape', 'omega-admin-td'),
                        'desc'    => __('Shape of coloured background behind the social icon.', 'omega-admin-td'),
                        'id'      => 'background_shape',
                        'default' => 'circle',
                        'type' => 'select',
                        'options' => array(
                            'circle' => __('Circle', 'omega-admin-td'),
                            'rect'   => __('Square', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Background Shape Colour', 'omega-admin-td'),
                        'desc'    => __('Colour of background behind the social icon.', 'omega-admin-td'),
                        'id'      => 'background_colour',
                        'default' => '#82c9ed',
                        'type' => 'colour',
                    ),
                    array(
                        'name'    => __('Open Social Links In', 'omega-admin-td'),
                        'id'      => 'link_target',
                        'type'    => 'select',
                        'default' => '_self',
                        'options' => array(
                            '_self'   => __('Same page as it was clicked ', 'omega-admin-td'),
                            '_blank'  => __('Open in new window/tab', 'omega-admin-td'),
                            '_parent' => __('Open the linked document in the parent frameset', 'omega-admin-td'),
                            '_top'    => __('Open the linked document in the full body of the window', 'omega-admin-td')
                        ),
                        'desc'    => __('Where the social links open to', 'omega-admin-td'),
                    ),
                ),
            ),
            array(
                'title'     => __('Links', 'omega-admin-td'),
                'fields'    => oxy_create_social_options(),
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'divider' => array(
        'shortcode'   => 'divider',
        'title'       => __('Divider', 'PLUGIN_TD'),
        'desc'        => __('Adds space between elements.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => __('General', 'omega-admin-td'),
                'fields'  => array(
                    array(
                        'name'    => __('Visibility', 'omega-admin-td'),
                        'desc'    => __('Toggles if the divider is visible or not.', 'omega-admin-td'),
                        'id'      => 'visibility',
                        'default' => 'hidden',
                        'type'    => 'select',
                        'options' => array(
                            'visible' => __('Show', 'omega-admin-td'),
                            'hidden' => __('Hide', 'omega-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Background Colour', 'omega-admin-td'),
                        'desc'    => __('Background colour of the divider if it is set to visible.', 'omega-admin-td'),
                        'id'      => 'background_colour',
                        'default' => '#FFFFF',
                        'type' => 'colour',
                    ),
                    array(
                        'name'      => __('Mobile Height ', 'omega-admin-td'),
                        'desc'      => __('Height of divider on mobile displays (<768px).', 'omega-admin-td'),
                        'id'        => 'xs_height',
                        'type'      => 'slider',
                        'default'   => '24',
                        'attr'      => array(
                            'max'       => 500,
                            'min'       => 0,
                            'step'      => 1,
                        )
                    ),
                    array(
                        'name'      => __('Tablet Height ', 'omega-admin-td'),
                        'desc'      => __('Height of divider on tablet displays (>768px <992px).', 'omega-admin-td'),
                        'id'        => 'sm_height',
                        'type'      => 'slider',
                        'default'   => '24',
                        'attr'      => array(
                            'max'       => 500,
                            'min'       => 0,
                            'step'      => 1,
                        )
                    ),
                    array(
                        'name'      => __('Desktop Height ', 'omega-admin-td'),
                        'desc'      => __('Height of divider on desktop displays (>992px <1200px).', 'omega-admin-td'),
                        'id'        => 'md_height',
                        'type'      => 'slider',
                        'default'   => '24',
                        'attr'      => array(
                            'max'       => 500,
                            'min'       => 0,
                            'step'      => 1,
                        )
                    ),
                    array(
                        'name'      => __('Large Desktop Height ', 'omega-admin-td'),
                        'desc'      => __('Height of divider on mobile displays (>1200px).', 'omega-admin-td'),
                        'id'        => 'lg_height',
                        'type'      => 'slider',
                        'default'   => '24',
                        'attr'      => array(
                            'max'       => 500,
                            'min'       => 0,
                            'step'      => 1,
                        )
                    ),
                ),
            )
        )
    ),
    'chart' => array(
        'shortcode'     => 'chart',
        'title'         => __('Chart', 'omega-admin-td'),
        'desc'          => __('Add a data chart to the page.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Chart Options', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Chart Type', 'omega-admin-td'),
                        'desc'      => __('Choose from pie, doughnut, radar, polararea, bar, line', 'omega-admin-td'),
                        'id'        => 'type',
                        'type'      => 'select',
                        'options'   => array(
                            'pie'       => __('PIE Chart', 'omega-admin-td'),
                            'doughnut'  => __('Doughnut Chart', 'omega-admin-td'),
                            'radar'     => __('Radar Chart', 'omega-admin-td'),
                            'polararea' => __('Polar Area Chart', 'omega-admin-td'),
                            'bar'       => __('Bar Chart', 'omega-admin-td'),
                            'line'      => __('Line Chart', 'omega-admin-td'),
                        ),
                        'admin_label' => true,
                        'default'   =>  'pie',
                    ),
                    array(
                        'name'      => __('Data', 'omega-admin-td'),
                        'desc'      => __('Used for the pie, doughnut and radar charts.', 'omega-admin-td'),
                        'id'        => 'data',
                        'type'      => 'textarea',
                        'default'   =>  '',
                    ),
                    array(
                        'name'      => __('Datasets', 'omega-admin-td'),
                        'desc'      => __("Used for the bar, line, and radar charts,  the data for each 'set' is put in as before, but using the 'next' keyword to seperate each of the datasets.", 'omega-admin-td'),
                        'id'        => 'datasets',
                        'type'      => 'textarea',
                        'default'   =>  '',
                    ),
                    array(
                        'name'      => __('Colours', 'omega-admin-td'),
                        'desc'      => __("These should be put in in there HEX value only(as above). These are the default colors, there should be the same number of colours as data points, or datasets, but if you only got a few, or too many, don't worry the plugin will handle it.  (more practically if you don't want your chart to look like a rainbow, the plugin will cycle a set a colors for your data)", 'omega-admin-td'),
                        'id'        => 'colors',
                        'type'      => 'textarea',
                        'default'   =>  '',
                    ),
                    array(
                        'name'      => __('Labels', 'omega-admin-td'),
                        'desc'      => __('Used for the bar, line and polararea charts.', 'omega-admin-td'),
                        'id'        => 'labels',
                        'type'      => 'textarea',
                        'default'   =>  '',
                    ),
                    array(
                        'name'      => __('Width', 'omega-admin-td'),
                        'desc'      => __('This sets the width of the container for the chart, and should be the only size property you need to adjust.  Setting it as a % value will make the chart fluid / responsive, you can use any valid CSS measurement of value (em, px, %).', 'omega-admin-td'),
                        'id'        => 'width',
                        'type'      => 'text',
                        'default'   =>  '70%',
                    ),
                    array(
                        'name'      => __('Height', 'omega-admin-td'),
                        'desc'      => __('optional - the height will automatticaly be proportionate to the width, and you should not need to adjust this .', 'omega-admin-td'),
                        'id'        => 'height',
                        'type'      => 'text',
                        'default'   =>  'auto',
                    ),
                    array(
                        'name'      => __('Canvas Width', 'omega-admin-td'),
                        'desc'      => __('This sets the width of the container for the chart, and should be the only size property you need to adjust.  Setting it as a % value will make the chart fluid / responsive, you can use any valid CSS measurement of value (em, px, %).', 'omega-admin-td'),
                        'id'        => 'canvaswidth',
                        'type'      => 'text',
                        'default'   =>  '625',
                    ),
                    array(
                        'name'      => __('Canvas Height', 'omega-admin-td'),
                        'desc'      => __('This will be converted to px, only adjust this up or down if you experience rendering issues.', 'omega-admin-td'),
                        'id'        => 'canvasheight',
                        'type'      => 'text',
                        'default'   =>  '625',
                    ),
                    array(
                        'name'      => __('Relative Width', 'omega-admin-td'),
                        'desc'      => __('The width to height ratio', 'omega-admin-td'),
                        'id'        => 'relativewidth',
                        'type'      => 'text',
                        'default'   =>  '1',
                    ),
                    array(
                        'name'      => __('Margin', 'omega-admin-td'),
                        'desc'      => __('optional - use standard css syntax for the margin, defaults to 5px for top, bottom, left and right.', 'omega-admin-td'),
                        'id'        => 'margin',
                        'type'      => 'text',
                        'default'   =>  '20px',
                    ),
                    array(
                        'name'      => __('Align', 'omega-admin-td'),
                        'desc'      => __('optional - use one of the standard WordPress alignment classes alignleft, alignright, aligncenter.', 'omega-admin-td'),
                        'id'        => 'align',
                        'type'      => 'text',
                        'default'   =>  '',
                    ),
                    array(
                        'name'      => __('Class', 'omega-admin-td'),
                        'desc'      => __('optional - apply a css class to the chart container.', 'omega-admin-td'),
                        'id'        => 'class',
                        'type'      => 'text',
                        'default'   =>  '',
                    ),
                    array(
                        'name'      => __('Scale Font Size', 'omega-admin-td'),
                        'desc'      => __('Adjust the font size of the scale for the charts that display it', 'omega-admin-td'),
                        'id'        => 'scalefontsize',
                        'type'      => 'slider',
                        'default'   => '12',
                        'attr'      => array(
                            'max'       => 100,
                            'min'       => 1,
                            'step'      => 1,
                        )
                    ),
                    array(
                        'name'      => __('Scale Font Colour', 'omega-admin-td'),
                        'desc'      => __('Change the scale font colour', 'omega-admin-td'),
                        'id'        => 'scalefontcolor',
                        'type'      => 'colour',
                        'default'   => '#666666',
                    ),
                    array(
                        'name'      => __('Scale Override', 'omega-admin-td'),
                        'desc'      => __('By default this is turned off, and the script attempts to output an appropriate scale, setting this to true will require the following three properties to be set as well: scaleSteps, scaleStepWidth and scaleStartValue', 'omega-admin-td'),
                        'id'        => 'scaleoverride',
                        'type'      => 'select',
                        'options'   => array(
                            'true'  => __('On', 'omega-admin-td'),
                            'false' => __('Off', 'omega-admin-td'),
                        ),
                        'default'   =>  'false',
                    ),
                    array(
                        'name'      => __('Scale Steps', 'omega-admin-td'),
                        'desc'      => __('Only applicable if scaleOveride is set to true - the number of steps in the scale', 'omega-admin-td'),
                        'id'        => 'scalesteps',
                        'type'      => 'text',
                        'default'   =>  'null',
                    ),
                    array(
                        'name'      => __('Scale Step Width', 'omega-admin-td'),
                        'desc'      => __('Only applicable if scaleOveride is set to true - the value jump used in the scale', 'omega-admin-td'),
                        'id'        => 'scalestepwidth',
                        'type'      => 'text',
                        'default'   =>  'null',
                    ),
                    array(
                        'name'      => __('Scale Start Value', 'omega-admin-td'),
                        'desc'      => __('Only applicable if scaleOveride is set to true - the center starting value for the scale', 'omega-admin-td'),
                        'id'        => 'scalestartvalue',
                        'type'      => 'text',
                        'default'   =>  'null',
                    ),
                    array(
                        'name'      => __('Chart Animation', 'omega-admin-td'),
                        'desc'      => __('Turn the load animation for the charts on or off', 'omega-admin-td'),
                        'id'        => 'animation',
                        'type'      => 'select',
                        'options'   => array(
                            'true'  => __('On', 'omega-admin-td'),
                            'false' => __('Off', 'omega-admin-td'),
                        ),
                        'default'   =>  'true',
                    ),
                    array(
                        'name'      => __('Fill Opacity', 'omega-admin-td'),
                        'desc'      => __('For line, bar and polararea type charts you can set an opactiy for fill of the chart.', 'omega-admin-td'),
                        'id'        => 'fillopacity',
                        'type'      => 'slider',
                        'default'   => '0.7',
                        'attr'      => array(
                            'max'       => 1,
                            'min'       => 0,
                            'step'      => 0.1,
                        )
                    ),
                    array(
                        'name'      => __('Point Stroke Colour', 'omega-admin-td'),
                        'desc'      => __('For line and polararea type charts you can set the point color, though usually looks pretty good with the default.', 'omega-admin-td'),
                        'id'        => 'pointstrokecolor',
                        'type'      => 'colour',
                        'default'   => '#FFFFFF',
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'menu' => array(
        'shortcode'     => 'menu',
        'title'         => __('Site Menu', 'omega-admin-td'),
        'desc'          => __('Adds a site menu to the page.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Choose a menu', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Choose a menu', 'omega-admin-td'),
                        'desc'      => __('Select a wordpress menu to use.', 'omega-admin-td'),
                        'id'        => 'slug',
                        'type'      => 'select',
                        'options'   => $menus,
                        'admin_label' => true,
                        'default'   =>  '',
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
                        'name'    => __('Menu Underline', 'omega-admin-td'),
                        'desc'    => __('Underline of the menu items when selected', 'omega-admin-td'),
                        'id'      => 'underline_menu',
                        'type'    => 'select',
                        'options' => array(
                            'underline'    => __('On', 'omega-admin-td'),
                            'no-underline' => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'underline',
                    ),
                    array(
                        'name'    => __('Capitalization', 'omega-admin-td'),
                        'desc'    => __('Enable-disable automatic capitalization in menu logo and menus', 'omega-admin-td'),
                        'id'      => 'menu_capitalization',
                        'type'    => 'select',
                        'options' => array(
                            'text-caps'      => __('Force Uppercase', 'omega-admin-td'),
                            'text-lowercase' => __('Force Lowercase', 'omega-admin-td'),
                            'text-none'      => __('Off', 'omega-admin-td'),
                        ),
                        'default' => 'text-none',
                    ),
                    array(
                        'name'    => __('Menu Width', 'omega-admin-td'),
                        'desc'    => __('Choose between normal or fullwidth menu', 'omega-admin-td'),
                        'id'      => 'container_class',
                        'type'    => 'select',
                        'options' => array(
                            'container'           => __('Normal', 'omega-admin-td'),
                            'container-fullwidth' => __('Full Width', 'omega-admin-td'),
                        ),
                        'default' => 'container',
                    ),
                )
            )
        )
    ),
    'vc_tabs' => array(
        'shortcode'     => 'vc_tabs',
        'title'         => __('Tabs', 'omega-admin-td'),
        'desc'          => __('Creates Bootstrap Tabs with content.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Choose a menu', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Tabs Style', 'omega-admin-td'),
                        'desc'      => __('Select a style to use for the tabs.', 'omega-admin-td'),
                        'id'        => 'style',
                        'type'      => 'select',
                        'options'   => array(
                            'top'    => __('Top', 'omega-admin-td'),
                            'bottom' => __('Bottom', 'omega-admin-td'),
                        ),
                        'default'   =>  '',
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'vc_accordion' => array(
        'shortcode'     => 'vc_accordion',
        'title'         => __('Accordion', 'omega-admin-td'),
        'desc'          => __('Creates a Bootstrap Accordion.', 'omega-admin-td'),
        'insert_with'   => 'dialog',
        'sections'      => array(
            array(
                'title' => __('Accordion Options', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Accordion type', 'PLUGIN_TD'),
                        'desc'    => __('Type of accordion to display', 'PLUGIN_TD'),
                        'id'      => 'type',
                        'type'    => 'select',
                        'default' => 'primary',
                        'admin_label' => true,
                        'options' => array(
                            'default' => __('Default', 'PLUGIN_TD'),
                            'primary' => __('Primary', 'PLUGIN_TD'),
                            'info'    => __('Info', 'PLUGIN_TD'),
                            'success' => __('Success', 'PLUGIN_TD'),
                            'warning' => __('Warning', 'PLUGIN_TD'),
                            'danger'  => __('Danger', 'PLUGIN_TD'),
                        ),
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'simple_icon_list' => array(
        'shortcode'   => 'simple_icon_list',
        'title'       => __('Icons List', 'omega-admin-td'),
        'desc'        => __('Displays a list of icons.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'has_content'   => false,
        'sections'    => array(
            array(
                'title' => __('Video Options', 'omega-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Item size', 'omega-admin-td'),
                        'desc'    => __('Choose between normal or and big item size', 'omega-admin-td'),
                        'id'      => 'size',
                        'type'    => 'select',
                        'options' => array(
                            'normal' => __('Normal', 'omega-admin-td'),
                            'big'    => __('Big', 'omega-admin-td'),
                        ),
                        'default' => 'normal',
                    ),
                )
            ),
            array(
                'title' => __('List Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'simple_icon' => array(
        'shortcode'   => 'simple_icon',
        'title'       => __('Simple Icon', 'omega-admin-td'),
        'desc'        => __('Displays an icon alongside some text.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'has_content'   => false,
        'sections'    => array(
            array(
                'title'   => 'general',
                'fields'  => array(
                    array(
                        'name'    => __('Font Awesome Icon', 'omega-admin-td'),
                        'desc'    => __('Select a font awesome icon that will appear in your features shape.', 'omega-admin-td'),
                        'id'      => 'fa_icon',
                        'type'    => 'select',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/fontawesome.php',
                        'default' => ''
                    ),

                    array(
                        'name'      => __('Icon Colour', 'omega-admin-td'),
                        'desc'      => __('Set the colour of the icon ( svg & font awesome icons )', 'omega-admin-td'),
                        'id'        => 'icon_color',
                        'type'      => 'colour',
                        'default'   => '#FFFFFF',
                    ),
                    array(
                        'name'        => __('Title', 'omega-admin-td'),
                        'id'          => 'title',
                        'type'        => 'text',
                        'admin_label' => true,
                        'default'     => '',
                        'desc'        => __('Choose a title for your featured item.', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Title Link', 'omega-admin-td'),
                        'id'      => 'link',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('Link that the title will link to (leave empty for unlinkable title)', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Open Link In', 'omega-admin-td'),
                        'id'      => 'link_target',
                        'type'    => 'select',
                        'default' => '_self',
                        'options' => array(
                            '_self'   => __('Same page as it was clicked ', 'omega-admin-td'),
                            '_blank'  => __('Open in new window/tab', 'omega-admin-td'),
                        ),
                        'desc'    => __('Where the link will open.', 'omega-admin-td'),
                    )
                )
            ),
        )
    ),
    'audio' => array(
        'shortcode'   => 'audio',
        'title'       => __('Audio Player', 'omega-admin-td'),
        'desc'        => __('Creates an audio player.', 'omega-admin-td'),
        'insert_with' => 'dialog',
        'has_content'   => false,
        'sections'    => array(
            array(
                'title'   => 'general',
                'fields'  => array(
                    array(
                        'name'        => __('Audio URL', 'omega-admin-td'),
                        'id'          => 'src',
                        'type'        => 'text',
                        'admin_label' => true,
                        'default'     => '',
                        'desc'        => __('Add a link to your audio file (mp3, m4a, ogg, wav, wma).', 'omega-admin-td'),
                    ),
                    array(
                        'name'    => __('Loop Audio', 'omega-admin-td'),
                        'id'      => 'loop',
                        'desc'    => __('Allows for looping of media.', 'omega-admin-td'),
                        'type'    => 'select',
                        'options' => array(
                            'on'  => __('On', 'omega-admin-td'),
                            '' => __('Off', 'omega-admin-td')
                        ),
                        'default' => ''
                    ),
                    array(
                        'name'    => __('Autoplay', 'omega-admin-td'),
                        'id'      => 'autoplay',
                        'desc'    => __('Causes the media to automatically play as soon as the media file is ready.', 'omega-admin-td'),
                        'type'    => 'select',
                        'options' => array(
                            '1'  => __('On', 'omega-admin-td'),
                            '0' => __('Off', 'omega-admin-td')
                        ),
                        'default' => '0'
                    ),
                    array(
                        'name'    => __('Preload', 'omega-admin-td'),
                        'id'      => 'preload',
                        'desc'    => __('Specifies if and how the audio should be loaded when the page loads.', 'omega-admin-td'),
                        'type'    => 'select',
                        'options' => array(
                            'none'     => __('Audio should not be loaded', 'omega-admin-td'),
                            'auto'     => __('Audio should be loaded', 'omega-admin-td'),
                            'metadata' => __('Metadata should be loaded', 'omega-admin-td')
                        ),
                        'default' => 'none'
                    ),
                )
            ),
            array(
                'title' => __('Extra Options', 'omega-admin-td'),
                'fields' => include OXY_THEME_DIR . 'inc/options/global-options/global-options.php'
            )
        )
    ),
    'product' => array(
        'shortcode'   => 'product',
        'title'       => __('Product', 'omega-admin-td'),
        'desc'        => __('Displays a single product', 'omega-admin-td'),
        'insert_with' => 'text',
        'has_content'   => false,
        'sections'    => array(
            array(
                'title'   => 'general',
                'fields'  => array(
                    array(
                        'name'        => __('Product', 'omega-admin-td'),
                        'desc'        => __('Choose a product to display.', 'omega-admin-td'),
                        'id'          => 'id',
                        'type'        => 'select',
                        'default'     =>  '',
                        'blank'       => __('None', 'omega-admin-td'),
                        'options'     => 'custom_post_id',
                        'post_type'   => 'product',
                        'admin_label' => true,
                    ),
                )
            ),
        )
    ),
    'product_page' => array(
        'shortcode'   => 'product_page',
        'title'       => __('Product Page', 'omega-admin-td'),
        'desc'        => __('Displays a single product page', 'omega-admin-td'),
        'insert_with' => 'text',
        'has_content'   => false,
        'sections'    => array(
            array(
                'title'   => 'general',
                'fields'  => array(
                    array(
                        'name'        => __('Product', 'omega-admin-td'),
                        'desc'        => __('Choose a product to display.', 'omega-admin-td'),
                        'id'          => 'id',
                        'type'        => 'select',
                        'default'     =>  '',
                        'blank'       => __('None', 'omega-admin-td'),
                        'options'     => 'custom_post_id',
                        'post_type'   => 'product',
                        'admin_label' => true,
                    ),
                )
            ),
        )
    ),
    'product_category' => array(
        'shortcode'   => 'product_category',
        'title'       => __('Product Category', 'omega-admin-td'),
        'desc'        => __('Displays a product category', 'omega-admin-td'),
        'insert_with' => 'text',
        'has_content'   => false,
        'sections'    => array(
            array(
                'title'   => 'general',
                'fields'  => array(
                    array(
                        'name'        => __('Product Category', 'omega-admin-td'),
                        'desc'        => __('Choose a product category to display', 'omega-admin-td'),
                        'id'          => 'category',
                        'type'        => 'select',
                        'default'     =>  '',
                        'blank'       => __('None', 'omega-admin-td'),
                        'options'     => 'taxonomy',
                        'taxonomy'    => 'product_cat',
                        'admin_label' => true,
                    ),
                    array(
                        'name'    => __('Number', 'omega-admin-td'),
                        'desc'    => __('Set the number of products to display.', 'omega-admin-td'),
                        'id'      => 'per_page',
                        'type'    => 'text',
                        'default' => ''
                    ),
                    array(
                        'name'    => __('Columns', 'omega-admin-td'),
                        'desc'    => __('Set the number of columns to display.', 'omega-admin-td'),
                        'id'      => 'columns',
                        'type'    => 'text',
                        'default' => ''
                    ),
                    array(
                        'name'        => __('Order by', 'omega-admin-td'),
                        'desc'        => __('Choose the way products will be ordered.', 'omega-admin-td'),
                        'id'          => 'orderby',
                        'type'        => 'select',
                        'default'     =>  'none',
                        'options'     => array(
                            'none'     => __('None', 'omega-admin-td'),
                            'title' => __('Title', 'omega-admin-td'),
                            'name' => __('Name', 'omega-admin-td'),
                            'date' => __('Date', 'omega-admin-td'),
                            'ID'     => __('ID', 'omega-admin-td'),
                            'author' => __('Author', 'omega-admin-td'),
                            'modified' => __('Last Modified', 'omega-admin-td'),
                            'parent' => __('Parent id', 'omega-admin-td'),
                            'rand' => __('Random', 'omega-admin-td'),
                            'comment_count' => __('Number of comments', 'omega-admin-td')
                        )
                    ),
                    array(
                        'name'        => __('Order', 'omega-admin-td'),
                        'desc'        => __('Choose how products will be ordered.', 'omega-admin-td'),
                        'id'          => 'order',
                        'type'        => 'select',
                        'default'     =>  'ASC',
                        'options'     => array(
                            'ASC'     => __('Ascending', 'omega-admin-td'),
                            'DESC' => __('Descending', 'omega-admin-td'),
                        )
                    ),
                )
            ),
        )
    ),
    'product_categories' => array(
        'shortcode'   => 'product_categories',
        'title'       => __('Product Categories', 'omega-admin-td'),
        'desc'        => __('Displays product categories', 'omega-admin-td'),
        'insert_with' => 'text',
        'has_content'   => false,
        'sections'    => array(
            array(
                'title'   => 'general',
                'fields'  => array(
                    array(
                        'name'        => __('Product Categories', 'omega-admin-td'),
                        'desc'        => __('Choose the product categories to display.  Enter the IDs comma separated, or leave empty for all categories.', 'omega-admin-td'),
                        'id'          => 'ids',
                        'type'        => 'text',
                        'default'     =>  ''
                    ),
                    array(
                        'name'    => __('Number', 'omega-admin-td'),
                        'desc'    => __('Set the number of categories to display.', 'omega-admin-td'),
                        'id'      => 'number',
                        'type'    => 'text',
                        'default' => ''
                    ),
                    array(
                        'name'    => __('Columns', 'omega-admin-td'),
                        'desc'    => __('Set the number of columns to display.', 'omega-admin-td'),
                        'id'      => 'columns',
                        'type'    => 'text',
                        'default' => ''
                    ),
                    array(
                        'name'        => __('Order by', 'omega-admin-td'),
                        'desc'        => __('Choose the way categories will be ordered.', 'omega-admin-td'),
                        'id'          => 'orderby',
                        'type'        => 'select',
                        'default'     =>  'none',
                        'options'     => array(
                            'none'     => __('None', 'omega-admin-td'),
                            'title' => __('Title', 'omega-admin-td'),
                            'name' => __('Name', 'omega-admin-td'),
                            'date' => __('Date', 'omega-admin-td'),
                            'ID'     => __('ID', 'omega-admin-td'),
                            'author' => __('Author', 'omega-admin-td'),
                            'modified' => __('Last Modified', 'omega-admin-td'),
                            'parent' => __('Parent id', 'omega-admin-td'),
                            'rand' => __('Random', 'omega-admin-td'),
                            'comment_count' => __('Number of comments', 'omega-admin-td')
                        )
                    ),
                    array(
                        'name'        => __('Order', 'omega-admin-td'),
                        'desc'        => __('Choose how categories will be ordered.', 'omega-admin-td'),
                        'id'          => 'order',
                        'type'        => 'select',
                        'default'     =>  'ASC',
                        'options'     => array(
                            'ASC'     => __('Ascending', 'omega-admin-td'),
                            'DESC' => __('Descending', 'omega-admin-td'),
                        )
                    ),
                    array(
                        'name'        => __('Hide empty categories', 'omega-admin-td'),
                        'desc'        => __('Choose whether to show categories with no products set.', 'omega-admin-td'),
                        'id'          => 'hide_empty',
                        'type'        => 'select',
                        'default'     =>  '0',
                        'options'     => array(
                            '1'     => __('Hide', 'omega-admin-td'),
                            '0' => __('Show', 'omega-admin-td'),
                        )
                    ),
                    array(
                        'name'    => __('Parent', 'omega-admin-td'),
                        'desc'    => __('Set the parent id of the categories to display. Set to 0 to only display top level categories', 'omega-admin-td'),
                        'id'      => 'parent',
                        'type'    => 'text',
                        'default' => '0'
                    )
                )
            ),
        )
    ),
);
