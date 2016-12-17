<?php
/**
 * Shows a woocommerce account page
 *
 * @package Omega
 * @subpackage Frontend
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.14.0
 */

global $woocommerce; ?>

<section class="section section-commerce <?php echo apply_filters( 'oxy_woocommerce_shop_classes', 10 );?>">
    <div class="container">
        <?php wc_print_notices(); ?>
        <div class="row element-normal-top element-normal-bottom">
            <div class="col-md-3">
                <?php get_template_part('woocommerce/myaccount/navigation'); ?>
            </div>
            <div class="col-md-9">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</section>
