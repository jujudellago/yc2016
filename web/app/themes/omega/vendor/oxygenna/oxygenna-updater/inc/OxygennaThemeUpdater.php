<?php
/**
 * WP Theme Updater based on the Envato WordPress Toolkit Library and Pixelentity class from ThemeForest forums
 *
 * @package WordPress
 * @link http://themeforest.net/forums/thread/simple-theme-update-class-using-envato-api/73278 Thread on ThemeForest Forums
 * @author Pixelentity
 * @author Primož Cigler <primoz@proteusnet.com>
 * @since 1.0
 */

if (!class_exists('OxyennaThemeUpdater')) {
    class OxygennaThemeUpdater
    {
        protected $username;
        protected $apiKey;
        protected $authors;

        /**
         * Set the protected properties
         * @param String $username Envato marketplace username
         * @param String $apiKey   Generated API key
         * @param String $authors  Author of the theme, as in the style.css
         */
        public function __construct($username, $apiKey, $authors)
        {
            $this->username = $username;
            $this->apiKey   = $apiKey;
            $this->authors  = $authors;

            add_filter('pre_set_site_transient_update_themes', array(&$this,'check'));
            add_action('upgrader_process_complete', array(&$this,'upgrader_process_complete'), 10, 2);
        }

        /**
         * Check for the updates
         */
        public function check($updates)
        {
            global $current_user;
            $this->username = apply_filters('pixelentity_theme_update_username', $this->username);
            $this->apiKey   = apply_filters('pixelentity_theme_update_apiKey', $this->apiKey);
            $this->authors  = apply_filters('pixelentity_theme_update_authors', $this->authors);

            if ($this->authors && !is_array($this->authors)) {
                $this->authors = array($this->authors);
            }

            if (!$this->username || !$this->apiKey || !isset($updates->checked)) {
                return $updates;
            }

            if (!class_exists('Envato_Protected_API')) {
                require_once(OXY_THEME_DIR . 'vendor/primozcigler/envato-wordpress-theme-updater/class-envato-protected-api.php');
            }


            $api = new Envato_Protected_API($this->username, $this->apiKey);

            add_filter('http_request_args', array( &$this, 'http_timeout' ), 10, 1);
            $purchased = $api->wp_list_themes(false);

            $installed = wp_get_themes();
            $filtered = array();

            foreach ($installed as $theme) {
                if ($this->authors && !in_array($theme->{'Author Name'}, $this->authors)) {
                    continue;
                }
                $filtered[$theme->Name] = $theme;
            }

            foreach ($purchased as $theme) {
                if (isset($theme->theme_name) && isset($filtered[$theme->theme_name])) {
                    // gotcha, compare version now
                    $current = $filtered[$theme->theme_name];
                    if (version_compare($current->Version, $theme->version, '<')) {
                        // bingo, inject the update
                        if ($url = $api->wp_download($theme->item_id)) {
                            $update = array(
                                'url'         => 'http://help.oxygenna.com/wordpress/'.THEME_SHORT.'/changelog.html',
                                'new_version' => $theme->version,
                                'package'     => $url
                            );

                            $updates->response[$current->Stylesheet] = $update;
                            update_user_meta($current_user->ID, 'dismiss-update-notice', 'no');
                        }
                    }
                }
            }

            remove_filter('http_request_args', array(&$this, 'http_timeout'));

            return $updates;
        }


        public function upgrader_process_complete($wp_upgrader, $hook_extra)
        {
            if (get_class($wp_upgrader) === 'Theme_Upgrader') {
                $installed_theme = $wp_upgrader->theme_info();
                $current_theme = wp_get_theme();
                if ($installed_theme->__get('name') === $current_theme->__get('name')) {
                    do_action('oxy_upgrader_process_complete');
                }
            }
        }

        /**
         * Increase timeout for api request
         * @param  Array $req
         * @return Array
         */
        public function http_timeout($req)
        {
            $req['timeout'] = 300;
            return $req;
        }

        /**
         * Init the class
         */
        public static function init($username = null, $apiKey = null, $authors = null)
        {
            new OxygennaThemeUpdater($username, $apiKey, $authors);
        }
    }
}
