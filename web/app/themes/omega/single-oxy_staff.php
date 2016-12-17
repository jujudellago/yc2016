<?php
/**
 * Default page template
 *
 * @package Omega
 * @subpackage Frontend
 * @since 0.1
 *
 * @copyright **COPYRIGHT*
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.14.0
 */

get_header();
global $post;
oxy_page_header( $post->ID, array( 'heading_type' => 'page' ) );
while( have_posts() ) {
    the_post();
    get_template_part('partials/content', 'page');
}
get_footer();