<?php
/**
 * Textarea option
 *
 * @package ThemeFramework
 * @subpackage Options
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.14.0
 */

/**
 * Simple Select option
 */
class OxygennaSelect extends OxygennaOption
{
    /**
     * Creates option
     *
     * @return void
     *              @since 1.0
     **/
    public function __construct($field, $value, $attr)
    {
        // check for multiple and add a [] to the name if it is
        if (isset($field['attr']) && is_array($field['attr']) && array_key_exists('multiple', $field['attr'])) {
            if (isset($attr['name'])) {
                $attr['name'] .= '[]';
            }
        }

        parent::__construct($field, $value, $attr);
    }

    /**
     * Overrides super class render function
     *
     * @return string HTML for option
     *                @since 1.0
     **/
    public function render($echo = true)
    {
        //if it is not an array , search the backend for the select options
        if (!is_array($this->_field['options'])) {
            $this->load_select_options($this->_field['options']);
        }

        $option = '<select' . $this->create_attributes() . '>';

        if (isset($this->_field['blank'])) {
            $option .= '<option value="">' . $this->_field['blank'] . '</option>';
        }

        $option .= $this->create_select_options($this->_field['options'], $this->_value);

        $option .= '</select>';

        if ($echo) {
            echo $option;
        } else {
            return $option;
        }
    }

    public function load_select_options($database)
    {
        $data = $this->load_select_data($database);
        $this->build_options_from_data($database, $data);
    }

    public function load_select_data($database)
    {
        // get data
        $data = array();
        switch ($database) {
            case 'custom_post_type':
            case 'custom_post_id':
                if (isset($this->_field['post_type'])) {
                    $data = get_posts(array(
                        'posts_per_page' => -1,
                        'post_type' => $this->_field['post_type'],
                        'orderby' => 'title',
                        'order' => 'DESC'
                    ));
                }
                break;
            case 'taxonomy':
                if (isset($this->_field['taxonomy'])) {
                    if (isset($this->_field['blank_label'])) {
                        $this->_field['blank'] = $this->_field['blank_label'];
                    }
                    switch ($this->_field['taxonomy']) {
                        case 'pages':
                            $data = get_pages();
                            break;
                        case 'posts':
                            $data = get_posts(array('posts_per_page'=> -1));
                            break;
                        case 'oxy_portfolio_image':
                            $data = get_posts(array('posts_per_page'=> -1, 'post_type'=>'oxy_portfolio_image'));
                            break;
                        default:
                            $data = get_categories(array('orderby' => 'name', 'hide_empty' => '0', 'taxonomy' => $this->_field['taxonomy']));
                            break;
                    }
                }
                break;
            case 'revolution':
                $this->_field['blank'] = __('Select a Slideshow', 'omega-admin-td');
                global $wpdb;
                $data = $wpdb->get_results('select * from ' . $wpdb->prefix . 'revslider_sliders');
                break;
            case 'layerslider':
                if (class_exists('LS_Sliders')) {
                    $this->_field['blank'] = __('Select a Slideshow', 'omega-admin-td');
                    $data = LS_Sliders::find(array('limit' => 100));
                } else {
                    $this->_field['blank'] = __('Please activate LayersSlider plugin', 'omega-admin-td');
                }
                break;
            case 'slideshow':
                $this->_field['blank'] = __('Select a Slideshow', 'omega-admin-td');
                $data = get_categories(array('orderby' => 'name', 'hide_empty' => '0', 'taxonomy' => 'oxy_slideshow_categories'));
                break;

            case 'get_option':
                $options = get_option(THEME_SHORT. '-options');
                if (isset($options['unregistered'][$this->_field['option']])) {
                    $data = oxy_get_option($this->_field['option']);
                    $unregistered = oxy_get_option('unregistered');
                    $data = $options['unregistered'][$this->_field['option']];
                } else {
                    $data = null;
                }
                break;

            case 'staff_featured':
                $this->_field['blank'] = __('Select a Staff member', 'omega-admin-td');
                $posts =  get_posts('showposts=-1&post_type=oxy_staff');
                foreach ($posts as $staff) {
                    $data[$staff->post_title] = $staff->ID;
                }
                break;
            case 'icons':
                if (file_exists(OXY_THEME_DIR . 'inc/options/global-options/fontawesome.php')) {
                    $data = include OXY_THEME_DIR . 'inc/options/global-options/fontawesome.php';
                }
                break;
            case 'categories':
                //$this->_field['blank'] = __('all categories', 'omega-admin-td');
                $data = get_categories(array('orderby' => 'name', 'hide_empty' => '0'));
                break;
            case 'portfolios':
                $this->_field['blank'] = __('Select a Portfolio', 'omega-admin-td');
                $data = get_categories(array('orderby' => 'name', 'hide_empty' => '0', 'taxonomy' => 'oxy_portfolio_categories'));
                break;
            case 'typekit_kits':
                $theme_options = get_option(THEME_SHORT . '-options');
                if (isset($theme_options['unregistered']['typekit_kits'])) {
                    $kits_details = $theme_options['unregistered']['typekit_kits'];
                    if (!empty($kits_details)) {
                        $this->_field['blank'] = __('Select a kit', 'omega-admin-td');
                        foreach ($kits_details as $kit) {
                            $data[$kit->kit->id] = $kit->kit->name;
                        }
                    }
                }
                break;

            default:
                $data = array();
                break;
        }

        return $data;
    }

