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
 * @version 1.14.0
 */

return array(
    array(
        'name'    => __('Swatch', 'omega-admin-td'),
        'desc'    => __('Choose a color swatch for the section', 'omega-admin-td'),
        'id'      => 'swatch',
        'type'    => 'select',
        'default' => 'swatch-white',
        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php',
        'admin_label' => true,
    ),
    array(
        'name'    => __('Text Shadow', 'omega-admin-td'),
        'desc'    => __('Adds a text shadow to all the text in this row.', 'omega-admin-td'),
        'id'      => 'text_shadow',
        'type'    => 'select',
        'options' => array(
            'no-shadow' => __('No Shadow', 'omega-admin-td'),
            'shadow'    => __('Show Shadow', 'omega-admin-td'),
        ),
        'default' => 'no-shadow',
    ),
    array(
        'name'    => __('Inner Shadow', 'omega-admin-td'),
        'desc'    => __('Adds an inner shadow to the inside of this row.', 'omega-admin-td'),
        'id'      => 'inner_shadow',
        'type'    => 'select',
        'options' => array(
            'no-shadow' => __('No Shadow', 'omega-admin-td'),
            'shadow'    => __('Show Shadow', 'omega-admin-td'),
        ),
        'default' => 'no-shadow',
    ),
    array(
        'name'    => __('Section Width', 'omega-admin-td'),
        'desc'    => __('Choose between padded-non padded section', 'omega-admin-td'),
        'id'      => 'width',
        'type'    => 'select',
        'options' => array(
            'padded'    => __('Padded', 'omega-admin-td'),
            'no-padded' => __('Full Width', 'omega-admin-td'),
        ),
        'default' => 'padded',
    ),
    array(
        'name'    => __('Optional class', 'omega-admin-td'),
        'id'      => 'class',
        'type'    => 'text',
        'default' => '',
        'desc'    => __('Add an optional class to the section (separated with spaces)', 'omega-admin-td'),
    ),
    array(
        'name'    => __('Optional id', 'omega-admin-td'),
        'id'      => 'id',
        'type'    => 'text',
        'default' => '',
        'desc'    => __('Add an optional id to the section', 'omega-admin-td'),
    ),
    array(
        'name'    => __('Optional label', 'omega-admin-td'),
        'id'      => 'label',
        'type'    => 'text',
        'default' => '',
        'desc'    => __('Add an optional label for this section, used in bullet nav tooltips', 'omega-admin-td'),
    ),
    array(
        'name'      => __('Overlay Colour', 'omega-admin-td'),
        'desc'      => __('Set the colour of the video & image overlay', 'omega-admin-td'),
        'id'        => 'overlay_colour',
        'type'      => 'colour',
        'default'   => '#000000',
    ),
    array(
        'name'      => __('Overlay Opacity', 'omega-admin-td'),
        'desc'      => __('Set the opacity of the video & image overlay', 'omega-admin-td'),
        'id'        => 'overlay_opacity',
        'type'      => 'slider',
        'default'   => '0',
        'attr'      => array(
            'max'       => 1,
            'min'       => 0,
            'step'      => 0.1,
        )
    ),
    array(
        'name'      => __('Overlay Grid', 'omega-admin-td'),
        'desc'      => __('Adds an overlay pattern image', 'omega-admin-td'),
        'id'        => 'overlay_grid',
        'type'      => 'slider',
        'default'   => '0',
        'attr'      => array(
            'max'       => 100,
            'min'       => 0,
            'step'      => 10,
        )
    ),
    array(
        'name'    => __('Background Video mp4', 'omega-admin-td'),
        'id'      => 'background_video_mp4',
        'type'    => 'text',
        'default' => '',
        'desc'    => __('Enter url of an mp4 video to use for this rows background.', 'omega-admin-td'),
    ),
    array(
        'name'    => __('Background Video webm', 'omega-admin-td'),
        'id'      => 'background_video_webm',
        'type'    => 'text',
        'default' => '',
        'desc'    => __('Enter url of a webm video to use for this rows background.', 'omega-admin-td'),
    ),
    array(
        'name'    => __('Background Image', 'omega-admin-td'),
        'id'      => 'background_image',
        'store'   => 'url',
        'type'    => 'upload',
        'default' => '',
        'desc'    => __('Choose an image to use for this rows background.', 'omega-admin-td'),
    ),
    array(
        'name'    => __('Mobile Background Image', 'omega-admin-td'),
        'id'      => 'background_image_mobile',
        'store'   => 'url',
        'type'    => 'upload',
        'default' => '',
        'desc'    => __('Optional alternate image to use for this rows background on mobile.', 'omega-admin-td'),
    ),
    array(
        'name'    => __('Image Background Size', 'omega-admin-td'),
        'desc'    => __('Set how the image will fit into the section', 'omega-admin-td'),
        'id'      => 'background_image_size',
        'type'    => 'select',
        'options' => array(
            'cover' => __('Full Width', 'omega-admin-td'),
            'auto'  => __('Actual Size', 'omega-admin-td'),
        ),
        'default' => 'cover',
    ),
    array(
        'name'    => __('Image Background Repeat', 'omega-admin-td'),
        'id'      => 'background_image_repeat',
        'type'    => 'select',
        'default' => 'no-repeat',
        'options' => array(
            'no-repeat' => __('No repeat', 'omega-admin-td'),
            'repeat-x'  => __('Repeat horizontally', 'omega-admin-td'),
            'repeat-y'  => __('Repeat vertically', 'omega-admin-td'),
            'repeat'    => __('Repeat horizontally and vertically', 'omega-admin-td')
        ),
        'desc'    => __('Set how the image will be repeated', 'omega-admin-td'),
    ),
    array(
        'name'      => __('Background Position vertical', 'omega-admin-td'),
        'desc'      => __('Set the vertical position of background image. 0 value represents the top horizontal edge of the section. Positive values will push the background image up.', 'omega-admin-td'),
        'id'        => 'background_position_vertical',
        'type'      => 'slider',
        'default'   => '0',
        'attr'      => array(
            'max'       => 100,
            'min'       => -100,
            'step'      => 1,
        )
    ),
    array(
        'name'    => __('Background Image Attachment', 'omega-admin-td'),
        'id'      => 'background_image_attachment',
        'type'    => 'select',
        'default' => 'scroll',
        'options' => array(
            'scroll' => __('Scroll', 'omega-admin-td'),
            'fixed'  => __('Fixed', 'omega-admin-td'),
        ),
        'desc'    => __('Set the way the background image is attached to the page. Scroll = normal Fixed = The background is fixed with regard to the viewport.', 'omega-admin-td'),
    ),
    array(
        'name'    => __('Background Image Parallax Effect', 'omega-admin-td'),
        'id'      => 'background_image_parallax',
        'type'    => 'select',
        'default' => 'off',
        'options' => array(
            'off' => __('Off', 'omega-admin-td'),
            'on'  => __('On', 'omega-admin-td'),
        ),
        'desc'    => __('Toggles the background image parallax effect.', 'omega-admin-td'),
    ),
    array(
        'name'      => __('Parallax Effect Start Position ', 'omega-admin-td'),
        'desc'      => __('Sets the position of the image in pixels that the parallax effect will start from.', 'omega-admin-td'),
        'id'        => 'background_image_parallax_start',
        'type'      => 'slider',
        'default'   => '0',
        'attr'      => array(
            'max'       => 500,
            'min'       => -500,
            'step'      => 1
        )
    ),
    array(
        'name'      => __('Parallax Effect End Position', 'omega-admin-td'),
        'desc'      => __('Sets the percentage of the image in pixels that the parallax effect will end up at.', 'omega-admin-td'),
        'id'        => 'background_image_parallax_end',
        'type'      => 'slider',
        'default'   => '-80',
        'attr'      => array(
            'max'       => 500,
            'min'       => -500,
            'step'      => 1
        )
    ),
    array(
        'name'        => __('Background Color Animation Bundle', 'omega-admin-td'),
        'desc'        => __('Choose a color bundle used to animate the section backgrounds', 'omega-admin-td'),
        'id'          => 'section_color_set',
        'type'        => 'select',
        'default'     =>  '',
        'blank'       => __('None', 'omega-admin-td'),
        'options'     => 'custom_post_id',
        'post_type'   => 'oxy_color_bundle',
        'admin_label' => true,
    ),
    array(
        'name'      => __('Background Color Animation Speed', 'omega-admin-td'),
        'desc'      => __('Set the speed that the colors will change, in milliseconds', 'omega-admin-td'),
        'id'        => 'color_speed',
        'type'      => 'slider',
        'default'   => '2000',
        'attr'      => array(
            'max'       => 20000,
            'min'       => 1000,
            'step'      => 1000
        )
    ),
    array(
        'name'      => __('Background Color Animation Duration', 'omega-admin-td'),
        'desc'      => __('Set the length of time each color will stay active between changes, in milliseconds', 'omega-admin-td'),
        'id'        => 'color_duration',
        'type'      => 'slider',
        'default'   => '4000',
        'attr'      => array(
            'max'       => 20000,
            'min'       => 1000,
            'step'      => 1000
        )
    ),
    array(
        'name'    => __('Section Height', 'omega-admin-td'),
        'desc'    => __('Section will vertically cover the entire viewport if Full Height is selected', 'omega-admin-td'),
        'id'      => 'height',
        'type'    => 'select',
        'options' => array(
            'normal'       => __('Normal', 'omega-admin-td'),
            'fullheight'   => __('Full Height', 'omega-admin-td'),
        ),
        'default' => 'normal',
    ),
    array(
        'name'    => __('Section Transparency', 'omega-admin-td'),
        'desc'    => __('Section will be tranparent if On is selected', 'omega-admin-td'),
        'id'      => 'transparency',
        'type'    => 'select',
        'options' => array(
            'transparent'   => __('On', 'omega-admin-td'),
            'opaque'        => __('Off', 'omega-admin-td'),
        ),
        'default' => 'opaque',
    ),
    array(
        'name'    => __('Section Content Vertical Alignment', 'omega-admin-td'),
        'desc'    => __('Align the content of the section vertically', 'omega-admin-td'),
        'id'      => 'vertical_alignment',
        'type'    => 'select',
        'options' => array(
            'top'       => __('Top', 'omega-admin-td'),
            'middle'    => __('Middle', 'omega-admin-td'),
            'bottom'    => __('Bottom', 'omega-admin-td'),
        ),
        'default' => 'top',
    ),
);
