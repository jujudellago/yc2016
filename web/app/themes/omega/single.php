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
?>
<section class="section <?php echo oxy_get_option( 'blog_swatch' ); ?>">
    <?php get_template_part( 'partials/blog/list', oxy_get_option( 'blog_style' ) ); ?>
</section>
<?php get_footer();