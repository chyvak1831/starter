<?php
/**
 * The Template for displaying dropdown wishlist products.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/ti-wishlist-product-counter.php.
 *
 * @version             1.9.0
 * @package           TInvWishlist\Template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
wp_enqueue_script( 'tinvwl' );
if ( $icon_class && 'custom' === $icon && ! empty( $icon_upload ) ) {
	$starter_custom_icon = wp_remote_get( esc_url( $icon_upload ) )['body'];
}
?>
<a title="wishlist" href="<?php echo esc_url( tinv_url_wishlist_default() ); ?>"
	class="wishlist_products_counter<?php echo ' ' . $icon_class . ' ' . $icon_style . ( empty( $text ) ? ' no-txt' : '' ) . ( 0 < $counter ? ' wishlist-counter-with-products' : '' ); // WPCS: xss ok. ?>">
	<span class="wishlist_products_counter_text menu_icon"><?php echo $starter_custom_icon; // WPCS: xss ok. ?></span>
	<?php if ( $show_counter ) : ?>
		<span class="wishlist_products_counter_number badge rounded-pill bg-dark"></span>
	<?php endif; ?>
	<?php echo $text; // WPCS: xss ok. ?>
</a>
