<div class="alert <?php echo implode(' ', $classes); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s">
	<?php if ( $dismissable === 'true' ) : ?>
	    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<?php endif; ?>   
	<strong><?php echo $title; ?></strong>
	<?php echo $content; ?>
</div>