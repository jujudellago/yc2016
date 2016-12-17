<?php
/**
 * Theme Options Builder
 *
 * @package ThemeFramework
 * @subpackage Options
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.14.0
 */
if (!class_exists('OxygennaOptions')) {
    /**
     * Main theme options class
     *
     **/
    class OxygennaOptions
    {
        /**
         * stores setting option_group
         *
         * @var array
         **/
        private $option_group;

        /**
         * stores setting option_name
         *
         * @var array
         **/
        private $option_name;

        /**
         * stores all theme options
         *
         * @var array
         **/
        private $option_pages;

        /**
         * stores main menu page if set
         *
         * @var array
         **/
        private $main_menu_page;

        /**
         * stores these option arguments
         *
         * @var array
         **/
        private $args;

        /**
         * stores option pages using admin page hooks as index
         *
         * @var array
         **/
        private $hooks;

        /**
         * Main constructor
         *
         * @return void
         *              @since 1.0
         **/
        public function __construct($option_group, $option_name, $args = array())
        {
            $this->option_group   = $option_group;
            $this->option_name    = $option_name;
            $this->option_pages   = array();
            $this->main_menu_page = null;
            $this->args           = $args;
            $this->hooks          = array();

            // admin init
            add_action('admin_init', array(&$this, 'admin_init'));

            // load all option pages into admin menu
            add_action('admin_menu', array(&$this, 'create_option_pages'), 1);

            // load admin bar
            if (isset($args['admin_bar']) && $args['admin_bar'] === true) {
                add_action('admin_bar_menu', array(&$this, 'admin_bar_menu'), 81);
            }
        }

        public function add_option_page($option_page)
        {
            if (isset($option_page['main_menu']) && $option_page['main_menu'] === true) {
                $this->main_menu_page = $option_page;
            }

            $this->option_pages[] = $option_page;
        }

        /**
         * Adds theme options to admin bar
         *
         */
        public function admin_bar_menu($wp_admin_bar)
        {
            if (!is_super_admin() || !is_admin_bar_showing() || !current_user_can('manage_options')) {
                return;
            }
            global $wp_admin_bar;

            // create base main menu
            foreach ($this->option_pages as $option_page) {
                if ($option_page['main_menu'] == true) {
                    $wp_admin_bar->add_node(array('id' => THEME_SHORT , 'title' => THEME_NAME . ' ' . __('Theme', 'omega-admin-td') , 'href' => admin_url('admin.php?page=' . $option_page['slug'])));
                    break;
                }
            }
            // get dashboard menu and add all submenus to the admin bar using admin-menu as a parent menu
            foreach ($this->option_pages as $option_page) {
                $wp_admin_bar->add_node(array('id' => $option_page['slug'], 'title' => $option_page['menu_title'], 'href' => admin_url('admin.php?page=' . $option_page['slug']), 'parent' => THEME_SHORT));
            }
        }


        /**
         * Setup theme options
         *
         * @return void
         *              @since 1.0
         **/
        public function admin_init()
        {
            // get all options
            $this->options = get_option($this->option_name);

            // check for default options
            if ($this->options === false) {
                $this->create_default_options();
            } else {
                // check for missing default options
                $this->create_missing_default_options();
            }

            // register theme settings
            register_setting($this->option_group, $this->option_name, array(&$this, 'validate_options'));

            // create settings
            // create default options
            foreach ($this->option_pages as $page) {
                foreach ($page['sections'] as $section_id => $section) {
                    add_settings_section(
                        $section_id,
                        $section['title'],
                        array(&$this, 'section_description'),
                        $page['slug']
                    );
                    foreach ($section['fields'] as $field) {
                        add_settings_field(
                            $field['id'],
                            $field['name'],
                            array(&$this, 'render_option'),
                            $page['slug'],
                            $section_id,
                            $field
                        );
                    }
                }
            }
        }

        /**
         * Checks all default options are set for missing options
         *
         * @return void
         *              @since 1.1
         **/
        public function create_missing_default_options()
        {
            // create default options for missing ones
            foreach ($this->option_pages as $page) {
                foreach ($page['sections'] as $section) {
                    foreach ($section['fields'] as $field) {
                        if (isset($field['default'])) {
                            if (!isset($this->options[$field['id']])) {
                                $this->options[$field['id']] = $field['default'];
                            }
                        }
                    }
                }
            }
            // save default options
            update_option($this->option_name, $this->options);
        }

        /**
         * Displays the section description
         *
         * @return void
         *              @since 1.0
         **/
        public function section_description($section_data)
        {
            foreach ($this->option_pages as $page) {
                foreach ($page['sections'] as $section_id => $section) {
                    if ($section_id == $section_data['id']) {
                        if (isset($section['header'])) {
                            echo '<p class="section-description">' . $section['header'] . '</p>';
                        }
                        break;
                    }
                }
            }
        }

        /**
         * Validates all options on save
         *
         * @return void
         *              @since 1.0
         **/
        public function validate_options($new_options)
        {
           // reset button was not pressed , so we validate and update the options
            if (isset($_POST['reset_options'])) {
                // reset defaults button was pressed , so we reset this page to default options
                $url = parse_url(wp_get_referer());
                parse_str($url['query'], $path);
                $pagename = $path['page'];
                foreach ($this->option_pages as $page) {
                    if ($page['slug'] == $pagename) {
                        foreach ($page['sections'] as $section) {
                            foreach ($section['fields'] as $field) {
                                if (isset($field['default'])) {
                                    $this->options[$field['id']] = $field['default'];
                                }
                            }
                        }
                        break;
                    }
                }
            // for the import of the options
            } else if (isset($_POST['import'])) {
                if (isset($_POST[THEME_SHORT.'-options']['data_import'])) {
                    $import_data = unserialize(base64_decode($_POST[THEME_SHORT.'-options']['data_import']));
                    if (is_array($import_data) && $import_data !== false) {
                        foreach ($this->option_pages as $page) {
                            foreach ($page['sections'] as $section) {
                                foreach ($section['fields'] as $field) {
                                    if (isset($import_data[$field['id']])) {
                                        $this->options[$field['id']] = $import_data[$field['id']];
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                // save option
                foreach ($this->option_pages as $page) {
                    foreach ($page['sections'] as $section) {
                        foreach ($section['fields'] as $field) {
                            // has this field been saved?
                            if (isset($new_options[$field['id']])) {
                                // does it need validation?
                                if (isset($field['validation'])) {
                                    $validators = explode('|', $field['validation']);
                                    foreach ($validators as $validation) {
                                        // load class for validation
                                        $class_file = OXY_TF_DIR . 'options/validation/Oxygenna' . ucfirst($validation) . '.php';
                                        if (file_exists($class_file)) {
                                            require_once $class_file;
                                            $validator_class = 'Oxy' . ucwords($validation);
                                            if (class_exists($validator_class)) {
                                                $validator = new $validator_class();
                                                $this->options = $validator->validate($field, $this->options, $new_options);
                                            }
                                        }
                                    }
                                } else {
                                    // no validation so just save whatever we get
                                    $previous_value = $this->options[$field['id']];
                                    $this->options[$field['id']] = $new_options[$field['id']];
                                    $value_changed = $previous_value !== $this->options[$field['id']];
                                    if ($value_changed === true && isset($field['on_change']) && function_exists($field['on_change'])) {
                                        // run the callback only after the options have been saved
                                        add_action('update_option_'.THEME_SHORT . '-options', $field['on_change'], 10, 2);
                                    }
                                }
                            }
                        }
                    }
                }
                // check for customiser options
                $customise_options = apply_filters('oxy-customise-fields', array());

                foreach ($customise_options as $section) {
                    foreach ($section['fields'] as $field) {
                        if (isset($new_options[$field['id']])) {
                            $this->options[$field['id']] = $new_options[$field['id']];
                        }
                    }
                }
            }
            // special case for options that we create conditionally on the fly.
            if (isset($new_options['unregistered'])) {
                $this->options['unregistered'] = $new_options['unregistered'];
            }

            // call hook
            if (isset($_POST['option_page'])) {
                do_action('oxy-validate-options-' . $_POST['option_page']);
            }

            return $this->options;
        }

        /**
         * Creates default options
         *
         * @return void
         *              @since 1.0
         **/
        public function create_default_options()
        {
            $this->options = array();
            // create default options
            foreach ($this->option_pages as $page) {
                foreach ($page['sections'] as $section) {
                    foreach ($section['fields'] as $field) {
                        if (isset($field['default'])) {
                            $this->options[$field['id']] = $field['default'];
                        }
                    }
                }
            }

            // check for customiser defaults
            $customiser_options = apply_filters('oxy-customise-fields', array());
            foreach ($customiser_options as $customiser_option) {
                foreach ($customiser_option['fields'] as $field) {
                    if (isset($field['default'])) {
                        $this->options[$field['id']] = $field['default'];
                    }
                }
            }
            // save default options
            add_option($this->option_name, $this->options);
        }

        /**
         * Creates option page
         *
         * @return void
         *              @since 1.0
         **/
        public function create_option_pages()
        {
            // create a new page array using hooks for keys
            $pages = array();

            // do we have a main menu set?
            if ($this->main_menu_page !== null) {
                // store the slug for this page to add sub menus
                $main_menu_slug = $this->main_menu_page['slug'];
                // add main menu page
                add_menu_page($this->main_menu_page['page_title'], $this->main_menu_page['main_menu_title'], 'manage_options', $this->main_menu_page['slug'], array(&$this , 'option_page_html'), $this->main_menu_page['main_menu_icon']);
            } else {
                // no main menu page so we must be setting option pages to another slug
                $main_menu_slug = $this->args['menu_slug'];
            }

            foreach ($this->option_pages as $option_page) {
                $hook = add_submenu_page($main_menu_slug, $option_page['page_title'], $option_page['menu_title'], 'manage_options', $option_page['slug'], array(&$this , 'option_page_html'));
                $this->store_page_hook($hook, $option_page);
                add_action('load-' . $hook, array(&$this, 'option_page_loaded'));
            }
            // add action to enqueue scripts for each page
            add_action('admin_enqueue_scripts', array(&$this, 'enqueue_scripts'));
        }

        private function store_page_hook($hook, $option_page)
        {
            $this->hooks[$hook] = $option_page;
        }

        public function option_page_loaded()
        {
            if (isset($_GET['settings-updated']) && $_GET['settings-updated'] == true) {
                do_action('oxy-options-updated-' . $_GET['page']);
            }
        }

        /**
         * Enqueues scripts needed for each option page
         *
         * @return void
         *              @since 1.0
         **/
        public function enqueue_scripts($hook)
        {
            // if we are on an option page enqueue script and style for options
            if (isset($this->hooks[$hook])) {
                // always enqueue base option css
                wp_enqueue_style('oxy-option-page');

                wp_enqueue_style('jquery-oxygenna-ui-theme');
                wp_enqueue_script('theme-options-page', OXY_TF_URI . 'assets/javascripts/theme-options-page.js', array('jquery', 'jquery-ui-tooltip'));

                // now load any option specific js / css
                foreach ($this->hooks[$hook]['sections'] as $section) {
                    foreach ($section['fields'] as $field) {
                        if (isset($field['type'])) {
                            $new_field = OxygennaOptions::create_option($field);
                            if ($new_field !== false) {
                                $new_field->enqueue();
                            }
                        }
                    }
                }

            }

            // load any option page css
            if (isset($this->hooks[$hook]['stylesheets'])) {
                foreach ($this->hooks[$hook]['stylesheets'] as $css) {
                    wp_enqueue_style($css['handle'], $css['src'], $css['deps']);
                }
            }

            // load any option page js
            if (isset($this->hooks[$hook]['javascripts'])) {
                foreach ($this->hooks[$hook]['javascripts'] as $js) {
                    wp_enqueue_script($js['handle'], $js['src'], $js['deps']);
                    if (isset($js['localize'])) {
                        wp_localize_script($js['handle'], $js['localize']['object_handle'], $js['localize']['data']);
                    }
                }
            }
        }

        /**
         * Displays the option page
         *
         * @return void
         *              @since 1.0
         **/
        public function option_page_html()
        {
            ?>
            <?php do_action($_GET['page'] . '-before-page'); ?>
            <div class="wrap oxygenna-options-page">
                <div class="icon32">
                    <img src="<?php echo OXY_TF_URI . 'assets/images/oxygenna.png' ?>" alt="Oxygenna logo">
                </div>
                <h2><?php echo get_admin_page_title(); ?></h2>
                <?php settings_errors(); ?>
                <div id="ajax-errors-here"></div>
                <form method="post" action="options.php">
                    <?php settings_fields($this->option_group); ?>
                    <?php do_settings_sections($_GET['page']); ?>
                    <div class="submit-footer">
                        <?php submit_button(__('Save Changes', 'omega-admin-td'), 'primary', 'save_changes'); ?>
                        <?php submit_button(__('Restore Defaults', 'omega-admin-td'), 'secondary', 'reset_options'); ?>
                    </div>
                </form>
            </div>
            <?php do_action($_GET['page'] . '-after-page'); ?>
        <?php
        }

        /**
         * Creates a single option
         *
         * @return void
         *              @since 1.0
         **/
        public function render_option($field)
        {
            $value = isset($this->options[$field['id']]) ? $this->options[$field['id']] : null;
            $attr = array('name' => $this->option_name . '[' . $field['id'] . ']');

            // create new field
            $form_field = OxygennaOptions::create_option($field, $value, $attr);
            $form_field->render();

            if (isset($field['desc'])) {
                echo '</td><td>';
                echo '<a class="description" title="' . $field['desc'] . '"><img src="' . OXY_TF_URI . 'assets/images/what.png" alt="Tooltip"></a>';
            }
        }

        /**
         * Creates a nice new field for you
         *
         * @return object field false on error
         *                @since 1.0
         **/
        public static function create_option($field, $value = '', $attr = array())
        {
            if (isset($field['type'])) {
                // load class for option type
                // if class-file is set by plugin then use the custom class file
                $class_file = isset($field['class-file']) ? $field['class-file'] : OXY_TF_DIR . 'inc/options/fields/' . $field['type'] . '/Oxygenna' . ucfirst($field['type']) . '.php';
                if (file_exists($class_file)) {
                    require_once $class_file;
                    $option_class = 'Oxygenna' . ucwords($field['type']);
                    if (class_exists($option_class)) {
                        return new $option_class($field, $value, $attr);
                    }
                }
            }

            return false;
        }
    }

}
