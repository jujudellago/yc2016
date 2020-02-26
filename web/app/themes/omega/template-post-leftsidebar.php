<?php
/**
 * Template Name: Left Sidebar Post
 * Template Post Type: post
 *
 * @package Omega
 * @subpackage Frontend
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.18.14
 */

 get_header();
 oxy_blog_header();
 ?>
 <section class="section <?php echo oxy_get_option( 'blog_swatch' ); ?>">
     <?php get_template_part( 'partials/blog/list', 'left-sidebar' ); ?>
 </section>
 <?php get_footer();
