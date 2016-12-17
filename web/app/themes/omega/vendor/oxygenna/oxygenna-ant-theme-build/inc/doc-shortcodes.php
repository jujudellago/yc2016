<?php
/**
 * Builder of codex
 *
 * @package Omega
 * @subpackage CodexBuilder
 * @since 1.3
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.14.0
 */

// get arguments from script
$theme_root = $argv[1];
$shortcode_options_file = $argv[2];
$output_markdown_file = $argv[3];

define( 'THEME_SHORT', 'swatch' );
define( 'OXY_THEME_URI', '' );

define( 'OXY_THEME_DIR', $theme_root . '/' );

function __( $myString ) {
    return $myString;
}

function get_posts( $options ) {
    return array();
}

function get_terms( $terms ) {
    return array();
}

function oxy_create_social_options(){
    $icons = include OXY_THEME_DIR . 'inc/options/global-options/social-icons-options.php';
    $fields = array();
    foreach( $icons as $icon => $name ) {
        $fields[] =  array(
            'name'    => sprintf( __('%s URL', 'omega-admin-td'), $name ),
            'id'      => sprintf( __('%s', 'omega-admin-td'), $icon ),
            'type'    => 'text',
            'default' => '',
            'attr'    =>  array(
                'class'    => 'widefat',
            ),
        );
    }
    return $fields;
}

$shortcodes = require $shortcode_options_file;

if(isset($shortcodes['vc_row_inner'])) {
    unset($shortcodes['vc_row_inner']);
}

ob_start();?>
---
  title: Shortcode Options
  subtitle: An overview of all theme shortcodes and their options
  layout: docs.hbs
---
<?php foreach( $shortcodes as $shortcode ) : ?>
# <?php echo $shortcode['title'];  ?>

<?php echo isset( $shortcode['desc'] ) ? $shortcode['desc'] : ''; ?>


#### Full Example

    <?php echo create_example( $shortcode ); ?>

<?php if (isset($shortcode['sections'])): ?>

#### Options

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Default</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach( $shortcode['sections'] as $section ) {
    foreach( $section['fields'] as $field ) { ?>
<tr>
    <td><?php echo $field['id']; ?></td>
    <td>
        <?php echo isset( $field['desc'] ) ? $field['desc'] : ''; ?>
        <?php echo get_field_options( $field ); ?>
    </td>
    <td><?php echo isset($field['default']) ? $field['default'] : ''; ?></td>
</tr>
<?php
    }
} ?>
</tbody>
</table>

<?php endif ?>

<?php endforeach;

$markdown = ob_get_contents();
ob_end_clean();

file_put_contents( OXY_THEME_DIR . $output_markdown_file, $markdown );

function get_field_options( $field ) {
    $options = '';
    if( isset( $field['options'] ) && is_array( $field['options'] ) && !empty( $field['options'] ) ) {
        $options .= '<br><strong>options : </strong>';
        $valid_options = array_keys( $field['options'] );
        // for( $i = 0 ; $i < count( $valid_options ) ; $i++ ) {
        //     if( empty( $valid_options[$i] ) ) {
        //         $valid_options[$i] = '""';
        //     }
        // }
        $options .= '<code style="white-space: normal;">' . implode(', ', $valid_options ) . '</code>';
    }
    return $options;
}

function create_example( $option ) {
    // check for older insert examples (<= Swatch)
    if (isset($option['insert'])) {
        return $option['insert'];
    }
    $sc = '[' . $option['shortcode'];
    foreach( $option['sections'] as $section ) {
        foreach( $section['fields'] as $field ) {
            if( isset( $field['default'] ) && $field['id'] !== 'content' ) {
                $sc .= ' ' . $field['id'] . '="' . $field['default'] . '"';
            }
        }
    }
    $sc .= ']';
    if( isset( $option['has_content'] ) && $option['has_content'] === true ) {
        $sc .= ' content goes here [/' . $option['shortcode'] . ']';
    }
    return $sc;
}