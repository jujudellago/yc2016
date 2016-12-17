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
$extra_post_class  = oxy_get_option('blog_post_icons') == 'on'? 'post-showinfo':'';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $extra_post_class ); ?>>
    <?php if( oxy_get_option( 'blog_post_icons' ) === 'on' ) : ?>
		<header class="post-head small-screen-center no-title">
	        <span class="post-icon">
	            <?php oxy_post_icon($post->ID, true); ?>
	        </span>
	    </header>
    <?php endif; ?>
    <div class="post-body">
        <?php echo oxy_shortcode_blockquote( array(
            'who'           => get_the_title(),
            'margin_top'    => 'no-top',
            'margin_bottom' => 'no-bottom'
        ), get_the_content() ); ?>
    </div>
</article>