<div class="figure <?php echo implode( ' ', $figure_classes ); ?> <?php echo $image_stretch  ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s">
    <?php if( !empty( $hover_link ) ) : ?>
        <a href="<?php echo $hover_link; ?>" class="figure-image <?php echo implode( ' ', $hover_link_classes ); ?> image-all" data-links="<?php echo implode( ',', $gallery_images ); ?>" target="<?php echo $link_target; ?>">
    <?php else : ?>
        <span class="figure-image">
    <?php endif; ?>

    <?php echo $img_html; ?>
    <?php if( $overlay !== 'none' ) : ?>
    <div class="figure-overlay <?php echo implode( ' ', $overlay_classes ); ?>">
        <div class="figure-overlay-container">
            <?php if( $overlay === 'caption' || $overlay === 'strip' ) : ?>
                <div class="figure-caption">
                    <h3 class="figure-caption-title bordered bordered-small"><?php echo $caption_title; ?></h3>
                    <p class="figure-caption-description"><?php echo $caption_text; ?></p>
                </div>
            <?php elseif( $overlay === 'icon' ) : ?>
                <span class="figure-icon">
                    <?php include OXY_THEME_DIR . 'assets/images/svg/' . $overlay_icon . '.svg'; ?>
                </span>
            <?php elseif( $overlay === 'buttons' || $overlay === 'buttons_only' ) : ?>
                <div class="figure-caption">
                    <?php if( $overlay === 'buttons' ) : ?>
                        <h4 class="figure-caption-title element-small-bottom bordered bordered-small"><?php echo $caption_title; ?></h4>
                    <?php endif; ?>
                    <p class="figure-caption-description">
                        <a href="<?php echo $magnific_link_url; ?>" class="btn btn-primary btn-sm <?php echo implode( ' ', $magnific_link_classes ); ?> image-all" data-links="<?php echo implode( ',', $gallery_images ); ?>"><?php echo $button_text_zoom; ?></a>
                        <a href="<?php echo $link; ?>" class="btn btn-primary btn-sm" target="<?php echo $link_target; ?>"><?php echo $button_text_details; ?></a>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if( !empty( $hover_link ) ) : ?>
        </a>
    <?php else : ?>
        </span>
    <?php endif; ?>

<?php if( $captions_below === 'show' ) : ?>
    <div class="figure-caption text-<?php echo $caption_align; ?>">
        <h3 class="figure-caption-title bordered bordered-small <?php if( !empty( $below_title_link ) ) { echo 'bordered-link'; } ?>">
            <?php if( !empty( $below_title_link ) ) : ?>
                <a href="<?php echo $below_title_link; ?>" class="<?php echo implode( ' ', $below_title_link_classes ); ?>" data-links="<?php echo implode( ',', $gallery_images ); ?>" target="<?php echo $link_target; ?>">
            <?php endif; ?>
            <?php echo $caption_title; ?>
            <?php if( !empty( $below_title_link ) ) : ?>
                </a>
            <?php endif; ?>
        </h3>
        <p class="figure-caption-description"><?php echo $caption_text; ?></p>
    </div>
<?php endif; ?>
</div>