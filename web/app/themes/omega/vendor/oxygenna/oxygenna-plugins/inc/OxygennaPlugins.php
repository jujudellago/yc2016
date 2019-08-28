<?php
/**
 * Plugin installer
 *
 * @package Omega
 * @subpackage Admin
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.12
 * @author Oxygenna.com
 */

require_once(OXY_PLUGINS_INSTALLER_DIR . 'inc/OxygennaPluginsTable.php');

class OxygennaPlugins
{
    private static $instance;
    private $messages;

    public static function instance()
    {
        if (! self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __construct()
    {
        $this->messages = array();

        add_action(THEME_SHORT . '-plugins-before-page', array(&$this, 'render_plugins_page'));

        add_filter('install_plugin_complete_actions', array(&$this, 'plugin_complete_actions'));
    }

    public function render_plugins_page()
    {
        // check if we need to save the purchase code
        $this->save_purchase_code();

        // check if we are activating a plugin
        $this->plugin_activate();

        // are we installing a plugin?
        if (isset($_GET['action']) && 'install-plugin' === $_GET['action']) {
            $this->plugin_install();
        } else {
            // get purchase code for input box
            $plugin_options = $this->get_options();

            // prepare plugins table
            $plugins_table = new OxygennaPluginsTable($plugin_options);
            $plugins_table->prepare_items();

            $form_url = esc_url(
                add_query_arg(
                    array(
                        'page'   => THEME_SHORT . '-plugins',
                    ),
                    admin_url('admin.php')
                )
            );

            // create plugins page
            ob_start();
            include(OXY_PLUGINS_INSTALLER_DIR . 'partials/plugins.php');
            $output = ob_get_contents();
            ob_end_clean();
            echo $output;
        }

        include(ABSPATH . 'wp-admin/admin-footer.php');
        die();
    }

    /**
     * Saves purchase code to option if needed
     *
     * @return void
     **/
    private function save_purchase_code()
    {
        if (isset($_POST['save-purchase-code'])) {
            $plugin_options = $this->get_options();
            $plugin_options['purchase-code'] = $_POST['purchase-code'];
            $this->save_options($plugin_options);
            $this->add_message(__('Purchase code updated', 'omega-admin-td'), 'updated');
        }
    }

    private function plugin_install()
    {
        // All plugin information will be stored in an array for processing.
        $plugin = array();

        // Checks for actions from hover links to process the installation.
        if (isset($_GET['id'] ) && (isset($_GET['action'] ) && 'install-plugin' === $_GET['action'])) {
            check_admin_referer('oxy-plugin-install');

            include_once ABSPATH . 'wp-admin/includes/plugin-install.php'; //for plugins_api..
            require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php'; // Need for upgrade classes.

            $plugin['id']      = $_GET['id'];
            $plugin['action']  = $_GET['action'];
            $plugin['type']    = $_GET['type'];
            $plugin['plugin']  = $_GET['plugin'];
            $plugin['path']    = $_GET['path'];
            $plugin['version'] = $_GET['version'];

            switch($plugin['type']) {
                case 'wordpress':
                    $api = plugins_api('plugin_information', array('slug' => $plugin['id'], 'fields' => array('sections' => false))); //Save on a bit of bandwidth.

                    if (is_wp_error($api)) {
                        wp_die($api);
                    }

                    $title = sprintf(__('Installing Plugin: %s', 'omega-admin-td'), $api->name . ' ' . $api->version);
                    $nonce = 'install-plugin_' . $plugin['id'];
                    $url = 'update.php?action=install-plugin&plugin=' . urlencode($plugin['id']);

                    if (isset($_GET['from'])) {
                        $url .= '&from=' . urlencode(stripslashes($_GET['from']));
                    }

                    $type = 'web'; //Install plugin type, From Web or an Upload.

                    $upgrader = new Plugin_Upgrader(new Plugin_Installer_Skin(compact('title', 'url', 'nonce', 'plugin', 'api')));
                    $upgrader->install($api->download_link);

                    break;
                case 'premium':
                    if (! current_user_can('upload_plugins')) {
                        wp_die(__('You do not have sufficient permissions to install plugins on this site.', 'omega-admin-td'));
                    }

                    $upgrader = new Plugin_Upgrader(new Plugin_Installer_Skin(compact('type', 'title', 'nonce', 'url')));
                    $plugin_options = $this->get_options();
                    $key = base64_encode($plugin_options['purchase-code']);
                    $download_link = 'http://updates.oxygenna.com/themes/' . THEME_SHORT . '/' . $plugin['id'] . '/' . $key;

                    $title = sprintf(__('Installing Plugin from uploaded file: %s'), esc_attr($plugin['plugin']));
                    $nonce = 'plugin-upload';
                    $url = esc_url(
                        add_query_arg(
                            array(
                                'action' => 'install-plugin',
                                'package' => $plugin['id'],
                                'url' => $download_link
                            ),
                            'update.php'
                        )
                    );
                    $type = 'upload'; //Install plugin type, From Web or an Upload.

                    if (isset($_GET['update'])) {
                        // change update_plugins option to allow update
                        // delete_site_transient('update_plugins');
                        $data = get_site_transient('update_plugins');
                        $data->response[$plugin['id']] = new stdClass();
                        $data->response[$plugin['id']]->package = $download_link;
                        $data->response[$plugin['id']]->version  = $plugin['version'];
                        set_site_transient('update_plugins', $data);
                        // update the plugins
                        $result = $upgrader->upgrade($plugin['id']);
                    } else {
                        $result = $upgrader->install($download_link);
                    }
                    if ($result) {
                        $this->store_plugin_version($plugin['id'], $plugin['version']);
                    }
                    break;
            }
        }
    }

    private function plugin_activate()
    {
        if (isset($_GET['action']) && 'activate-plugin' === $_GET['action']) {
            if (!current_user_can('update_plugins')) {
                wp_die(__('You do not have sufficient permissions to update plugins for this site.', 'omega-admin-td'));
            }

            check_admin_referer('oxy-plugin-activate');

            if (isset($_GET['path']) && is_plugin_inactive($_GET['path'])) {
                if (null === activate_plugin($_GET['path'])) {
                    $this->add_message(__('The following plugin was activated successfully:', 'omega-admin-td') . ' <strong>' . $_GET['plugin'] . '</strong>', 'updated');
                }
            }
        }
    }

    public function plugin_complete_actions($install_actions)
    {
        if (isset($_GET['page']) && THEME_SHORT . '-plugins' === $_GET['page']) {
            $url = esc_url(
                add_query_arg(
                    array(
                        'page'   => THEME_SHORT . '-plugins'
                    ),
                    admin_url('admin.php')
                )
            );
            $install_actions = array(
                'plugins_page' => '<a href="' . $url . '" title="' . esc_attr__('Return to theme plugin installer', 'omega-admin-td') . '" target="_parent">' . __('Return to theme plugin installer', 'omega-admin-td') . '</a>'
            );
        }

        return $install_actions;
    }

    private function get_options()
    {
        return get_option(THEME_SHORT . '-plugin-options', array());
    }

    private function save_options($plugin_options)
    {
        update_option(THEME_SHORT . '-plugin-options', $plugin_options);
    }

    private function store_plugin_version($plugin_id, $version)
    {
        $plugin_options = $this->get_options();
        if (!isset($plugin_options['installed-plugins'])) {
            $plugin_options['installed-plugins'] = array();
        }

        $plugin_options['installed-plugins'][$plugin_id] = $version;

        $this->save_options($plugin_options);
    }

    private function add_message($message, $type)
    {
        $new_message = compact('message', 'type');
        $this->messages[] = $new_message;
    }

    public function display_messages()
    {
        foreach ($this->messages as $message) {
            echo '<div class="' . $message['type'] . '">';
            echo '<p>' . $message['message']  . '</p>';
            echo '</div>';
        }
        $this->messages = array();
    }
}
