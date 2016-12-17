<div class="<?php echo implode( ' ', $classes ); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s">
    <?php if( 'show' === $show_image ) : ?>
        <div class="box <?php echo implode( ' ', $figure_classes ); ?>">
            <div class="box-dummy"></div>
            <?php if( !empty( $link ) && 'on' === $link_image ) : ?>
                <a class="box-inner <?php echo implode( ' ', $overlay_classes ); ?>" href="<?php echo $link; ?>" target="<?php echo $link_target; ?>" style="background-color:<?php echo $background_colour; ?>;">
            <?php else : ?>
                <div class="box-inner <?php echo implode( ' ', $overlay_classes ); ?>" style="background-color:<?php echo $background_colour; ?>;">
            <?php endif; ?>
            <div class="box-animate" data-animation="<?php echo $animation; ?>" style="stroke:<?php echo $icon_colour; ?>;">
                <?php if( !empty( $svg_icon ) ) : ?>
                    <?php include OXY_THEME_DIR . 'assets/images/svg/' . $svg_icon . '.svg'; ?>
                <?php elseif( !empty( $image_src ) ) : ?>
                    <img src="<?php echo $image_src; ?>" />
                <?php endif; ?>
                <?php if( !empty( $fa_icon ) ) : ?>
                    <i class="fa fa-<?php echo $fa_icon; ?>" style="color:<?php echo $icon_colour; ?>;"></i>
                <?php endif; ?>
            </div>
            <?php if( !empty( $link ) && 'on' === $link_image ) : ?>
                </a>
            <?php else : ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <?php if( 'show' === $show_title ) : ?>
        <h3 class="<?php echo implode( ' ' , $header_classes ); if( !empty( $link ) && 'on' === $link_title ) { echo ' bordered-link'; } ?> ">
            <?php if( !empty( $link ) && 'on' === $link_title ) : ?>
                <a href="<?php echo $link; ?>" target="<?php echo $link_target; ?>">
            <?php endif; ?>
            <?php the_title(); ?>
            <?php if( !empty( $link ) && 'on' === $link_title ) : ?>
                </a>
            <?php endif; ?>
        </h3>
    <?php endif; ?>
    <?php if( 'show' === $show_excerpt ) : ?>
        <p><?php echo get_the_excerpt(); ?></p>
    <?php endif; ?>
    <?php if( !empty( $link ) && 'show' === $show_readmore ) : ?>
        <a href="<?php echo $link ?>" class="more-link text-<?php echo $align; ?>" target="<?php echo $link_target; ?>">
        <?php echo $readmore_text; ?>
        </a>
    <?php
    endif ?>

</div>