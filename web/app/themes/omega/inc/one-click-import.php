<?php
/**
 * Adds theme specific filters for one click installer module
 *
 * @package Omega
 * @subpackage Admin
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.14
 * @author Oxygenna.com
 */

function oxy_one_click_before_insert_post( $post, $one_click ) {

    if (!class_exists('simple_html_dom')) {
        require_once OXY_THEME_DIR . 'vendor/oxygenna/oxygenna-one-click/inc/simple_html_dom.php';
    }

    // create post object
    $post_object = new stdClass();
    // strip slashes added by json
    $post_object->post_content = stripslashes($post['post_content']);

    $gallery_shortcode = oxy_get_content_shortcode($post_object, 'gallery');
    if ($gallery_shortcode !== null) {
        if (isset($gallery_shortcode[0])) {
            // show gallery
            $gallery_ids = null;
            if (array_key_exists(3, $gallery_shortcode)) {
                if (array_key_exists(0, $gallery_shortcode[3])) {
                    $gallery_attrs = shortcode_parse_atts($gallery_shortcode[3][0]);
                    if (array_key_exists('ids', $gallery_attrs)) {
                        // we have a gallery with ids so lets replace the ids
                        $gallery_ids = explode(',', $gallery_attrs['ids']);
                        $new_gallery_ids = array();
                        foreach ($gallery_ids as $gallery_id) {
                            $new_gallery_ids[] = $one_click->install_package->lookup_map('attachments', $gallery_id);
                        }
                        // replace old ids with new ones
                        $old_string = 'ids="' . implode(',', $gallery_ids) . '"';
                        $new_string = 'ids="' . implode(',', $new_gallery_ids) . '"';
                        $post_object->post_content = str_replace($old_string, $new_string, $post_object->post_content);
                    }
                }
            }
        }
    }

    if (!empty($post_object->post_content)) {
        $html = str_get_html($post_object->post_content);
        $imgs = $html->find('img');
        foreach ($imgs as $img) {
            $replace_image_src = $one_click->install_package->lookup_map('images', $img->src);
            if (false !== $replace_image_src) {
                $img->src = $replace_image_src;
            }
        }
        $post_object->post_content = $html->save();

        $post_object->post_content = $one_click->replace_shortcode_attachment_id($post_object->post_content, 'vc_single_image', 'image', 'attachments');
        $post_object->post_content = $one_click->replace_shortcode_attachment_id($post_object->post_content, 'vc_row', 'background_image', 'attachments');
        $post_object->post_content = $one_click->replace_shortcode_attachment_id($post_object->post_content, 'shapedimage', 'image', 'attachments');
        $post_object->post_content = $one_click->replace_shortcode_attachment_id($post_object->post_content, 'staff_featured', 'member', 'oxy_staff');

    }

    // replace post content with one from object
    $post['post_content'] = $post_object->post_content;

    return $post;
}
add_filter( 'oxy_one_click_before_insert_post', 'oxy_one_click_before_insert_post', 10, 2 );

/**
 * Modifies imported menu befor save in one click importer
 *
 * @return void
 * @author
 **/
function oxy_one_click_before_wp_update_nav_menu_item($new_menu_item, $menu_item, $one_click)
{
    switch ($menu_item['type']) {
        case 'post_type':
        case 'taxonomy':
            switch($menu_item['object']) {
                case 'oxy_mega_menu':
                    $mega_menu = get_page_by_title('Mega Menu', 'OBJECT', 'oxy_mega_menu');
                    $new_menu_item['menu-item-object-id'] = $mega_menu->ID;
                    break;
                case 'oxy_mega_columns':
                    $columns = get_posts(array(
                        'post_type' => 'oxy_mega_columns'
                    ));
                    foreach ($columns as $column) {
                        if ($column->post_content === $menu_item['post_content']) {
                            $new_menu_item['menu-item-object-id'] = $column->ID;
                        }
                    }
                    break;
                default:
                    $new_id = $one_click->install_package->lookup_map($menu_item['object'], $menu_item['object_id']);
                    if ($new_id !== false) {
                        $new_menu_item['menu-item-object-id'] = $new_id;
                    }
                    break;
            }
            break;
        case 'custom':
        default:
            // do nothing
            break;
    }
    return $new_menu_item;
}
add_filter('oxy_one_click_before_wp_update_nav_menu_item', 'oxy_one_click_before_wp_update_nav_menu_item', 10, 3);

