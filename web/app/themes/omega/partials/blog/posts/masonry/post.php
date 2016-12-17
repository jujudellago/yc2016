<?php
/**
 * Loads a masonry post
 *
 * @package Omega
 * @subpackage Admin
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.14.0
 */
global $post;
$image = get_post_meta( $post->ID, THEME_SHORT.'_masonry_image', true );
if( empty( $image ) ) {
    $image_attachment = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
    if( isset( $image_attachment[0] ) ) {
        $image = $image_attachment[0];
    }
}
$width = get_post_meta( $post->ID, THEME_SHORT.'_masonry_width', true );
?>
<article class="post-masonry masonry-item masonry-<?php echo $width; ?>" data-menu-order="<?php echo $masonry_count; ?>">
    <div class="post-masonry-inner <?php echo implode( ' ', $classes ); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay;?>s">
        <a href="<?php the_permalink(); ?>" class="post-masonry-content <?php echo $masonry_items_swatch; ?>">
            <?php if( !empty( $image ) ) : ?>
                <img src="<?php echo $image; ?>" alt="<?php the_title(); ?>">
            <?php endif; ?>
            <div class="post-head small-screen-center">
                <h2 class="post-title bordered bordered-small"><?php the_title(); ?></h2>
                <small>
                <?php if( oxy_get_option( 'blog_author' ) === 'on' ) : ?>
                    <?php _e('by', 'omega-td' ); ?>
                    <?php the_author(); ?>,
                <?php endif; ?>
                <?php if( oxy_get_option( 'blog_date' ) === 'on' ) : ?>
                    <?php the_time(get_option('date_format')); ?>
                <?php endif; ?>
                </small>
            </div>
            <p class="post-body"><?php echo oxy_excerpt(15); ?></p>
        </a>
    </div>
</article>