<?php
/**
 * Displays the archive for oxy_portfolio_image custom post type
 *
 * @package Omega
 * @subpackage Frontend
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.14.0
 */

get_header(); 

$page = oxy_get_option( 'portfolio_archive_page' ); 
if( !empty( $page ) ) : 	
	
	global $post;
	$post = get_post($page);
	setup_postdata($post);
	
	oxy_page_header( $post->ID );
	get_template_part('partials/content', 'page');
	
	wp_reset_postdata();

endif; 

get_footer();