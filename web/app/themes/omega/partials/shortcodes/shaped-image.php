<div class="box <?php echo implode( ' ', $classes ); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s">
    <div class="box-dummy"></div>
    <?php if( !empty( $link ) ) : ?>
        <a class="box-inner <?php echo implode( ' ', $link_classes ); ?> <?php echo implode( ' ', $overlay_classes ); ?>" href="<?php echo $link; ?>" target="<?php echo $link_target; ?>" style="background-color:<?php echo $background_colour; ?>;">
    <?php else : ?>
        <div class="box-inner <?php echo implode( ' ', $overlay_classes ); ?>" style="background-color:<?php echo $background_colour; ?>;">
    <?php endif; ?>
    <div class="box-animate" data-animation="<?php echo $animation; ?>">
        <img src="<?php echo $src; ?>" <?php echo $alt; ?> <?php echo $title; ?>  />
    </div>
    <?php if( !empty( $link ) ) : ?>
        </a>
    <?php else : ?>
        </div>
    <?php endif; ?>
</div>