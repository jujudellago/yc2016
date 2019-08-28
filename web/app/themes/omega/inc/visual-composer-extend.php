<?php
/**
 * Extra custom classes for the VC composer
 *
 * @package Omega
 * @subpackage Admin
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.12
 */

if( class_exists('WPBakeryShortCodesContainer') && class_exists('WPBakeryShortCode') ) {
    // Features list and Feature
    class WPBakeryShortCode_Features_List extends WPBakeryShortCodesContainer {
    }
    class WPBakeryShortCode_Feature extends WPBakeryShortCode {
    }
    class WPBakeryShortCode_Panel extends WPBakeryShortCodesContainer {
    }
    class WPBakeryShortCode_Simple_Icon_List extends WPBakeryShortCodesContainer {
    }
    class WPBakeryShortCode_Simple_Icon extends WPBakeryShortCode {
    }
}