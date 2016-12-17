<?php
/**
 * Displays a single portfolio post
 *
 * @package Omega
 * @subpackage Frontend
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.14.0
 */

global $post;
// get template to use for portfolio
$page_template = get_post_meta( $post->ID, THEME_SHORT.'_template', true );

// load the template
if ( $overridden_template = locate_template( $page_template ) ) {
    // locate_template() returns path to file
    // if either the child theme or the parent theme have overridden the template
    load_template( $overridden_template );
}
else {
    // If neither the child nor parent theme have overridden the template,
    // we load the template from the 'templates' sub-directory of the directory this file is in
    load_template( OXY_THEME_DIR . '/' . $page_template  );
}