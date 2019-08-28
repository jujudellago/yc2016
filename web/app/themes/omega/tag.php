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

get_header();
$title = single_tag_title( '', false );
$subtitle = __('All posts tagged', 'omega-td') . ' ' . single_tag_title( '', false );
oxy_blog_header( $title, $subtitle );
// if masonry option set then use masonry option for name otherwise use blog style
$name = oxy_get_option( 'blog_masonry' ) === 'no-masonry' ? oxy_get_option( 'blog_style' ) : oxy_get_option( 'blog_masonry' );
?>

<section class="section <?php echo oxy_get_option( 'blog_swatch' ); ?>">
    <?php get_template_part( 'partials/blog/list', $name ); ?>
</section>
<?php get_footer();