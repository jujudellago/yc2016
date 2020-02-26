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
 * @version 1.18.14
 */

get_header();
oxy_blog_header();
// if masonry option set then use masonry option for name otherwise use blog style
$name = oxy_get_option( 'blog_style' );
$classes = array( oxy_get_option( 'blog_swatch' ) );

if( oxy_get_option( 'blog_masonry' ) !== 'no-masonry' ) {
    $name = oxy_get_option( 'blog_masonry' );
    if( oxy_get_option( 'blog_masonry_section_transparent' ) === 'on' ) {
        $classes[] = 'section-transparent';
    }
}
?>
<section class="section <?php echo implode(' ', $classes); ?>">
    <?php get_template_part( 'partials/blog/list', apply_filters( 'oxy_blog_type', $name ) ); ?>
</section>
<?php get_footer();