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
$src = '';
if( has_post_thumbnail() ) {
    $attachment = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
    if ( isset( $attachment[0] ) ) {
        $src = 'style="background-image: url(' . $attachment[0] . ')"';
    }
}
?>
<article id="post-<?php the_ID(); ?>" class="post-related-post" <?php echo $src; ?>>
    <?php echo oxy_shortcode_blockquote( array(
        'who'           => get_the_title(),
        'margin_top'    => 'no-top',
        'margin_bottom' => 'no-bottom'
    ), get_the_content() ); ?>
</article>