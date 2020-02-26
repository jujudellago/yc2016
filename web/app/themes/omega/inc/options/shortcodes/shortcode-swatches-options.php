<?php
/**
 * Themes shortcode options go here
 *
 * @package Omega
 * @subpackage Core
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.18.14
 */


// get all swatches
$swatches = get_posts( array(
    'post_type' => 'oxy_swatch',
    'order_by' => 'title',
    'posts_per_page' => '-1'
));

$swatch_options = array();
foreach( $swatches as $swatch ) {
    if( get_post_meta( $swatch->ID, THEME_SHORT . '_status', true ) === 'enabled' ) {
        $swatch_options['swatch-' . $swatch->post_name] = $swatch->post_title;
    }
}

return $swatch_options;