function oxy_filter_import_packages( $packages ) {
    return array(
        array(
            'id'           => THEME_SHORT . '-main-demo',
            'name'         => __('Main Demo Content', 'omega-admin-td'),
            'demo_url'     => 'http://omega.oxygenna.com',
            'docs_url'     => 'http://help.oxygenna.com/wordpress/omega',
            'thumbnail'    => 'http://one-click-import.s3.amazonaws.com/omega/thumbnail.jpg',
            'screenshot'   => 'http://one-click-import.s3.amazonaws.com/omega/screenshot.jpg',
            'description'  => __('Main demo content, many pages for you to use for every kind of site.', 'omega-admin-td'),
            'type'         => 'oxygenna',
            'importUrl'    => 'https://one-click-import.s3.amazonaws.com/omega/',
            'importFile'   => 'import.json',
            'requirements' => array(
                array(
                    'name' => __('Visual Composer Plugin', 'omega-admin-td'),
                    'path' => 'js_composer/js_composer.php'
                ),
                array(
                    'name' => __('Layer Slider', 'omega-admin-td'),
                    'path' => 'LayerSlider/layerslider.php'
                ),
                array(
                    'name' => __('Revolution Slider', 'omega-admin-td'),
                    'path' => 'revslider/revslider.php'
                ),
            ),
        ),
        array(
            'id'           => THEME_SHORT . '-shop-demo',
            'name'         => __('WooCommerce Shop Content', 'omega-admin-td'),
            'demo_url'     => 'http://omega.oxygenna.com/shop/',
            'docs_url'     => 'http://help.oxygenna.com/wordpress/omega',
            'thumbnail'    => 'http://one-click-import.s3.amazonaws.com/omega/shop/thumbnail.jpg',
            'screenshot'   => 'http://one-click-import.s3.amazonaws.com/omega/shop/screenshot.jpg',
            'description'  => __('Installs all the woocommerce products and shop pages that you see on the demo site.', 'omega-admin-td'),
            'type'         => 'oxygenna',
            'importUrl'    => 'https://one-click-import.s3.amazonaws.com/omega/',
            'importFile'   => 'woocommerce.json',
            'requirements' => array(
                array(
                    'name' => __('Visual Composer Plugin', 'omega-admin-td'),
                    'path' => 'js_composer/js_composer.php'
                ),
                array(
                    'name' => __('Woo Commerce Plugin', 'omega-admin-td'),
                    'path' => 'woocommerce/woocommerce.php'
                ),
                array(
                    'name' => __('Revolution Slider', 'omega-admin-td'),
                    'path' => 'revslider/revslider.php'
                ),
            ),
        ),
    );
}
add_filter( 'oxy_one_click_import_packages', 'oxy_filter_import_packages', 10, 1 );

function oxy_one_click_export_slideshows( $package_file ) {
    switch( $package_file ) {
        case 'import.json':
            $slideshows = array(
                array(
                    'type'     => 'layerslider',
                    'filename' => 'Business-Header.zip',
                    'url'      => 'http://one-click-import.s3.amazonaws.com/omega/layerslider/Business-Header.zip'
                ),
                array(
                    'type' => 'layerslider',
                    'filename' => 'Creative-Header.zip',
                    'url'      => 'http://one-click-import.s3.amazonaws.com/omega/layerslider/Creative-Header.zip'
                ),
                array(
                    'type' => 'layerslider',
                    'filename' => 'Food-Header.zip',
                    'url'      => 'http://one-click-import.s3.amazonaws.com/omega/layerslider/Food-Header.zip'
                ),
                array(
                    'type' => 'layerslider',
                    'filename' => 'Food-Testimonials.zip',
                    'url'      => 'http://one-click-import.s3.amazonaws.com/omega/layerslider/Food-Testimonials.zip'
                ),
                array(
                    'type' => 'layerslider',
                    'filename' => 'Onepage-Header.zip',
                    'url'      => 'http://one-click-import.s3.amazonaws.com/omega/layerslider/Onepage-Header.zip'
                ),
                array(
                    'type' => 'layerslider',
                    'filename' => 'Portfolio-Item-One.zip',
                    'url'      => 'http://one-click-import.s3.amazonaws.com/omega/layerslider/Portfolio-Item-One.zip'
                ),
                array(
                    'type' => 'layerslider',
                    'filename' => 'Portfolio-Item-Two.zip',
                    'url'      => 'http://one-click-import.s3.amazonaws.com/omega/layerslider/Portfolio-Item-Two.zip'
                ),
                array(
                    'type' => 'revslider',
                    'filename' => 'app.zip',
                    'url'      => 'http://one-click-import.s3.amazonaws.com/omega/revslider/app.zip'
                ),
                array(
                    'type' => 'revslider',
                    'filename' => 'corporate.zip',
                    'url'      => 'http://one-click-import.s3.amazonaws.com/omega/revslider/corporate.zip'
                ),
                array(
                    'type' => 'revslider',
                    'filename' => 'creative.zip',
                    'url'      => 'http://one-click-import.s3.amazonaws.com/omega/revslider/creative.zip'
                ),
                array(
                    'type' => 'revslider',
                    'filename' => 'minimal.zip',
                    'url'      => 'http://one-click-import.s3.amazonaws.com/omega/revslider/minimal.zip'
                ),
                array(
                    'type' => 'revslider',
                    'filename' => 'extended.zip',
                    'url'      => 'http://one-click-import.s3.amazonaws.com/omega/revslider/extended.zip'
                ),
                array(
                    'type' => 'revslider',
                    'filename' => 'fashion.zip',
                    'url'      => 'http://one-click-import.s3.amazonaws.com/omega/revslider/fashion.zip'
                ),
                array(
                    'type' => 'revslider',
                    'filename' => 'homepage-blue.zip',
                    'url'      => 'http://one-click-import.s3.amazonaws.com/omega/revslider/homepage-blue.zip'
                )
            );
        break;
        case 'woocommerce.json':
            $slideshows = array();
        break;
    }

    return $slideshows;
}
add_filter( 'oxy_one_click_export_slideshows', 'oxy_one_click_export_slideshows' );


