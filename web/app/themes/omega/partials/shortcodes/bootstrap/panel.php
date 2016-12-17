<div class="panel <?php echo implode( ' ', $classes ); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s">
    <div class="panel-heading">
        <h3 class="panel-title">
            <?php echo $title; ?>
        </h3>
    </div>
    <div class="panel-body">
        <?php echo do_shortcode( $content ) ?>
    </div>
</div>