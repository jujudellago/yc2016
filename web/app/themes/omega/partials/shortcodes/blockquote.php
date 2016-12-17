<blockquote class="<?php echo implode(' ', $classes); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay;?>s">
    <p><?php echo do_shortcode( $content ); ?></p>
	<?php if (!empty( $who )): ?>
		<footer><?php echo $who ?><?php if (!empty( $cite )): ?><cite title="<?php echo $cite; ?>"><?php echo $cite; ?></cite><?php endif; ?></footer>
	<?php endif ?>
</blockquote>