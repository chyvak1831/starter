<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<ul class="list mt-3">
		<li>
			<div class="btn-group count_block single_count_block js_count_add_product">
				<a href="#" class="btn btn-outline-primary btn-lg" data-count="minus" role="button" aria-label="<?php esc_attr_e( 'Minus product', 'starter' ); ?>"><?php echo starter_get_svg( array( 'icon' => 'bi-minus' ) ); ?></a>
				<?php
					do_action( 'woocommerce_before_add_to_cart_quantity' );

					woocommerce_quantity_input(
						array(
							'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
							'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
							'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
						)
					);

					do_action( 'woocommerce_after_add_to_cart_quantity' );
					?>
				<a href="#" class="btn btn-outline-primary btn-lg" data-count="plus" role="button" aria-label="<?php esc_attr_e( 'Plus product', 'starter' ); ?>"><?php echo starter_get_svg( array( 'icon' => 'bi-plus' ) ); ?></a>
			</div>
		</li>
		<li>
			<button type="submit" class="single_add_to_cart_button btn btn-lg btn-outline-primary js_add_to_cart_btn"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
		</li>
	</ul>

	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
