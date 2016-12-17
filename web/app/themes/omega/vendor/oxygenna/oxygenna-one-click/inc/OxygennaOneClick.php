<?php
/**
 * One Click Installer
 *
 * @package One Click Installer
 * @subpackage Admin
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.14.0
 * @author Oxygenna.com
 */

define('OXY_ONECLICK_DIR', OXY_THEME_DIR . 'vendor/oxygenna/oxygenna-one-click/');
define('OXY_ONECLICK_URI', OXY_THEME_URI . 'vendor/oxygenna/oxygenna-one-click/');

define('OXY_IMPORT_OK', 1);
define('OXY_IMPORT_FAIL', 0);
define('OXY_IMPORT_EXISTS', -1);

require_once OXY_ONECLICK_DIR . 'inc/OxygennaPackageInstall.php';

class OxygennaOneClick
{
    public $install_package;
    private $meta_id_key;

    public function __construct()
    {
        $this->meta_id_key = 'oxy-' . THEME_SHORT . '-original-id';

        add_action('init', array(&$this, 'init'));
        // register hook for before option page
        add_action(THEME_SHORT . '-oneclick-before-page', array(&$this, 'render'));
        // add ajax calls
        add_action('wp_ajax_oxy_import_package_details', array(&$this, 'render_packages_detail_popup'));

        add_action('wp_ajax_oxy_import_start', array(&$this, 'import_start'));

        add_action('wp_ajax_oxy_import_posts', array(&$this, 'import_posts'));

        add_action('wp_ajax_oxy_import_menu', array(&$this, 'import_menu'));

        add_action('wp_ajax_oxy_import_final_setup', array(&$this, 'final_setup'));

        add_action('wp_ajax_oxy_import_slideshow', array(&$this, 'import_slideshow'));
    }

    public function init()
    {
        include OXY_ONECLICK_DIR . 'inc/option-pages.php';
    }

    public function return_object()
    {
        $return = new stdClass();
        $return->status = false;
        $return->data = '';

        return $return;
    }

    public function import_start()
    {
        @error_reporting(0); // Don't break the JSON result
        header('Content-Type: application/json');

        $return = $this->return_object();
        $return->data = __('Could not validate nonce', 'omega-admin-td');

        if (isset($_POST['nonce'])) {
            if (wp_verify_nonce($_POST['nonce'], 'oxy-importer')) {
                $this->install_package = OxygennaPackageInstall::instance($_POST['installPackageId']);
                $this->install_package->start_install_run();
                $return->status = true;
            }
        }

        echo json_encode($return);
        die();
    }

    public function import_posts()
    {
        header('Content-Type: application/json');
        @error_reporting(0); // Don't break the JSON result
        @set_time_limit(900); // 5 minutes should be PLENTY

        $return = $this->return_object();
        $return->data = __('Could not validate nonce', 'omega-admin-td');

        // load current install package
        $this->install_package = OxygennaPackageInstall::instance($_POST['installPackageId']);

        if (isset($_POST['nonce']) && wp_verify_nonce($_POST['nonce'], 'oxy-importer')) {
            $posts = json_decode(stripslashes($_POST['data']), true);
            if (is_array($posts) && count($posts) > 0) {
                foreach ($posts as $post) {
                    $this->import_post($post);
                }
                $return->status = true;
                $return->data = __('Import Posts OK', 'omega-admin-td');
            }
        }

        echo json_encode($return);
        die();
    }

