<?php
/**
 * Oxygenna.com
 *
 * $Template:: *(TEMPLATE_NAME)*
 * $Copyright:: *(COPYRIGHT)*
 * $Licence:: *(LICENCE)*
 */
require_once OXY_TF_DIR . 'inc/OxygennaWidget.php';

/**
 * Adds Caelus_title widget.
 */
class Swatch_wpml_language_selector extends OxygennaWidget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_options = array( 'description' => __( 'WPML Language Selector', 'omega-admin-td' ) );
        parent::__construct( 'swatch_wpml-language-selector-options.php', false, $name = THEME_NAME . ' - ' . __('WPML Language Selector Widget', 'omega-admin-td'), $widget_options );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );

        if( function_exists( 'icl_get_languages' ) ) {
            $display_as = $this->get_option( 'display', $instance, 'name');
            $options = 'skip_missing=' . $this->get_option( 'skip_missing', $instance, '1');
            $options .= '&order=' . $this->get_option( 'orderby', $instance, 'asc');
            $options .= '&orderby=' . $this->get_option( 'order', $instance, 'id');

            $languages = icl_get_languages( $options );

            $output = $before_widget;

            $output .= '<ul class="inline">';
            foreach( $languages as $lang ) {                
                $class = $lang['active'] ? 'active' : '';
                $link = $lang['active'] ? '#' : $lang['url'];
                $output .= '<li class="' . $class . '">';
                $output .= '<a href="' . $link . '" class="navbar-text">';
                switch( $display_as ) {
                    case 'name':
                        $output .= $lang['translated_name'];
                    break;
                    case 'code':
                        $output .= $lang['language_code'];
                    break;
                    case 'flag':
                        $output .= '<img src="' . $lang['country_flag_url'] . '" alt="' . $lang['translated_name'] . '" />';
                    break;
                    case 'nameflag':
                        $output .= '<img src="' . $lang['country_flag_url'] . '" alt="' . $lang['translated_name'] . '" /> ' . $lang['translated_name'];
                    break;
                }
                $output .= '</a>';
                $output .= '</li>';
            }
            $output .= '</ul>';
            $output .= $after_widget;
        }
        else {
            $output = 'You must install the WPML plugin';
        }

        echo $output;
    }
}