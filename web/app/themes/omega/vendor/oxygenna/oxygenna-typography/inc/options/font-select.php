<?php
/**
 * Font Select Box
 *
 * @package OxygennaTypography
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.14
 * @author Oxygenna.com
 */

require_once OXY_TF_DIR . 'inc/options/fields/select/OxygennaSelect.php';

/**
 * Simple Text Input Box
 */
class OxygennaFontSelect extends OxygennaSelect
{
    private $oxy_typography;
    /**
     * Creates option
     *
     * @return void
     *              @since 1.0
     **/
    public function __construct($field, $value, $attr, $oxy_typography)
    {
        $this->oxy_typography = $oxy_typography;
        $field['options'] = $this->load_select_data();
        $attr['class'] = 'font-select select2';

        parent::__construct($field, $value, $attr);
    }

    public function load_select_data($database = null)
    {
        // get data
        $data = array();

        // get default system fonts first
        global $oxy_typography;
        $system_fonts = $oxy_typography->get_system_fonts();
        $data['system_fonts'] = array(
            'optgroup' => __('System Fontstacks', 'omega-admin-td'),
            'options' => array()
        );
        foreach ($system_fonts as $key => $font) {
            $data['system_fonts']['options'][$key] = $font['family'];
        }

        // include typekit fonts if available
        $typekit = $oxy_typography->get_typekit_fonts();
        if (false !== $typekit) {
            foreach ($typekit as $kit) {
                $key = $kit['kit']['id'];
                $data[$key] = array(
                    'optgroup' => __('TypeKit', 'omega-admin-td') . ' - ' . $kit['kit']['name'] . ' Kit',
                    'options' => array()
                );
                foreach ($kit['kit']['families'] as $font) {
                    $data[$key]['options'][$font['name']] = $font['name'];
                }
            }
        }
        // include google fonts if they exist
        $google_fonts = $oxy_typography->get_google_fonts();
        if (!empty($google_fonts)) {
            $data['google_fonts'] = array(
                'optgroup' => __('Google Web Fonts', 'omega-admin-td'),
                'options' => array()
            );
            foreach ($google_fonts as $font) {
                $data['google_fonts']['options'][$font['family']] = $font['family'];
            }
        }

        return $data;
    }
}
