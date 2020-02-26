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
 * @version 1.18.14
 */

get_header();
global $post;
oxy_page_header( $post->ID, array( 'heading_type' => 'page' ) );
while( have_posts() ) {
    the_post();
    get_template_part('partials/content', 'page');
}

$allow_comments = oxy_get_option( 'site_comments' );
// If comments are open or we have at least one comment, load up the comment template.
if( ($allow_comments === 'pages' || $allow_comments === 'all') && (comments_open() || get_comments_number())) : ?>
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
