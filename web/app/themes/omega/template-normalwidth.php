<?php
/**
 * Template Name: Full Width Padded
 *
 * @package Omega
 * @subpackage Frontend
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.18.12
 */

get_header();
global $post;
oxy_page_header( $post->ID, array( 'heading_type' => 'page' ) );
$allow_comments = oxy_get_option( 'site_comments' );
?>

<section class="section">
    <div class="container">
        <div class="row element-normal-top">
            <div class="col-md-12">
                <?php while ( have_posts() ) : the_post(); ?>

                <?php get_template_part( 'partials/content', 'page' ); ?>

                <?php if( $allow_comments == 'pages' || $allow_comments == 'all' ) comments_template( '', true ); ?>

                <?php endwhile; ?>
            </div>
        </div>
    </div>
</section>
<?php get_footer();