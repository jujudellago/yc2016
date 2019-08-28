<?php
/**
 * Themes shortcode functions go here
 *
 * @package Omega
 * @subpackage Core
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.18.12
 */

/****************** VISUAL COMPOSER SHORTCODES *******************************/
function oxy_shortcode_section( $atts , $content = '') {
    extract( shortcode_atts( array(
        'swatch'                          => 'swatch-white',
        'section_color_set'               => '',
        'color_speed'                     => '2000',
        'color_duration'                  => '4000',
        'text_shadow'                     => 'no-shadow',
        'inner_shadow'                    => 'no-shadow',
        'width'                           => 'padded',
        'class'                           => '',
        'id'                              => '',
        'label'                           => '',
        'overlay_colour'                  => '#000000',
        'overlay_opacity'                 => '0',
        'overlay_grid'                    => '0',
        'background_video_mp4'            => '',
        'background_video_webm'           => '',
        'background_image'                => '',
        'background_image_mobile'         => '',
        'background_image_size'           => 'cover',
        'background_image_repeat'         => 'no-repeat',
        'background_image_attachment'     => 'no-scroll',
        'background_position_vertical'    => '0',
        'background_image_parallax'       => 'off',
        'background_image_parallax_start' => '0',
        'background_image_parallax_end'   => '-80',
        'height'                          => 'normal',
        'transparency'                    => 'opaque',
        'vertical_alignment'              => 'top'
    ), $atts ) );

    global $oxy_is_iphone, $oxy_is_ipad, $oxy_is_android;

    $has_video = ( !empty( $background_video_mp4 ) || !empty( $background_video_webm ) ) && ( !$oxy_is_iphone && !$oxy_is_ipad  && !$oxy_is_android || oxy_get_option( 'mobile_videos' ) === 'on' );
    $has_media = !empty( $background_image ) || $has_video || ( !empty( $background_image_mobile ) && ( $oxy_is_iphone || $oxy_is_ipad  || $oxy_is_android ) );

    $section_id = $id == '' ? '' : ' id="' . $id . '"';

    // Fetching the colour sets
    $color_set_attr = array();
    if( !empty( $section_color_set ) ) {
        $colors = array();
        $colors = get_post_meta( $section_color_set, THEME_SHORT . '_color_set', true );
        // we need at least one colour to be enabled
        if( !empty( $colors ) ){
            // set background colour to first colour in the array
            $color_set_attr[] = 'style="background-color:' . $colors[0] . ';"';
            // move first colour to end of array
            $color = array_shift( $colors );
            array_push( $colors, $color );
            $color_set_attr[] = 'data-color-set="' . implode(',', $colors) . '"';
            $color_set_attr[] = 'data-color-speed="' . $color_speed . '"';
            $color_set_attr[] = 'data-color-duration="' . $color_duration . '"';
        }
    }

    $section_classes = array();
    $section_classes[] = $swatch;
    $section_classes[] = $class;
    $section_classes[] = 'section-text-' . $text_shadow;
    $section_classes[] = 'section-inner-' . $inner_shadow;
    $section_classes[] = 'section-' . $height;
    $section_classes[] = 'section-' . $transparency;

    $background_image_url = '';
    if( is_numeric( $background_image_mobile ) && ( $oxy_is_iphone || $oxy_is_ipad  || $oxy_is_android ) ){
        $attachment_image = wp_get_attachment_image_src( $background_image_mobile, 'full' );
        $background_image_url = $attachment_image[0];
    }
    else if( is_numeric( $background_image ) ) {
         $attachment_image = wp_get_attachment_image_src( $background_image, 'full' );
         $background_image_url = $attachment_image[0];
    }
    else {
        $background_image_url = $background_image;
    }

    $background_media_style = ( $has_media ) ? 'background-image: url(\''. $background_image_url .'\'); background-repeat:'. $background_image_repeat .'; background-size:'.$background_image_size.'; background-attachment:'. $background_image_attachment.'; background-position: 50% '. $background_position_vertical.'%;': "";

    // create parallax data attributes if needed
    $parallax_data_attr = array();
    if( 'on' === $background_image_parallax ) {
        $offset_y = 0;
        if( 'navbar-sticky' === oxy_get_option( 'header_type' ) ) {
            $offset_y = oxy_get_option('navbar_scrolled');
        }
        $parallax_data_attr[] = 'data-start="background-position: 50% ' . $background_image_parallax_start . 'px"';
        $parallax_data_attr[] = 'data-' . $offset_y . '-top-bottom="background-position: 50% ' . $background_image_parallax_end . 'px"';
    }

    $container_class = $width == 'padded' ? 'container' : 'container-fullwidth';
    $row_class = 'vertical-' . $vertical_alignment;

    $overlay_colour = oxy_hex2rgba( $overlay_colour, $overlay_opacity );

    ob_start();
    include( locate_template( 'partials/shortcodes/section.php' ) );
    $output = ob_get_contents();
    ob_end_clean();

    if( class_exists('WPBakeryVisualComposerAbstract') ) {
        $class = Vc_Shortcodes_Manager::getInstance()->getElementClass('vc_row');
        // Filter for overriding output
        $output = apply_filters( 'vc_shortcode_output', $output, $class, $atts );
    }
    return $output;
}
add_shortcode( 'vc_row', 'oxy_shortcode_section' );

/**
 * Creates a section header ( used in page header sections and section headers )
 *
 * @return shortcode HTML
 **/
