<?php
/**
 * Metabox class for creating a metabox
 *
 * @package ThemeFramework
 * @subpackage Metabox
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.14
 */

class OxygennaMetabox
{
    private $options;

    /**
     * Constructior, called by themeadmin.php when metaboxes are created
     *
     * @since 1.0
     * @param array $options array of all theme options to use in construction this theme
     */
    public function __construct($metabox)
    {
        $this->options = $metabox;
        if (isset($this->options['pages'])) {
            foreach ($this->options['pages'] as $page) {
                add_action('add_meta_boxes_' . $page, array(&$this, 'add_meta_boxes'));
            }
        }
        if (isset($this->options['taxonomies'])) {
            add_action('admin_init', array(&$this, 'add_meta_to_taxonomies'), 100);
            add_action('edit_term', array($this, 'save_meta_to_taxonomies'), 10, 2);
            add_action('created_term', array($this, 'save_meta_to_taxonomies'), 10, 2);
        }

        add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue_scripts'));

        add_action('save_post', array(&$this, 'save_metabox'));
    }

    public function add_meta_boxes()
    {
        foreach ($this->options['pages'] as $page) {
            add_meta_box($this->options['id'], $this->options['title'], array(&$this, 'render_metabox'), $page, $this->options['context'], $this->options['priority']);
        }
    }
    public function add_meta_to_taxonomies()
    {
        foreach (get_taxonomies() as $tax_name) {
            if (in_array($tax_name, $this->options['taxonomies'])) {
                add_action($tax_name . '_add_form_fields', array($this, 'render_taxonomy_metabox'));
                add_action($tax_name . '_edit_form_fields', array($this, 'render_taxonomy_metabox'));
            }
        }
    }

    /**
     * Enqueue common styles
     *
     * @return void
     */
    public function admin_enqueue_scripts()
    {
        $screen = get_current_screen();
        if (isset($screen) && 'post' == $screen->base &&  isset($this->options['pages']) &&  in_array($screen->post_type, $this->options['pages']) || isset($screen) && 'edit-tags' == $screen->base || 'term' == $screen->base && isset($this->options['taxonomies']) &&  in_array($screen->taxonomy, $this->options['taxonomies'])) {
            wp_enqueue_style('oxy-metabox-global', OXY_TF_URI . 'assets/css/metaboxes/metabox-global.css', array('jquery-oxygenna-ui-theme'));
            wp_enqueue_script('metabox-options-global', OXY_TF_URI . 'assets/javascripts/metabox-options-global.js', array('jquery', 'jquery-ui-tooltip'));

            // enqueue scripts for each field
            foreach ($this->options['fields'] as $field) {
                if (isset($field['type'])) {
                    $new_field = OxygennaOptions::create_option($field);
                    if ($new_field !== false) {
                        $new_field->enqueue();
                    }
                }
            }
            // enqueue metabox-wide javascripts
            if (isset($this->options['javascripts'])) {
                foreach ($this->options['javascripts'] as $js) {
                    wp_enqueue_script($js['handle'], $js['src'], $js['deps']);
                    if (isset($js['localize'])) {
                        wp_localize_script($js['handle'], $js['localize']['object_handle'], $js['localize']['data']);
                    }
                }
            }
        }
    }

    /**
     * Main function called when metabox is shown
     *
     * @return void
     **/
    public function render_metabox($post)
    {
        echo '<table class="metabox-table">';
        foreach ($this->options['fields'] as $field) {
            $id = THEME_SHORT . '_' . $field['id'];
            $value = get_post_meta($post->ID, $id, false);
            if (empty($value) && isset($field['default'])) {
                $value = $field['default'];
            } else {
                $value = $value[0];
            }
            $attr = array('name' => THEME_SHORT . '-options[' . $id . ']');

             // create new field
            $form_field = OxygennaOptions::create_option($field, $value, $attr);

            if ($form_field !== false) {
                echo '<tr class="form-table" id="' . $id . '">';
                echo '<th scope="row" valign="top">';
                echo '<label for="' . $field['name'] . '">' . $field['name'] . '</label>';
                echo '</th><td>';
                $form_field->render();
                if (isset($field['desc'])) {
                    echo '</td><td class="tooltip-column">';
                    echo '<a class="description" title="' . $field['desc'] . '"><img src="' . OXY_TF_URI . 'assets/images/what.png" alt="Tooltip"></a>';
                }
                echo '</td></tr>';
            }
        }
        echo '</table>';
        // create nonce
        wp_nonce_field($this->options['id'] . THEME_SHORT . '-metabox', $this->options['id'] . '-theme-metabox-nonce');
    }

