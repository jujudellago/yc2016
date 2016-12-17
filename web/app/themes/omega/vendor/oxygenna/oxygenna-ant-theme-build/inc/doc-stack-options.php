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

define('OXY_STACKS_DIR', $theme_root . '/vendor/oxygenna/oxygenna-stacks/');

define('OXY_THEME_DIR', $theme_root . '/');

function __($myString)
{
    return $myString;
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

$stack_options = include $options_file;

ob_start();?>
---
  title: Skin Options
  subtitle: A list of all options available to modify the theme skin
  layout: docs.hbs
  section: options
---
<?php foreach ($stack_options as $section) : ?>

# <?php echo $section['title']; ?>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($section['fields'] as $field) : ?>
    <tr>
        <td><?php echo $field['name']; ?></td>
        <td>
            <?php echo isset($field['desc']) ? $field['desc'] : ''; ?>

            <?php echo get_field_options($field); ?>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
</table>

<?php endforeach;

$markdown = ob_get_contents();
ob_end_clean();

file_put_contents($output_markdown_file, $markdown);