<div id="<?php echo $id ?>" class="flexslider <?php echo implode(' ', $classes); ?>" <?php echo implode(' ', $data); ?> data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s" >
    <ul class="slides">
    <?php foreach ($items as $item) : ?>
        <li>
        	<?php 
            if( $item->post_type == 'attachment' ) :
            	include( locate_template( 'partials/shortcodes/flexslider/slide-attachment.php' ) );
            else :
				include( locate_template( 'partials/shortcodes/flexslider/slide-post.php' ) );
            endif; ?>
        </li>
    <?php endforeach; ?>
    </ul>
</div>
