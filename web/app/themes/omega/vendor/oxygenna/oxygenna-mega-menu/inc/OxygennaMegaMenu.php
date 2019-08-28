<?php
/**
 * Main mega menu class
 *
 * @package Omega
 * @subpackage Admin
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.12
 * @author Oxygenna.com
 */

class OxygennaMegaMenu
{
    private static $instance;

    public static function instance()
    {
        if (! self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Constructor, this should be called first
     */
    public function __construct()
    {
        if (is_admin()) {
            // load walker for admin menus
            require_once OXY_MEGA_MENU_DIR . 'walkers/AdminBootstrapMegaMenuWalker.php';

            // allows us to enqueue scripts/js on menu page
            add_action('current_screen', array(&$this, 'current_screen'), 10, 1);

            // our own way of saving menus - for extra large menus
            add_action('wp_ajax_oxy_save_menu', array(&$this, 'wp_ajax_oxy_save_menu'));

            // custom hook for adding options to top of menu options
            add_action('oxy_admin_menu_options_top', array(&$this, 'oxy_admin_menu_options_top'), 10, 4);

            // custom hook for adding options to bottom of menu options
            add_action('oxy_admin_menu_options_bottom', array(&$this, 'oxy_admin_menu_options_bottom'), 10, 4);

            // forces WP to use our menu walker for admin menu page
            add_filter('wp_edit_nav_menu_walker', array(&$this, 'wp_edit_nav_menu_walker'), 10, 2);

            // add extra fields to nav menu items
            add_filter('wp_setup_nav_menu_item', array(&$this, 'wp_setup_nav_menu_item'));

            // save extra field when menu saves
            add_action('wp_update_nav_menu_item', array(&$this, 'wp_update_nav_menu_item'), 10, 3);
        }

        add_action('widgets_init', array(&$this, 'widgets_init'));

    }

    public function widgets_init()
    {
        // register any menu items that have widget positions
        $menu_widgets = get_posts(array(
            'post_type' => 'nav_menu_item',
            'meta_key' => 'oxy_widget',
            'meta_value' => 'on'
        ));

        $locations = get_nav_menu_locations();
        if (isset($locations['primary'])) {
            $menu_items = wp_get_nav_menu_items($locations['primary']);
            if ($menu_items !== false && is_array($menu_items)) {
                foreach ($menu_items as $menu_item) {
                    if ('oxy_mega_columns' === $menu_item->object) {
                        $oxy_widget = get_post_meta($menu_item->ID, 'oxy_widget', true);
                        if ('on' === $oxy_widget) {
                            register_sidebar(array(
                                'id'            => 'menu-' . $menu_item->ID,
                                'name'          => __('Menu', 'omega-admin-td') . ' - ' . $menu_item->title,
                                'description'   => $menu_item->description,
                                'before_widget' => '<div id="%1$s" class="menu-widget %2$s">',
                                'after_widget'  => '</div>',
                                'before_title'  => '<h3 class="menu-widget-header">',
                                'after_title'   => '</h3>',
                            ));
                        }
                    }
                }
            }
        }
    }

    public function current_screen($current_screen)
    {
        if ('nav-menus' === $current_screen->base) {
            wp_enqueue_style('oxy-mega-menu', OXY_MEGA_MENU_URI . 'assets/css/oxy-mega-menu.css');

            if ('on' === oxy_get_option('ajax_menu_save')) {
                wp_enqueue_script('oxy-ajax-save-menu', OXY_MEGA_MENU_URI . 'assets/js/ajax-save-menu.js', array('jquery'));
            }
            // Make sure Mega Menu is installed
            $menus = get_posts(array('post_type' => 'oxy_mega_menu'));
            if (count($menus) === 0) {
                // Create post object
                $my_post = array(
                  'post_title'    => 'Mega Menu',
                  'post_content'  => '',
                  'post_status'   => 'publish',
                  'post_type'     => 'oxy_mega_menu'
                );

                // Insert the post into the database
                wp_insert_post($my_post);
            }

            $menus = get_posts(array('post_type' => 'oxy_mega_columns'));
            if (count($menus) === 0) {
                $columns = array(
                    'col-md-3'  => __('One Quarter Column (1/4)', 'omega-admin-td'),
                    'col-md-4'  => __('One Third Column (1/3)', 'omega-admin-td'),
                );

                foreach ($columns as $content => $title) {
                    // Create post object
                    $column_post = array(
                      'post_title'    => $title,
                      'post_content'  => $content,
                      'post_status'   => 'publish',
                      'post_type'     => 'oxy_mega_columns'
                    );

                    // Insert the post into the database
                    wp_insert_post($column_post);
                }
            }
        }
    }

    public function wp_edit_nav_menu_walker($walker, $menu_id)
    {
        return 'AdminBoostrapMegaMenuWalker';
    }

    public function oxy_admin_menu_options_top($item, $depth, $args, $id)
    {
        $item_id = esc_attr($item->ID);
        switch($item->object)
        {
            case 'oxy_mega_menu':
            case 'oxy_mega_columns':
                include(OXY_MEGA_MENU_DIR . 'partials/options/top/' . $item->object . '.php');
                break;
        }
    }

    public function oxy_admin_menu_options_bottom($item, $depth, $args, $id)
    {
        $item_id = esc_attr($item->ID);
        switch($item->object)
        {
            case 'menu_item':
                break;
        }
        include(OXY_MEGA_MENU_DIR . 'partials/options/bottom/global.php');
    }

    public function wp_setup_nav_menu_item($menu_item)
    {
        $menu_item->oxy_mega_url     = get_post_meta($menu_item->ID, 'oxy_mega_url', true);
        $menu_item->oxy_modal        = get_post_meta($menu_item->ID, 'oxy_modal', true);
        $menu_item->oxy_icon         = get_post_meta($menu_item->ID, 'oxy_icon', true);
        $menu_item->oxy_bg_url       = get_post_meta($menu_item->ID, 'oxy_bg_url', true);
        $menu_item->oxy_col_url      = get_post_meta($menu_item->ID, 'oxy_col_url', true);
        $menu_item->oxy_special      = get_post_meta($menu_item->ID, 'oxy_special', true);
        $menu_item->oxy_widget       = get_post_meta($menu_item->ID, 'oxy_widget', true);
        $menu_item->oxy_label        = get_post_meta($menu_item->ID, 'oxy_label', true);
        $menu_item->oxy_label_type   = get_post_meta($menu_item->ID, 'oxy_label_type', true);
        $menu_item->oxy_mega_borders = get_post_meta($menu_item->ID, 'oxy_mega_borders', true);
        return $menu_item;
    }

    public function wp_update_nav_menu_item($menu_id, $menu_item_db_id, $args)
    {
        $extra_fields = array(
            'oxy_mega_url',
            'oxy_modal',
            'oxy_icon',
            'oxy_bg_url',
            'oxy_col_url',
            'oxy_special',
            'oxy_widget',
            'oxy_label',
            'oxy_label_type',
            'oxy_mega_borders'
        );
        // check for extra fields
        foreach ($extra_fields as $field) {
            if (isset($_REQUEST['menu-item-' . $field]) && is_array($_REQUEST['menu-item-' . $field])) {
                if (isset($_REQUEST['menu-item-' . $field][$menu_item_db_id])) {
                    $mega_url = $_REQUEST['menu-item-' . $field][$menu_item_db_id];
                    update_post_meta($menu_item_db_id, $field, $mega_url);
                }
            }
        }
    }

    /**
     * Saves wordpress menu using ajax calls
     *
     * @return json messages from nav-menus.php
     * @author
     **/
    public function wp_ajax_oxy_save_menu()
    {
        @error_reporting(0); // Don't break the JSON result

        // parse variables sent from $.serialize into an array
        $oxy_menu_to_save = json_decode(stripslashes($_POST['menu']), true);

        // set request and post to parsed menu data to fake the request
        $_REQUEST = $oxy_menu_to_save;
        $_POST = $oxy_menu_to_save;

        require_once(ABSPATH . 'wp-admin/includes/nav-menu.php');

        // Container for any messages displayed to the user
        $messages = array();

        // Container that stores the name of the active menu
        $nav_menu_selected_title = '';

        // The menu id of the current menu being edited
        $nav_menu_selected_id = isset($_REQUEST['menu']) ? (int) $_REQUEST['menu'] : 0;

        // Get existing menu locations assignments
        $locations = get_registered_nav_menus();
        $menu_locations = get_nav_menu_locations();
        $num_locations = count(array_keys($locations));

        check_admin_referer('update-nav_menu', 'update-nav-menu-nonce');

        // Remove menu locations that have been unchecked
        foreach ($locations as $location => $description) {
            if ((empty($_POST['menu-locations']) || empty($_POST['menu-locations'][ $location ])) && isset($menu_locations[ $location ]) && $menu_locations[ $location ] == $nav_menu_selected_id) {
                unset($menu_locations[ $location ]);
            }
        }

        // Merge new and existing menu locations if any new ones are set
        if (isset($_POST['menu-locations'])) {
            $new_menu_locations = array_map('absint', $_POST['menu-locations']);
            $menu_locations = array_merge($menu_locations, $new_menu_locations);
        }

        // Set menu locations
        set_theme_mod('nav_menu_locations', $menu_locations);

        // Add Menu
        if (0 == $nav_menu_selected_id) {
            $new_menu_title = trim(esc_html($_POST['menu-name']));

            if ($new_menu_title) {
                $_nav_menu_selected_id = wp_update_nav_menu_object(0, array('menu-name' => $new_menu_title));

                if (is_wp_error($_nav_menu_selected_id)) {
                    $messages[] = '<div id="message" class="error"><p>' . $_nav_menu_selected_id->get_error_message() . '</p></div>';
                } else {
                    $_menu_object = wp_get_nav_menu_object($_nav_menu_selected_id);
                    $nav_menu_selected_id = $_nav_menu_selected_id;
                    $nav_menu_selected_title = $_menu_object->name;
                    if (isset($_REQUEST['menu-item'])) {
                        wp_save_nav_menu_items($nav_menu_selected_id, absint($_REQUEST['menu-item']));
                    }
                    if (isset($_REQUEST['zero-menu-state'])) {
                        // If there are menu items, add them
                        wp_nav_menu_update_menu_items($nav_menu_selected_id, $nav_menu_selected_title);
                        // Auto-save nav_menu_locations
                        $locations = get_nav_menu_locations();
                        foreach ($locations as $location => $menu_id) {
                                $locations[ $location ] = $nav_menu_selected_id;
                                break; // There should only be 1
                        }
                        set_theme_mod('nav_menu_locations', $locations);
                    }
                    if (isset($_REQUEST['use-location'])) {
                        $locations = get_registered_nav_menus();
                        $menu_locations = get_nav_menu_locations();
                        if (isset($locations[ $_REQUEST['use-location'] ])) {
                            $menu_locations[ $_REQUEST['use-location'] ] = $nav_menu_selected_id;
                        }
                        set_theme_mod('nav_menu_locations', $menu_locations);
                    }
                    // $messages[] = '<div id="message" class="updated"><p>' . sprintf(__('<strong>%s</strong> has been created.'), $nav_menu_selected_title) . '</p></div>';
                    wp_redirect(admin_url('nav-menus.php?menu=' . $_nav_menu_selected_id));
                    exit();
                }
            } else {
                $messages[] = '<div id="message" class="error"><p>' . __('Please enter a valid menu name.', 'omega-admin-td') . '</p></div>';
            }

        // Update existing menu
        } else {

            $_menu_object = wp_get_nav_menu_object($nav_menu_selected_id);

            $menu_title = trim(esc_html($_POST['menu-name']));
            if (! $menu_title) {
                $messages[] = '<div id="message" class="error"><p>' . __('Please enter a valid menu name.', 'omega-admin-td') . '</p></div>';
                $menu_title = $_menu_object->name;
            }

            if (! is_wp_error($_menu_object)) {
                $_nav_menu_selected_id = wp_update_nav_menu_object($nav_menu_selected_id, array('menu-name' => $menu_title));
                if (is_wp_error($_nav_menu_selected_id)) {
                    $_menu_object = $_nav_menu_selected_id;
                    $messages[] = '<div id="message" class="error"><p>' . $_nav_menu_selected_id->get_error_message() . '</p></div>';
                } else {
                    $_menu_object = wp_get_nav_menu_object($_nav_menu_selected_id);
                    $nav_menu_selected_title = $_menu_object->name;
                }
            }

            // Update menu items
            if (! is_wp_error($_menu_object)) {
                $messages = array_merge($messages, wp_nav_menu_update_menu_items($nav_menu_selected_id, $nav_menu_selected_title));
            }
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'messages' => $messages,
            'nav_menu_selected_id' => $nav_menu_selected_id
        ));

        die();
    }
}
