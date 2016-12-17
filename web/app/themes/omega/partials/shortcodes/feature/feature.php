<li class="<?php echo implode( ' ', $classes ); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s">
    <?php if( $show_icon === 'show' && ( !empty( $fa_icon ) || !empty( $svg_icon ) ) ) : ?>
        <div class="features-list-icon box-animate" style="background-color:<?php echo $background_color; ?>;stroke:<?php echo $icon_color; ?>;" data-animation="<?php echo $animation; ?>">
            <?php if( !empty( $fa_icon ) ) : ?>
                <i class="fa fa-<?php echo $fa_icon; ?>" style="color:<?php echo $icon_color; ?>;"></i>
            <?php elseif( !empty( $svg_icon ) ) : ?>
                <?php include OXY_THEME_DIR . 'assets/images/svg/' . $svg_icon . '.svg'; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <h3>
        <?php echo $title; ?>
    </h3>
    <p>
        <?php echo $content; ?>
    </p>
</li>