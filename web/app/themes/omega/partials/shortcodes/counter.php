<div class="counter <?php echo implode(' ', $header_classes); ?>" data-count="<?php echo $value; ?>" data-format="<?php echo $format; ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s">
    <span class="value odometer-counter <?php echo $counter_size . ' ' . $counter_weight; ?>">
        <?php echo $initvalue; ?>
    </span>
</div>