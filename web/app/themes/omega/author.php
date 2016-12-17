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
 * @version 1.14.0
 */
// get the author name
if( get_query_var('author_name') ) {
    $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
}
else {
    $author = get_userdata( get_query_var( 'author' ) );
}

get_header();
oxy_blog_header( get_the_author_meta( 'display_name', $author->ID ), null );
// if masonry option set then use masonry option for name otherwise use blog style
$name = oxy_get_option( 'blog_masonry' ) === 'no-masonry' ? oxy_get_option( 'blog_style' ) : oxy_get_option( 'blog_masonry' );
?>
<section class="section <?php echo oxy_get_option( 'blog_swatch' ); ?>">
    <?php get_template_part( 'partials/blog/list', $name ); ?>
</section>
<?php get_footer();