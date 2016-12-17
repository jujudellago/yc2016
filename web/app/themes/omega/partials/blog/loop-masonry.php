<?php
/**
 * Main Blog loop
 *
 * @package Omega
 * @subpackage Frontend
 * @since 1.4
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.14.0
 */
if( have_posts() ) {
    $masonry_count = 0;
    $classes = array();
    $scroll_animation = 'none';
    $scroll_animation_delay = 0;
    $masonry_items_swatch = oxy_get_option( 'masonry_items_swatch' );
    while( have_posts() ) {
        the_post();
        $format = '-' . get_post_format();
        // only quote and link look different
        if( $format !== '-quote' && $format !== '-link' ) {
            $format = '';
        }
        include( locate_template( 'partials/blog/posts/masonry/post' . $format . '.php' ) );
        $masonry_count++;
    }
    infinite_scroll_pagination();
}
else {
    get_template_part( 'partials/blog/posts/normal/post', 'no-posts' );
}