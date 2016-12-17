<?php
/**
 * Order Customer Details
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="row element-normal-top">
    <div class="col-md-4">
        <header>
            <h3><?php _e( 'Customer details', 'woocommerce' ); ?></h3>
        </header>
        <dl class="customer_details">
        <?php
            if ( $order->billing_email ) echo '<dt>' . __( 'Email:', 'woocommerce' ) . '</dt><dd>' . esc_html( $order->billing_email ) . '</dd>';
            if ( $order->billing_phone ) echo '<dt>' . __( 'Telephone:', 'woocommerce' ) . '</dt><dd>' . esc_html( $order->billing_phone ) . '</dd>';
            if ( $order->customer_note ) echo '<dt>' . __( 'Note:', 'woocommerce' ) . '</dt><dd>' . wptexturize( $order->customer_note ) . '</dd>';

            // Additional customer details hook
            do_action( 'woocommerce_order_details_after_customer_details', $order );
        ?>
        </dl>
    </div>

    <?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) : ?>

        <div class="col-md-4">

    <?php else : ?>

        <div class="col-md-8">

    <?php endif; ?>

            <header class="title">
                <h3><?php _e( 'Billing Address', 'woocommerce' ); ?></h3>
            </header>
            <address><p>
                <?php
                    if ( ! $order->get_formatted_billing_address() ) _e( 'N/A', 'woocommerce' ); else echo $order->get_formatted_billing_address();
                ?>
            </p></address>

        </div>

    <?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) : ?>

        <div class="col-md-4">

            <header class="title">
                <h3><?php _e( 'Shipping Address', 'woocommerce' ); ?></h3>
            </header>
            <address><p>
                <?php
                    if ( ! $order->get_formatted_shipping_address() ) _e( 'N/A', 'woocommerce' ); else echo $order->get_formatted_shipping_address();
                ?>
            </p></address>

        </div><!-- /.col-2 -->

    </div><!-- /.col2-set -->

    <?php endif; ?>

</div>
