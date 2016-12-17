<div class="<?php echo implode( ' ', $classes ); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s">
	<?php
		if ($style == 'bottom') { ?>
			<div class="tabbable">
				<div class="tab-content"><?php echo $tab_contents; ?></div>
				<ul class="nav nav-tabs" data-tabs="tabs"><?php echo $tab_headers; ?></ul>
			</div>
	<?php }
		else { ?>
			<div class="tabbable">
				<ul class="nav nav-tabs" data-tabs="tabs"><?php echo $tab_headers; ?></ul>
				<div class="tab-content"><?php echo $tab_contents; ?></div>
			</div>
	<?php } ?>
</div>