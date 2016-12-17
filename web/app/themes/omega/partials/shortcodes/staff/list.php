<div class="<?php echo implode( ' ', $container_classes ); ?>"><?php
    global $post;
    foreach ($posts as $index => $post) :
        setup_postdata($post);    	
        include( locate_template( 'partials/shortcodes/staff/single.php' ) );

        if( $item_scroll_animation_timing === 'staggered' ) :
                $scroll_animation_delay += $item_delay;
        endif;
    endforeach; ?>
</div>