 <div class="<?php echo implode( ' ', $container_classes ); ?>" data-padding="<?php echo $masonry_items_padding; ?>" data-col-xs="1" data-col-sm="2" data-col-md="4" data-col-lg="4"><?php
    $masonry_count = 0;
    foreach( $posts as $post ):
        setup_postdata( $post );
        $format = '-' . get_post_format();
        if( $format !== '-quote' && $format !== '-link' ) :
            $format = '';
        endif;

        include( locate_template( 'partials/blog/posts/masonry/post' . $format . '.php' ) );

        if( $scroll_animation_timing === 'staggered' ) :
                $scroll_animation_delay += $item_delay;
        endif;
        $masonry_count++;
    endforeach;?>
</div>