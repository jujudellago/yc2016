<?php
/**
 * Template Name: Right Sidebar
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
<section class="section <?php echo get_post_meta( $post->ID, THEME_SHORT. '_sidebar_page_swatch', true ); ?>">
    <div class="container">
        <div class="row element-normal-top">
            <div class="col-md-9">
                <?php while ( have_posts() ) : the_post(); ?>

                <?php get_template_part( 'partials/content', 'page' ); ?>

                <?php endwhile; ?>
            </div>
            <div class="col-md-3 sidebar">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</section>
<?php if( ($allow_comments === 'pages' || $allow_comments === 'all') && (comments_open() || get_comments_number())) : ?>
<section class="section <?php echo oxy_get_option( 'page_comments_swatch' ); ?>">
    <div class="container">
        <div class="row element-normal-top element-normal-bottom">
            <?php comments_template( '', true ); ?>
        </div>
    </div>
</section>
<?php
endif;
get_footer();