function oxy_one_click_import_download_url( $filename ) {
    return 'http://one-click-import.s3.amazonaws.com/omega/images/' . $filename;
}
add_filter( 'oxy_one_click_import_download_url', 'oxy_one_click_import_download_url', 10, 1 );

function oxy_one_clicl_theme_docs_url( $url ) {
    return 'http://omegadocs.oxygenna.com';
}
add_filter( 'oxy_one_clicl_theme_docs_url', 'oxy_one_clicl_theme_docs_url', 10, 1 );

/**
 * Adds extra custom fields to menus
 *
 * @return void
 * @author
 **/
function oxy_one_click_import_add_metadata_menu_item($new_menu_item_id, $menu_item, $one_click)
{
    // add custom data if exists
    if (isset($menu_item['custom_fields'])) {
        foreach ($menu_item['custom_fields'] as $key => $custom_field) {
            // just import oxygenna fields
            if (strpos($key, 'oxy_') !== false) {
                switch($key) {
                    case 'oxy_bg_url':
                        $new_image = $one_click->install_package->lookup_map('images', $custom_field[0]);
                        add_post_meta($new_menu_item_id, $key, $new_image);
                        break;
                    default:
                        add_post_meta($new_menu_item_id, $key, $custom_field[0]);
                        break;
                }
            }
        }
    }
}
add_action('oxy_one_click_new_menu_item', 'oxy_one_click_import_add_metadata_menu_item', 10, 3);


//  filter out all revslider and layerslider images from export
function oxy_one_click_export_main_content_attachments( $attachments ) {
    $slideshows = apply_filters('oxy_one_click_export_slideshows', 'import.json');
    $ignore_files = array();
    foreach ($slideshows as $slideshow) {
        // get the zip file
        $zip = new ZipArchive();
        $zip->open(OXY_THEME_DIR . $slideshow['filename']);
        // cycle through each file / dir
        for ($i = 0; $i < $zip->numFiles; $i++) {
            // get the status so we can check if dir (size==0)
            $status = $zip->statIndex($i);
            // only interested in files
            if( $status['size'] > 0 ) {
                // get the filename
                $filename = $zip->getNameIndex($i);
                $pathinfo = pathinfo($filename);
                if( strpos($pathinfo['dirname'], '/uploads') ) {
                    $ignore_files[] = $pathinfo['filename'] . '.' . $pathinfo['extension'];
                }
            }
        }
    }
    $new_attachments = array();
    foreach ( $attachments as $attachment ) {
        $filename = basename(get_attached_file($attachment->ID));
        $ignore_this = false;
        foreach ( $ignore_files as $ignore_file ) {
            if( $filename === $ignore_file ) {
                $ignore_this = true;
                break;
            }
        }

        // do we want to add this one?
        if( !$ignore_this ) {
            $new_attachments[] = $attachment;
        }
    }

    return $new_attachments;
}
add_filter( 'oxy_one_click_export_main_content_attachments', 'oxy_one_click_export_main_content_attachments', 10, 1 );

