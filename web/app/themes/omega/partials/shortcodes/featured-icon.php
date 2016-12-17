<div class="box <?php echo implode( ' ', $classes ); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s">
    <div class="box-dummy"></div>
    <?php if( !empty( $link ) ) : ?>
        <a class="box-inner <?php echo implode( ' ', $link_classes ); ?> <?php echo implode( ' ', $overlay_classes ); ?>" href="<?php echo $link; ?>" style="background-color:<?php echo $background_colour; ?>">
    <?php else : ?>
        <div class="box-inner <?php echo implode( ' ', $overlay_classes ); ?>" style="background-color:<?php echo $background_colour; ?>">
    <?php endif; ?>
    <div class="box-animate" data-animation="<?php echo $animation; ?>">
        <i class="fa fa-<?php echo $icon; ?>" style="color:<?php echo $icon_colour; ?>;"></i>
    </div>
    <?php if( !empty( $link ) ) : ?>
        </a>
    <?php else : ?>
        </div>
    <?php endif; ?>
</div>