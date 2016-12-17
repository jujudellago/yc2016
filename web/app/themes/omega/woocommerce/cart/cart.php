<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.8
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;
do_action( 'woocommerce_before_cart' ); ?>

<section class="section section-commerce <?php echo apply_filters( 'oxy_woocommerce_shop_classes', 10 ); ?>">
	<div class="container">

		<?php do_action( 'woocommerce_before_cart' ); ?>

		<div class="row element-normal-top element-normal-bottom">

			<div class="col-md-12">
			<?php wc_print_notices(); ?>
				<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

					<?php do_action( 'woocommerce_before_cart_table' ); ?>
					<div class="table-responsive">
						<table class="shop_table cart table margin-bottom" cellspacing="0">
							<thead>
								<tr>
									<th class="product-remove">&nbsp;</th>
									<th class="product-thumbnail">&nbsp;</th>
									<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
									<th class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></th>
									<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
									<th class="product-subtotal"><?php _e( 'Total', 'woocommerce' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php do_action( 'woocommerce_before_cart_contents' ); ?>

								<?php
								foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
									$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
									$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

									if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
										?>
										<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

											<td class="product-remove">
												<?php
													echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s">&times;</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'woocommerce' ) ), $cart_item_key );
												?>
											</td>

											<td class="product-thumbnail">
												<?php
													$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

													if ( ! $_product->is_visible() )
														echo $thumbnail;
													else
														printf( '<a href="%s">%s</a>', $_product->get_permalink( $cart_item ), $thumbnail );
												?>
											</td>

											<td class="product-name">
												<?php
													if ( ! $_product->is_visible() )
														echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
													else
														echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', $_product->get_permalink( $cart_item ), $_product->get_title() ), $cart_item, $cart_item_key );

													// Meta data
													echo WC()->cart->get_item_data( $cart_item );

						               				// Backorder notification
						               				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
						               					echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';
												?>
											</td>

											<td class="product-price">
												<?php
													echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
												?>
											</td>

											<td class="product-quantity">
												<?php
													if ( $_product->is_sold_individually() ) {
														$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
													} else {
														$product_quantity = woocommerce_quantity_input( array(
															'input_name'  => "cart[{$cart_item_key}][qty]",
															'input_value' => $cart_item['quantity'],
															'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
															'min_value'   => '0'
														), $_product, false );
													}

													echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
												?>
											</td>

											<td class="product-subtotal">
												<?php
													echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
												?>
											</td>
										</tr>
										<?php
									}
								}?>

							</tbody>
						</table>
					</div>
					<?php do_action( 'woocommerce_cart_contents' ); ?>
					<div class="row">
						<div class="col-md-6 margin-bottom" >
							<?php if ( WC()->cart->coupons_enabled() ) { ?>
								<div class="input-group">
									<input name="coupon_code" class="input-text form-control" id="coupon_code" value="" placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>" />
									<span class="input-group-btn">
										<input type="submit" class="btn btn-primary" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'woocommerce' ); ?>" />
									</span>
								</div>

								<?php do_action('woocommerce_cart_coupon'); ?>

							<?php } ?>
						</div>
						<div class="col-md-3 margin-bottom">
							<button type="submit" class="btn btn-info btn-block" name="update_cart" value="true">
								<i class="fa fa-refresh"></i>
								<?php _e( 'Update Cart', 'woocommerce' ); ?>
							</button>
                        </div>
                        <div class="col-md-3 margin-bottom" >
							<button type="submit" class="btn btn-success checkout-button alt wc-forward btn-block" name="proceed" value="true">
								<?php _e( 'Proceed to Checkout', 'woocommerce' ); ?>
								<i class="fa fa-shopping-cart"></i>
							</button>

                        </div>
						<?php wp_nonce_field( 'woocommerce-cart' ); ?>
					</div>

					<?php do_action( 'woocommerce_after_cart_contents' ); ?>

					<?php do_action( 'woocommerce_after_cart_table' ); ?>
				</form>
			</div>

		</div>
		<div class="row">
            <div class="col-md-6">
                <?php woocommerce_shipping_calculator(); ?>
            </div>
            <div class="col-md-6">
                <?php do_action( 'woocommerce_cart_collaterals' ); ?>
            </div>
		</div>
	</div>
</section>

<?php do_action( 'woocommerce_after_cart' ); ?>