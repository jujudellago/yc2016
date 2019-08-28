<?php
/**
 * Handles customise theme options
 *
 * @package ThemeFramework
 * @subpackage Options
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.12
 */

/**
 * Multiple checkbox customize control class.
 *
 * @since  1.0.0
 * @access public
 */
class OxyCustomizeControlMultipleCheckbox extends WP_Customize_Control
{

    /**
     * The type of customize control being rendered.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $type = 'checkbox-multiple';

    /**
     * Enqueue scripts/styles.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function enqueue()
    {
        wp_enqueue_script('oxy-customize-multiple-checkbox', OXY_TF_URI . 'assets/javascripts/customiser/multiple-checkbox.js', array('jquery'));
    }

    /**
     * Displays the control content.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function render_content()
    {
        if (empty($this->choices)) {
            return;
        }

        include OXY_TF_DIR . 'partials/customiser/multiple-checkbox.php';
    }
}
