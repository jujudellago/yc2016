<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>

<div class="mini-cart-overview">
    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="navbar-text">
        <i class="fa fa-shopping-cart"></i>
        <span><?php echo WC()->cart->cart_contents_count; ?></span>
        -
        <?php echo WC()->cart->get_cart_subtotal(); ?>
    </a>
</div>

<a class="mini-cart-underlay" onclick="jQuery('.mini-cart-container').removeClass('active');jQuery('.mini-cart-underlay').removeClass('cart-open');jQuery('body').removeClass('mini-cart-opened');" href="javascript:void(0);"></a>

<div id="mini-cart-container" class="mini-cart-container <?php echo oxy_get_option( 'pageslide_cart_swatch' ); ?>" style="top: 0; bottom: 0; position: fixed;">
    <a onclick="jQuery('.mini-cart-container').removeClass('active');jQuery('.mini-cart-underlay').removeClass('cart-open');jQuery('body').removeClass('mini-cart-opened');" href="javascript:void(0);" class="btn btn-primary btn-cart-sidebar block margin-bottom">Close Cart</a>

    <ul class="cart_list product_list_widget <?php echo $args['list_class']; ?>">

        <?php if ( ! WC()->cart->is_empty() ) : ?>

    		<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :

                $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

                    $product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
                    $thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                    $product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                    ?>

        			<li class="<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
        				<div class="media">
                            <?php if ( ! $_product->is_visible() ) : ?>
                                <?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
                            <?php else : ?>
                                <a class= "product-image pull-left" href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
                                    <?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
                                </a>
                            <?php endif; ?>
                            <div class="media-body">
                                <h5 class="media-heading">
                                    <a href="<?php echo get_permalink( $cart_item['product_id'] ); ?>">
                                       <?php echo apply_filters('woocommerce_widget_cart_product_title', $product_name, $_product ); ?>

                                    </a>
                                </h5>
                                <?php
                                    echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                    '<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                    esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
                                    __( 'Remove this item', 'woocommerce' ),
                                    esc_attr( $product_id ),
                                    esc_attr( $_product->get_sku() )
                                ), $cart_item_key );
                                ?>
                                <p>
                                    <?php echo WC()->cart->get_item_data( $cart_item ); ?>
                                </p>
                                <p>
                                    <?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
                                </p>
                             </div>
                        </div>
        			</li>
                <?php } ?>
    		<?php endforeach; ?>

    	<?php else : ?>

    		<li class="empty"><?php _e( 'No products in the cart.', 'woocommerce' ); ?></li>

    	<?php endif; ?>

    </ul><!-- end product list -->

    <?php if ( ! WC()->cart->is_empty() ) : ?>

    	<div class="cart-actions">
            <p class="total overlay"><strong><?php _e( 'Subtotal', 'woocommerce' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

            <?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

        	<div class="buttons">
                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="btn btn-success block"><?php _e( 'View Cart', 'woocommerce' ); ?><i class="fa fa-shopping-cart"></i></a>
                <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="btn checkout btn-primary block"><?php _e( 'Checkout', 'woocommerce' ); ?><i class="fa fa-credit-card"></i></a>
        	</div>
        </div>

    <?php endif; ?>
</div>
<?php do_action( 'woocommerce_after_mini_cart' ); ?>
