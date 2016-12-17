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
 * @version 1.14.0
 */
global $post;
$src = '';
if( has_post_thumbnail() ) {
    $attachment = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
    if ( isset( $attachment[0] ) ) {
        $src = 'style="background-image: url(' . $attachment[0] . ')"';
    }
}
?>
<article id="post-<?php the_ID(); ?>" class="post-related-post" <?php echo $src; ?>>
    <h4>
        <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
        <?php if( oxy_get_option( 'blog_author' ) === 'on' ) : ?>
            <small>
                <?php _e('by', 'omega-td' ); ?>
                <?php the_author(); ?>
            </small>
        <?php endif; ?>
    </h4>
</article>