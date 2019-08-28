<?php
/**
 * Oxygennas Typography Plugin
 *
 * @package OxygennaTypography
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.0
 */

/**
 * Main Typography Admin Class
 *
 * @author Oxygenna
 **/
class OxygennaTypography
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
     * Constructor, this should be called plugin base
     */
    public function __construct()
    {
        add_action('init', array(&$this, 'init'));

        add_action('admin_init', array(&$this, 'admin_init'));

        add_action(THEME_SHORT . '-typography-before-page', array(&$this, 'render_typography_page'));

        // register google fonts list ajax call
        add_action('wp_ajax_google_fonts_list', array(&$this, 'google_fetch_fonts_list'));

        // register typekit update kits
        add_action('wp_ajax_typekit_update_kits', array(&$this, 'typekit_update_kits'));

        // fetch full font stack
        add_action('wp_ajax_fontstack_list', array(&$this, 'fontstack_list'));

        // add to fontstack page
        add_action('wp_ajax_fontstack_font_modal', array(&$this, 'font_modal'));

        // save fontstack
        add_action('wp_ajax_fontstack_save', array(&$this, 'fontstack_save'));

        // set fontstack to default
        add_action('wp_ajax_fontstack_defaults', array(&$this, 'fontstack_defaults'));

        // get font info
        add_action('wp_ajax_oxy_get_font', array(&$this, 'get_font'));
    }

    public function init()
    {
        wp_register_script('oxy-typography-select2', OXY_TYPOGRAPHY_URI . 'assets/javascripts/select2.js', array('jquery'));
        wp_register_style('oxy-typography-select2', OXY_TYPOGRAPHY_URI . 'assets/css/select2.css');
    }

    public function admin_init()
    {
        // check if old plugin is on
        $type_plugin_url = 'oxygenna-type/oxygenna-type.php';
        $installed_plugins = get_plugins();
        if (array_key_exists($type_plugin_url, $installed_plugins)) {
            deactivate_plugins($type_plugin_url);
            add_action('admin_notices', array(&$this, 'add_theme_plugin_nag'));
        }
    }

    public function add_theme_plugin_nag()
    { ?>
        <div class="error">
            <p><?php _e('Looks like you have the <strong>Oxygenna Typography Plugin</strong> Installed - this is no longer needed please delete it <a href="' . admin_url('plugins.php') . '">here on your plugins page</a>', 'omega-admin-td'); ?></p>
        </div>
    <?php
    }

    public function get_system_fonts()
    {
        return include OXY_TYPOGRAPHY_DIR . 'inc/providers/system.php';
    }

    public function get_google_fonts()
    {
        return get_option('oxy-google-fonts');
    }

    public function get_typekit_fonts()
    {
        return get_option('oxy-typekit-fonts');
    }

    public function google_fetch_fonts_list()
    {
        @error_reporting(0); // Don't break the JSON result
        header('Content-Type: application/json');
        @set_time_limit(180); // 3 minutes should be PLENTY

        $resp = $this->create_response();

        if (isset($_POST['nonce'])) {
            if (wp_verify_nonce($_POST['nonce'], 'google-fetch-fonts-nonce')) {
                $resp = $this->google_update_font_list();
            } else {
                $resp->message = __('Could not verify nonce', 'omega-admin-td');
            }
        }
        echo json_encode($resp);
        die();
    }

    public function google_update_font_list()
    {
        $resp = $this->create_response();

        $google_api_url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDVQGrQVBkgCBi9JgPiPpBeKN69jIRk8ZA';
        $remote_get = wp_remote_get($google_api_url, array('sslverify' => false));
        $response = wp_remote_retrieve_body($remote_get);

        if (is_wp_error($response)) {
            $resp->status = false;
            $resp->message = __('Error fetching Google Font List', 'omega-admin-td');
        } else {
            // we got a new list , so we update the theme options
            $list = json_decode($response, true);
            update_option('oxy-google-fonts', $list['items']);
            $resp->status = true;
        }

        return $resp;
    }

    public function typekit_update_kits()
    {
        @error_reporting(0); // Don't break the JSON result
        header('Content-Type: application/json');
        @set_time_limit(180); // 3 minutes should be PLENTY

        $resp = $this->create_response();

        if (isset($_POST['nonce'])) {
            if (wp_verify_nonce($_POST['nonce'], 'typekit-kits-nonce')) {

                $api_url = 'https://typekit.com/api/v1/json/kits';
                // fetch list of kits available for this token
                $kits_list = wp_remote_retrieve_body(wp_remote_get($api_url, array(
                    'sslverify' => false,
                    'headers' => array(
                        'X-Typekit-Token' => $_POST['api_key']
                    )
                )));
                $kits = json_decode($kits_list);
                if (null !== $kits) {
                    if (empty($kits->errors)) {
                        // create an array and fetch details of each kit inside
                        $kits_details = array();
                        foreach ($kits->kits as $kit) {
                            $kit_details = wp_remote_retrieve_body(wp_remote_get($api_url  . '/' . $kit->id, array(
                                'sslverify' => false,
                                'headers' => array(
                                    'X-Typekit-Token' => $_POST['api_key']
                                )
                            )));
                            $kits_details[] = json_decode($kit_details, true);
                        }

                        update_option('oxy-typekit-fonts', $kits_details);
                        $resp->status = true;
                    }
                }
            } else {
                $resp->message = __('Could not verify nonce', 'omega-admin-td');
            }
        }

        echo json_encode($resp);
        die();
    }

    public function fetch_font($family, $provider)
    {
        switch ($provider) {
            case 'system_fonts':
                $system_fonts = $this->get_system_fonts();
                if (isset($system_fonts[$family])) {
                    return $system_fonts[$family];
                }
                break;
            case 'google_fonts':
                $google_fonts = $this->get_google_fonts();
                foreach ($google_fonts as $font) {
                    if ($family == $font['family']) {
                        return $font;
                    }
                }
                break;
            // typekit sends the kit id
            default:
                $typekit = $this->get_typekit_fonts();

                if (!empty($typekit)) {
                    foreach ($typekit as $kit) {
                        if ($kit['kit']['id'] === $provider) {
                            foreach ($kit['kit']['families'] as $font) {
                                if ($font['name'] == $family) {
                                    $font['family'] = $font['name'];
                                    $font['variants'] = $font['variations'];
                                    $font['subsets'] = $font['subset'];
                                    return $font;
                                }
                            }
                        }
                    }
                }
                break;
        }
    }

    public function fontstack_list()
    {
        @error_reporting(0); // Don't break the JSON result
        header('Content-Type: application/json');

        $response = $this->create_response();
        if (isset($_POST['nonce'])) {
            if (wp_verify_nonce($_POST['nonce'], 'list-fontstack')) {

                $response->data = get_option('oxy-fontstack');
                if ($response->data === false) {
                    $response->data = array();
                }
                $response->status = true;
            }
        }
        echo json_encode($response);
        die();
    }

    private function create_response()
    {
        $reponse = new stdClass();
        $reponse->status = false;
        return $reponse;
    }

    public function font_modal()
    {
        if (isset($_GET['nonce'])) {
            if (wp_verify_nonce($_GET['nonce'], 'font-modal')) {

                global $hook_suffix;
                $isNew = $_GET['isNew'] === 'true';
                // set button text for bottom button
                $save_button_text = $isNew ? __('Add font', 'omega-admin-td') : __('Update Font', 'omega-admin-td');

                // get font info for font options
                $font_info = $this->fetch_font($_GET['family'], $_GET['provider']);

                $default_font_css = apply_filters('oxy_default_typography_css', '');

                // create font object
                if ($isNew) {
                    $font = array(
                        'variants' => array(),
                        'elements' => array(),
                        'subsets'  => array(),
                        'extracss' => ''
                    );
                } else {
                    $font = array(
                        'variants' => isset($_GET['variants']) ? $_GET['variants'] : array(),
                        'elements' => isset($_GET['elements']) ? $_GET['elements'] : array(),
                        'subsets'  => isset($_GET['subsets']) ? $_GET['subsets'] : array(),
                        'extracss' => isset($_GET['extracss']) ? $_GET['extracss'] : ''
                    );
                }

                $elements = array(
                    'body'       => __('All (body tag)', 'omega-admin-td'),
                    'headings'   => __('Headings (h1-h6 tags)', 'omega-admin-td'),
                    'forms'      => __('Forms (all input tags)', 'omega-admin-td'),
                    'blockquote' => __('Block Quote (blockquote tag)', 'omega-admin-td'),
                );

                wp_enqueue_style('colors');
                wp_enqueue_style('ie');
                wp_enqueue_style('plugin-install');
                wp_enqueue_script('utils');
                wp_enqueue_script('add-font', OXY_TYPOGRAPHY_URI . 'assets/javascripts/add-font.js', array('jquery'));
                wp_enqueue_style('add-font', OXY_TYPOGRAPHY_URI . 'assets/css/add-font.css');

                wp_localize_script('add-font', 'localData', array(
                    // URL to wp-admin/admin-ajax.php to process the request
                    'ajaxurl'   => admin_url('admin-ajax.php'),
                    // generate a nonce with a unique ID "myajax-post-comment-nonce"
                    // so that you can check it later when an AJAX request is sent
                    'nonce'     => wp_create_nonce('oxygenna-add-fontstack'),
                ));

                ob_start();
                include(OXY_TYPOGRAPHY_DIR . 'partials/font-modal.php');
                $output = ob_get_contents();
                ob_end_clean();
                echo $output;
            }
        }
        die();
    }

    public function checkbox_status($option, $font)
    {
        $checked = '';
        foreach ($font as $index => $value) {
            if ($option === $value) {
                $checked = 'checked';
                break;
            }
        }
        echo $checked;
    }

    public function fontstack_save()
    {
        @error_reporting(0); // Don't break the JSON result
        header('Content-Type: application/json');

        $resp = $this->create_response();
        $resp->message = 'Failed';

        if (isset($_POST['nonce'])) {
            if (wp_verify_nonce($_POST['nonce'], 'update-fontstack')) {
                if (!empty($_POST['fontstack'])) {
                    $fontstack = $_POST['fontstack'];
                    update_option('oxy-fontstack', $fontstack);
                    // now update the font css
                    $this->create_font_css($fontstack);
                    // now update the font js
                    $js = $this->create_font_js($fontstack);
                    update_option('oxy-typography-js', $js);
                } else {
                    delete_option('oxy-fontstack');
                    delete_option('oxy-typography-css');
                    delete_option('oxy-typography-js');
                    $fontstack = array();
                }
                // set response to ok
                $resp->status = true;
                $resp->message = __('Fontsack Updated Successfully', 'omega-admin-td');
                $resp->fontstack = $fontstack;
            }
        }

        echo json_encode($resp);
        die();
    }

    public function create_font_css($fontstack)
    {
        $css = '';
        if (!empty($fontstack)) {
            $google_import_url = $this->create_google_import_url($fontstack);
            if (null !== $google_import_url) {
                $css .= '<link href="' . $google_import_url . '" rel="stylesheet" type="text/css">';
            }
            $css_rules = $this->create_font_css_rules($fontstack);
            if (!empty($css_rules)) {
                $css .= '<style type="text/css" media="screen">' . $css_rules . '</style>';
            }
        }
        update_option('oxy-typography-css', $css);
    }

    public function create_font_css_rules($fontstack)
    {
        $css = '';
        foreach ($fontstack as $font) {
            if (isset($font['elements'])) {
                foreach ($font['elements'] as $element) {
                    // get font family
                    $family = $this->get_font_family($font);
                    switch ($element) {
                        case 'body':
                            $css .= <<<CSS
body {
    font-family: {$family};
}
CSS;
                            break;
                        case 'headings':
                            $css .= <<<CSS
h1, h2, h3, h4, h5, h6 {
    font-family: {$family};
}
CSS;
                            break;
                        case 'blockquote':
                            $css .= <<<CSS
blockquote {
    font-family: {$family};
}
CSS;
                            break;
                        case 'forms':
                            $css .= <<<CSS
input, textarea, .btn, button {
    font-family: {$family};
}
CSS;
                            break;
                    }
                }
            }
            // add any custom css
            if (isset($font['extracss'])) {
                $css .= $font['extracss'];
            }
        }

        return $css;
    }

    public function get_font_family($font)
    {
        $font_info = $this->fetch_font($font['family'], $font['provider']);
        switch ($font['provider']) {
            case 'system_fonts':
                return $font_info['family'];
            case 'google_fonts':
                // wrap font family in quotes if it contains spaces
                return preg_match('/\s/', $font_info['family']) ? '\''.$font_info['family'].'\'' : $font_info['family'];
            default:
                return $font_info['css_stack'];
        }
    }

    public function create_google_import_url($fontstack)
    {
        $font_codes = array();
        $subsets = array();
        foreach ($fontstack as $font) {
            if ($font['provider'] === 'google_fonts') {
                // remove regular and italic and replace with url format
                $font['variants'] = $this->convert_google_variants_to_url($font['variants']);
                $variants = empty($font['variants']) ? '' : ':' . implode(',', $font['variants']);
                if (isset($font['subsets'])) {
                    foreach ($font['subsets'] as $add_subset) {
                        $subsets[] = $add_subset;
                    }
                }
                $font_codes[] = str_replace(' ', '+', $font['family']) . $variants;
            }
        }
        if (!empty($font_codes)) {
            $families = implode('%7C', $font_codes);
            $subsets_url = empty($subsets) ? '' : '&amp;subset=' . implode(',', $subsets);

            return '//fonts.googleapis.com/css?family=' . $families . $subsets_url;
        }
    }

    public function convert_google_variants_to_url($variants)
    {
        $new_variants = array();
        foreach ($variants as $variant) {
            $new_variants[] = $this->google_variant_to_url_format($variant);
        }

        return $new_variants;
    }

    public function google_variant_to_url_format($variant)
    {
        switch ($variant) {
            case 'regular':
                return '400';
            case 'italic':
                return '400italic';
            default:
                return $variant;
        }
    }

    public function create_font_js($fontstack)
    {
        $js = '';
        if (is_array($fontstack)) {
            foreach ($fontstack as $font) {
                switch ($font['provider']) {
                    case 'google_fonts':
                    case 'system_fonts':
                        // do nothing
                        break;
                    default:
                        $kit = $font['provider'];
                        $js .= <<<JS
    <script type="text/javascript" src="//use.typekit.net/{$kit}.js"></script>
    <script type="text/javascript">try {Typekit.load();} catch (e) {}</script>
JS;
                        break;
                }
            }
        }
        return $js;
    }

    public function oxy_get_font_weight_style($variant, $provider)
    {
        $variations = array(
            'font-style' => array(
                'n' => 'normal',
                'i' => 'italic',
                'o' => 'oblique'
            ),
            'font-weight' => array(
                '1' => '100',
                '2' => '200',
                '3' => '300',
                '4' => '400',
                '5' => '500',
                '6' => '600',
                '7' => '700',
                '8' => '800',
                '9' => '900',
                '4' => 'normal',
                '7' => 'bold'
            )
        );

        $weight_style = array('style' => 'normal', 'weight' => 'normal');
        if (null !== $variant) {
            switch ($provider) {
                case 'google_fonts':
                    // if variant has italic inside string set style otherwise use normal
                    $weight_style['style'] = (strpos($variant, 'italic') === false) ? 'normal' : 'italic';
                    // remove italic from weight
                    $weight_style['weight'] = str_replace('italic', '', $variant);
                    if ($weight_style['weight'] == '') {
                        $weight_style['weight'] = 'regular';
                    }
                    break;
                default:
                case 'system_fonts':
                    if (2 == strlen($variant)) {
                        $pieces = str_split($variant, 1);
                        if (array_key_exists($pieces[1], $variations['font-weight'])) {
                            $weight_style['weight'] = $variations['font-weight'][$pieces[1]];
                        }
                        if (array_key_exists($pieces[0], $variations['font-style'])) {
                            $weight_style['style'] = $variations['font-style'][$pieces[0]];
                        }
                    }
                    break;
            }
        }

        return implode(' - ', $weight_style);
    }

    public function render_typography_page()
    {
        add_thickbox();
        ob_start();
        include(OXY_TYPOGRAPHY_DIR . 'partials/typography-page.php');
        $output = ob_get_contents();
        ob_end_clean();
        echo $output;
        die();
    }

    public function create_font_select()
    {
        include(OXY_TYPOGRAPHY_DIR . 'inc/options/font-select.php');
        $font_select = new OxygennaFontSelect(array(), '', array('id' => 'fontstack-select'), $this);
        $font_select->render();
    }

    public function fontstack_defaults()
    {
        @error_reporting(0); // Don't break the JSON result
        header('Content-Type: application/json');

        $resp = $this->create_response();
        $resp->message = 'Failed to install default fonts';

        if (isset($_POST['nonce'])) {
            if (wp_verify_nonce($_POST['nonce'], 'default-fonts')) {
                $google_fonts = get_option('oxy-google-fonts', false);
                if (false !== $google_fonts) {
                    $get_response = wp_remote_get(OXY_THEME_URI . 'import/default-fonts.php', array('sslverify' => false));
                    $response = wp_remote_retrieve_body($get_response);
                    $default_fonts = unserialize($response);

                    foreach ($default_fonts as $option_name => $value) {
                        update_option($option_name, $value);
                    }

                    $resp->status = true;
                    $resp->data = get_option('oxy-fontstack');
                    $resp->message = __('Default Fonts Installed Successfully', 'omega-admin-td');
                } else {
                    $resp->message = __('No Google Fonts Installed. Please go to ' . THEME_NAME . ' -> Fonts and update your google fonts', 'omega-admin-td');
                }
            }
        }

        echo json_encode($resp);
        die();
    }

    public function get_font()
    {
        @error_reporting(0); // Don't break the JSON result
        header('Content-Type: application/json');

        $resp = $this->create_response();
        $resp->message = 'Failed nonce test';
        if (isset($_POST['nonce']) && isset($_POST['font']) && !empty($_POST['font'])) {
            if (wp_verify_nonce($_POST['nonce'], 'get-font-nonce')) {
                $font_data = explode('|', $_POST['font']);
                // check for typekit
                $provider = $font_data[0];
                $font = $font_data[1];
                if (isset($font_data[2])) {
                    $provider = $font_data[2];
                }

                $font_info = $this->fetch_font($font, $provider);
                if (null !== $font_info) {
                    $resp->status = true;
                    $resp->data = $font_info;
                    $resp->provider = $provider;
                    // if typekit dont return variants & subsets
                    if (isset($font_data[2])) {
                        $resp->data['variants'] = array();
                        $resp->data['subsets'] = array();
                    }

                }
            }
        }

        echo json_encode($resp);
        die();
    }
}
