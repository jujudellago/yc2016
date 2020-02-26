<?php
/**
 * BBPress actions
 *
 * @package Omega
 * @subpackage BBPress
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.18.14
 */

class OmegaBBPress extends OxygennaBBPress
{
    public function __construct($options_file)
    {
        parent::__construct($options_file);
    }

    public function global_page_header()
    {
        global $oxy_theme_options;

        if (isset( $oxy_theme_options['bbpress_header_show_header']) && $oxy_theme_options['bbpress_header_show_header'] === 'show') {
            // use custom title
            $title = $this->get_page_header_title();

            $heading = oxy_call_shortcode_with_theme_options('oxy_section_heading', array(
                'sub_header',
                'header_type',
                'section_swatch_override',
                'heading_colour',
                'sub_header_size',
                'header_size',
                'header_weight',
                'header_align',
                'header_condensed',
                'header_underline',
                'header_underline_size',
                'heading_type',
                'header_fade_out',
                'extra_classes',
                'margin_top',
                'margin_bottom',
                'scroll_animation',
                'scroll_animation_delay'
            ), $title, $oxy_theme_options, 'bbpress_header_', array('heading_type' => 'bbpress'));
            // create section using theme options
            echo oxy_call_shortcode_with_theme_options('oxy_shortcode_section', array(
                'swatch',
                'section_color_set',
                'color_speed',
                'color_duration',
                'text_shadow',
                'inner_shadow',
                'width',
                'class',
                'id',
                'label',
                'overlay_colour',
                'overlay_opacity',
                'overlay_grid',
                'background_video_mp4',
                'background_video_webm',
                'background_image',
                'background_image_size',
                'background_image_repeat',
                'background_image_attachment',
                'background_position_vertical',
                'background_image_parallax',
                'background_image_parallax_start',
                'background_image_parallax_end',
                'height',
                'transparency',
                'vertical_alignment'
            ), $heading, $oxy_theme_options, 'bbpress_header_');
        }
    }
}


// only load all of this if bbpress is active
if( class_exists( 'bbPress' ) ) {
    $oxy_bbpress = new OmegaBBPress(OXY_THEME_DIR . 'inc/options/bbpress-options/option-pages.php');
}