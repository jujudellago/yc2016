<?php
/**
 * Oxyggena Typography Module
 *
 * @package OxygennaUpdater
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.0
 */


/**
 * Main Updater Class
 *
 * @author Oxygenna
 **/
class OxygennaUpdater
{
    private static $instance;

    private $theme_status;

    public static function instance()
    {
        if (! self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Constructor, this should be called plugin base
     */
    public function __construct()
    {
        add_action('init', array(&$this, 'init'));
        add_action('admin_init', array(&$this, 'set_theme_status'));

        add_action(THEME_SHORT . '-update-before-page', array(&$this, 'render_updater_page'));
        add_action('admin_enqueue_scripts', array(&$this, 'enqueue_scripts'));
    }

    public function init()
    {
        if (!class_exists('Envato_Protected_API')) {
            // prevent errors in case someone has already installed envato toolkit
            require_once(OXY_THEME_DIR . 'vendor/primozcigler/envato-wordpress-theme-updater/class-envato-protected-api.php');
        }
        require_once(OXY_UPDATER_DIR . 'inc/OxygennaThemeUpdater.php');

        // do we have any credentials to save?
        $options = $this->save_credentials();

        if (!empty($options['username']) && !empty($options['api']) && 'authenticated' === $options['status']) {
            // init the class that will register the update filters.
            OxygennaThemeUpdater::init($options['username'], $options['api'], 'Oxygenna.com');
        }
    }

    public function set_theme_status()
    {
        global $current_user;
        $dismiss_notice = get_user_meta($current_user->ID, 'dismiss-update-notice', true);
        $all_updates = get_site_transient('update_themes');

        if (!empty($all_updates)) {
            // get checked version
            if (isset($all_updates->checked[THEME_SHORT])) {
                $this->theme_status = array(
                    'version' => $all_updates->checked[THEME_SHORT]
                );
            }

            // check for updated version
            $options = $this->get_options();
            if (!empty($all_updates->response) && isset($options['status']) && 'authenticated' === $options['status']) {
                $theme = wp_get_theme();
                if ($key = array_key_exists(THEME_SHORT, $all_updates->response)) {
                    // we have a theme update, display a notice if it hasn't been hidden
                    if (user_can($current_user->ID, 'manage_options') && $dismiss_notice != 'yes') {
                        add_action('admin_notices', array(&$this,'render_update_notice'));
                    }
                    $all_updates->response[$theme->get_template()]['version'] = $theme->Version;
                    $this->theme_status = $all_updates->response[$theme->get_template()];
                }
            }
        }
    }

    public function render_updater_page()
    {
        $options = $this->get_options();
        $options['username'] = isset($options['username']) ? $options['username'] : '';
        $options['api'] = isset($options['api']) ? $options['api'] : '';

        // create save credentials form url
        $credentials_form_url = esc_url(
            add_query_arg(
                array(
                    'page' => THEME_SHORT . '-update',
                ),
                admin_url('admin.php')
            )
        );

        $message = __('Please insert your Envato User Name and API Key in the above section in order to receive automatic updates', 'omega-admin-td');
        $update_available = false;
        if (isset($options['status'])) {
            switch($options['status']) {
                case 'missing':
                    // do nothing already set above
                    break;
                case 'invalid':
                    $message = '<span class="updater-warning">' . __('Your Envato User Name and/or API Key are wrong.', 'omega-admin-td') . '</span>';
                    $message .= __('Please insert the correct Envato User Name and API Key in the above section in order to receive automatic updates', 'omega-admin-td');
                    break;
                case 'authenticated':
                    if (isset($this->theme_status['new_version'])) {
                        $update_available = true;
                        $form_action = 'update-core.php?action=do-theme-upgrade';
                        $message = sprintf(__('Version %1$s of %2$s is available! You are currently running version %3$s', 'omega-admin-td'), $this->theme_status['new_version'], THEME_NAME, $this->theme_status['version']);
                    } else {
                        $message = sprintf(__('You are running the latest version of %1$s (%2$s). Your theme is up to date!', 'omega-admin-td'), THEME_NAME, $this->theme_status['version']);
                    }
                    break;
            }
        }

        ob_start();
        include(OXY_UPDATER_DIR . 'partials/updater-page.php');
        $output = ob_get_contents();
        ob_end_clean();
        echo $output;
        include(ABSPATH . 'wp-admin/admin-footer.php');
        die();
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style('update-notice-style', OXY_UPDATER_URI . 'assets/stylesheets/dismissable-notice.css');
        wp_enqueue_script('update-notice-script', OXY_UPDATER_URI . 'assets/javascripts/dismissable-notice.js', array('jquery'));
        wp_localize_script('update-notice-script', 'oxyUpdateNotice', array(
            'ajaxURL' => admin_url('admin-ajax.php'),
            'updateNoticeNonce' => wp_create_nonce('update-notice-nonce')
        ));
    }

    private function save_credentials()
    {
        // get the options array
        $options = $this->get_options();
        if (isset($_POST['save_credentials'])) {

            // set user name and api key
            $options['username'] = trim($_POST['username']);
            $options['api'] = trim($_POST['api']);

            // default to missing status
            $options['status'] = 'missing';

            if (!empty($options['username']) && !empty($options['api'])) {
                $api = new Envato_Protected_API($options['username'], $options['api']);
                $purchased = $api->wp_list_themes(false);

                if (isset($purchased['api_error'])) {
                    $options['status'] = 'invalid';
                } else {
                    $options['status'] = 'authenticated';
                    // Force an update of the themes because we have saved credentials
                    set_site_transient('update_themes', null);
                }
            }

            $this->save_options($options);
        }

        return $options;
    }

    private function get_options()
    {
        return get_option(THEME_SHORT . '-theme-update', array());
    }

    private function save_options($options)
    {
        update_option(THEME_SHORT . '-theme-update', $options);
    }

    public function hide_update_notice()
    {
        @error_reporting(0); // Don't break the JSON result
        header('Content-Type: application/json');

        $resp = $this->create_response();
        // Should never see this
        $resp->message = 'Not Allowed';

        if (isset($_POST['nonce'])) {
            if (wp_verify_nonce($_POST['nonce'], 'update-notice-nonce')) {
                global $current_user;
                update_user_meta($current_user->ID, 'dismiss-update-notice', 'yes');
                $resp->message = 'success';
            }
        }
        echo json_encode($resp);
        die();
    }

    public function render_update_notice()
    {
        // create save credentials form url
        $update_page_url = esc_url(
            add_query_arg(
                array(
                    'page' => THEME_SHORT . '-update',
                ),
                admin_url('admin.php')
            )
        );
        echo '<div id="ajax-update-notice" class="updated"><p>' . sprintf(__('There is an update available for %1$s <a href="%2$s">click here to update</a>'), THEME_NAME, $update_page_url) . '<span><a class="notice-close">Dismiss</a></span></p></div>';
    }
}
