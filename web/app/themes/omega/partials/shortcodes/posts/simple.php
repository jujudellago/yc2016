 <div class="<?php echo implode(' ', $container_classes); ?>">
    <?php
    foreach($posts as $post):
        setup_postdata($post);
        $format = '-' . get_post_format();
        if( $format !== '-quote' && $format !== '-link' ) :
            $format = '';
        endif; ?>
        
        <div class="<?php echo implode( ' ', $classes ); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s">
        
        <?php include( locate_template( 'partials/blog/posts/related/post' . $format . '.php' ) ); ?>
        
        </div>
        <?php
        if( $scroll_animation_timing === 'staggered' ) :
                $scroll_animation_delay += $item_delay;
        endif;        
    endforeach; ?>
</div>