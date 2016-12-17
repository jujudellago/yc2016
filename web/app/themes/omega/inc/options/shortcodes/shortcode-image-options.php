<?php
/**
 * Themes shortcode image options go here
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
        'title' => __('Image options', 'omega-admin-td'),
        'fields' => array(
            array(
                'name'    => __('Image Shape', 'omega-admin-td'),
                'desc'    => __('Choose the shape of the image', 'omega-admin-td'),
                'id'      => 'image_shape',
                'type'    => 'select',
                'options' => array(
                    'box-round'    => __('Round', 'omega-admin-td'),
                    'box-rect'     => __('Rectangle', 'omega-admin-td'),
                    'box-square'   => __('Square', 'omega-admin-td'),
                ),
                'default' => 'box-round',
            ),
            array(
                'name'    => __('Image Size', 'omega-admin-td'),
                'desc'    => __('Choose the size of the image', 'omega-admin-td'),
                'id'      => 'image_size',
                'type'    => 'select',
                'options' => array(
                    'box-mini'    => __('Mini', 'omega-admin-td'),
                    'no-small'    => __('Small', 'omega-admin-td'),
                    'box-medium'  => __('Medium', 'omega-admin-td'),
                    'box-big'     => __('Big', 'omega-admin-td'),
                    'box-huge'    => __('Huge', 'omega-admin-td'),
                ),
                'default' => 'box-medium',
            ),
        )
);