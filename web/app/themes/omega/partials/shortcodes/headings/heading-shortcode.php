<header class="<?php echo implode( ' ', $header_classes ); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s" <?php echo implode(' ', $parallax_data_attr); ?>>
    <<?php echo $header_type; ?> class="<?php echo implode( ' ', $headline_classes ); ?>"<?php echo $colour_override; ?> >
        <?php echo $content; ?>
    </<?php echo $header_type; ?>>
    <?php if( !empty( $sub_header ) ) : ?>
        <p class="<?php echo $sub_header_size; ?>"<?php echo $colour_override; ?> ><?php echo $sub_header; ?></p>
    <?php endif; ?>
</header>
