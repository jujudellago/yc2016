
<header class="portfolio-header col-md-12 <?php echo implode( ' ', $header_classes ); ?>" data-os-animation="<?php echo $scroll_animation; ?>" data-os-animation-delay="<?php echo $scroll_animation_delay; ?>s" <?php echo implode(' ', $parallax_data_attr); ?>>
    <<?php echo $header_type; ?> class="portfolio-header-title <?php echo implode( ' ', $headline_classes ); ?>">
        <?php echo $content; ?>
    </<?php echo $header_type; ?>>
    <?php if( !empty( $sub_header ) ) : ?>
        <p class="<?php echo $sub_header_size; ?>"><?php echo $sub_header; ?></p>
    <?php endif; ?>

    <nav class="portfolio-nav">
        <ul>
            <?php $prev = get_adjacent_post( false, '', true ); ?>
            <?php if( !empty( $prev ) ) : ?>
                <li>
                    <a data-original-title="<?php echo $prev->post_title; ?>" data-toggle="tooltip" data-placement="top" href="<?php echo get_permalink($prev->ID); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                            <g>
                                <polyline fill="none" stroke-width="2" stroke-miterlimit="10" points="68.692,16.091 33.146,50 68.692,83.906   "/>
                            </g>
                        </svg>
                    </a>
                </li>
            <?php endif; ?>
            <?php $page = oxy_get_option( 'portfolio_page' ); ?>
            <?php if( !empty( $page ) ) : ?>
                <li>
                    <a data-original-title="<?php _e('Back to portfolio', 'omega-td'); ?>" data-toggle="tooltip" data-placement="top" href="<?php echo get_permalink($page); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                                <g>
                                    <rect x="15.958" y="15" fill="none" stroke-width="2" stroke-miterlimit="10" width="70" height="70"/>
                                    <line fill="none" stroke-width="2" stroke-miterlimit="10" x1="15.958" y1="61.655" x2="85.958" y2="61.655"/>
                                    <line fill="none" stroke-width="2" stroke-miterlimit="10" x1="15.958" y1="38.345" x2="85.958" y2="38.345"/>
                                    <line fill="none" stroke-width="2" stroke-miterlimit="10" x1="62.632" y1="15" x2="62.632" y2="85"/>
                                    <line fill="none" stroke-width="2" stroke-miterlimit="10" x1="39.286" y1="15" x2="39.286" y2="85"/>
                                </g>
                        </svg>
                    </a>
                </li>
            <?php endif; ?>
            <?php $next = get_adjacent_post( false, '', false ); ?>
            <?php if( !empty( $next ) ) : ?>
                <li>
                    <a data-original-title="<?php echo $next->post_title; ?>" data-toggle="tooltip" data-placement="top" href="<?php echo get_permalink($next->ID); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                            <g>
                                <polyline fill="none" stroke-width="2" stroke-miterlimit="10" points="33.146,16.091 68.692,50
                                    33.146,83.906   "/>
                            </g>
                        </svg>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>


