<?php
$indicator = 0;
$id = 'carousel'. rand(1,100); ?>

<div class="carousel slide <?php echo implode(' ', $classes); ?>" id="<?php echo $id; ?>" data-ride="carousel" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s">
    <ol class="carousel-indicators"><?php
    $active = 'class="active"'; ?>
    <!-- Controls -->
    <?php if ($directionnav == 'show') {
	    while( $indicator < $items_count): ?>
	        <li data-target="#<?php echo $id; ?>" data-slide-to="<?php echo $indicator++; ?>"<?php echo $active; ?>></li><?php
	        $active = '';
	    endwhile;
    } ?>
    </ol><?php
    $active = 'active'; ?>
    <div class="carousel-inner"> <?php
    foreach ($items as $item) : ?>
        <div class="item <?php echo $active; ?>"><?php
    	$active = '';
        global $post;
    	$post = $item;
        setup_postdata( $post );
        $link_target = oxy_get_slide_link( $post );
        // get link
        $link = oxy_get_slide_link( $post );
        if (!empty($link)): ?>
            <a href="<?php echo $link; ?>" target="<?php echo $link_target; ?>"><?php
        endif;
        echo get_the_post_thumbnail();
        if ($captions == 'show') { ?>
        	<div class="carousel-caption">
			    <h3><?php  echo get_the_title($post->ID); ?></h3>
			    <p><?php  echo $post->post_content; ?></p>
			</div>
        <?php }
        if (!empty($link)): ?>
            </a>
        <?php endif; ?>
        </div><?php
    endforeach; ?>
    </div>
    <!-- Navigation Arrows -->
    <?php
    if ($showcontrols == 'show') { ?>
    	<a class="left carousel-control" href="#<?php echo $id; ?>" data-slide="prev">
    	<span class="fa fa-chevron-left"></span>
    	</a>
	    <a class="right carousel-control" href="#<?php echo $id; ?>" data-slide="next">
	    	<span class="fa fa-chevron-right"></span>
	  	</a><?php
    }?>
</div>