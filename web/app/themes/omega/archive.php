<?php
/**
 * Displays the main body of the theme
 *
 * @package Omega
 * @subpackage Frontend
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.18.12
 */
$name = oxy_get_option( 'blog_masonry' ) === 'no-masonry' ? oxy_get_option( 'blog_style' ) : oxy_get_option( 'blog_masonry' );
$title = null;
$subtitle = null;

get_header();
if( is_day() ) {
    $title = get_the_date( 'j M Y' );
    $subtitle = __( 'All posts from', 'omega-td' ) . ' ' . get_the_date( 'j M Y' );
}
elseif( is_month() ) {
    $title = get_the_date( 'F Y' );
    $subtitle = __( 'All posts from', 'omega-td' ) . ' ' . get_the_date( 'F Y' );
}
elseif( is_year() ) {
    $title = get_the_date( 'Y' );
    $subtitle = __( 'All posts from', 'omega-td' ) . ' ' . get_the_date( 'Y' );
}
oxy_blog_header( $title, $subtitle );
?>
<section class="section <?php echo oxy_get_option( 'blog_swatch' ); ?>">
    <?php get_template_part( 'partials/blog/list', $name ); ?>
</section>
<?php get_footer();