    public function import_post($post)
    {
        $this->install_package->open_item_log($post['post_title'], $post['post_type']);

        $this->install_package->add_log_message(__('Starting import of "', 'omega-admin-td') . $post['post_title'] . '"');

        $post_return_id = null;

        if (!$this->post_already_installed($post)) {
            if ($post) {
                // apply filter in case theme needs to change anything before creating post
                $post = apply_filters('oxy_one_click_before_insert_post', $post, $this);

                if (post_type_exists($post['post_type'])) {
                    switch ($post['post_type']) {
                        case 'attachment':
                            $post_return_id = $this->create_attachment($post);
                            break;
                        default:
                            $post_return_id = $this->create_post($post);
                            break;
                    }
                }
            }

            if ($post_return_id !== null) {
                // add meta data to mark this as import content
                update_post_meta($post_return_id, $this->meta_id_key, $post['ID']);

                // apply filter in case theme needs to change anything after creating post
                $post = apply_filters('oxy_one_click_after_insert_post', $post, $this);

                $this->install_package->set_log_status(OXY_IMPORT_OK);
                $this->install_package->add_log_message(__('Post Created.', 'omega-admin-td'));
            } else {
                $this->install_package->set_log_status(OXY_IMPORT_FAIL);
                $this->install_package->add_log_message(__('Failed to create post.', 'omega-admin-td'));
            }
        } else {
            $this->install_package->set_log_status(OXY_IMPORT_EXISTS);
            $this->install_package->add_log_message(__('Import stopped reason - Post already exists.', 'omega-admin-td'));
        }

        $this->install_package->close_item_log();

        return $post_return_id;
    }

    private function post_already_installed($post)
    {
        // check if this post has been installed before
        $installed_already = get_posts(array(
            'meta_key'       => $this->meta_id_key,
            'meta_value'     => $post['ID'],
            'posts_per_page' => 1,
            'post_type'      => $post['post_type']
        ));

        return count($installed_already) > 0;
    }

    public function create_post($post)
    {
        $old_id = $post['ID'];

        unset($post['ID']);
        unset($post['guid']);
        unset($post['post_parent']);

        // make sure wp_insert_post doesnt filter the post content ( adds p tags and shit )
        $post['filter'] = true;

        kses_remove_filters();
        $new_id = wp_insert_post($post);
        kses_init_filters();

        if ($new_id !== 0) {
            $this->install_package->item_created($post['post_type'], $new_id);
            $this->install_package->add_log_message(__('Import Post OK', 'omega-admin-td'));
            $this->install_package->add_to_map($post['post_type'], $old_id, $new_id);

            // handle custom fields
            if (isset($post['custom_fields'])) {
                foreach ($post['custom_fields'] as $key => $value) {
                    $add_field = false;
                    switch ($key) {
                        case '_thumbnail_id':
                            foreach ($value as $old_media_id) {
                                $new_media_id = $this->install_package->lookup_map('attachments', $old_media_id);
                                if ($new_media_id !== false) {
                                    add_post_meta($new_id, '_thumbnail_id', $new_media_id);
                                }
                            }
                            break;
                        case '_product_image_gallery':
                            $old_media_ids = explode(',', $value[0]);
                            $new_media_ids = array();
                            foreach ($old_media_ids as $old_media_id) {
                                $new_media_id = $this->install_package->lookup_map('attachments', $old_media_id);
                                if ($new_media_id !== false) {
                                    $new_media_ids[] = $new_media_id;
                                }
                            }
                            if (count($new_media_id) > 0) {
                                add_post_meta($new_id, '_product_image_gallery', implode(',', $new_media_ids));
                            }
                            break;
                        case THEME_SHORT . '_post_gallery':
                            foreach ($value as $post_gallery) {
                                $post_gallery = $this->replace_gallery_shortcode_ids($post_gallery);
                                add_post_meta($new_id, $key, $post_gallery);
                            }
                            break;
                        case '_edit_last':
                            // ignore
                            break;
                        case THEME_SHORT . '_masonry_image':
                        case THEME_SHORT . '_background_image':
                            // get the new url of the image
                            $new_url = $this->install_package->lookup_map('images', $value[0]);
                            add_post_meta($new_id, $key, $new_url);
                            break;
                        default:
                            $add_field = true;
                            break;
                    }

                    if ($add_field) {
                        foreach ($value as $old_value) {
                            add_post_meta($new_id, $key, $old_value);
                        }
                    }
                }
                $this->install_package->add_log_message(__('Added ' . count($post['custom_fields']) . ' custom fields', 'omega-admin-td'));
            }

            if (isset($post['taxonomies'])) {
                $taxonomies = get_taxonomies();
                foreach ($taxonomies as $taxonomy) {
                    if (isset($post['taxonomies'][$taxonomy])) {
                        foreach ($post['taxonomies'][$taxonomy] as $old_tax) {
                            $term_id = term_exists($old_tax['slug'], $taxonomy);

                            // if tag doesnt exist we must create it
                            if (!$term_id) {
                                $new_tag_args = array('slug' => $old_tax['slug'], 'description' => $old_tax['description']);
                                if ($old_tax['parent'] !== 0) {
                                    $new_tag_args['parent'] = $this->install_package->lookup_map($taxonomy, $old_tax['term_id']);
                                }
                                $term_id = wp_insert_term($old_tax['name'], $taxonomy, $new_tag_args);
                            }

                            if (! is_wp_error($term_id)) {

                                if (is_array($term_id)) {
                                    $term_id = $term_id['term_id'];
                                }

                                // store old / new term id in map
                                $this->install_package->add_to_map($taxonomy, $old_tax['term_id'], $term_id);

                                // now save the taxonomy
                                if ($taxonomy === 'post_tag' || $taxonomy === 'product_tag') {
                                     wp_set_post_terms($new_id, $old_tax['name'], $taxonomy, true);
                                } else {
                                    wp_set_post_terms($new_id, array($term_id), $taxonomy, true);
                                }
                            }
                        }
                    }
                }
                $this->install_package->add_log_message(__('Added ' . count($taxonomies) . ' taxonomies', 'omega-admin-td'));
            }

            // handle post_format
            if (isset($post['format']) && $post['format'] !== false) {
                $this->install_package->add_log_message(__('Set post format ' . $post['format'], 'omega-admin-td'));
                set_post_format($new_id, $post['format']);
            }

            if (isset($post['attachments'])) {
                foreach ($post['attachments'] as $old_attachment_id) {
                    $this->install_package->add_log_message(__('Set attachment', 'omega-admin-td'));
                    $this->update_post_parent($this->install_package->lookup_map('attachments', $old_attachment_id), $new_id);
                }
            }
        }
        return $new_id;
    }

