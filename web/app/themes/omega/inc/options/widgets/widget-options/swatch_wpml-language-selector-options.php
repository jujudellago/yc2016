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
 * @version 1.18.12
 */

return array(
    'sections'   => array(
        'twitter-section' => array(
            'fields' => array(
                array(
                    'name' => __('Show language as', 'omega-admin-td'),
                    'id' => 'display',
                    'type' => 'select',
                    'default' => 'name',
                    'options' => array(
                        'name'     => __('Name', 'omega-admin-td'),
                        'code'     => __('Country Code', 'omega-admin-td'),
                        'flag'     => __('Flag', 'omega-admin-td'),
                        'nameflag' => __('Name & Flag', 'omega-admin-td')
                    )
                ),
                array(
                    'name' => __('Order languages by', 'omega-admin-td'),
                    'id' => 'order',
                    'type' => 'select',
                    'default' => 'id',
                    'options' => array(
                        'id'   => __('ID', 'omega-admin-td'),
                        'code' => __('Code', 'omega-admin-td'),
                        'name' => __('Name', 'omega-admin-td')
                    ),
                ),
                array(
                    'name' => __('Order direction', 'omega-admin-td'),
                    'id' => 'orderby',
                    'type' => 'select',
                    'default' => 'id',
                    'options' => array(
                        'asc'   => __('Ascending', 'omega-admin-td'),
                        'desc' => __('Descending', 'omega-admin-td'),
                    ),
                ),
                array(
                    'name' => __('Skip Missing Languages', 'omega-admin-td'),
                    'id' => 'skip_missing',
                    'type' => 'select',
                    'default' => '1',
                    'options' => array(
                        '1' => __('Skip', 'omega-admin-td'),
                        '0' => __('Dont Skip', 'omega-admin-td'),
                    ),
                    'desc' => __('Skip languages with no translations.', 'omega-admin-td')
                ),
            )//fields
        )//section
    )//sections
);//array
