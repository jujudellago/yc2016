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
class Swatch_social extends OxygennaWidget {


    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_options = array( 'description' => __( 'Social Icons Widget', 'omega-admin-td') );
        parent::__construct( 'swatch_social-options.php', false, $name = THEME_NAME . ' - ' . __('Social Icons Widget', 'omega-admin-td'), $widget_options );
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

        $title = $this->get_option( 'title', $instance, '');
        $new_window = $this->get_option( 'social_window', $instance, 'off');
        $custom_color = $this->get_option( 'social_color', $instance, 'on');
        $target = $new_window == 'on' ? 'target="_blank"' : '';
        $extra_class = $this->get_option( 'social_style', $instance, 'social-simple');
        $extra_class .= ' ' . $this->get_option( 'social_size', $instance, 'social-normal');

        $output = $before_widget;
        if( !empty( $title ) ) {
            $output .= '<h3 class="sidebar-header">' . $title . '</h3>';
        }
        $output.= '<ul class="unstyled inline social-icons '.$extra_class.'">';
        for( $i = 0 ; $i < 10 ; $i++ ) {
            $social_url = $this->get_option( 'social' . $i . '_url', $instance, '');
            $social_icon = $this->get_option( 'social' . $i . '_icon', $instance, '');
            $color = $custom_color == 'on'? 'data-iconcolor="' . oxy_get_icon_color( $social_icon ) . '"':'';
            $output .= empty( $social_icon ) ? '' : '<li><a ' . $target . ' '.$color.' href="' . $social_url . '"><i class="fa fa-' . $social_icon . '"></i></a></li>';
        }

        $output.= '</ul>';
        $output.= $after_widget;

        echo $output;
    }

}