     /**
     * Main function called when metabox is shown in taxonomy.
     *
     * @return void
     **/
    public function render_taxonomy_metabox($term)
    {
        foreach ($this->options['fields'] as $field) {
            $id = THEME_SHORT . '_' . $field['id'];
            $attr = array('name' => THEME_SHORT . '-options[' . $id . ']');
            // we are in edit screen
            if (is_object($term)) {
                $value = get_option(THEME_SHORT . '-tax-mtb-' .$field['id']. $term->term_id, $field['default']) == false ? $field['default'] : get_option(THEME_SHORT . '-tax-mtb-' . $field['id'].$term->term_id, $field['default']);
            } else {
                // we are in creation screen
                $value = $field['default'];
            }
            // create new field
            $form_field = OxygennaOptions::create_option($field, $value, $attr);

            if ($form_field !== false) {
                //echo the wrappers first
                echo '<table class="form-table">';
                echo '<th scope="row" valign="top">';
                echo '<label for="' . $field['name'] . '">' . $field['name'] . '</label>';
                echo '</th><td>';
                $form_field->render();
                if (isset($field['desc'])) {
                    echo '<span class="description">' . $field['desc'] . '</span>';
                }
                echo '</td></table>';
            }
        }

        // create nonce
        wp_nonce_field($this->options['id'] . THEME_SHORT . 'taxonomy-metabox', $this->options['id'] . '-theme-taxonomy-metabox-nonce');
    }

    public function save_meta_to_taxonomies($term_id, $tt_id)
    {
        foreach ($this->options['fields'] as $field) {
            $id = THEME_SHORT . '_' . $field['id'];
            if (isset($_POST[THEME_SHORT.'-options'][$id])) {
                update_option(THEME_SHORT . '-tax-mtb-' . $field['id'].$term_id, $_POST[THEME_SHORT.'-options'][$id]);
            }
        }
    }
    /**
     * Saves all fields as metadata
     *
     * @return void
     **/
    public function save_metabox($post_id)
    {
        // verify if this is an auto save routine.
        // If it is our form has not been submitted, so we dont want to do anything
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // check nonce
        if (! isset($_POST[ $this->options['id'] . '-theme-metabox-nonce' ]) || ! wp_verify_nonce($_POST[ $this->options['id'] . '-theme-metabox-nonce' ], $this->options['id'] . THEME_SHORT . '-metabox')) {
            return false;
        }

         // First we need to check if the current user is authorised to do this action.
        if ('page' == $_REQUEST['post_type']) {
            if (! current_user_can('edit_page', $post_id)) {
                return;
            }
        } else {
            if (! current_user_can('edit_post', $post_id)) {
                return;
            }
        }

        // Thirdly we can save the value to the database
        foreach ($this->options['fields'] as $field) {
            //sanitize user input
            $id = THEME_SHORT . '_' . $field['id'];
            if (isset($_POST[THEME_SHORT . '-options']) && isset($_POST[THEME_SHORT . '-options'][$id])) {
                $value = sanitize_text_field($_POST[THEME_SHORT . '-options'][$id]);
                $this->update_option($post_id, $id, $value);
            }
        }
    }

     /**
     * saves values as post meta data
     * @access private
     * @param int post_id post id to update meta data
     * @param string name name of metadata
     * @param string|array value of metadata
     * @return void
     */
    private function update_option($post_id, $name, $value = null)
    {
        if (empty($value)) {
            delete_post_meta($post_id, $name);
        }
        // Update meta
        update_post_meta($post_id, $name, $value);
    }
}
