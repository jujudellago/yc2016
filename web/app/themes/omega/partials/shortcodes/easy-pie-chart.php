<div class="chart easyPieChart <?php echo implode(' ', $header_classes); ?>" data-percent="<?php echo $percentage; ?>" data-track-color="<?php echo $track_colour; ?>" data-bar-color="<?php echo $bar_colour; ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s" data-line-width="<?php echo $line_width; ?>" data-size="<?php echo $size; ?>" >
    <span>
        <?php echo $percentage; ?>
    </span>
    <i class="fa fa-<?php echo $icon; ?>" <?php echo $icon_animation; ?> ></i>
</div>