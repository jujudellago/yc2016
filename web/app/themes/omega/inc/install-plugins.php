<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.3.6
 * @author     Thomas Griffin <thomas@thomasgriffinmedia.com>
 * @author     Gary Jones <gamajo@gamajo.com>
 * @copyright  Copyright (c) 2012, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once OXY_THEME_DIR . 'vendor/tgmpa/tgm-plugin-activation/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'oxy_theme_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function oxy_theme_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        array(
            'name'                  => 'Contact Form 7',
            'slug'                  => 'contact-form-7',
            'required'              => false,
            'version'               => '5.1.3',
            'force_activation'      => false,
            'force_deactivation'    => false,
        ),
        array(
            'name'                  => 'Revolution Slider',
            'slug'                  => 'revslider',
            'source'                => 'http://oxygenna-theme-plugins.s3.amazonaws.com/omega/revslider.zip',
            'required'              => false,
            'version'               => '6.0.5',
            'force_activation'      => false,
            'force_deactivation'    => false,
        ),
        array(
            'name'                  => 'WPBakery Visual Composer',
            'slug'                  => 'js_composer',
            'source'                => 'http://oxygenna-theme-plugins.s3.amazonaws.com/omega/js_composer.zip',
            'required'              => false,
            'version'               => '6.0.4',
            'force_activation'      => false,
            'force_deactivation'    => false,
        ),
        array(
            'name'                  => 'Envato Market',
            'slug'                  => 'envato-market',
            'source'                => 'http://envato.github.io/wp-envato-market/dist/envato-market.zip',
            'required'              => false,
            'version'               => '2.0.1',
            'force_activation'      => false,
            'force_deactivation'    => false,
        ),
        array(
            'name'                  => 'WooSidebars',
            'slug'                  => 'woosidebars',
            'required'              => false,
            'version'               => '1.4.5',
            'force_activation'      => false,
            'force_deactivation'    => false,
        ),
        array(
            'name'                  => 'bbPress',
            'slug'                  => 'bbpress',
            'required'              => false,
            'version'               => '2.5.14',
            'force_activation'      => false,
            'force_deactivation'    => false,
        ),
        array(
            'name'                  => 'WooCommerce',
            'slug'                  => 'woocommerce',
            'required'              => false,
            'version'               => '3.6.5',
            'force_activation'      => false,
            'force_deactivation'    => false,
        ),
        array(
            'name'                  => 'Regenerate Thumbnails',
            'slug'                  => 'regenerate-thumbnails',
            'required'              => false,
            'version'               => '3.1.1',
            'force_activation'      => false,
            'force_deactivation'    => false,
        ),
        array(
            'name'                  => 'Wordpress Charts',
            'slug'                  => 'wp-charts',
            'required'              => false,
            'version'               => '0.7.0',
            'force_activation'      => false,
            'force_deactivation'    => false,
        ),
        array(
            'name'                  => 'Layers Slider',
            'slug'                  => 'LayerSlider',
            'source'                => 'http://oxygenna-theme-plugins.s3.amazonaws.com/omega/layerslider.zip',
            'required'              => false,
            'version'               => '6.8.4',
            'force_activation'      => false,
            'force_deactivation'    => false,
        )

    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'id'                => THEME_SHORT . '-theme',
        'domain'            => 'omega-admin-td',        // Text domain - likely want to be the same as your theme.
        'default_path'      => '',
        'has_notices'       => true,                        // Show admin notices or not
        'is_automatic'      => false,                       // Automatically activate plugins after installation or not
        'message'           => '',                          // Message to output right before the plugins table
        'strings'           => array(
            'page_title'                                => esc_html__( 'Install Required Plugins', 'omega-admin-td' ),
            'menu_title'                                => esc_html__( 'Install Plugins', 'omega-admin-td' ),
            'installing'                                => esc_html__( 'Installing Plugin: %s', 'omega-admin-td' ), // %1$s = plugin name
            'oops'                                      => esc_html__( 'Something went wrong with the plugin API.', 'omega-admin-td' ),
            'notice_can_install_required'               => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'omega-admin-td' ), // %1$s = plugin name(s)
            'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'omega-admin-td' ), // %1$s = plugin name(s)
            'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'omega-admin-td' ), // %1$s = plugin name(s)
            'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'omega-admin-td' ), // %1$s = plugin name(s)
            'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'omega-admin-td' ), // %1$s = plugin name(s)
            'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'omega-admin-td' ), // %1$s = plugin name(s)
            'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'omega-admin-td' ), // %1$s = plugin name(s)
            'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'omega-admin-td' ), // %1$s = plugin name(s)
            'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'omega-admin-td' ),
            'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'omega-admin-td' ),
            'return'                                    => esc_html__( 'Return to Required Plugins Installer', 'omega-admin-td' ),
            'plugin_activated'                          => esc_html__( 'Plugin activated successfully.', 'omega-admin-td' ),
            'complete'                                  => esc_html__( 'All plugins installed and activated successfully. %s', 'omega-admin-td' ), // %1$s = dashboard link
            'nag_type'                                  => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
        )
    );

    tgmpa( $plugins, $config );
}
