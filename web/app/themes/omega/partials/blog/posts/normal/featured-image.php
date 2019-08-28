<?php
/**
 * Shows a posts featured image
 *
 * @package Omega
 * @subpackage Admin
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.12
 */

global $post;

$image_link         = is_single() ? '' : get_permalink( $post->ID );
$image_link_type    = is_single() && oxy_get_option( 'blog_fancybox' ) === 'on' ? 'magnific' : 'item';
$image_overlay_icon = is_single() ? 'plus' : 'link';
$image_overlay      = oxy_get_option( 'blog_fancybox' ) === 'on' ? 'icon' : 'none';

$img_id = get_post_thumbnail_id($post->ID); // This gets just the ID of the img
$alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);


echo oxy_section_vc_single_image( array(
    'image'          => get_post_thumbnail_id( $post->ID ),
    'alt'            => $alt_text,
    'size'           => 'full',
    'link'           => $image_link,
    'item_link_type' => $image_link_type,
    'overlay_icon'   => $image_overlay_icon,
    'margin_top'     => 'no-top',
    'overlay'        => $image_overlay
));