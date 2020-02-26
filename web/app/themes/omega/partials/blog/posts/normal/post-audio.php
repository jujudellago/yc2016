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
global $wp_embed;
global $post;

$content          = get_the_content( '', oxy_get_option('blog_stripteaser') === 'on' );
$extra_post_class = oxy_get_option('blog_post_icons') === 'on' ? 'post-showinfo' : '';
$audio_shortcode  = oxy_get_content_shortcode( $post, 'audio' );

if( $audio_shortcode !== null){
    $audio_src = null;
    if( array_key_exists( 3, $audio_shortcode ) ) {
        if( array_key_exists( 0, $audio_shortcode[3] ) ) {
            $audio_attrs = shortcode_parse_atts( $audio_shortcode[3][0] );
            if( array_key_exists( 'src', $audio_attrs) ) {
                $audio_src =  $audio_attrs['src'];
            }
        }
        $content = str_replace( $audio_shortcode[0][0], '', $content );
    }
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $extra_post_class ); ?>>
    <div class="post-media">
        <?php
        if( !is_search() ) {
            if( $audio_src !== null ) { ?>
                <audio controls="" preload="auto" style="width:100%; height:100%;">
                    <source src="<?php echo $audio_src; ?>">
                </audio>
                <?php

            }
            else if ( has_post_thumbnail()  ) {
                get_template_part( 'partials/blog/posts/normal/featured-image' );
            }
        }
        ?>
    </div>

    <?php get_template_part( 'partials/blog/posts/normal/post', 'header' ); ?>

    <div class="post-body">
        <?php
        echo apply_filters( 'the_content', $content );

        if( !is_single() && oxy_get_option('blog_show_readmore') == 'on' ) {
            // show up to readmore tag and conditionally render the readmore
            oxy_read_more_link();
        }
        ?>
    </div>

    <?php get_template_part( 'partials/blog/posts/normal/post', 'footer' ); ?>
</article>