    public function create_attachment($post)
    {
        $attach_id = null;
        $package_details = $this->install_package->get_install_package();

        $image_url = trailingslashit($package_details['importUrl']) . 'images/' . $post['filename'];
        $response = wp_remote_get($image_url, array('timeout' => 120, 'sslverify' => false));

        if (is_wp_error($response)) {
            $this->install_package->add_log_message(__('Could not download - ' . $image_url, 'omega-admin-td'));
        } else {
            $image_body = wp_remote_retrieve_body($response);
            $this->install_package->add_log_message(__('Downloaded image data - ' . $image_url, 'omega-admin-td'));

            // next upload to the WP uploads directory
            $upload = wp_upload_bits($post['filename'], null, $image_body);

            // did everything go ok?
            if ($upload['error']) {
                $this->install_package->add_log_message(__('Could not upload to WordPress - ' . $upload['error'], 'omega-admin-td'));
            }

            // everything is fine so lets
            $attachment = array(
                'guid'           => $upload['url'],
                'post_mime_type' => $post['post_mime_type'],
                'post_title'     => $post['post_title'],
                'post_content'   => $post['post_content'],
                'post_status'    => $post['post_status']
            );

            // create attachment post
            $attach_id = wp_insert_attachment($attachment, $upload['file']);

            if (0 !== $attach_id) {
                $this->install_package->item_created($post['post_type'], $attach_id);
                $this->install_package->add_log_message(__('Attachment created', 'omega-admin-td'));

                // regenerate thumbnails
                $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
                wp_update_attachment_metadata($attach_id, $attach_data);

                $this->install_package->add_log_message(__('Generated Thumbnails', 'omega-admin-td'));

                // store old url and new url in map
                $map = $this->install_package->add_to_map('images', $post['guid'], $upload['url']);

                // store old id and new id in map
                $map = $this->install_package->add_to_map('attachments', $post['ID'], $attach_id);
            }
        }
        return $attach_id;
    }

