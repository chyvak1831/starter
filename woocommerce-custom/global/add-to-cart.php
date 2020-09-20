<?php
/**
 * Add to cart button
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;

if ( !$product->is_type( 'variable' ) ) :
	if ( $product->is_in_stock() ) : ?>
		<!-- add to cart button -->
			<a
				role="button"
				href="<?php echo esc_attr( $product->add_to_cart_url() ); ?>"
				data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
				data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
				rel="nofollow"
				data-quantity="1"
				aria-label="<?php echo esc_attr( $product->add_to_cart_description() ); ?>"
				class="<?php echo esc_attr( $button_class ); ?> btn btn-block add_to_cart_button ajax_add_to_cart">
				<span class="add_to_cart_txt btn_static_txt"><?php esc_html_e( 'Add to Cart', 'starter' ); ?></span>
				<span class="added_to_cart_txt"><?php echo starter_get_svg( array( 'icon' => 'bi-check2' ) ); ?><?php esc_html_e( 'Added', 'starter' ); ?></span>
				<span class="loading_txt"><?php esc_html_e( 'Loading...', 'starter' ); ?></span>
			</a>
		<!-- END add to cart button -->
	<?php else : ?>
		<!-- sold out -->
			<a
				href="<?php echo esc_attr( $product->add_to_cart_url() ); ?>"
				data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
				data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
				rel="nofollow"
				data-quantity="1"
				aria-label="<?php echo esc_attr( $product->add_to_cart_description() ); ?>"
				class="<?php echo esc_attr( $button_class ); ?> btn btn-block"><?php esc_html_e( 'Sold', 'starter' ); ?>
			</a>
		<!-- END sold out -->
	<?php endif;
else : ?>
	<!-- variable product -->
			<a
				href="<?php echo esc_attr( $product->add_to_cart_url() ); ?>"
				data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
				data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
				rel="nofollow"
				data-quantity="1"
				aria-label="<?php echo esc_attr( $product->add_to_cart_description() ); ?>"
				class="<?php echo esc_attr( $button_class ); ?> btn btn-block"><?php esc_html_e( 'Select options', 'starter' ); ?>
			</a>
	<!-- END variable product -->
<?php endif;