function oxy_section_heading( $options, $content = '' ) {
    extract( shortcode_atts( array(
        'sub_header'            => '',
        'header_type'           => 'h1',
        'section_swatch_override' => 'off',
        'heading_colour'        => '',
        'sub_header_size'       => 'normal',
        'header_size'           => 'normal',
        'header_weight'         => 'regular',
        'header_align'          => 'left',
        'header_condensed'      => 'not-condensed',
        'header_underline'      => 'no-bordered-header',
        'header_underline_size' => 'bordered-normal',
        'heading_type'          => 'shortcode',
        'header_fade_out'       => 'off',
        'extra_classes'         => '',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $options ) );

    $header_classes = array();
    $header_classes[] = 'text-' . $header_align;
    $header_classes[] = $extra_classes;
    $header_classes[] = 'element-' . $margin_top;
    $header_classes[] = 'element-' . $margin_bottom;
    $header_classes[] = $header_condensed;
    if( $scroll_animation !== 'none' ) {
        $header_classes[] = 'os-animation';
    }
    // Adding inline style if we want to override the section swatch
    $colour_override = $section_swatch_override == 'on' ?  'style="color:'.$heading_colour.';"' : '';

    $headline_classes = array();
    $headline_classes[] = $header_size;
    $headline_classes[] = $header_weight;
    $headline_classes[] = $header_underline;
    $headline_classes[] = $header_underline_size;

    $parallax_data_attr = array();
    if ( 'on' === $header_fade_out ) {
        $fade_y = 0;
        if( 'navbar-sticky' === oxy_get_option( 'header_type' ) ) {
            $fade_y = oxy_get_option('navbar_scrolled');
        }
        $parallax_data_attr[] = 'data-start="opacity:1"';
        $parallax_data_attr[] = 'data-center="opacity:1"';
        $parallax_data_attr[] = 'data-' . $fade_y . '-top-bottom="opacity:0"';
    }
    ob_start();
    include( locate_template( 'partials/shortcodes/headings/heading-' . $heading_type . '.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'heading', 'oxy_section_heading' );

/**
 * Creates an Inner Row ( rendered when a user adds a nested row )
 *
 * @return shortcode HTML
 **/
function oxy_section_vc_row_inner( $atts, $content ) {
    extract( shortcode_atts( array(
        'extra_classes' => ''
    ), $atts ) );

    $output = '<div class="row ' . $extra_classes . '">';
    $output .= do_shortcode( $content );
    $output .= '</div>';

    if( class_exists('WPBakeryVisualComposerAbstract') ) {
        $class = Vc_Shortcodes_Manager::getInstance()->getElementClass('vc_row_inner');
        // Filter for overriding output
        $output = apply_filters( 'vc_shortcode_output', $output, $class, $atts );
    }
    return $output;
}
add_shortcode( 'vc_row_inner', 'oxy_section_vc_row_inner' );

/**
 * Handles VC columns
 *
 * @return shortcode HTML
 **/
function oxy_section_vc_column( $atts, $content ) {
    extract( shortcode_atts( array(
        'width'                  => '1/1',
        'column_colour'          => '',
        'extra_classes'          => '',
        'align'                  => 'default',
        'align_sm'               => 'default',
        'xs_col'                 => 'default',
        'sm_col'                 => 'default',
        'lg_col'                 => 'default',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ) );

    $fraction = array('whole' => 0);
    preg_match('/^((?P<whole>\d+)(?=\s))?(\s*)?(?P<numerator>\d+)\/(?P<denominator>\d+)$/', $width, $fraction);
    $decimal_width = (int) $fraction['whole'] + (int) $fraction['numerator'] / (int) $fraction['denominator'];
    $col_width_class = ($decimal_width * 12);
    $col_width_class = str_replace('.', '-', $col_width_class);
    $col_md_width_class = 'col-md-' . $col_width_class;

    $column_classes = array();
    $column_attrs = array();
    $column_classes[] = $col_md_width_class;
    // default behaviour for xs screens, always full width
    $column_classes[] = $xs_col == 'default' || $xs_col == '12' ? '' : 'col-xs-' . $xs_col;
    $column_classes[] = $sm_col == 'default' || $sm_col == '12' ? '' : 'col-sm-' . $sm_col;
    $column_classes[] = $lg_col == 'default' || $lg_col == '12' ? '' : 'col-lg-' . $lg_col;
    $column_classes[] = $extra_classes;
    $column_classes[] = 'text-' . $align;
    $column_classes[] = 'small-screen-' . $align_sm;
    if( $scroll_animation !== 'none' ) {
        $column_classes[] = 'os-animation';
        $column_attrs[] = 'data-os-animation="' . $scroll_animation . '"';
        $column_attrs[] = 'data-os-animation-delay="' . $scroll_animation_delay . 's"';
    }
    // background color of the column
    $column_colour = empty($column_colour) ? '' : 'style="background:' . $column_colour . ';"';

    $output = '<div class="' . implode( ' ', $column_classes ) . '" ' . implode( ' ', $column_attrs) . ' ' . $column_colour . '>';
    $output .= do_shortcode( $content );
    $output .= '</div>';

    return $output;
}
add_shortcode( 'vc_column', 'oxy_section_vc_column' );
add_shortcode( 'vc_column_inner', 'oxy_section_vc_column' );

/**
 * Handles VC column text
 *
 * @return shortcode HTML
 **/
function oxy_section_vc_column_text( $atts, $content ) {
    extract( shortcode_atts( array(
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ) );

    $classes = array();
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }

    // removed wrongly placed p tags and insert them again after entering some newlines
    $content = wpautop(preg_replace('/<\/?p\>/', "\n", $content)."\n");
    $content = do_shortcode( $content );

    ob_start();
    include( locate_template( 'partials/shortcodes/column-text.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'vc_column_text', 'oxy_section_vc_column_text' );

/**
 * Handles VC separator
 *
 * @return <hr> HTML
 **/
function oxy_section_vc_separator( $atts, $content ) {
    return '<hr>';
}
add_shortcode( 'vc_separator', 'oxy_section_vc_separator' );


/**
 * Handles VC image shortcode
 *
 * @return shortcode HTML
 **/
function oxy_section_vc_single_image($atts , $content = '') {
    // setup options
    extract( shortcode_atts( array(
        'image'                    => '',
        'size'                     => 'medium',
        'image_stretch'            => 'normalwidth',
        'alt'                      => '',
        'title'                    => '',
        'item_link_type'           => 'magnific',
        'link'                     => '',
        'link_target'              => '_self',
        'magnific_type'            => 'image',
        'magnific_link'            => '',
        'captions_below'           => 'hide',
        'captions_below_link_type' => 'item',
        'caption_title'            => '',
        'caption_text'             => '',
        'caption_align'            => 'center',
        'hover_filter'             => 'none',
        'hover_filter_invert'      => 'image-filter-onhover',
        'overlay'                  => 'icon',
        'button_text_zoom'         => 'View Larger',
        'button_text_details'      => 'More Details',
        'overlay_caption_vertical' => 'middle',
        'overlay_animation'        => 'fade-in',
        'overlay_grid'             => '0',
        'overlay_icon'             => 'plus',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'portfolio_item'         => 'false',
        'scroll_animation_delay' => '0',
    ), $atts ) );

    $src = '';
    $output = '';
    if( !empty( $image ) ) {
        $attachment = wp_get_attachment_image_src( $image, $size );

        if( isset( $attachment[0] ) ) {
            $src = $attachment[0];
        }
        $alt = !empty($alt) ? 'alt="' . $alt . '"' : '';
        $title = !empty($title) ? 'title="' . $title . '"' : '';

        $img_html = '<img src="' . $src . '" ' . $alt . ' ' . $title . ' class="' . $image_stretch . '" />';
        $img_html = apply_filters('post_thumbnail_html', $img_html, null, $image, $size, null);

        $figure_classes = array();
        $figure_classes[] = $extra_classes;
        $figure_classes[] = 'element-' . $margin_top;
        $figure_classes[] = 'element-' . $margin_bottom;
        if( $scroll_animation !== 'none' ) {
            $figure_classes[] = $portfolio_item === 'true'? 'portfolio-os-animation' : 'os-animation' ;
        }
        if( $overlay === 'strip' ) {
            $figure_classes[] = 'preview-bottom';
        }

        $figure_classes[] = 'image-filter-' . $hover_filter;
        $figure_classes[] = $hover_filter_invert;
        $figure_classes[] = $overlay_animation;
        $figure_classes[] = 'text-' . $caption_align;
        $figure_classes[] = 'figcaption-' . $overlay_caption_vertical;

        $overlay_classes = array( 'grid-overlay-' . $overlay_grid );

        // create magnific link
        $magnific_link_classes = array();
        $gallery_images = array();
        $magnific_link_url = '';
        switch( $magnific_type ) {
            case 'image':
                $full = wp_get_attachment_image_src( $image, 'full' );
                $magnific_link_url = $full[0];
                $magnific_link_classes[] = 'magnific';
            break;
            case 'video':
                $magnific_link_url = $magnific_link;
                $magnific_link_classes[] = 'magnific-vimeo';
            break;
            case 'gallery':
                if( !empty( $magnific_link ) && is_array( $magnific_link ) ) {
                    // ok lets create a gallery
                    foreach( $magnific_link as $gallery_image_id ) {
                        $gallery_image = wp_get_attachment_image_src( $gallery_image_id, 'full' );
                        $gallery_images[] = $gallery_image[0];
                    }

                    $full = wp_get_attachment_image_src( $image, 'full' );
                    $magnific_link_url = $full[0];
                    $magnific_link_classes[] = 'magnific-gallery';
                }
            break;
        }

        // set up links
        $hover_link_classes = array();
        $hover_link = '';
        // never set hover link if we are using buttons a inside a breaks the markup
        if( $overlay !== 'buttons' && $overlay !== 'buttons_only' ) {
            switch( $item_link_type ) {
                case 'magnific':
                case 'magnific-all':
                    $hover_link = $magnific_link_url;
                    $hover_link_classes = $magnific_link_classes;
                break;
                case 'item':
                    $hover_link = $link;
                break;
                case 'no-link':
                    // hover_link is default ''
                break;
            }
        }

        $below_title_link_classes = array();
        $below_title_link = '';
        switch( $captions_below_link_type ) {
            case 'magnific':
                $below_title_link = $magnific_link_url;
                $below_title_link_classes = $magnific_link_classes;
            break;
            case 'item':
                $below_title_link = $link;
            break;
            case 'no-link':
                // hover_link is default ''
            break;
        }

        ob_start();
        include( locate_template( 'partials/shortcodes/single-image.php' ) );
        $output = ob_get_contents();
        ob_end_clean();
    }
    return $output;
}
add_shortcode( 'vc_single_image', 'oxy_section_vc_single_image' );


/**
 * Handles VC shaped image shortcode
 *
 * @return shortcode HTML
 **/
function oxy_section_shapedimage($atts , $content = '') {
    // setup options
    extract( shortcode_atts( array(
        'image'             => '',
        'shape_size'        => 'medium',
        'shape'             => 'round',
        'animation'         => 'none',
        'magnific'          => 'off',
        'alt'               => '',
        'title'             => '',
        'link'              => '',
        'link_target'       => '_self',
        'overlay_grid'      => '0',
        'background_colour' => '#e9e9e9',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ) );

    $output = '';
    if( !empty( $image ) ) {
        // get image
        $image_size = $shape === 'round' ? 'square-image' : $shape . '-image';
        $attachment = wp_get_attachment_image_src( $image, $image_size );
        if( isset( $attachment[0] ) ) {
            $src = $attachment[0];
        }
        $alt = !empty($alt) ? 'alt="' . $alt . '"' : '';
        $title = !empty($title) ? 'title="' . $title . '"' : '';

        $classes = array( 'box-' . $shape );
        if( $shape_size != 'none' ) {
            $classes[] = 'box-' . $shape_size;
        }
        $classes[] = 'box-simple';
        $classes[] = $extra_classes;
        $classes[] = 'element-' . $margin_top;
        $classes[] = 'element-' . $margin_bottom;
        if( $scroll_animation !== 'none' ) {
            $classes[] = 'os-animation';
        }

        $link_classes = array();
        if( $magnific == 'on' ){
            $full = wp_get_attachment_image_src( $image, 'full' );
            $link = $full[0];
            $link_classes[] = 'magnific';
        }

        $overlay_classes = array( 'grid-overlay-' . $overlay_grid );

        ob_start();
        include( locate_template( 'partials/shortcodes/shaped-image.php' ) );
        $output = ob_get_contents();
        ob_end_clean();
    }

    return $output;
}
add_shortcode( 'shapedimage', 'oxy_section_shapedimage' );

/**
 * Handles VC tabs shortcode
 *
 * @return shortcode HTML
 **/
function oxy_shortcode_vc_tabs($atts , $content = '' ) {
    extract( shortcode_atts( array(
        'style'        => 'top',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ) );

    $classes = array();
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }

    // grab all tabs inside this tabs pane
    $pattern = get_shortcode_regex();
    $count = preg_match_all( '/'. $pattern .'/s', $content, $matches );
    if( is_array( $matches ) && array_key_exists( 2, $matches ) && in_array( 'vc_tab', $matches[2] ) ) {
        ob_start();
        include( locate_template( 'partials/shortcodes/bootstrap/tabs/tab_headers.php' ) );
        $tab_headers = ob_get_contents();
        ob_end_clean();
        ob_start();
        include( locate_template( 'partials/shortcodes/bootstrap/tabs/tab_contents.php' ) );
        $tab_contents = ob_get_contents();
        ob_end_clean();
        ob_start();
        include( locate_template( 'partials/shortcodes/bootstrap/tabs/tabs.php' ) );
        $output = ob_get_contents();
        ob_end_clean();
    }
    return $output;
}
add_shortcode( 'vc_tabs', 'oxy_shortcode_vc_tabs' );

/**
 * Handles VC tab shortcode
 *
 * @return shortcode HTML
 **/
function oxy_shortcode_vc_tab($atts , $content=''){

    return do_shortcode($content);
}
add_shortcode( 'vc_tab' , 'oxy_shortcode_vc_tab');

function oxy_shortcode_vc_accordion($atts , $content = '' ) {
    extract( shortcode_atts( array(
        'type' => 'primary',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ) );

    $id = 'accordion_'.rand(100,999);
    $pattern = get_shortcode_regex();
    $count = preg_match_all( '/'. $pattern .'/s', $content, $matches );

    $classes = array();
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }

    if( is_array( $matches ) && array_key_exists( 2, $matches ) && in_array( 'vc_accordion_tab', $matches[2] ) ) {
        ob_start();
        include( locate_template( 'partials/shortcodes/bootstrap/accordion.php' ) );
        $output = ob_get_contents();
        ob_end_clean();
    }

    return $output;
}
add_shortcode( 'vc_accordion', 'oxy_shortcode_vc_accordion' );

/**
 * Creates a boostrap accordion
 *
 * @return shortcode HTML
 **/
function oxy_shortcode_vc_accordion_tab($atts , $content=''){

    return do_shortcode($content);
}
add_shortcode( 'vc_accordion_tab' , 'oxy_shortcode_vc_accordion_tab');


/****************** TYPOGRAPHY SHORTCODES *******************************/

/**
 * Code shortcode - for showing code!
 *
 * @return Code html
 **/
function oxy_shortcode_code( $atts, $content = null) {
    extract( shortcode_atts( array(
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0'
    ), $atts ) );

    $classes = array();
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation ';
    }

    ob_start();
    include( locate_template( 'partials/shortcodes/code.php' ) );
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}
add_shortcode( 'code', 'oxy_shortcode_code' );


/**
 * Featured Icon shortcode - for showing a big icon in a shape
 *
 * @return Icon html
 **/
function oxy_shortcode_icon( $atts, $content = null) {
    extract( shortcode_atts( array(
        'size'       => '16',
    ), $atts ) );

    $output = '<i class="fa fa-' . $content . '"';
    if( $size !== 0 ) {
        $output .= ' style="font-size:' . $size . 'px"';
    }
    $output .= '></i>';
    return $output;
}
add_shortcode( 'icon', 'oxy_shortcode_icon' );

/**
 * Lead Paragraph shortcode
 *
 * @return Lead Paragraph HTML
 **/
function oxy_shortcode_lead( $atts, $content ) {
    extract( shortcode_atts( array(
        'align'  => 'center',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0'

    ), $atts ) );
    $classes = array();
    $classes[] = $align;
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation ';
    }
    return '<p class="lead text-' . $align . ' ' . implode(' ', $classes) . '" data-os-animation="' . $scroll_animation . '" data-os-animation-delay="' . $scroll_animation_delay . 's">' . do_shortcode($content) . '</p>';
}
add_shortcode( 'lead', 'oxy_shortcode_lead' );

/**
 * Blockquote Shortcode
 *
 * @return Icon Item HTML
 **/
function oxy_shortcode_blockquote( $atts, $content ) {
    extract( shortcode_atts( array(
        'who'   => '',
        'cite'  => '',
        'align'  => 'left',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0'
    ), $atts ) );

   if ($align == 'left') {
       $align_class = 'text-left';
   }
   else if ($align == 'right') {
       $align_class = 'text-right';
   }
   else if ($align == 'justify') {
       $align_class = 'text-justify';
   }
   else {
       $align_class = 'text-center';
   }
    $classes = array();
    $classes[] = $extra_classes;
    $classes[] = $align_class;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }
    ob_start();
    include( locate_template( 'partials/shortcodes/blockquote.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'blockquote', 'oxy_shortcode_blockquote' );

/****************** THEME SHORTCODES *******************************/

/**
 * Feature List - to show a list of features with icon
 *
 * @return Feature List
 **/
function oxy_shortcode_features_list( $atts, $content = null) {
    extract( shortcode_atts( array(
        'show_connections'       => 'hide',
        'connection_line_colour' => '#82c9ed',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0'
    ), $atts ) );

    $classes = array();
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }

    if( $show_connections === 'show' ) {
        $classes[] = 'features-connected';
    }

    ob_start();
    include( locate_template( 'partials/shortcodes/feature/feature-list.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'features_list', 'oxy_shortcode_features_list' );


/**
 * Feature Shortcode - to show a feature with icon
 *
 * @return Feature Item
 **/
function oxy_shortcode_feature( $atts, $content = null) {
    extract( shortcode_atts( array(
        'show_icon'              => 'show',
        'fa_icon'                => '',
        'svg_icon'               => '',
        'shape'                  => 'round',
        'background_color'       => '#82c9ed',
        'icon_color'             => '#ffffff',
        'title'                  => '',
        'animation'              => '',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0'

    ), $atts ) );

    $classes = array();
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }

    ob_start();
    include( locate_template( 'partials/shortcodes/feature/feature.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'feature', 'oxy_shortcode_feature' );


/**
 * Icon shortcode - for showing an icon
 *
 * @return Icon html
 **/
function oxy_shortcode_featuredicon( $atts, $content = null) {
    // setup options
    extract( shortcode_atts( array(
        'icon'              => 'headphones',
        'shape_size'        => 'medium',
        'shape'             => 'round',
        'animation'         => '',
        'link'              => '',
        'overlay_grid'      => '0',
        'icon_colour'       => '#000000',
        'background_colour' => '#e9e9e9',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0'
    ), $atts ) );

    $image_size = $shape === 'round' ? 'square-image' : $shape . '-image';

    $link_classes = array();

    $classes = array( 'box-' . $shape );
    if( $shape_size != 'none' ) {
        $classes[] = 'box-' . $shape_size;
    }
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }

    $overlay_classes = array( 'grid-overlay-' . $overlay_grid );

    ob_start();
    include( locate_template( 'partials/shortcodes/featured-icon.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'featuredicon', 'oxy_shortcode_featuredicon' );

/**
 * Icon shortcode - for showing an icon
 *
 * @return Icon html
 **/
function oxy_shortcode_svgicon( $atts, $content = null) {
    // setup options
    extract( shortcode_atts( array(
        'icon'              => 'link',
        'shape_size'        => 'medium',
        'shape'             => 'round',
        'animation'         => '',
        'overlay_grid'      => '0',
        'icon_colour'       => '#000000',
        'background_colour' => '#e9e9e9',
        'link'              => '',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0'
    ), $atts ) );

    $link_classes = array();

    $image_size = $shape === 'round' ? 'square-image' : $shape . '-image';

    $classes = array( 'box-' . $shape );
    if( $shape_size != 'none' ) {
        $classes[] = 'box-' . $shape_size;
    }
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }

    $overlay_classes = array( 'grid-overlay-' . $overlay_grid );

    ob_start();
    include( locate_template( 'partials/shortcodes/svg-featured-icon.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'svgfeaturedicon', 'oxy_shortcode_svgicon' );
/**
 * Creates a bootstrap button
 *
 * @return bootstrap button HTML
 **/
function oxy_shortcode_button($atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'type'          => 'default',
        'animation'     => '',
        'size'          => '',
        'xclass'        => '',
        'modal'         => '',
        'link'          => '',
        'label'         => 'My button',
        'icon'          => '',
        'custom_color'          => 'false',
        'background_color'          => '',
        'text_font_color'          => '',
        'icon_position' => 'left',
        'link_open'     => '_self',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0'
    ), $atts ) );

    $size = $size == '' ? '' : $size;

    if (empty($modal)) {
        $modal_atts = '';
    }
    else {
        $modal_atts = 'data-toggle="modal" data-target="#' . $modal. '"';
        $link = '#';
    }

    $fancy_class = '';
    $custom_style = '';
    $icon_style = '';
    if ($icon != '') {
        if ($icon_position == 'left') {
            $fancy_class = 'btn-icon-left';
        }
        else if ($icon_position == 'right') {
            $fancy_class = 'btn-icon-right';
        }
    }
    $animation = ( $animation != '') ? ' data-animation="' . $animation . '"' : '';

    $size = $size == '' ? '' : 'btn-' . $size;
    $classes = array();
    $classes[] = 'btn-' . $type;
    $classes[] = $size;
    $classes[] = $xclass;
    $classes[] = $fancy_class;
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;

    // if custom color is enabled
    if( $custom_color == 'true' ) {
        $classes[] = 'btn-custom';
        $custom_style = 'style="background:' . $background_color . ' !important; color:' . $text_font_color . ' !important;"';
        $icon_style = 'style="color:' . $text_font_color . ' !important;"';

    }

    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }

    ob_start();
    include( locate_template( 'partials/shortcodes/button.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'button', 'oxy_shortcode_button' );


/* Services Section */
function oxy_shortcode_service( $atts, $content = '') {
    extract( shortcode_atts( array(
        'service'           => '',
        'image_shape'       => 'round',
        'image_size'        => 'big',
        'icon_colour'       => '#000000',
        'icon_animation'    =>  'bounce',
        'icon_effect'       => 'on',
        'background_colour' => '#e9e9e9',
        'hover_effect'      => '#e9e9e9',
        'overlay_grid'      => '0',
        'show_title'        => 'show',
        'link_title'        => 'on',
        'title_size'        => 'normal',
        'title_weight'      => 'regular',
        'title_underline'   => 'underline',
        'title_underline_size' => 'bordered-normal',
        'show_image'        => 'show',
        'link_image'        => 'on',
        'show_excerpt'      => 'show',
        'align'             => 'center',
        'show_readmore'     => 'hide',
        'readmore_text'     => 'read more',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ) );

    $query = array(
        'post_type'   => 'oxy_service',
        'numberposts' =>  1,
        'name'        => $service,
        'post_status' => 'publish',
    );

    // get the service
    $service = get_posts( $query );

    $output = '';

    if( count( $service ) > 0 ) {
        global $post;
        $post = $service[0];
        setup_postdata( $post );
        // get services data
        $fa_icon = get_post_meta( $post->ID, THEME_SHORT . '_fa_icon', true );
        $svg_icon = get_post_meta( $post->ID, THEME_SHORT . '_svg_icon', true );
        $link_target = get_post_meta( $post->ID, THEME_SHORT . '_target', true );
        $animation = $icon_animation;

        // get link
        $link = oxy_get_slide_link( $post );

        // get image
        $img_size = $image_shape === 'round' ? 'square-image' : $image_shape . '-image';
        $image_src = '';
        $featured_image_id = get_post_thumbnail_id( $post->ID );
        if( !empty( $featured_image_id ) ) {
            $image = wp_get_attachment_image_src( $featured_image_id, $img_size );
            if( isset( $image[0] ) ) {
                $image_src = $image[0];
            }
        }

        // setup surrounding dic classes
        $classes = array();
        $classes[] = $extra_classes;
        $classes[] = 'element-' . $margin_top;
        $classes[] = 'element-' . $margin_bottom;
        $classes[] = 'text-' . $align;
        if( $scroll_animation !== 'none' ) {
            $classes[] = 'os-animation';
        }

        $header_classes = array();
        $header_classes[] = $title_size;
        $header_classes[] = $title_weight;
        $header_classes[] = $title_underline;
        $header_classes[] = $title_underline_size;

        // setup image classes
        $figure_classes = array( 'box-' . $image_shape );
        if( $image_size != 'none' ) {
            $figure_classes[] = 'box-' . $image_size;
        }
        if( $icon_effect != 'on' ) {
            $figure_classes[] = 'box-simple';
        }


        $overlay_classes = array( 'grid-overlay-' . $overlay_grid );

        ob_start();
        include( locate_template( 'partials/shortcodes/services/service.php' ) );
        $output = ob_get_contents();
        ob_end_clean();
    }

    // reset post data because we are all done here
    wp_reset_postdata();

    return $output;
}
add_shortcode( 'service', 'oxy_shortcode_service' );


/* Services Section */
function oxy_shortcode_services( $atts, $content = '') {
    extract( shortcode_atts( array(
        'category'          => '',
        'count'             => '3',
        'columns'           => '3',
        'image_shape'       => 'round',
        'image_size'        => 'big',
        'icon_colour'       => '#000000',
        'icon_animation'    =>  'bounce',
        'icon_effect'       => 'on',
        'background_colour' => '#e9e9e9',
        'overlay_grid'      => '0',
        'show_title'        => 'show',
        'link_title'        => 'on',
        'title_size'        => 'normal',
        'title_weight'      => 'regular',
        'title_underline'   => 'underline',
        'title_underline_size' => 'bordered-normal',
        'show_image'        => 'show',
        'link_image'        => 'on',
        'show_excerpt'      => 'show',
        'align'             => 'center',
        'show_readmore'     => 'show',
        'readmore_text'     => 'read more',
        'orderby'           => 'none',
        'order'             => 'ASC',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ) );

    // calculate column span
    $columns = $columns > 0 ? floor( 12 / $columns ) : 12;

    $query = array(
        'post_type'        => 'oxy_service',
        'posts_per_page' => $count === '0' ? -1 : $count,
        'orderby'          => $orderby,
        'order'            => $order,
        'suppress_filters' => 0
    );

    if( !empty( $category ) ) {
        $query['tax_query'] = array(
            array(
                'taxonomy' => 'oxy_service_category',
                'field'    => 'slug',
                'terms'    => $category
            )
        );
    }

    // get the services
    global $post;
    $services = get_posts( $query );

    //setup surrounding div classes
    $wrapper_classes = array();
    $wrapper_classes[] = 'row';
    $wrapper_classes[] = $extra_classes;
    $wrapper_classes[] = 'element-' . $margin_top;
    $wrapper_classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $wrapper_classes[] = 'os-animation';
    }

    ob_start();
    include( locate_template( 'partials/shortcodes/services/services.php' ) );
    $output = ob_get_contents();
    ob_end_clean();

    // reset post data because we are all done here
    wp_reset_postdata();

    return $output;
}
add_shortcode( 'services', 'oxy_shortcode_services' );

/**
 * The Gallery shortcode.
 *
 * This implements the functionality of the Gallery Shortcode for displaying
 * images on a post.
 *
 * @param array $attr Attributes of the shortcode.
 * @return string HTML content to display gallery.
 * @since 1.2
 */
function oxy_gallery_shortcode($attr) {
    $post = get_post();

    if ( ! empty( $attr['ids'] ) ) {
        // 'ids' is explicitly ordered, unless you specify otherwise.
        if ( empty( $attr['orderby'] ) )
            $attr['orderby'] = 'post__in';
        $attr['include'] = $attr['ids'];
    }

    // Allow plugins/themes to override the default gallery template.
    $output = apply_filters('post_gallery', '', $attr);
    if ( $output != '' )
        return $output;

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'rect-image',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby, 'posts_per_page' => -1) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $columns = intval($columns);
    $span_width = $columns > 0 ? floor( 12 / $columns ) : 12;

    $output = '<div class="row">';
    foreach ( $attachments as $id => $attachment ) {
        $thumb = wp_get_attachment_image_src( $id, $size );
        $full = wp_get_attachment_image_src( $id, 'full' );
        $caption = $attachment->post_excerpt !== '' ? 'title="' . $attachment->post_excerpt . '"' : '';
        $output .= '<div class="col-md-' . $span_width . '">';
        $output .= '<a class="thumbnail magnific" '. $caption .' href="' . $full[0]  . '">';
        $output .= '<img src="' . $thumb[0] . '">';
        $output .= '</a>';
        $output .= '</div>';
    }

    $output .= '</div>';
    return $output;
}
add_shortcode( 'gallery', 'oxy_gallery_shortcode' );

/* ---------- TESTIMONIALS SHORTCODE ---------- */

function oxy_shortcode_testimonials( $atts , $content = '' ) {
    // setup options
    extract( shortcode_atts( array(
        'count'       => '3',
        'group'       => '',
        'show_image'  => 'show',
        'speed'       => '7000',
        'randomize'   => 'off',
        'text_align'  => 'center',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ) );

    // setup surrounding dic classes
    $classes = array();
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    $classes[] = 'text-' . $text_align;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }
    $classes[] = 'flexslider';

    $order_by = $randomize === 'off' ? 'menu_order' : 'rand';

    $query_options = array(
        'post_type'   => 'oxy_testimonial',
        'posts_per_page' => $count === '0' ? -1 : $count,
        'order'      => 'ASC',
        'orderby'     => $order_by,
        'suppress_filters' => 0
    );

    if( !empty( $group ) ) {
        $query_options['tax_query'] = array(
            array(
                'taxonomy' => 'oxy_testimonial_group',
                'field' => 'slug',
                'terms' => $group
            )
        );
    }
    // fetch posts
    $items = get_posts( $query_options );
    $items_count = count( $items );
    $layout = $show_image == 'show'? 'image':'no-image';
    $output = '';
    if( $items_count > 0):
        ob_start();
        include( locate_template( 'partials/shortcodes/testimonials/slideshow/'.$layout.'.php' ) );
        $output = ob_get_contents();
        ob_end_clean();
    endif;
    return $output;
}


add_shortcode( 'testimonials', 'oxy_shortcode_testimonials' );

/* ---------- TESTIMONIALS LIST SHORTCODE ---------- */

function oxy_shortcode_testimonials_list( $atts , $content = '' ) {
    // setup options
    extract( shortcode_atts( array(
        'count'       => '3',
        'columns'     => '3',
        'group'       => '',
        'show_image'  => 'show',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
        'testimonial_scroll_animation_timing' => 'staggered'
    ), $atts ) );

    // calculate column span
    $columns = $columns > 0 ? floor( 12 / $columns ) : 12;
    // setup surrounding dic classes
    $classes = array();
    $classes[] = 'row';
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;

    $wrapper_classes[] = 'col-md-' . $columns;
    $wrapper_classes[] = 'element-short-bottom';
    if( $scroll_animation !== 'none' ) {
        $wrapper_classes[] = 'os-animation';
    }

    $item_delay = $scroll_animation_delay ;
    $query_options = array(
        'post_type'   => 'oxy_testimonial',
        'posts_per_page' => $count === '0' ? -1 : $count,
        'order'      => 'ASC',
        'orderby'     => 'menu_order',
        'suppress_filters' => 0
    );


    if( !empty( $group ) ) {
        $query_options['tax_query'] = array(
            array(
                'taxonomy' => 'oxy_testimonial_group',
                'field' => 'slug',
                'terms' => $group
            )
        );
    }
    // fetch posts
    $items = get_posts( $query_options );
    $items_count = count( $items );
    $layout = $show_image == 'show'? 'image':'no-image';
    $output = '';
    if( $items_count > 0):
        ob_start();
        include( locate_template( 'partials/shortcodes/testimonials/list/'.$layout.'.php' ) );
        $output = ob_get_contents();
        ob_end_clean();
    endif;
    return $output;
}


add_shortcode( 'testimonials_list', 'oxy_shortcode_testimonials_list' );

/* Staff List */
function oxy_shortcode_staff_list($atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'department'                   => '',
        'count'                        => '3',
        'columns'                      => '3',
        'show_position'                => 'show',
        'show_social'                  => 'show',
        'item_size'                    => 'full',
        'item_overlay'                 => 'strip',
        'item_link_type'               => 'magnific',
        'item_captions_below'          => 'hide',
        'captions_below_link_type'     => 'item',
        'item_caption_align'           => 'center',
        'item_caption_vertical'        => 'middle',
        'item_overlay_animation'       => 'fade-in',
        'item_hover_filter'            => 'item_hover_filter',
        'hover_filter_invert'          => 'image-filter-onhover',
        'item_overlay_grid'            => '0',
        'item_overlay_icon'            => 'plus',
        'item_scroll_animation_timing' => 'staggered',
        'orderby'                      => 'none',
        'order'                        => 'ASC',
        // global options
        'extra_classes'                => '',
        'margin_top'                   => 'short-top',
        'margin_bottom'                => 'short-bottom',
        'scroll_animation'             => 'none',
        'scroll_animation_delay'       => '0',


    ), $atts ) );

    $query_options = array(
        'post_type'   => 'oxy_staff',
        'posts_per_page' => $count === '0' ? -1 : $count,
        'orderby'     => $orderby,
        'order'       => $order,
        'suppress_filters' => 0
    );

    if( !empty( $department ) ) {
        $query_options['tax_query'] = array(
            array(
                'taxonomy' => 'oxy_staff_department',
                'field' => 'slug',
                'terms' => $department
            )
        );
    }

    // calculate column span
    $columns = $columns > 0 ? floor( 12 / $columns ) : 12;

    $container_classes = array();
    $container_classes[] = $extra_classes;
    $container_classes[] = 'row';
    $container_classes[] = 'staff-list-container';
    $container_classes[] = 'list-container';
    $container_classes[] = 'element-' . $margin_top;
    $container_classes[] = 'element-' . $margin_bottom;

    $classes = array();
    $classes[] = 'staff-os-animation';
    $classes[] = 'col-md-' . $columns;

    $item_delay = $scroll_animation_delay ;

    // fetch posts
    $posts = get_posts( $query_options );

    ob_start();
    include( locate_template( 'partials/shortcodes/staff/list.php' ) );
    $output = ob_get_contents();
    ob_end_clean();

    // reset post data because we are all done here
    wp_reset_postdata();

    return $output;
}
add_shortcode( 'staff_list', 'oxy_shortcode_staff_list' );



/* ---------------- FEATURED STAFF MEMBER SHORTCODE --------------- */

function oxy_shortcode_staff_featured($atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'member'                    => '',
        'show_position'             => 'show',
        'show_social'               => 'show',
        'item_size'                 => 'full',
        'item_overlay'              => 'strip',
        'item_link_type'            => 'magnific',
        'item_captions_below'       => 'hide',
        'captions_below_link_type'  => 'item',
        'item_caption_align'        => 'center',
        'item_caption_vertical'     => 'middle',
        'item_overlay_animation'    => 'fade-in',
        'item_hover_filter'         => 'item_hover_filter',
        'hover_filter_invert'       => 'image-filter-onhover',
        'item_overlay_grid'         => '0',
        'item_overlay_icon'         => 'plus',
        // global options
        'extra_classes'          => '',
        'margin_top'                => 'short-top',
        'margin_bottom'             => 'short-bottom',
        'scroll_animation'          => 'none',
        'scroll_animation_delay'    => '0',
    ), $atts ) );


    if( !empty($member) ) :
        global $post;
        $post = get_post( $member );
        setup_postdata( $post );

        $classes = array();
        $classes[] = $extra_classes;
        $classes[] = 'element-' . $margin_top;
        $classes[] = 'element-' . $margin_bottom;
        if( $scroll_animation !== 'none' ) {
            $classes[] = 'os-animation';
        }

        ob_start();
        include( locate_template( 'partials/shortcodes/staff/single.php' ) );
        $output = ob_get_contents();
        ob_end_clean();

        wp_reset_postdata();
    endif;

    return $output;
}
add_shortcode( 'staff_featured', 'oxy_shortcode_staff_featured' );

/* --------------------- PORTFOLIO SHORTCODES --------------------- */

function oxy_shortcode_portfolio( $atts , $content = '', $code ) {
     // setup options
    extract( shortcode_atts( array(
        'categories'             => '',
        'count'                  => '0',
        'filters'                => '',
        'columns'                => '3',
        'xs_col'                 => '2',
        'sm_col'                 => '3',
        'md_col'                 => '4',
        'lg_col'                 => '5',
        'layout_mode'            => 'fitRows',
        // item options
        'item_size'                    => 'portfolio-thumb',
        'item_padding'                 => '15',
        'item_link_type'               => 'magnific',
        'item_captions_below'          => 'hide',
        'captions_below_link_type'     => 'item',
        'item_caption_align'           => 'center',
        'item_hover_filter'            => 'none',
        'hover_filter_invert'          => 'image-filter-onhover',
        'item_overlay'                 => 'icon',
        'item_caption_vertical'        => 'middle',
        'item_overlay_animation'       => 'from-top',
        'item_overlay_grid'            => '0',
        'item_overlay_icon'            => 'plus',
        'item_scroll_animation'        => 'none',
        'item_scroll_animation_delay'  => '0',
        'item_scroll_animation_timing' => 'staggered',
        'pagination'                   => 'none',
        'orderby'                      => 'menu_order',
        'order'                        => 'ASC',
        'extra_classes'                => '',
        'margin_top'                   => 'short-top',
        'margin_bottom'                => 'short-bottom',
    ), $atts ) );

    $show_filters = explode( ',', $filters );
    $query_options = array(
        'post_type'   => 'oxy_portfolio_image',
        'orderby'     => $orderby,
        'order'       => $order,
        'suppress_filters' => 0,
        'posts_per_page'   => $count === '0' ? -1 : $count
    );

    global $paged, $oxy_is_iphone, $oxy_is_ipad, $oxy_is_android;
    if( $pagination !== 'none' || $oxy_is_iphone || $oxy_is_ipad || $oxy_is_android ) {
        // if pagination, count sets posts per page
        if ( get_query_var('paged') ) {
            $paged = get_query_var('paged');
        }
        elseif ( get_query_var('page') ) {
            $paged = get_query_var('page');
        }
        else {
            $paged = 1;
        }
        $query_options['paged'] = $paged;
        $query_options['posts_per_page'] = $count;
    }

    $filters = get_terms( 'oxy_portfolio_categories', array( 'hide_empty' => 1 ) );

    if( !empty( $categories ) ) {
        $selected_portfolios = explode( ',', $categories );
        $query_options['tax_query'][] = array(
            'taxonomy' => 'oxy_portfolio_categories',
            'field' => 'slug',
            'terms' => $selected_portfolios
        );
        // remove categories that arent selected from the category filter
        foreach( $filters as $index => $filter ) {
            if( !in_array( $filter->slug, $selected_portfolios ) ) {
                unset( $filters[$index] );
            }
        }
    }

    $classes = array( 'portfolio', 'masonry', 'no-transition');
    if($item_link_type === 'magnific-all') {
        $classes[] = 'magnific-all';
    }

    $container_classes = array();
    $container_classes[] = $extra_classes;
    $container_classes[] = 'element-' . $margin_top;
    $container_classes[] = 'element-' . $margin_bottom;
    // fetch posts
    $posts = query_posts( $query_options );
    $count = count( $posts );
    $span_num = 12 / $columns;


    ob_start();
    echo '<div class="portfolio-container ' . implode(' ', $container_classes) . '">';
    include( locate_template( 'partials/shortcodes/portfolio/filters.php' ) );
    include( locate_template( 'partials/shortcodes/portfolio/standard.php' ) );
    echo '</div>';
    $output = ob_get_contents();
    ob_end_clean();

    wp_reset_query();
    wp_reset_postdata();

    return $output;
}
add_shortcode( 'portfolio', 'oxy_shortcode_portfolio' );

function oxy_shortcode_portfolio_masonry( $atts , $content = '', $code ) {
     // setup options
    extract( shortcode_atts( array(
        'categories'             => '',
        'count'                  => '0',
        'filters'                => '',
        'columns'                => '3',
        'xs_col'                 => '2',
        'sm_col'                 => '3',
        'md_col'                 => '4',
        'lg_col'                 => '5',
        'layout_mode'            => 'masonry',
        'pagination'             => 'none',
        // item options
        'item_size'                    => 'full',
        'item_padding'                 => '0',
        'item_link_type'               => 'magnific',
        'item_link_target'             => '_self',
        'item_captions_below'          => 'hide',
        'captions_below_link_type'     => 'item',
        'item_caption_align'           => 'center',
        'item_hover_filter'            => 'none',
        'hover_filter_invert'          => 'image-filter-onhover',
        'item_overlay'                 => 'icon',
        'item_caption_vertical'        => 'middle',
        'item_overlay_animation'       => 'fade-in',
        'item_overlay_grid'            => '0',
        'item_overlay_icon'            => 'plus',
        'item_scroll_animation'        => 'none',
        'item_scroll_animation_delay'  => '0',
        'item_scroll_animation_timing' => 'staggered',
        'pagination'                   => 'none',
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
    ), $atts ) );

    $show_filters = explode( ',', $filters );

    $query_options = array(
        'post_type'   => 'oxy_portfolio_image',
        'orderby'     => 'menu_order',
        'order'       => 'ASC',
        'suppress_filters' => 0,
        'posts_per_page' => $count === '0' ? -1 : $count
    );

    global $paged, $oxy_is_iphone, $oxy_is_ipad, $oxy_is_android;
    if( $pagination !== 'none' || $oxy_is_iphone || $oxy_is_ipad || $oxy_is_android ) {
        // if pagination, count sets posts per page
        if ( get_query_var('paged') ) {
            $paged = get_query_var('paged');
        }
        elseif ( get_query_var('page') ) {
            $paged = get_query_var('page');
        }
        else {
            $paged = 1;
        }
        $query_options['paged'] = $paged;
        $query_options['posts_per_page'] = $count;
    }

    $filters = get_terms( 'oxy_portfolio_categories', array( 'hide_empty' => 1 ) );

    if( !empty( $categories ) ) {
        $selected_portfolios = explode( ',', $categories );
        $query_options['tax_query'][] = array(
            'taxonomy' => 'oxy_portfolio_categories',
            'field' => 'slug',
            'terms' => $selected_portfolios
        );

         // remove categories that arent selected from the category filter
        foreach( $filters as $index => $filter ) {
            if( !in_array( $filter->slug, $selected_portfolios ) ) {
                unset( $filters[$index] );
            }
        }
    }

    $classes = array( 'portfolio', 'masonry', 'no-transition', 'use-masonry' );
    if($item_link_type === 'magnific-all') {
        $classes[] = 'magnific-all';
    }

    $container_classes = array();
    $container_classes[] = $extra_classes;
    $container_classes[] = 'element-' . $margin_top;
    $container_classes[] = 'element-' . $margin_bottom;

    // fetch posts
    $posts = query_posts( $query_options );
    $count = count( $posts );
    $span_num = 12 / $columns;

    ob_start();
    echo '<div class="portfolio-container ' . implode(' ', $container_classes) . '">';
    include( locate_template( 'partials/shortcodes/portfolio/filters.php' ) );
    include( locate_template( 'partials/shortcodes/portfolio/standard.php' ) );
    echo '</div>';
    $output = ob_get_contents();
    ob_end_clean();

    wp_reset_query();
    wp_reset_postdata();

    return $output;
}
add_shortcode( 'portfolio_masonry', 'oxy_shortcode_portfolio_masonry' );


/* ---------------------- PIE CHART SHORTCODE -----------------  */

function oxy_shortcode_pie( $atts , $content = '' ){
    // setup options
    extract( shortcode_atts( array(
        'track_colour'  => '',
        'bar_colour'    => '',
        'icon'          => '',
        'icon_animation'=> 'none',
        'percentage'    => '50',
        'size'          => '200',
        'line_width'    => '20',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ) );

    $header_classes = array();
    $header_classes[] = 'element-' . $margin_top;
    $header_classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $header_classes[] = 'os-animation';
    }

    $icon_animation = $icon_animation != 'none' ? ' data-animation="'.$icon_animation.'"':"";
    ob_start();
    include( locate_template( 'partials/shortcodes/easy-pie-chart.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

add_shortcode( 'pie', 'oxy_shortcode_pie' );
/* ---------------------- CIRCULAR COUNTER SHORTCODE -----------------  */

function oxy_shortcode_counter( $atts , $content = '' ){
    // setup options
    extract( shortcode_atts( array(
        'initvalue'      => '0',
        'value'          => 0,
        'format'         => '(,ddd)',
        'counter_size'   => 'normal',
        'counter_weight' => 'regular',
        'underline'      => 'bordered',
        'align'          => 'default',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ) );

    $header_classes = array();
    $header_classes[] = $underline;
    $header_classes[] = 'text-'. $align;
    $header_classes[] = $extra_classes;
    $header_classes[] = 'element-' . $margin_top;
    $header_classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $header_classes[] = 'os-animation';
    }

    ob_start();
    include( locate_template( 'partials/shortcodes/counter.php' ) );
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}

add_shortcode( 'counter', 'oxy_shortcode_counter' );

/* ---------------------- COUNTDOWN TIMER SHORTCODE -----------------  */

function oxy_shortcode_countdown( $atts , $content = '' ){
    // setup options
    extract( shortcode_atts( array(
        'date'             => '',
        'number_size'      => 'super',
        'number_weight'    => 'regular',
        'number_underline' => 'bordered',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ) );

    $classes = array();
    $classes[] = $number_size;
    $classes[] = $number_weight;

    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }

    ob_start();
    include( locate_template( 'partials/shortcodes/countdown/countdown.php' ) );
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}

add_shortcode( 'countdown', 'oxy_shortcode_countdown' );


/* --------------------- PRICING SHORTCODE ---------------------- */

function oxy_shortcode_pricing($atts , $content=''){
    extract( shortcode_atts( array(
        'heading'         => '',
        'featured'        => 'false',
        'pricing_background_colour' => '#82c9ed',
        'pricing_foreground_colour' => '#FFFFFF',
        'show_price'      => 'true',
        'price'           =>  '10',
        'pricing_colour'  =>  '#82c9ed',
        'pricing_background'  =>  '#ffffff',
        'currency'        => '&#36;',
        'custom_currency' => '',
        'per'             => '',
        'list'            => '',
        'show_button'     => 'true',
        'button_text'     => '',
        'button_link'     => '',
        'button_background_colour' => '#ffffff',
        'button_foreground_colour' => '#82c9ed',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ) );

    $classes = array();
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    $classes[] = 'pricing-col';

    if( $featured === 'true' ) {
        $classes[] = 'pricing-featured';
    }
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }

    $list = explode( ',', $list );

    ob_start();
    include( locate_template( 'partials/shortcodes/pricing/pricing.php'  ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'pricing' , 'oxy_shortcode_pricing');

/*----------------- RECENT NEWS SECTION SHORTCODE AND HELPER FUNCTIONS --------------------*/

function oxy_get_recent_posts( $count, $categories, $authors = null , $post_formats = null ) {
    $query = array();
    // set post count
    global $paged;
    if ( get_query_var('paged') ) {
        $paged = get_query_var('paged');
    }
    elseif ( get_query_var('page') ) {
        $paged = get_query_var('page');
    }
    else {
        $paged = 1;
    }
    $query['paged'] = $paged;
    $query['posts_per_page'] = $count;
    // set category if selected
    if( !empty( $categories ) ) {
        $query['category_name'] = implode( ',', $categories );
    }
    // set author if selected
    if( !empty( $authors ) ) {
        $query['author'] = implode( ',', $authors );
    }
    // set post format if selected
    if( !empty( $post_formats ) ) {
        foreach( $post_formats as $key => $value ) {
            $post_formats[$key] = 'post-format-' . $value;
        }
        $query['tax_query'] = array();
        $query['tax_query'][] = array(
            'taxonomy' => 'post_format',
            'field'    => 'slug',
            'terms'    => $post_formats
        );
    }
    // fetch posts
    return query_posts( $query );
}


function oxy_shortcode_recent($atts , $content = '' ) {
    // setup options
    extract( shortcode_atts( array(
        'count'                     => '3',
        'cat'                       => null,
        'masonry_items_swatch'      => 'swatch-white',
        'masonry_items_padding'     => '8',
        'scroll_animation_timing'   => 'staggered',
        // global options
        'extra_classes'          => '',
        'margin_top'                => 'short-top',
        'margin_bottom'             => 'short-bottom',
        'scroll_animation'          => 'none',
        'scroll_animation_delay'    => '0',
    ), $atts ) );

    $classes = array();
    $container_classes = array();
    $container_classes[] = 'masonry';
    $container_classes[] = 'blog-masonry';
    $container_classes[] = 'use-masonry';
    $container_classes[] = 'isotope';
    $container_classes[] = 'no-transition';
    $container_classes[] = $extra_classes;
    $container_classes[] = 'element-' . $margin_top;
    $container_classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'blog-os-animation';
    }

    $item_delay = $scroll_animation_delay ;
    $cat = ( null === $cat ) ? null : explode( ',', $cat );

    $posts = oxy_get_recent_posts( $count, $cat );

    global $post;
    $output = '';
    if( !empty( $posts ) ):
        ob_start();
        include( locate_template( 'partials/shortcodes/posts/masonry.php' ) );
        $output .= ob_get_contents();
        ob_end_clean();
    endif;

    // reset post data
    wp_reset_postdata();
    wp_reset_query();

    return $output;
}

add_shortcode( 'recent_posts', 'oxy_shortcode_recent' );


function oxy_shortcode_recent_simple($atts , $content = '' ) {
    // setup options
    extract( shortcode_atts( array(
        'count'                     => '3',
        'cat'                       => null,
        'columns'                   => '3',
        'scroll_animation_timing'   => 'staggered',
        // global options
        'extra_classes'             => '',
        'margin_top'                => 'short-top',
        'margin_bottom'             => 'short-bottom',
        'scroll_animation'          => 'none',
        'scroll_animation_delay'    => '0',
    ), $atts ) );

    if ($columns !== '5') {
        $span_width = $columns > 0 ? floor( 12 / $columns ) : 4;
    } else {
        $span_width = '2-4';
    }

    $classes = array();
    $container_classes = array();
    $container_classes[] = $extra_classes;
    $container_classes[] = 'row';
    $container_classes[] = 'element-' . $margin_top;
    $container_classes[] = 'element-' . $margin_bottom;
    $container_classes[] = 'recent-simple-os-container';

    $classes[] = 'col-md-'. $span_width;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'recent-simple-os-animation';
    }

    $item_delay = $scroll_animation_delay ;
    $cat = ( null === $cat ) ? null : explode( ',', $cat );

    $posts = oxy_get_recent_posts( $count, $cat );

    global $post;
    $output = '';
    if( !empty( $posts ) ):
        ob_start();
        include( locate_template( 'partials/shortcodes/posts/simple.php' ) );
        $output .= ob_get_contents();
        ob_end_clean();
    endif;

    // reset post data
    wp_reset_postdata();
    wp_reset_query();

    return $output;
}

add_shortcode( 'recent_posts_simple', 'oxy_shortcode_recent_simple' );


/*------------------------ SLIDESHOW SHORTCODE -----------------------*/

function oxy_shortcode_slideshow($atts , $content = '' ){
    extract( shortcode_atts( array(
        'flexslider'         => '',
        'ids'                => '',
        'animation'          => 'slide',
        'direction'          => 'horizontal',
        'speed'              => '7000',
        'duration'           => '600',
        'directionnav'       => 'hide',
        'itemwidth'          => '',
        'showcontrols'       => 'show',
        'controlsposition'   => 'inside',
        'controlsalign'      => 'center',
        'controls_vertical'  => 'bottom',
        'captions'           => 'show',
        'captions_horizontal'=> 'left',
        'autostart'          => 'true',
        'tooltip'            => 'hide',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ));


    $items_count = 0;
    $classes = array();
    $data = array();
    $tooltip_attrs = array();
    // Setting the data attributes
    $data[] =  'data-flex-slideshow=' . $autostart;
    $data[] =  'data-flex-sliderdirection=' . $direction;
    $data[] =  'data-flex-speed=' . $speed;
    $data[] =  'data-flex-animation=' . $animation;
    $data[] =  'data-flex-directions=' . $directionnav;
    $data[] =  'data-flex-controls=' . $showcontrols;
    $data[] =  'data-flex-controlsalign=' . $controlsalign;
    $data[] =  'data-flex-controlsvertical=' . $controls_vertical;
    $data[] =  'data-flex-controlsposition=' . $controlsposition;
    $data[] =  'data-flex-duration=' . $duration;
    $data[] =  'data-flex-captionhorizontal=' . $captions_horizontal;
    if (!empty($itemwidth)) {
        $data[] =  'data-flex-itemwidth=' . $itemwidth;
    }

    if (is_array($ids)) {
        $items = get_posts( array( 'post_type' => 'attachment', 'post__in' => $ids, 'orderby' => 'post__in', 'posts_per_page' => -1 ) );
    }
    else{
        $query_options = array(
            'post_type'   => 'oxy_slideshow_image',
            'orderby'     => 'menu_order',
            'order'       => 'ASC',
            'suppress_filters' => 0,
            'posts_per_page' => -1
        );

        if( ( $flexslider !== '') ) {
            $query_options['tax_query'] = array(
                array(
                    'taxonomy' => 'oxy_slideshow_categories',
                    'field' => 'slug',
                    'terms' => $flexslider
                )
            );
            $items = get_posts( $query_options );
        }
    }
    $items_count = count( $items );

    // Setting a unique id
    $id = 'flexslider-' . rand(1,100);

    $classes[] = 'flex-controls-' .  $controls_vertical;
   // $classes[] = 'flex-caption-' .  $captions_vertical;
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }

    $output = '';
    if( $items_count > 0):
        ob_start();
        include( locate_template( 'partials/shortcodes/flexslider/flexslider.php' ) );
        $output = ob_get_contents();
        ob_end_clean();
    endif;
    return $output;
}

add_shortcode( 'slideshow', 'oxy_shortcode_slideshow');

function oxy_shortcode_carousel($atts , $content = '' ){
    extract( shortcode_atts( array(
        'carousel'         => '',
        'count'              => 0,
        'showcontrols'       => 'show',
        'directionnav'       => 'show',
        'captions'           => 'show',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ));

    $items_count = 0;

    $query_options = array(
        'post_type'   => 'oxy_slideshow_image',
        'orderby'     => 'menu_order',
        'suppress_filters' => 0,
        'posts_per_page' => $count === '0' ? -1 : $count
    );

    if( !empty( $carousel ) ) {
        $query_options['tax_query'] = array(
            array(
                'taxonomy' => 'oxy_slideshow_categories',
                'field' => 'slug',
                'terms' => $carousel
            )
        );
        $items = get_posts( $query_options );
        $items_count = count( $items );
    }



    $classes = array();
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }
    $output = '';
    if( $items_count > 0):
        ob_start();
        include( locate_template( 'partials/shortcodes/bootstrap/carousel.php' ) );
        $output = ob_get_contents();
        ob_end_clean();
    endif;
    return $output;
}

add_shortcode( 'carousel', 'oxy_shortcode_carousel');

/**
 * Icon Item Shortcode - for use inside an iconlist shortcode
 *
 * @return Icon Item HTML
 **/
function oxy_shortcode_social_icon( $atts, $content = null) {
    extract( shortcode_atts( array(
        'url'       => '',
        'icon'      => '',
        'target'    => '_blank',
    ), $atts ) );

    $target = ( $target == '_blank')?'target="_blank"':'';
    $output = '<li>';
    $output .= '<a data-iconcolor="'.oxy_get_icon_color( $icon ).'" href="'.$url.'" '.$target.'>';
    $output .= '<i class="' . $icon . '"></i></a></li>';
    return $output;
}
add_shortcode( 'socialicon', 'oxy_shortcode_social_icon' );


/**
 * Google Map Shortocde
 *
 * @return Map HTML
 **/
function oxy_shortcode_google_map( $atts, $content = null) {
    $atts = shortcode_atts( array(
        'map_type'       => 'ROADMAP',
        'map_zoom'       => '15',
        'map_style'      => 'flat',
        'map_scrollable' => 'on',
        'marker'         => 'show',
        'auto_center'    => 'auto',
        'latlng'         => '51.5171,0.1062',
        'center_latlng'  => '',
        'label'          => '',
        'address'        => '',
        'height'         => '500',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts );

    $classes = array();
    $center_address = '';
    $classes[] = $atts['extra_classes'];
    $classes[] = 'element-' . $atts['margin_top'];
    $classes[] = 'element-' . $atts['margin_bottom'];
    if( $atts['scroll_animation'] !== 'none' ) {
        $classes[] = 'os-animation';
    }

    $atts['auto_center'] = $atts['auto_center'] === 'auto';
    $atts['latlng'] = explode('|', $atts['latlng']);
    $atts['label'] = explode('|', $atts['label']);
    if ($atts['address'] !== '') {
        $atts['address'] = explode('|', $atts['address']);
    }
    else {
        $atts['address'] = '';
    }
    $atts['markerURL'] = OXY_THEME_URI . 'assets/images/marker.png';

    //Grabing the Google API key set in General section of the theme options
    $api_key = oxy_get_option('api_key');
    $api_key = !empty($api_key) ? 'key=' . $api_key : '';
    $api_key = esc_attr($api_key);

    $map_id = 'map' . rand(1, 1000);

    wp_enqueue_script(THEME_SHORT.'-google-map-api', 'https://maps.googleapis.com/maps/api/js?v=3.35&' . $api_key );
    wp_enqueue_script( THEME_SHORT.'-google-map', OXY_THEME_URI . 'assets/js/map.min.js', array( 'jquery', THEME_SHORT.'-google-map-api' ) );
    wp_localize_script( THEME_SHORT.'-google-map', $map_id, $atts );

    $output = '<div id="' . $map_id . '" class="google-map ' . implode( ' ', $classes ) . '" style="height:' . $atts['height'] . 'px" data-os-animation="' . $atts['scroll_animation'] . '" data-os-animation-delay="' . $atts['scroll_animation_delay'] . 's"></div>';

    return $output;

}
add_shortcode( 'map', 'oxy_shortcode_google_map' );



/* ---- BOOTSTRAP ALERT SHORTCODE ----- */

function oxy_shortcode_alert($atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'color'       => 'alert-success',
        'title'       => 'Watch Out!',
        'dismissable' => 'false',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ) );


    $classes = array();
    $classes[] = $color;
    $classes[] = $dismissable == 'true' ? 'alert-dismissable' : '';
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }

    ob_start();
    include( locate_template( 'partials/shortcodes/bootstrap/alert.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'vc_message', 'oxy_shortcode_alert' );

/* ---- BOOTSTRAP JUMBOTRON SHORTCODE ----- */

function oxy_shortcode_jumbotron($atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'title'       => 'Watch Out!',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ) );


    $classes = array();
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }

    ob_start();
    include( locate_template( 'partials/shortcodes/bootstrap/jumbotron.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'vc_jumbotron', 'oxy_shortcode_jumbotron' );

/* ----------------- BOOTSTRAP ACCORDION SHORTCODES ---------------*/

/**
 * Bootstrap Panel Shortcode
 *
 * @return Panel html
 **/
function oxy_shortcode_panel($atts , $content = '' ) {
    extract( shortcode_atts( array(
        'title'        => '',
        'style'        => '',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ) );

    $classes = array();
    $classes[] = $style;
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }

    ob_start();
    include( locate_template( 'partials/shortcodes/bootstrap/panel.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

add_shortcode( 'panel' , 'oxy_shortcode_panel');


/* ------------------ PROGRESS BAR SHORTCODE -------------------- */

function oxy_shortcode_progress_bar($atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'percentage'    =>  '50',
        'type'          => 'progress',
        'style'         => 'progress-bar-info',
        'progress_text' => '',
                // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ) );

    $classes[] = $type;
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }

    ob_start();
    include( locate_template( 'partials/shortcodes/bootstrap/progress-bar.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'progress', 'oxy_shortcode_progress_bar' );

/**
 * Video shortcode
 *
 * @return void
 * @author
 **/
function oxy_shortcode_video( $atts , $content = '' ) {
    extract( shortcode_atts( array(
        'src'    =>  '',

        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ) );

    $classes = array();
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }

    global $wp_embed;
    $output = '<div class="' . implode(' ', $classes) . '" data-os-animation="' . $scroll_animation . '" data-os-animation-delay="' . $scroll_animation_delay . 's" >';
    $output .= do_shortcode( $wp_embed->run_shortcode( '[embed]' . $src . '[/embed]' ) );
    $output .= '</div>';
    return $output;
}
add_shortcode( 'vc_video', 'oxy_shortcode_video' );


/* ---- SCROLL TO BUTTON ----- */

function oxy_shortcode_scroll_to($atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'link'       => '#link',
        'icon'       => 'down',
        'icon'       => 'down',
        'place_bottom' => '',

        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ) );

    $classes = array();
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }
    if( $place_bottom  ) {
        $classes[] = 'place-bottom';
    }

    ob_start();
    include( locate_template( 'partials/shortcodes/scroll-to.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'vc_scroll', 'oxy_shortcode_scroll_to' );

/* ---- TAG LIST SHORTCODE ----- */

function oxy_shortcode_tag_list($atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'tags'    =>  '',
        'size'    => 'normal',
        'style'   => 'tag-list',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',

    ), $atts ) );

    $tags = explode( ',', $tags );

    $classes = array();
    $classes[] = 'tag-list tag-list-' . $size;
    $classes[] = $style;
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }

    ob_start();
    include( locate_template( 'partials/shortcodes/tags.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'tags', 'oxy_shortcode_tag_list' );


/**
 * Sharing buttons shortcode
 *
 * @return Sharing buttons html
 * @author
 **/
function oxy_shortcode_sharing($atts, $content = '') {
    extract( shortcode_atts( array(
        'title'             => '',
        'social_networks'   => 'facebook,twitter,google,pinterest,linkedin',
        'icon_size'         => 'sm',
        'background_show'   => 'background',
        'background_shape'  => 'circle',
        'background_colour' => '',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ) );

    $social_networks = explode( ',', $social_networks );

    // set classes to add to the ul in the partial
    $classes = array();
    $classes[] = 'social-icons';
    $classes[] = 'social-' . $icon_size;
    $classes[] = 'social-' . $background_show;
    $classes[] = 'social-' . $background_shape;
    $classes[] = $extra_classes;
    $container_classes = array();
    $container_classes[] = 'element-' . $margin_top;
    $container_classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $container_classes[] = 'os-animation';
    }
    $background_color_attr = empty($background_colour) ? '' : ' style="background-color:' . $background_colour . ';"';
    // create social network links
    global $post;
    $permalink = get_permalink( $post->ID );
    $post_title = rawurlencode( get_the_title( $post->ID ) );
    $network_links = array();
    $network_links['twitter']   = 'https://twitter.com/share?url=' . $permalink;
    $network_links['google']    = 'https://plus.google.com/share?url=' . $permalink;
    $network_links['facebook']  = 'http://www.facebook.com/sharer.php?u=' . $permalink;
    $network_links['pinterest'] = '//pinterest.com/pin/create/button/?url=' . $permalink . '&amp;description=' . $post_title;
    $network_links['linkedin'] = 'http://www.linkedin.com/shareArticle?mini=true&url=' . $permalink . '&amp;title=' . $post_title;

    // check for featured image and add it to the links
    $featured_image_attachment = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
    if( isset( $featured_image_attachment[0] ) ) {
        $network_links['google']    .= '&amp;images=' . $featured_image_attachment[0];
        $network_links['pinterest'] .= '&amp;media=' . $featured_image_attachment[0];
    }

    ob_start();
    include( locate_template( 'partials/shortcodes/social/social-sharing-icons.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'sharing', 'oxy_shortcode_sharing' );

/**
 * Sharing buttons shortcode
 *
 * @return Sharing buttons html
 * @author
 **/
function oxy_shortcode_divider($atts, $content = '') {
    extract( shortcode_atts( array(
        'visibility' => 'hidden',
        'background_colour' => '#FFFFFF',
        'xs_height' => '24',
        'sm_height' => '24',
        'md_height' => '24',
        'lg_height' => '24',
    ), $atts ) );

    ob_start();
    include( locate_template( 'partials/shortcodes/divider.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'divider', 'oxy_shortcode_divider' );

/**
 * Sharing buttons shortcode
 *
 * @return Sharing buttons html
 * @author
 **/
function oxy_shortcode_social($atts, $content = '') {
    extract( shortcode_atts( array(
        'title'             => '',
        'icon_size'         => 'sm',
        'background_show'   => 'background',
        'background_shape'  => 'circle',
        'background_colour' => '#82c9ed',
        'link_target'       => '_self',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts ) );

    $icons = include OXY_THEME_DIR . 'inc/options/global-options/social-icons-options.php';

    $classes = array();
    $classes[] = 'social-icons';
    $classes[] = 'social-' . $icon_size;
    $classes[] = 'social-' . $background_show;
    $classes[] = 'social-' . $background_shape;
    $classes[] = $extra_classes;
    $container_classes = array();
    $container_classes[] = 'element-' . $margin_top;
    $container_classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $container_classes[] = 'os-animation';
    }

    ob_start();
    include( locate_template( 'partials/shortcodes/social/social-links.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'socialicons', 'oxy_shortcode_social' );


/**
 * Chart js shortcode
 *
 * @return Sharing buttons html
 * @author
 **/
function oxy_shortcode_chart( $atts, $content = '' ) {
    $atts = shortcode_atts( array(
        'type'                   => 'pie',
        'data'                   => '',
        'datasets'               => '',
        'colors'                 => '',
        'labels'                 => '',
        'width'                  => '70%',
        'height'                 => 'auto',
        'canvaswidth'            => '625',
        'canvasheight'           => '625',
        'relativewidth'          => '1',
        'margin'                 => '20',
        'align'                  => '',
        'class'                  => '',
        'scalefontsize'          => '12',
        'scalefontcolor'         => '#666666',
        'scaleoverride'          => 'false',
        'scalesteps'             => 'null',
        'scalestepwidth'         => 'null',
        'scalestartvalue'        => 'null',
        'animation'              => 'true',
        'fillopacity'            => '0.7',
        'pointstrokecolor'       => '#FFFFFF',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0',
    ), $atts );

    $output = '';
    if( function_exists( 'wp_charts_shortcode' ) ) {

        $classes = array();
        $classes[] = $atts['extra_classes'];
        $classes[] = 'element-' . $atts['margin_top'];
        $classes[] = 'element-' . $atts['margin_bottom'];
        if( $atts['scroll_animation'] !== 'none' ) {
            $classes[] = 'os-animation';
        }

        $atts['title'] = 'chart_' . rand( 100, 999 );

        ob_start();
        include( locate_template( 'partials/shortcodes/chart.php' ) );
        $output = ob_get_contents();
        ob_end_clean();
    }
    return $output;
}
add_shortcode( 'chart', 'oxy_shortcode_chart' );

/**
 * Chart js shortcode
 *
 * @return Sharing buttons html
 * @author
 **/
function oxy_shortcode_menu( $atts, $content = '' ) {
    extract( shortcode_atts( array(
        'slug'                   => '',
        'container_class'        => 'container',
        'menu_swatch'            => 'swatch-white',
        'underline_menu'         => 'underline',
        'menu_capitalization'    => 'text-none',
        'header_type'            => 'navbar-sticky'
    ), $atts ) );

    $classes = array();
    $classes[] = $header_type;
    // add header swatch class
    $classes[] = $menu_swatch;
    $classes[] = $underline_menu;

    // no text transform option
    $classes[] = $menu_capitalization;

    ob_start();
    include( locate_template( 'partials/shortcodes/bootstrap/menu.php' ) );
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}
add_shortcode( 'menu', 'oxy_shortcode_menu' );

/**
 * Simple Icon List - to show a simple list of icons
 *
 * @return Simple Icon List
 **/
function oxy_shortcode_simple_icon_list( $atts, $content = null) {
    extract( shortcode_atts( array(
        'size'                   => 'normal',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0'
    ), $atts ) );

    $classes = array();
    if( $size === 'big' ) {
        $classes[] = 'lead';
    }
    $classes[] = $extra_classes;
    $classes[] = 'element-' . $margin_top;
    $classes[] = 'element-' . $margin_bottom;
    if( $scroll_animation !== 'none' ) {
        $classes[] = 'os-animation';
    }

    ob_start();
    include( locate_template( 'partials/shortcodes/icon-list/simple-icon-list.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'simple_icon_list', 'oxy_shortcode_simple_icon_list' );


/**
 * Simple Icon Shortcode - to show a simple icon
 *
 * @return Simple Icon
 **/
function oxy_shortcode_simple_icon( $atts, $content = null) {
    extract( shortcode_atts( array(
        'fa_icon'                => '',
        'icon_color'             => '#ffffff',
        'title'                  => '',
        'link'                   => '',
        'link_target'            => '_self',
    ), $atts ) );

    ob_start();
    include( locate_template( 'partials/shortcodes/icon-list/simple-icon.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'simple_icon', 'oxy_shortcode_simple_icon' );


/**
 * Audio - Loads an audio player
 *
 * @return Simple Icon
 **/
function oxy_shortcode_audio( $atts, $content = null) {
    $atts = shortcode_atts( array(
        'src'      => '',
        'loop'     => '0',
        'autoplay' => '0',
        'preload'  => 'none',
        // global options
        'extra_classes'          => '',
        'margin_top'             => 'short-top',
        'margin_bottom'          => 'short-bottom',
        'scroll_animation'       => 'none',
        'scroll_animation_delay' => '0'
    ), $atts );

    $classes = array();
    $classes[] = $atts['extra_classes'];
    $classes[] = 'element-' . $atts['margin_top'];
    $classes[] = 'element-' . $atts['margin_bottom'];
    if( $atts['scroll_animation'] !== 'none' ) {
        $classes[] = 'os-animation';
    }

    ob_start();
    include( locate_template( 'partials/shortcodes/audio.php' ) );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode( 'audio', 'oxy_shortcode_audio' );

/**
 * Audio - Loads an audio player
 *
 * @return Simple Icon
 **/
function oxy_shortcode_layerslider_vc( $atts, $content = null) {
    extract( shortcode_atts( array(
        'id'       => '',
        'slug'     => '',
        'el_class' => ''
    ), $atts ) );

    if( !empty( $slug ) ) {
        $id = $slug;
    }

    $output = '<div class="'.$el_class.'">';
    $output .= do_shortcode('[layerslider id="'.$id.'"]');
    $output .= '</div>';

    return $output;
}
add_shortcode( 'layerslider_vc', 'oxy_shortcode_layerslider_vc' );

/**
 * SVG - Loads a list of SVG Icons
 *
 * @return List of SVGs
 **/
function oxy_shortcode_svg( $atts, $content = null) {
    $svg_array = include OXY_THEME_DIR . 'inc/options/global-options/svgs.php';

    // Remove the first element as it is an empty icon
    array_shift($svg_array);

    $output = '<ul class="features-list list-container">';
    foreach ($svg_array as $key => $value) {
        $output .= do_shortcode('[feature svg_icon="'. $key .'" icon_color="#000" background_color="#dfdfdf" title="' . $value . '"  margin_top="medium-top" margin_bottom="medium-bottom" extra_classes="col-md-3"]');
    }
    $output .= '</ul>';
    return $output;
}
add_shortcode( 'svg_vc', 'oxy_shortcode_svg' );
