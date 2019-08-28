<?php
/**
 * Loads a masonry quote post
 *
 * @package Omega
 * @subpackage Admin
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.12
 */
global $post;
$width = get_post_meta( $post->ID, THEME_SHORT.'_masonry_width', true );
?>
<article class="post-masonry masonry-item masonry-<?php echo $width; ?>" data-menu-order="<?php echo $masonry_count; ?>">
    <div class="post-masonry-inner <?php echo implode( ' ', $classes ); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay;?>s">
        <div class="post-masonry-content <?php echo $masonry_items_swatch; ?>">
            <?php echo oxy_shortcode_blockquote( array(
                'who'           => get_the_title(),
                'margin_top'    => 'no-top',
                'margin_bottom' => 'no-bottom'
            ), get_the_content() ); ?>
        </div>
    </div>
</article>