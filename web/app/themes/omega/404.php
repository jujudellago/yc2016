<?php
/**
 * Default 404 template
 *
 * @package Omega
 * @subpackage Frontend
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.14.0
 */

$id_404 = oxy_get_option( '404_page' );
if( $id_404 ) {
    $post = get_post( $id_404 );
    setup_postdata( $post );
    get_header();
    oxy_page_header( $post->ID, array( 'heading_type' => 'page' ) );

    get_template_part('partials/content', 'page');

    $allow_comments = oxy_get_option( 'site_comments' );
    ?>
    <?php if( $allow_comments == 'pages' || $allow_comments == 'all' ) : ?>
    <section class="section">
        <div class="container">
            <div class="row">
                <?php comments_template( '', true ); ?>
            </div>
        </div>
    </section>
    <?php
    endif;
}
get_footer();