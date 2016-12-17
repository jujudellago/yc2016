<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

	<div class="row single-product-extras"><div class="col-md-12">
		<div class="tabbable top">
			<ul class="nav nav-tabs" data-tabs="tabs">
			<?php $active = 'active'; ?>
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<li class="<?php echo $active; ?>">
					<a data-toggle="tab" href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
				</li>
				<?php $active = ""; ?>
			<?php endforeach; ?>
			</ul>
			<div class="tab-content">
			<?php $active = 'active'; ?>
		<?php foreach ( $tabs as $key => $tab ) : ?>
				<div class="tab-pane <?php echo $active; ?>" id="tab-<?php echo esc_attr( $key ); ?>">
					<?php call_user_func( $tab['callback'], $key, $tab ) ?>
				</div>
				<?php $active = ""; ?>
		<?php endforeach; ?>
			</div>
		</div>
	</div></div>

<?php endif; ?>