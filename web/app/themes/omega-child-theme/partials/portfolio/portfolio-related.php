<?php
/**
 * Shows related posts
 *
 * @package Omega
 * @subpackage Frontend
 * @since 1.3
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.9.0
 */

// get related posts excluding this one.
$cats = wp_get_post_terms( $post->ID, 'oxy_portfolio_categories' );
$related_text = oxy_get_option( 'related_portfolio_text' );

if( !empty( $cats ) ) :
    $args = array(
        'post_type' => 'oxy_portfolio_image',
        'numberposts' => oxy_get_option( 'related_portfolio_count' ),
        'post__not_in' => array($post->ID),
        'orderby' => 'rand',
        'tax_query' => array(
            array(
                'taxonomy' => 'oxy_portfolio_categories',
                'field' => 'slug',
                'terms' => $cats[0]->slug
            )
        )
    );

    $columns = intval( oxy_get_option( 'related_portfolio_columns' ) );
    $span_width = $columns > 0 ? floor( 12 / $columns ) : 12;

    $posts = get_posts($args);
endif; ?>

<?php if( $posts ) : ?>

    <section class="section portfolio-related <?php echo oxy_get_option('related_portfolio_swatch'); ?>">
        <div class="container">
            <div class="row element-medium-top element-medium-bottom">
                <?php if (!empty($related_text)) : ?>
                    <header class="text-center element-no-top element-short-bottom not-condensed">
                        <h2 class="bigger hairline bordered bordered-normal <?php echo oxy_get_option('related_portfolio_text_weight'); ?>">
                            <?php echo $related_text; ?>
                        </h3>
                    </header>
                <?php endif ?>
                <?php
                foreach ($posts as $related_post) :
                    global $post;
                    $post = $related_post; ?>
                    <div class="col-md-<?php echo $span_width; ?> col-sm-<?php echo $span_width; ?>">
                        <?php
                            global $more;    // Declare global $more (before the loop).

                            setup_postdata( $post );
                            $more = 0;
                            // get post format ( only interested in quote / link rest use standard )
                            $format = get_post_format( $post );
                            if( 'quote' !== $format && 'link' !== $format ) {
                                $format = '';
                            }
                            get_template_part( 'partials/blog/posts/related/post', $format );
                        ?>
                    </div>
                <?php endforeach; ?>
            </div>

    </section>

<?php endif;
