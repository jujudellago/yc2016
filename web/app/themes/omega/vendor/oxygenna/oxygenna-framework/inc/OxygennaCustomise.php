<?php
/**
 * Handles customise theme options
 *
 * @package ThemeFramework
 * @subpackage Options
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.14
 */

include OXY_TF_DIR . 'inc/customiser/OxyCustomizeControlMultipleCheckbox.php';
include OXY_TF_DIR . 'inc/customiser/OxyCustomizeControlSlider.php';

class OxygennaCustomise
{
    public function __construct()
    {
        add_action('customize_register', array(&$this, 'customize_register'));
    }

    public function customize_register($wp_customize)
    {
        $customise_options = apply_filters('oxy-customise-fields', array());

        foreach ($customise_options as $section) {
            // create section
            $wp_customize->add_section($section['id'], array(
                'title'      => $section['title'],
                'priority'   => $section['priority'],
            ));

            foreach ($section['fields'] as $index => $field) {
                $option_group_id = THEME_SHORT . '-options[' . $field['id'] . ']';

                $setting = array(
                    'type'       => 'option',
                    'transport'  => 'refresh',
                    'capability' => 'edit_theme_options',
                    'sanitize_callback' => array(&$this, 'sanitize_callback')
                );

                if (isset($field['default'])) {
                    $setting['default'] = $field['default'];
                }

                $wp_customize->add_setting($option_group_id, $setting);

                $control_args = array(
                    'label'    => $field['name'],
                    'section'  => $section['id'],
                    'type'     => $field['type'],
                    'settings' => $option_group_id,
                    'priority' => $index,
                );

                if (isset($field['desc'])) {
                    $control_args['description'] = $field['desc'];
                }

                $control_id = $section['id'] . '-' . $field['id'];

                switch ($field['type']) {
                    case 'select':
                    case 'radio':
                        $control_args['choices'] = $field['options'];
                        $wp_customize->add_control($control_id, $control_args);
                        break;

                    case 'upload':
                        unset($control_args['type']);
                        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $control_id, $control_args));
                        break;

                    case 'slider':
                        unset($control_args['type']);
                        $control_args['choices'] = $field['attr'];
                        $wp_customize->add_control(new OxyCustomizeControlSlider($wp_customize, $control_id, $control_args));
                        break;

                    case 'multiple-checkbox':
                        $control_args['choices'] = $field['options'];
                        $wp_customize->add_control(new OxyCustomizeControlMultipleCheckbox($wp_customize, $control_id, $control_args));
                        break;
                    default:
                        // regular control
                        $wp_customize->add_control($control_id, $control_args);
                        break;
                }
            }
        }
    }

    public function sanitize_callback($value)
    {
        return apply_filters(THEME_SHORT . '-customizer-option-sanitize', $value);
    }
}
