<?php
/**
 * Default page template
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
oxy_page_header( $post->ID, array( 'heading_type' => 'portfolio' ) );
while( have_posts() ) {
    the_post();
    get_template_part('partials/content', 'page');
}

$allow_comments = oxy_get_option( 'site_comments' );
?>

<?php if ( oxy_get_option('related_portfolio_items') === 'on' ) : ?>
    <?php get_template_part( 'partials/portfolio/portfolio-related' ); ?>
<?php endif; ?>


<?php if( ($allow_comments === 'portfolio' || $allow_comments === 'all') && (comments_open() || get_comments_number())) : ?>
<section class="section <?php echo oxy_get_option( 'portfolio_comments_swatch' ); ?>">
    <div class="container">
        <div class="row element-normal-top element-normal-bottom">
            <?php comments_template( '', true ); ?>
        </div>
    </div>
</section>
<?php
endif;
get_footer();
