
<div class="<?php echo implode(' ', $classes); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s">

  <div class="progress-bar <?php echo $style; ?>" role="progressbar" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage; ?>%;">
    <?php if ($progress_text != '') : ?>
    	<span><?php echo $progress_text ?></span>
  	<?php endif; ?>
  </div>
</div>