    public function replace_shortcode_attachment_id($content, $shortcode, $param, $lookup_map)
    {
        if (preg_match_all('/\[' . $shortcode . '[^\]]*' . $param . '="([^"]*)"[^\]]*\]/i', $content, $matches)) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                // found a single image
                // replace old ids with new ones
                if (array_key_exists($i, $matches[0]) && array_key_exists($i, $matches[1])) {
                    $new_id = $this->install_package->lookup_map($lookup_map, $matches[1][$i]);
                    if ($new_id !== false) {
                        $old_string = $matches[0][$i];
                        $new_string = str_replace($matches[1][$i], $new_id, $matches[0][$i]);
                        $content = str_replace($old_string, $new_string, $content);
                    }
                }
            }
        }

        return $content;
    }

    public function replace_gallery_shortcode_ids($post_content)
    {
        $pattern = get_shortcode_regex();
        // look for an embeded shortcode in the post content
        if (preg_match_all('/'. $pattern .'/s', $post_content, $gallery_shortcode) && array_key_exists(2, $gallery_shortcode) && in_array('gallery', $gallery_shortcode[2])) {
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
                                $new_gallery_ids[] = $this->install_package->lookup_map('attachments', $gallery_id);
                            }
                            // replace old ids with new ones
                            $old_string = 'ids="' . implode(',', $gallery_ids) . '"';
                            $new_string = 'ids="' . implode(',', $new_gallery_ids) . '"';
                            $post_content = str_replace($old_string, $new_string, $post_content);
                        }
                    }
                }
            }
        }
        return $post_content;
    }

    public function update_post_parent($post_id, $parent_id)
    {
        global $wpdb;

        $parent_id = (string) $parent_id;
        $post_id = (string) $post_id;
        $result = $wpdb->update($wpdb->posts, array('post_parent' => $parent_id), array('ID' => $post_id));

        if ($result === false) {
            return false;
        } else {
            return true;
        }
    }

    public function import_menu()
    {
        header('Content-Type: application/json');
        @set_time_limit(900); // 5 minutes per menu should be PLENTY

        // load current job
        $this->install_package = OxygennaPackageInstall::instance($_POST['installPackageId']);

        $return = $this->return_object();

        if (isset($_POST['nonce']) && wp_verify_nonce($_POST['nonce'], 'oxy-importer')) {
            $menu = json_decode(stripslashes($_POST['data']), true);

            $this->install_package->open_item_log($menu['name'], 'menu');
            $this->install_package->add_log_message(__('Started Import Menu.', 'omega-admin-td'));

            $already_exists = wp_get_nav_menu_object($menu['slug']);

            if (false === $already_exists) {
                // apply filter in case theme needs to change anything before creating menu
                $menu = apply_filters('oxy_one_click_before_wp_create_nav_menu', $menu, $this);

                // create new menu
                $new_menu_id = wp_create_nav_menu($menu['name']);
                // $locations = get_theme_mod('nav_menu_locations');

                if (!is_wp_error($new_menu_id)) {
                    $this->install_package->item_created('nav_menu', $new_menu_id);
                    // everything was ok creating menu so set log and return value
                    $this->install_package->set_log_status(OXY_IMPORT_OK);
                    $this->install_package->add_log_message(__('Menu Created.', 'omega-admin-td'));

                    $return->status = true;
                    $return->data = $new_menu_id;

                    $this->install_package->add_to_map('nav_menu', $menu['term_id'], $new_menu_id);

                    // set the new menu to location if we have one
                    if (isset($menu['location'])) {
                        $locations[$menu['location']] = $new_menu_id;
                        set_theme_mod('nav_menu_locations', $locations);
                    }

                    // import menu items
                    foreach ($menu['menu_items'] as $menu_item) {
                        $this->import_menu_item($menu_item, $new_menu_id);
                    }

                    $this->install_package->add_log_message('Added ' . count($menu['menu_items']) . ' menu items to menu');

                } else {
                    $this->install_package->set_log_status(OXY_IMPORT_FAIL);
                    $this->install_package->add_log_message(__('Call to wp_create_nav_menu failed.', 'omega-admin-td'));
                }
            } else {
                $return->status = true;
                $return->data = 'Menu exists';
                $this->install_package->set_log_status(OXY_IMPORT_EXISTS);
                $this->install_package->add_log_message(__('Import stopped reason - Menu already exists.', 'omega-admin-td'));
            }

            $this->install_package->close_item_log();
        }


        echo json_encode($return);
        die();
    }

    private function import_menu_item($menu_item, $menu_id)
    {
        // if menu item points to a post / page / post_type need to make it point to the correct id
        $lookup_menu_item_target = $this->install_package->lookup_map($menu_item['object'], $menu_item['object_id']);

        $new_menu_item = array(
            'menu-item-type'        => $menu_item['type'],
            'menu-item-object'      => $menu_item['object'],
            'menu-item-object-id'   => $lookup_menu_item_target === false ? 0 : $lookup_menu_item_target,
            'menu-item-status'      => $menu_item['post_status'],
            'menu-item-title'       => $menu_item['title'],
            'menu-item-description' => $menu_item['description'],
            'menu-item-attr-title'  => $menu_item['attr_title'],
            'menu-item-target'      => $menu_item['target'],
            'menu-item-classes'     => implode(' ', $menu_item['classes']),
            'menu-item-xfn'         => $menu_item['xfn'],
            'menu-item-url'         => $menu_item['url'],
        );

        if ($menu_item['menu_item_parent'] != 0) {
            $new_menu_item['menu-item-parent-id'] = $this->install_package->lookup_map('menu_items', $menu_item['menu_item_parent']);
        }

        // apply filter in case theme needs to change anything before creating menu item
        $new_menu_item = apply_filters('oxy_one_click_before_wp_update_nav_menu_item', $new_menu_item, $menu_item, $this);

        $new_menu_item_id = @wp_update_nav_menu_item($menu_id, 0, $new_menu_item);

        if (!is_wp_error($new_menu_item_id)) {
            $this->install_package->item_created('nav_menu_item', $new_menu_item_id);
            // call extra hook to do any theme specific stuff to the menu item (meta data)
            do_action('oxy_one_click_new_menu_item', $new_menu_item_id, $menu_item, $this);
            // add to map
            $this->install_package->add_to_map('menu_items', $menu_item['ID'], $new_menu_item_id);
        } else {
            $this->install_package->add_log_message('Error importing menu item ' . $menu_item['title']);
        }

        return $new_menu_item_id;
    }

    public function final_setup()
    {
        @error_reporting(0); // Don't break the JSON result
        header('Content-Type: application/json');

        // load current job
        $this->install_package = OxygennaPackageInstall::instance($_POST['installPackageId']);

        $return = $this->return_object();

        if (isset($_POST['nonce']) && wp_verify_nonce($_POST['nonce'], 'oxy-importer') && isset($_POST['data'])) {
            // get final_setup data
            $data = json_decode(stripslashes($_POST['data']), true);

            // import widgets
            $this->import_widgets($data);

            // do final install hook (theme specific things)
            $this->install_package->open_item_log('Final Setup', 'Final Theme Setup Hook');
            do_action('oxy_one_click_final_setup', $data, $this);
            $this->install_package->set_log_status(OXY_IMPORT_OK);
            $this->install_package->close_item_log();

            $return->status = true;
        } else {
            $return->status = false;
            $return->data = 'Couldnt validate nonce';
        }

        echo json_encode($return);
        die();
    }

    public function import_slideshow()
    {
        @error_reporting(0); // Don't break the JSON result
        header('Content-Type: application/json');

        // load current job
        $this->install_package = OxygennaPackageInstall::instance($_POST['installPackageId']);

        $return = $this->return_object();

        if (isset($_POST['nonce']) && wp_verify_nonce($_POST['nonce'], 'oxy-importer')) {

            $current_package = $this->install_package->get_install_package();

            $slideshow = $_POST['slideshow'];

            $this->install_package->open_item_log($slideshow['filename'], $slideshow['type']);

            // check if slider has already been installed
            if (!$this->slideshow_already_installed($slideshow)) {
                $url = trailingslashit($current_package['importUrl'] . $slideshow['type']) . $slideshow['filename'];

                $response = wp_remote_get($url, array('sslverify' => false));

                if (is_wp_error($response)) {
                    $return->data = new WP_Error('Import Slider', 'Could not download ' . $url);
                } else {
                    $body = wp_remote_retrieve_body($response);

                    // next upload to the WP uploads directory
                    $upload = wp_upload_bits($slideshow['filename'], null, $body);

                    // did everything go ok?
                    if ($upload['error']) {
                        $return->data = new WP_Error('Import Slider', 'Could not save ' . $slideshow['filename']);
                    } else {
                        // we have the slider now install
                        switch($slideshow['type']) {
                            case 'layerslider':
                                if (is_plugin_active('LayerSlider/layerslider.php')) {
                                    // Get importUtil
                                    include LS_ROOT_PATH . '/classes/class.ls.importutil.php';

                                    // import the layer slider
                                    $import_object = @new LS_ImportUtil($upload['file']);

                                    // layerslider for some reason doesn't save the slug properly so we have to do it ourselves
                                    global $wpdb;
                                    // get the last inserted id
                                    $ls_import_id = $wpdb->insert_id;
                                    // get the layerslider
                                    $ls_slider = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . LS_DB_TABLE . ' WHERE id = %d', $ls_import_id));

                                    // decode the properties data to get the slug
                                    $ls_data = json_decode($ls_slider->data);
                                    $ls_slug = $ls_data->properties->slug;

                                    // update the layerslider with the new slug
                                    $updated = $wpdb->update(
                                        $wpdb->prefix . LS_DB_TABLE,
                                        array(
                                            'slug' => $ls_slug,
                                        ),
                                        array(
                                            'ID' => $ls_import_id
                                        ),
                                        array(
                                            '%s'
                                        ),
                                        array( '%d' )
                                    );
                                    $this->install_package->item_created($slideshow['type'], $ls_import_id);
                                    $return->status = true;
                                }
                                break;
                            case 'revslider':
                                if (is_plugin_active('revslider/revslider.php')) {
                                    $_FILES['import_file']['tmp_name'] = $upload['file'];
                                    $slider = @new RevSlider();
                                    ob_start();
                                    $return->data = @$slider->importSliderFromPost('true', 'true');
                                    ob_end_clean();

                                    $this->install_package->item_created($slideshow['type'], $return->data['sliderID']);
                                    $this->install_package->set_log_status(OXY_IMPORT_OK);
                                    $this->install_package->add_log_message(__('Revslider Created.', 'omega-admin-td'));
                                    $return->status = true;
                                }
                                break;
                        }
                    }
                }
            } else {
                $return->status = true;
                $return->data = 'Slideshow exists';
                $this->install_package->set_log_status(OXY_IMPORT_EXISTS);
                $this->install_package->add_log_message(__('Import stopped reason - Slideshow already exists.', 'omega-admin-td'));
            }
        }

        $this->install_package->close_item_log();

        echo json_encode($return);
        die();
    }

    private function slideshow_already_installed($slideshow)
    {
        $exists = false;
        switch($slideshow['type']) {
            case 'revslider':
                if (class_exists('RevSlider')) {
                    $revslider = new RevSlider();
                    try {
                        $revslider->initByAlias($slideshow['alias']);
                        $exists = true;
                    } catch (Exception $e) {
                        $exists = false;
                    }
                }
                break;
        }
        return $exists;
    }

    private function import_widgets($data)
    {
        if (isset($data['widgets'])) {
            $sidebar_widgets = get_option('sidebars_widgets');
            // loop through all widgets we have to install
            foreach ($data['widgets'] as $widget) {
                // create log for this widget
                $this->install_package->open_item_log('Final Setup', 'Install Widget - ' . $widget['type']);
                // check to make sure this area is availble in the theme
                if (null === $sidebar_widgets[$widget['widget_area']]) {
                    $sidebar_widgets[$widget['widget_area']] = array();
                }
                if (isset($sidebar_widgets[$widget['widget_area']])) {
                    // check to see if this widget has been installed here before
                    $widget_exists = false;
                    foreach ($sidebar_widgets[$widget['widget_area']] as $position => $widget_id) {
                        $last_dash = strrpos($widget_id, '-');
                        $length    = strlen($widget_id);
                        $count     = substr($widget_id, $last_dash + 1, $length);
                        $type      = substr($widget_id, 0, $last_dash);

                        if ($type === $widget['type']) {
                            $widget_exists = true;
                        }
                    }
                    if ($widget_exists) {
                        $this->install_package->set_log_status(OXY_IMPORT_EXISTS);

                    } else {
                        // need to add the widget
                        $this->import_widget($widget);
                    }
                }
                $this->install_package->close_item_log();
            }
        }
    }

    private function import_widget($widget)
    {
        // create widget
        $widgets_options = get_option('widget_' . $widget['type']);
        if (false === $widgets_options) {
            $widgets_options = array();
        }
        $count = count($widgets_options) + 1;

        // need to do anything special with the widget?
        switch($widget['type']) {
            case 'nav_menu':
                $widget['options']['nav_menu'] = $this->install_package->lookup_map('nav_menu', $widget['options']['nav_menu']);
                break;
        }
        $widgets_options[$count] = $widget['options'];
        update_option('widget_' . $widget['type'], $widgets_options);

        // add widget to widget_area
        $new_widget_id = $widget['type'] . '-' . $count;
        $sidebars_widgets = get_option('sidebars_widgets');
        $sidebars_widgets[$widget['widget_area']][] = $new_widget_id;
        update_option('sidebars_widgets', $sidebars_widgets);
        // note in the log it was made
        $this->install_package->set_log_status(OXY_IMPORT_OK);

        $this->install_package->item_created('widget', array(
            'widget_id'   => $new_widget_id,
            'widget_area' => $widget['widget_area'],
            'type'        => $widget['type'],
            'count'       => $count
        ));
    }

    // OPTION PAGES CODE
    public function render()
    {
        $status = isset($_POST['one_click_status']) ? $_POST['one_click_status'] : 'packages-page';
        switch($status) {
            case 'packages-page':
                $this->render_packages_page();
                break;
            case 'checklist-page':
                $this->render_checklist_page();
                break;
            case 'install-page':
                $this->render_install_page();
                break;
            case 'finished-page':
                $this->render_finished_page();
                break;
            case 'remove-page':
                $this->render_remove_page();
                break;
            case 'remove-content-page':
                $this->render_remove_content_page();
                break;
        }
        die();
    }

    private function render_checklist_page()
    {
        $this->install_package = OxygennaPackageInstall::instance($_POST['one_click_package_id']);
        $current_package = $this->install_package->get_install_package();

        $theme_check_list = apply_filters('oxy_one_click_checklist', array());
        $checks = array();
        $check_list_ok = true;
        $check_list_warnings = false;

        foreach ($theme_check_list as $check_item) {
            // get the checker class
            $class_file = OXY_ONECLICK_DIR . 'checks/Oxygenna' . $check_item['name'] . '.php';
            if (!file_exists($class_file)) {
                 throw new Exception('No such check file ' . $class_file);
            }
            require_once $class_file;

            // lets make a check
            $check_class = 'Oxygenna' . $check_item['name'];
            if (class_exists($check_class)) {
                // create check object
                $check = new $check_class($check_item['args']);
                // run the check
                $check->check();
                // was it ok?
                if (!$check->ok() && $check->type() === 'blocker') {
                    $check_list_ok = false;
                }
                // did we have a warning?
                if (!$check->ok() && $check->type() === 'warning') {
                    $check_list_warnings = true;
                }
                // store the check in array for the list page
                $checks[] = $check;
            }
        }

        include(OXY_ONECLICK_DIR . 'partials/checklist.php');
        include( ABSPATH . 'wp-admin/admin-footer.php' );
        die();
    }

    private function render_packages_page()
    {
        add_thickbox();
        // get packages available from theme
        $packages = apply_filters('oxy_one_click_import_packages', array());
        $packages_count = count($packages);

        $already_installed_package = null;
        foreach ($packages as $key => $package) {
            if (null !== get_option($package['id'], null)) {
                // $already_installed_package = $package;
                $this->move_to_top($packages, $key);
                $already_installed_package = $package['id'];
                break;
            }
        }

        include(OXY_ONECLICK_DIR . 'partials/packages.php');
        include( ABSPATH . 'wp-admin/admin-footer.php' );
        die();
    }

    private function move_to_top(&$array, $key)
    {
        $temp = array($key => $array[$key]);
        unset($array[$key]);
        $array = $temp + $array;
    }

    public function render_packages_detail_popup()
    {
        $this->install_package = OxygennaPackageInstall::instance($_GET['id']);
        $current_package = $this->install_package->get_install_package();
        $installer_details = apply_filters('oxy_one_click_details', array());
        $package_install_ok = true;
        if (null !== $current_package) {
            $is_installed = null !== get_option($current_package['id'], null);
            // check if requirements are there
            foreach ($current_package['requirements'] as &$required_plugin) {
                $required_plugin['ok'] = is_plugin_active($required_plugin['path']);
                if ($required_plugin['ok'] === false) {
                    $package_install_ok = false;
                }
            }
        }
        include(OXY_ONECLICK_DIR . 'partials/package-detail.php');
        die();
    }

    public function render_install_page()
    {
        $this->install_package = OxygennaPackageInstall::instance($_POST['one_click_package_id']);
        $current_package = $this->install_package->get_install_package();
        include(OXY_ONECLICK_DIR . 'partials/install.php');
        include( ABSPATH . 'wp-admin/admin-footer.php' );
        die();
    }

    public function render_finished_page()
    {
        $this->install_package = OxygennaPackageInstall::instance($_POST['installPackageId']);

        $package_details = $this->install_package->get_install_package();

        $results = $this->install_package->end_install_run();

        include(OXY_ONECLICK_DIR . 'partials/install-complete.php');
        include( ABSPATH . 'wp-admin/admin-footer.php' );
        die();
    }

    public function render_remove_page()
    {
        @set_time_limit(900); // 5 minutes should be PLENTY
        $this->install_package = OxygennaPackageInstall::instance($_POST['one_click_package_id']);
        $remove_package = $this->install_package->get_install_package();
        include(OXY_ONECLICK_DIR . 'partials/remove.php');
        include( ABSPATH . 'wp-admin/admin-footer.php' );
        die();
    }

    public function render_remove_content_page()
    {
        $this->install_package = OxygennaPackageInstall::instance($_POST['removePackageId']);
        $remove_package = $this->install_package->get_install_package();
        $installed_items = $this->install_package->get_installed_items();
        delete_option($remove_package['id']);
        include(OXY_ONECLICK_DIR . 'partials/remove-content.php');
        include( ABSPATH . 'wp-admin/admin-footer.php' );
        die();
    }
}

$one_click_install = new OxygennaOneClick();
