<div class="list-container <?php echo implode( ' ', $wrapper_classes ); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s"><?php
	// consistent data for all service items
	$img_size = $image_shape === 'round' ? 'square-image' : $image_shape . '-image';
	$overlay_classes = array( 'grid-overlay-' . $overlay_grid );
	$figure_classes = array( 'box-' . $image_shape );
    if( $image_size != 'none' ) :
        $figure_classes[] = 'box-' . $image_size;
    endif;
    if( $icon_effect != 'on' ) :
        $figure_classes[] = 'box-simple';
    endif;

    $header_classes = array();
    $header_classes[] = $title_size;
    $header_classes[] = $title_weight;
    $header_classes[] = $title_underline;
    $header_classes[] = $title_underline_size;

    if( $icon_effect != 'on' ) {
        $figure_classes[] = 'box-simple';
    }
    $animation = $icon_animation;

	foreach( $services as $post ) :
        setup_postdata( $post );
        // get item data
        $fa_icon = get_post_meta( $post->ID, THEME_SHORT . '_fa_icon', true );
        $svg_icon = get_post_meta( $post->ID, THEME_SHORT . '_svg_icon', true );
        $link_target = get_post_meta( $post->ID, THEME_SHORT . '_target', true );

        // get link
        $link = oxy_get_slide_link( $post );
        $image_src = '';
        $featured_image_id = get_post_thumbnail_id( $post->ID );
        if( !empty( $featured_image_id ) ) :
            $image = wp_get_attachment_image_src( $featured_image_id, $img_size );
            if( isset( $image[0] ) ) :
                $image_src = $image[0];
            endif;
        endif;
        // add item classes
        $classes = array();
        $classes[] = 'text-' . $align;
        $classes[] = 'col-md-' . $columns;
        $classes[] = 'element-short-bottom';
        include( locate_template( 'partials/shortcodes/services/service.php' ) );
    endforeach; ?>
</div>