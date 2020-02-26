<?php
/**
 * Shows a simple single post
 *
 * @package Omega
 * @subpackage Frontend
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.18.14
 */
global $post;
$extra_post_class = oxy_get_option('blog_post_icons') === 'on' ? 'post-showinfo' : '';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $extra_post_class ); ?>>
    <div class="post-media">
        <?php
        $image_link         = is_single() ? '' : get_permalink( $post->ID );
        $image_link_type    = is_single() && oxy_get_option( 'blog_fancybox' ) === 'on' ? 'magnific' : 'item';
        $image_overlay_icon = is_single() ? 'plus' : 'link';
        $image_overlay      = oxy_get_option( 'blog_fancybox' ) === 'on' ? 'icon' : 'none';

        echo oxy_section_vc_single_image( array(
            'image'          => get_post_thumbnail_id( $post->ID ),
            'size'           => 'full',
            'link'           => $post->post_content,
            'link_target'    => '_blank',
            'item_link_type' => $image_link_type,
            'overlay_icon'   => $image_overlay_icon,
            'margin_top'     => 'no-top',
            'overlay'        => $image_overlay
        ));
        ?>
    </div>
    <header class="post-head">
        <h2 class="post-title">
            <a href="<?php echo esc_url( strip_tags( $post->post_content ) ); ?>" target="_blank">
                <?php the_title(); ?>
            </a>
        </h2>
        <small>
            <?php _e( 'by', 'omega-td' );  ?>
            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                <?php the_author(); ?>
            </a>
            <?php _e( 'on', 'omega-td' ); ?>
            <?php the_time(get_option('date_format')); ?>
            <?php if (oxy_get_option('blog_comment_count') == 'on') {
                echo ', ';
                comments_popup_link( __( 'No comments', 'omega-td' ), __( '1 comment', 'omega-td' ), __( '% comments', 'omega-td' ) );
            } ?>
        </small>

        <?php if( oxy_get_option( 'blog_post_icons' ) == 'on') : ?>
            <span class="post-icon">
                <?php oxy_post_icon( $post->ID, true ); ?>
            </span>
        <?php endif; ?>
    </header>
</article>