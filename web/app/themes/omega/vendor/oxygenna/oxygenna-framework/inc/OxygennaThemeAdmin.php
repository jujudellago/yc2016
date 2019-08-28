<?php
/**
 * Main theme class file
 *
 * @package ThemeFramework
 * @subpackage Theme
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.18.12
 */

include OXY_TF_DIR . 'inc/OxygennaOption.php';
include OXY_TF_DIR . 'inc/OxygennaQuickUpload.php';
include OXY_TF_DIR . 'inc/OxygennaMetabox.php';
include OXY_TF_DIR . 'inc/OxygennaThemeInstall.php';

/**
 * Main theme admin bootstrap class
 *
 * @since 1.0
 */
class OxygennaThemeAdmin
{
    /**
     * Stores array of theme setuop options
     *
     * @since 1.0
     * @access public
     * @var array
     */
    public $theme;

    /**
     * Main theme options
     *
     * @var Object
     **/
    public $options;

    /**
     * Constructior, called if the theme is_admin by †he main Theme class
     *
     * @since 1.0
     * @param array $options array of all theme options to use in construction this theme
     */
    public function __construct($theme)
    {
        $this->theme = $theme;
        // initialise admin
        add_action('admin_init', array(&$this, 'admin_init'));

        add_action('init', array(&$this, 'create_meta_boxes'));

        $this->check_theme_compatible();
    }


    /**
     * called on admin_init
     *
     * @since 1.0
     */
    public function admin_init()
    {
        // register admin js & css
        $this->register_resources();
        // initialise media upload class (for media options)
        require_once OXY_TF_DIR . 'inc/OxygennaMediaUpload.php';
        $media_upload = new OxygennaMediaUpload();

        // check if old plugin is on
        $theme_plugin_url = 'oxygenna-theme/oxygenna-theme.php';
        $installed_plugins = get_plugins();
        if (array_key_exists($theme_plugin_url, $installed_plugins)) {
            deactivate_plugins($theme_plugin_url);
            add_action('admin_notices', array(&$this, 'add_theme_plugin_nag'));
        }
    }

    public function add_theme_plugin_nag()
    {
    ?>
        <div class="error">
            <p><?php _e('Looks like you have the <strong>Oxygenna Theme Framework Plugin</strong> Installed - this is no longer needed please delete it <a href="' . admin_url('plugins.php') . '">here on your plugins page</a>', 'omega-admin-td'); ?></p>
        </div>
    <?php
    }

    public function register_resources()
    {
        wp_register_style('jquery-oxygenna-ui-theme', OXY_TF_URI . 'assets/css/jquery-ui/smoothness/theme.min.css');
        wp_register_style('oxy-option-page', OXY_TF_URI . 'assets/css/options/oxy-option-page.css');
    }

    public function check_theme_compatible()
    {
        $version = get_bloginfo('version');
        $this->errors = array();

        if (version_compare($version, $this->theme->theme_args['min_wp_ver'], '<')) {
            $this->errors[] = sprintf(__('Version %s is incompatible with this theme minimum version %s', 'omega-admin-td'), $version, $this->theme->theme_args['min_wp_ver']);
        }

        if (!empty($this->errors)) {
            add_action('init', array(&$this, 'admin_warning'));
        }

    }

    public function admin_warning()
    {
        $msg = '<div class="error">';
        foreach ($this->errors as $error) {
            $msg .= '<p>' . $error . '</p>';
        }
        $msg .=  '</div>';
        echo $msg;
    }

    public function create_meta_boxes()
    {
        if (!empty($this->theme->metaboxes)) {
            foreach ($this->theme->metaboxes as $metabox) {
                $new_metabox = new OxygennaMetabox($metabox);
            }
        }
    }
}
