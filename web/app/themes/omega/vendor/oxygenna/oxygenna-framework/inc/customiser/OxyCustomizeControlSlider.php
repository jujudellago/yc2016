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

class OxyCustomizeControlSlider extends WP_Customize_Control
{
    public $type = 'slider';

    public function enqueue()
    {
        // load styles
        wp_enqueue_style('jquery-oxygenna-ui-theme');
        // load scripts
        wp_enqueue_script('slider-field', OXY_TF_URI . 'inc/options/fields/slider/slider.js', array('jquery-ui-slider'));
    }

    public function render_content()
    {
        include OXY_TF_DIR . 'partials/customiser/slider.php';
    }
}
