<ul class="list-unstyled row <?php echo $connected; ?> box-list">
<?php
foreach( $services as $post ) :
    setup_postdata($post);
    global $more;    // Declare global $more (before the loop).
    $more        = 0;
    $link        = oxy_get_slide_link( $post );
    $link_target = get_post_meta( $post->ID, THEME_SHORT. '_link_target', true ); ?>
    <li class="col-md-<?php echo $columns; ?>">
    <?php echo oxy_create_shaped_featured_image( $post, $image_shape, $image_size, $image_shadow === 'show', $link ); ?>
    <?php
    if( 'show' === $show_titles ) : ?>
        <h3 class="text-center">
        <?php
        if( 'on' === $link_titles ) : ?>
            <a href="<?php echo $link; ?>">
        <?php
        endif; ?>
            <?php the_title(); ?>
        <?php
        if( 'on' === $link_titles ) : ?>
            </a>
        <?php
        endif; ?>
        </h3>
    <?php
    endif; ?>
    <?php
    if( 'show' === $show_excerpts ) : ?>
        <p class="text-<?php echo $align; ?>">
        <?php echo get_the_excerpt(); ?>
        </p>
    <?php
    endif; ?>
    <?php
    if( 'show' === $show_readmores ) : ?>
        <a href="<?php echo $link ?>" class="more-link text-<?php echo $align; ?>" targets="<?php echo $link_target; ?>">
        <?php echo $readmore_text; ?>
        </a>
    <?php
    endif ?>
    </li>
<?php
endforeach; ?>
</ul>