/**
 * One click installer details
 *
 * @return details for one click installer
 **/
function oxy_one_click_checklist()
{
    // get packages so we can get url to test
    $packages = oxy_filter_import_packages(array());

    return array(
        array(
            'name' => 'WPMemoryCheck',
            'args' => array(
                'limit' => '40M'
            )
        ),
        array(
            'name' => 'MaxExecTime',
            'args' => array(
                'value' => 30,
            )
        ),
        array(
            'name' => 'FSockCheck',
            'args' => array()
        ),
        array(
            'name' => 'DNSCheck',
            'args' => array(
                'domain' => 'google.com'
            )
        ),
        // use first package as a test url
        array(
            'name' => 'OutConnectCheck',
            'args' => array(
                'domain' => $packages[0]['importUrl'] . $packages[0]['importFile']
            )
        ),
        array(
            'name' => 'ZipCheck',
            'args' => array(
                'name'  => 'PHP Zip Archive',
                'value' => 'ZipArchive',
                'ok_message' => __('Your server has PHP Zip or unzip_file enabled. Revolution Slider import will work.', 'omega-admin-td'),
                'fail_message' => __('Your server does not have PHP Zip enabled or unzip_file function - Revolution Slider slides will not be able to be unpacked. Contact your hosting provider.', 'omega-admin-td')
            )
        )
    );
}
add_filter('oxy_one_click_checklist', 'oxy_one_click_checklist', 10, 1);

/**
 * Create check list for one click installer
 *
 * @return void
 * @author
 **/
function oxy_one_click_details()
{
    return array(
        'install_plugins_url' => esc_url(
            add_query_arg(
                array(
                    'page'   => 'tgmpa-install-plugins',
                ),
                admin_url('admin.php')
            )
        )
    );
}
add_filter('oxy_one_click_details', 'oxy_one_click_details', 10, 1);

/*
 * Does final setup tasks at the end of the import
 *
 * @return void
 * @author
 **/
function oxy_one_click_final_setup($data, $OneClick)
{
    global $oxy_theme;

    // install page ids with a look up to see what is the new id
    if (isset($data['page_options'])) {
        foreach ($data['page_options'] as $option => $option_value) {
            update_option($option, $OneClick->install_package->lookup_map('page', $option_value));
        }
    }

    $OneClick->install_package->add_log_message('Set Page Options');

    // now save the regular options
    if (isset($data['options'])) {
        foreach ($data['options'] as $option => $option_value) {
            update_option($option, $option_value);
        }
    }

    // set up theme_mods if we have any
    if (isset($data['theme_mods'])) {
        foreach ($data['theme_mods'] as $name => $value) {
            set_theme_mod($name, $value);
        }
    }

    // set up theme options
    if (isset($data['theme_options'])) {
        foreach ($data['theme_options'] as $id => $value) {
            $new_value = null;
            switch($id) {
                case '404_page':
                case 'portfolio_page':
                case 'portfolio_archive_page':
                case 'services_archive_page':
                case 'staff_archive_page':
                    $new_id = $OneClick->install_package->lookup_map('pages', $value);
                    if (false !== $new_id) {
                        $new_value = $new_id;
                    }
                    break;
                case 'site_stack':
                    $new_id = $OneClick->install_package->lookup_map('oxy_stack', $value);
                    if (false !== $new_id) {
                        $new_value = $new_id;
                    }
                    // save new css to file
                    if (!class_exists('OxygennaStacks')) {
                        require_once(OXY_STACKS_DIR . 'inc/OxygennaStacks.php');
                    }
                    // get stack instance and save the meta data to the file
                    $OxyStack = OxygennaStacks::instance();
                    $OxyStack->update_css_in_file($new_value);
                    break;
                case 'logo_image':
                case 'logo_image_trans':
                    if (!empty($value)) {
                        $new_url = $OneClick->install_package->lookup_map('images', $value);
                        if (!empty($new_url)) {
                            $new_value = $new_url;
                        }
                    } else {
                        $new_value = '';
                    }
                    break;
                case 'favicon':
                case 'iphone_icon':
                case 'iphone_retina_icon':
                case 'ipad_icon':
                case 'ipad_icon_retina':
                case 'google_anal':
                case 'one_click_throttle':
                    // do nothing
                    break;
                default:
                    $new_value = $value;
                    break;
            }
            if (null !== $new_value) {
                $oxy_theme->set_option($id, $new_value);
            }
        }
    }
}
add_action('oxy_one_click_final_setup', 'oxy_one_click_final_setup', 10, 2);
