<?php
/**
 * Lists plugins to be updated
 *
 * @package Omega
 * @subpackage Admin
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.14.0
 * @author Oxygenna.com
 */

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class OxygennaPluginsTable extends WP_List_Table
{
    private $plugin_options;

    /**
     * Registers class
     *
     * @return void
     **/
    public function __construct($plugin_options)
    {
        $this->plugin_options = $plugin_options;
        parent::__construct(
            array(
                'singular' => 'plugin',
                'plural'   => 'plugins',
                'ajax'     => false,
            )
        );
    }

    /**
     * Calls api to get list of plugins
     *
     * @return void
     **/
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();
        $this->_column_headers = array($columns, $hidden, $sortable);

        // call update server
        $response = wp_remote_get('http://updates.oxygenna.com/themes/' . THEME_SHORT, array( 'timeout' => 30));

        if (!is_wp_error($response) && isset($response['response']['code']) && $response['response']['code'] === 200) {
            $body = wp_remote_retrieve_body($response);
            $theme = json_decode($body, true);
            $this->items = $theme['plugins'];
            $this->check_plugins_info();
        } else {
            $this->error_description = $response->get_error_message();

        }
    }

    public function no_items()
    {
         _e('Error connecting to server \'http://updates.oxygenna.com/themes/'.THEME_SHORT.'\' :'. $this->error_description);
    }

    /**
     * Gathers info about plugins status
     *
     * @return Plugins with extra info
     **/
    public function check_plugins_info()
    {
        $installed_plugins = get_plugins();

        foreach ($this->items as &$plugin) {
            $plugin['info'] = '';
            if (!isset($installed_plugins[$plugin['path']])) {
                $plugin['status'] = '<span class="dashicons dashicons-lightbulb status-not-installed" title="' . __('Not Installed', '**THEME_ADMIN**') . '"></span>';
            } elseif (is_plugin_inactive($plugin['path'])) {
                $plugin['status'] = '<span class="dashicons dashicons-lightbulb status-not-active" title="' . __('Installed But Not Activated', '**THEME_ADMIN**') . '"></span>';
            } else {
                $plugin['status'] = '<span class="dashicons dashicons-lightbulb status-active" title="' . __('Activated', '**THEME_ADMIN**') . '"></span>';
            }

            if (isset($installed_plugins[$plugin['path']]) && 'premium' === $plugin['type']) {
                $current_version = $this->get_installed_version($plugin['id']);
                // only update if version has got bigger
                if ($plugin['version'] > $current_version) {
                    $plugin['info'] .= '<strong>' . __('Update Available', '**THEME_ADMIN**') . '</strong>';
                }
            }

            if (empty($this->plugin_options['purchase-code']) && $plugin['type'] === 'premium') {
                $plugin['info'] = '<strong>' . __('NOTE - Requires theme purchase key to install or receive updates.', '**THEME_ADMIN**') . '</strong>';
            }
        }
    }

    /**
     * Create default title column along with action links of 'Install'
     * and 'Activate'.
     *
     * @return string     The action hover links.
     */
    public function column_plugin($item)
    {
        $installed_plugins = get_plugins();

        $actions = array();
        // We need to display the 'Install' hover link.
        // ignore if its premium and no purchase code
        if (!isset($installed_plugins[$item['path']])) {
            if (!empty($this->plugin_options['purchase-code']) || $item['type'] !== 'premium') {
                $actions['install'] = sprintf(
                    '<a href="%1$s" title="' . __('Install', '**THEME_ADMIN**') . ' %2$s">' . __('Install', '**THEME_ADMIN**') . '</a>',
                    wp_nonce_url(
                        add_query_arg(
                            array(
                                'id'     => $item['id'],
                                'page'   => THEME_SHORT . '-plugins',
                                'action' => 'install-plugin',
                                'type'   => urlencode($item['type']),
                                'plugin' => urlencode($item['plugin']),
                                'path'   => urlencode($item['path']),
                                'version' => urlencode($item['version']),
                            ),
                            self_admin_url('admin.php')
                        ),
                        'oxy-plugin-install'
                    ),
                    $item['plugin']
                );
            }
        } elseif (is_plugin_inactive($item['path'])) {
            $actions['activate'] = sprintf(
                '<a href="%1$s" title="' . __('Activate', '**THEME_ADMIN**') . ' %2$s">' . __('Activate', '**THEME_ADMIN**') . '</a>',
                wp_nonce_url(
                    add_query_arg(
                        array(
                            'page'   => THEME_SHORT . '-plugins',
                            'action' => 'activate-plugin',
                            'path'   => urlencode($item['path']),
                            'plugin' => urlencode($item['plugin']),
                        ),
                        self_admin_url('admin.php')
                    ),
                    'oxy-plugin-activate'
                ),
                $item['plugin']
            );
        }

        // check for update
        if (!empty($this->plugin_options['purchase-code']) && 'premium' === $item['type'] && isset($installed_plugins[$item['path']])) {
            $current_version = $this->get_installed_version($item['id']);
            // only update if version has got bigger
            if ($item['version'] > $current_version) {
                $actions['update'] = sprintf(
                    '<a href="%1$s" title="' . __('Update', '**THEME_ADMIN**') . ' %2$s">' . __('Update', '**THEME_ADMIN**') . '</a>',
                    wp_nonce_url(
                        add_query_arg(
                            array(
                                'id'     => $item['id'],
                                'page'   => THEME_SHORT . '-plugins',
                                'action' => 'install-plugin',
                                'type'   => urlencode($item['type']),
                                'plugin' => urlencode($item['plugin']),
                                'path'   => urlencode($item['path']),
                                'update' => true,
                                'version' => urlencode($item['version']),
                            ),
                            self_admin_url('admin.php')
                        ),
                        'oxy-plugin-install'
                    ),
                    $item['plugin']
                );
            }
        }

        return sprintf('<a target="_blank" href="%3$s">%1$s</a> %2$s', $item['plugin'], $this->row_actions($actions), $item['link']);
    }

    /**
     * Gets the current timestamp for this plugin
     *
     * @return current version timestamp
     **/
    private function get_installed_version($plugin_id)
    {
        return isset($this->plugin_options['installed-plugins'][$plugin_id]) ? $this->plugin_options['installed-plugins'][$plugin_id] : 0;
    }

    /**
     * Sets column titles
     *
     * @return void
     **/
    public function get_columns()
    {
        $columns = array(
            'plugin' => 'Plugin',
            'desc'   => 'Description',
            'type'   => 'Type',
            'status' => 'Status',
            'info'   => 'Info'
        );

        return $columns;
    }

    /**
     * Default display of column items
     *
     * @return void
     **/
    public function column_default($item, $column_name)
    {
        switch($column_name) {
            case 'type':
            case 'plugin':
            case 'status':
            case 'desc':
            case 'info':
                return $item[$column_name];
            break;
        }
    }
}
