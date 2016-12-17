<div class="col-md-12">
    <header class="<?php echo implode( ' ', $header_classes ); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s" <?php echo implode(' ', $parallax_data_attr); ?>>
        <<?php echo $header_type; ?> class="<?php echo implode( ' ', $headline_classes ); ?>" <?php echo $colour_override; ?> >
            <?php echo $content; ?>
        </<?php echo $header_type; ?>>
        <?php if( !empty( $sub_header ) ) : ?>
            <p class="<?php echo $sub_header_size; ?>" <?php echo $colour_override; ?> ><?php echo $sub_header; ?></p>
        <?php endif; ?>

        <?php if ( !is_home() && oxy_get_option('page_header_show_breadcrumbs') === 'show' ) :  ?>
            <ol class="breadcrumb breadcrumb-blog <?php echo oxy_get_option('page_header_breadcrumbs_case'); ?>">
                <li>
                    <a href="<?php echo home_url(); ?>"><?php echo __( 'home', 'omega-td' ); ?></a>
                </li>
                <?php if (is_page()) :
                    global $post;
                    $ancestors = get_post_ancestors( $post );
                    foreach ($ancestors as $ancestor) {
                        $parent_post = get_post($ancestor);
                        $parent_title = $parent_post->post_title;  ?>
                        <li>
                            <a href="<?php echo get_permalink($ancestor); ?>">
                                <?php echo $parent_title; ?>
                            </a>
                        </li><?php
                    } ?>
                    <li>
                        <?php echo $post->post_title; ?>
                    </li>
                <?php endif; ?>
                <?php if( is_search() ) : ?>
                    <li>
                        <?php echo __('Results for ', 'omega-td'). get_search_query();  ?>
                    </li>
                <?php endif; ?>
            </ol>
        <?php endif; ?>
    </header>
</div>
