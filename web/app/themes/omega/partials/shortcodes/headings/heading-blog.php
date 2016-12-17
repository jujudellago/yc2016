<div class="col-md-12">
    <header class="blog-header small-screen-center <?php echo implode( ' ', $header_classes ); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s" <?php echo implode(' ', $parallax_data_attr); ?>>
        <<?php echo $header_type; ?> class="blog-header-title <?php echo implode( ' ', $headline_classes ); ?> " <?php echo $colour_override; ?>>
            <?php echo $content; ?>
        </<?php echo $header_type; ?>>
        <?php if( !empty( $sub_header ) ) : ?>
            <p class="<?php echo $sub_header_size; ?>" <?php echo $colour_override; ?>><?php echo $sub_header; ?></p>
        <?php endif; ?>

        <?php if ( !is_home() && oxy_get_option('blog_header_show_breadcrumbs') === 'show' ) :  ?>
            <ol class="breadcrumb breadcrumb-blog <?php echo oxy_get_option('blog_header_breadcrumbs_case'); ?>">
                <li>
                    <a href="<?php echo home_url(); ?>"><?php echo __( 'home', 'omega-td' ); ?></a>
                </li>
                <?php if(!is_search()): ?>
                    <li>
                        <a href="<?php
                            if( get_option( 'show_on_front' ) == 'page' ) :
                                echo get_permalink( get_option( 'page_for_posts' ) );
                            else :
                                echo home_url();
                            endif; ?>"><?php echo __( 'blog', 'omega-td' ); ?>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (is_category()) : ?>
                    <li>
                        <?php single_cat_title(); ?>
                    </li>
                <?php endif; ?>
                <?php if( is_single() ) : ?>
                    <li>
                        <?php the_category(', '); ?>
                    </li>
                    <li class="active">
                        <?php
                        $tit = the_title('','',FALSE);
                        echo substr($tit, 0, 35);
                        if (strlen($tit) > 35) echo " ...";
                        ?>

                    </li>
                <?php endif; ?>
                <?php if( is_day() ) : ?>
                    <li>
                        <a href="<?php echo get_year_link( get_the_time('Y') ); ?>">
                            <?php the_time('Y'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo get_month_link( get_the_time('F') ); ?>">
                            <?php the_time('F'); ?>
                        </a>
                    </li>
                    <li>
                        <?php the_time('jS'); ?>
                    </li>
                <?php endif; ?>
                <?php if( is_month() ) : ?>
                    <li>
                        <a href="<?php echo get_year_link( get_the_time('Y') ); ?>">
                            <?php the_time('Y'); ?>
                        </a>
                    </li>
                    <li>
                        <?php the_time('F'); ?>
                    </li>
                <?php endif; ?>
                <?php if( is_year() ) : ?>
                    <li>
                        <?php the_time('Y'); ?>
                    </li>
                <?php endif; ?>
                <?php if( is_tag() ) : ?>
                    <li>
                        <?php single_tag_title(); ?>
                    </li>
                <?php endif; ?>
                <?php if( is_author() ) : ?>
                    <li>
                        <?php
                        // get the author name
                        if( get_query_var('author_name') ) {
                            $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
                        }
                        else {
                            $author = get_userdata( get_query_var( 'author' ) );
                        }
                        the_author_meta( 'display_name', $author->ID );
                        ?>
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