    public function build_options_from_data($database, $data)
    {
        $this->_field['options'] = array();
        if (!empty($data)) {
            foreach ($data as $key => $entry) {
                switch ($database) {
                    case 'revolution':
                        $this->_field['options'][$entry->alias] = $entry->title;
                        break;
                    case 'layerslider':
                        $this->_field['options'][$entry['id']] = $entry['name'];
                        break;
                    case 'custom_post_type':
                        $this->_field['options'][$entry->post_name] = $entry->post_title;
                        break;
                    case 'custom_post_id':
                        $this->_field['options'][$entry->ID] = $entry->post_title;
                        break;
                    case 'slideshow':
                        $this->_field['options'][$entry->slug] = $entry->name;
                        break;
                    case 'taxonomy':
                        switch ($this->_field['taxonomy']) {
                            case 'pages':
                            case 'posts':
                            case 'oxy_portfolio_image':
                                $this->_field['options'][$entry->ID] = $entry->post_title;
                                break;
                            default:
                                $this->_field['options'][$entry->slug] = $entry->name;
                                break;
                        }
                        break;
                    case 'staff_featured':
                        $this->_field['options'][$entry] = $key;
                        break;
                    case 'categories':
                        $this->_field['options'][$entry->slug] = $entry->name;
                        break;
                    case 'portfolios':
                        $this->_field['options'][$entry->slug] = $entry->name;
                        break;
                    case 'get_option':
                    case 'typekit_kits':
                    case 'icons':
                        $this->_field['options'][$key] = $entry;
                        break;
                    default:
                        $this->option['options'][$entry] = $entry;
                        break;
                }
            }
        }
    }

    public function create_select_options($options, $selected_value)
    {
        $options_html = '';
        foreach ($options as $key => $option) {
            if (is_array($option)) {
                // do we have an option group?
                if (isset($option['optgroup'])) {
                    // make option group with optgroup label and use options array to build child options
                    $options_html .= '<optgroup id="' . $key . '" label="' . $option['optgroup'] . '">';
                    $options_html .= $this->create_select_options($option['options'], $selected_value);
                    $options_html .= '</optgroup>';
                } else {
                    // no option group just make the options
                    $options_html .= $this->create_select_options($option, $selected_value);
                }
            } else {
                $options_html .= '<option value="' . $key . '"';
                if (is_array($selected_value)) {
                    foreach ($selected_value as $multi_val) {
                        if ($multi_val == $key) {
                            $selected = $key;
                            $options_html .= ' selected="selected"';
                        }
                    }
                }
                if ($selected_value == $key) {
                    $selected = $key;
                    $options_html .= ' selected="selected"';
                }
                $options_html .= '>' . $option . '</option>';
            }
        }

        return $options_html;
    }

    public function enqueue()
    {
        parent::enqueue();

        if (isset($this->attr['class']) && strrpos($this->attr['class'], 'select2') !== false) {
            wp_enqueue_script('select2-plugin', OXY_TF_URI . 'assets/components/select2/select2.min.js', array('jquery'));
            wp_enqueue_style('select2-style', OXY_TF_URI . 'assets/components/select2/select2.css');
            wp_enqueue_script('select2-select-option', OXY_TF_URI . 'inc/options/fields/select/select2.js', array('jquery'));
        }
    }
}
