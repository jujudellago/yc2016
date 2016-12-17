<?php
/**
 * Checkout coupon form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

if ( ! WC()->cart->coupons_enabled() )
	return;

$info_message = apply_filters( 'woocommerce_checkout_coupon_message', __( 'Have a coupon?', 'woocommerce' ) );
$info_message .= ' <strong><a href="#" class="showcoupon">' . __( 'Click here to enter your code', 'woocommerce' ) . '</a></strong>';
wc_print_notice( $info_message, 'notice' );
?>

<form class="checkout_coupon element-normal-bottom" method="post" style="display:none">

	<div class="form-group">
		<input type="text" name="coupon_code" class="input-text form-control" placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
	</div>

    <input type="submit" class="button" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'woocommerce' ); ?>" />

	<div class="clear"></div>
</form>