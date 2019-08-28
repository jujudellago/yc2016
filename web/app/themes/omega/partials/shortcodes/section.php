<section class="section <?php echo implode(' ', $section_classes); ?>"<?php echo $section_id; ?> <?php echo implode(' ', $color_set_attr); ?> data-label="<?php echo $label; ?>">
    <?php if( $has_media ) : ?>
        <div class="background-media" style="<?php echo $background_media_style; ?>" <?php echo implode(' ', $parallax_data_attr); ?>>
            <?php if( $has_video ) : ?>
                <video autoplay muted loop style="width: 100%; height: 100%;" class="section-background-video">
                <?php if( $background_video_mp4): ?>
                    <source type="video/mp4" src="<?php echo $background_video_mp4; ?>"/>
                <?php endif; ?>
                <?php if( $background_video_webm): ?>
                    <source type="video/webm" src="<?php echo $background_video_webm; ?>"/>
                <?php endif; ?>
                </video>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="background-overlay grid-overlay-<?php echo $overlay_grid; ?> " style="background-color: <?php echo $overlay_colour; ?>;"></div>

    <div class="<?php echo $container_class; ?>">
        <div class="row <?php echo $row_class; ?>">
            <?php echo do_shortcode( $content ); ?>
        </div>
    </div>
</section>
