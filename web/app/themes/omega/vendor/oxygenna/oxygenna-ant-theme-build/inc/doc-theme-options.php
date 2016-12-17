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
$options_file = $argv[2];
$output_markdown_file = $argv[3];

define('THEME_SHORT', '');
define('THEME_NAME', '');
define('OXY_THEME_URI', '');

define('OXY_THEME_DIR', $theme_root . '/');

function __($myString)
{
    return $myString;
}

function get_posts($options)
{
    return array();
}

function get_home_url()
{
    return '';
}

function get_site_url()
{
    return '';
}

function admin_url()
{
    return '';
}

function wp_create_nonce()
{
    return '';
}

function oxy_prefix_options_id($prefix, $options)
{
    foreach ($options as $index => &$val) {
        $val['id'] = $prefix.'_'.$val['id'];
    }
    return $options;
}

function get_field_options($field)
{
    $options = '';
    if (isset($field['options']) && is_array($field['options']) && !empty($field['options'])) {
        $options .= '<br><strong>options : </strong>';
        $valid_options = array_values($field['options']);

        for ($i = 0; $i < count($valid_options); $i++) {
            if (is_array($valid_options[$i])) {
                if (isset($valid_options[$i]['name'])) {
                    $valid_options[$i] = $valid_options[$i]['name'];
                }
            }
        }

        $options .= '<code style="white-space: normal;">' . implode(', ', $valid_options) . '</code>';
    }
    return $options;
}

global $theme_options;
$theme_options = array();
class OxyTheme
{
    public function register_option_page($options)
    {
        // print_r($options);
        global $theme_options;
        $theme_options[] = $options;
    }
}
global $oxy_theme;
$oxy_theme = new OxyTheme();

echo $theme_root . '/' . $options_file;
include $theme_root . '/' . $options_file;

ob_start();?>
---
  title: Theme Options
  subtitle: An overview of how to all the theme options available
  layout: docs.hbs
  section: options
---
<?php foreach ($theme_options as $options_page) : ?>

# <?php echo $options_page['page_title']; ?>

<?php foreach ($options_page['sections'] as $section) : ?>

## <?php echo $section['title']; ?>

<?php if (isset($section['header'])) : ?>
<?php echo $section['header']; ?>
<?php endif; ?>


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
foreach ($section['fields'] as $option) { ?>
<tr>
    <td><?php echo $option['name']; ?></td>
    <td>
        <?php echo isset($option['desc']) ? $option['desc'] : ''; ?>

        <?php echo get_field_options($option); ?>
    </td>
    <td>
        <?php if (isset($option['default'])): ?>
            <?php if (is_array($option['default'])): ?>
                <?php echo implode(' ,', $option['default']); ?>
            <?php else: ?>
                <?php echo $option['default']; ?>
            <?php endif ?>
        <?php endif ?>
    </td>
</tr>
<?php
    }
?>
</tbody>
</table>

<?php endforeach; ?>

<?php endforeach;

$markdown = ob_get_contents();
ob_end_clean();

file_put_contents($output_markdown_file, $markdown);