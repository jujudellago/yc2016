<?php
$custom_fields = get_post_custom($post->ID);
$position      = (isset($custom_fields[THEME_SHORT.'_position']))? $custom_fields[THEME_SHORT.'_position'][0]:'';
$caption_title = '<strong>' . get_the_title( $post->ID ) . '</strong>';
$item_link_target = get_post_meta( $post->ID, THEME_SHORT . '_target', true );

if( $show_position === 'show' ):
    $caption_title .= ' <span>'. $position . '</span>';
endif;

?>
<div class="<?php echo implode( ' ', $classes ); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s">

    <?php echo oxy_section_vc_single_image( array(
        'image'                    => get_post_thumbnail_id( $post->ID ),
        'size'                     => $item_size,
        'alt'                      => get_the_title( $post->ID ),
        'link'                     => oxy_get_slide_link( $post ),
        'link_target'              => $item_link_target,
        'item_link_type'           => $item_link_type,
        'captions_below'           => $item_captions_below,
        'captions_below_link_type' => $captions_below_link_type,
        'caption_title'            => $caption_title,
        'caption_text'             => get_the_excerpt(),
        'caption_align'            => $item_caption_align,
        'hover_filter'             => $item_hover_filter,
        'hover_filter_invert'      => $hover_filter_invert,
        'overlay'                  => $item_overlay,
        'overlay_caption_vertical' => $item_caption_vertical,
        'overlay_animation'        => $item_overlay_animation,
        'overlay_grid'             => $item_overlay_grid,
        'overlay_icon'             => $item_overlay_icon,
        'margin_top'               => 'no-top',
        'margin_bottom'            => 'no-bottom',
        'scroll_animation'         => 'none',
        'scroll_animation_delay'   => 0,
        'portfolio_item'           => false,
    ));

    if( $show_social === 'show' ): ?>
        <ul class="social-icons element-short-top element-short-bottom text-<?php echo $item_caption_align; ?>">  <?php
        for( $i = 0; $i < 5; $i++):
            $icon = (isset($custom_fields[THEME_SHORT . '_icon'.$i]))? $custom_fields[THEME_SHORT . '_icon'.$i][0]:'';
            $url  = (isset($custom_fields[THEME_SHORT . '_link'.$i]))? $custom_fields[THEME_SHORT . '_link'.$i][0]:'';
            if($url !== ''): ?>
                <li>
                    <a href="<?php echo esc_url($url); ?>" target="<?php echo esc_attr($item_link_target); ?>" data-iconcolor="<?php echo esc_attr(oxy_get_icon_color($icon)); ?>">
                        <i class="fa fa-<?php echo $icon; ?>"></i>
                    </a>
                </li><?php
            endif;
        endfor; ?>
        </ul><?php
    endif; ?>

</div>