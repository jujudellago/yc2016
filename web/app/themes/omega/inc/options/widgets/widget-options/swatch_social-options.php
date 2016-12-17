<?php
/**
 * Test Options Page
 *
 * @package Omega
 * @subpackage options-pages
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.14.0
 */


$options = array(
    'sections'   => array(
        'social-section' => array(
            'fields' => array()
        )
    )
);

$options['sections']['social-section']['fields'][] = array(
    'name' => __('Widget Title', 'omega-admin-td'),
    'id' => 'title',
    'type' => 'text',
    'default' => '',
    'attr'      =>  array(
        'class'    => 'widefat',
    ),
);

$options['sections']['social-section']['fields'][] =  array(
    'name'    => __('Open links in new window', 'omega-admin-td'),
    'id'      => 'social_window',
    'type'    => 'checkbox',
    'default' => 'off'
);

$options['sections']['social-section']['fields'][] =  array(
    'name'    => __('Enable custom social colors', 'omega-admin-td'),
    'id'      => 'social_color',
    'type'    => 'select',
    'options' =>  array(
        'on'   => 'On',
        'off'  => 'Off',
    ),
    'attr'    =>  array(
        'class' => 'widefat',
    ),
    'default'   => 'on',
);

$options['sections']['social-section']['fields'][] =  array(
    'name'    => __('Social icons style', 'omega-admin-td'),
    'id'      => 'social_style',
    'type'    => 'select',
    'options' =>  array(
        'social-background'   => 'Show background',
        'social-simple' => 'Hide background'
    ),
    'attr'    =>  array(
        'class' => 'widefat',
    ),
    'default'   => 'social-simple',
);

$options['sections']['social-section']['fields'][] =  array(
    'name' => __('Social icons size', 'omega-admin-td'),
    'id' => 'social_size',
    'type' => 'select',
    'options'    =>  array(
        'social-normal' => 'Normal',
        'social-lg'    => 'Big'
    ),
    'attr'    =>  array(
        'class' => 'widefat',
    ),
    'default' => 'social-normal',
);


for( $i = 0 ; $i < 10 ; $i++ ) {

    $options['sections']['social-section']['fields'][] = array(
        'name'    => sprintf( __('Social %s Icon', 'omega-admin-td'), $i+1 ),
        'id'      => 'social' . $i . '_icon',
        'type'    => 'select',
        'options' => 'icons',
        'default' => '',
        'blank'   => __('Choose a social network icon', 'omega-admin-td'),
        'attr'    =>  array(
            'class'    => 'widefat',
        ),
    );
    $options['sections']['social-section']['fields'][] = array(
        'name'    => sprintf( __('Social %s URL ', 'omega-admin-td'), $i+1 ),
        'id'      => 'social' . $i . '_url',
        'type'    => 'text',
        'default' => '',
        'attr'    =>  array(
            'class'    => 'widefat',
        ),
    );
}

return $options;