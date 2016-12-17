<a href="<?php echo $link; ?>" class="btn <?php echo implode(' ', $classes); ?>" target= "<?php echo $link_open; ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay;?>s " <?php echo $custom_style; ?> <?php echo $modal_atts; ?>>
	<?php echo $label . ' '; ?>
	<?php if ( $icon != '' ): ?>
		<span> <i class="fa fa-<?php echo $icon; ?>" <?php echo $animation; ?> <?php echo $icon_style; ?> ></i> </span>
	<?php endif ?>
</a>
