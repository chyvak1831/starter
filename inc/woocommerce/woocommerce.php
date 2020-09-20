<?php
/**
 * Woocommerce only code
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add woocommerce support
 *
 * @since starter 1.0
 */
function starter_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'starter_add_woocommerce_support' );

/*Remove woo css*/
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Remove woo assets
 *
 * @since starter 1.0
 */
function starter_woocommerce_assets_cleaner() {
	wp_dequeue_script( 'wc-single-product' );
	wp_dequeue_style( 'wc-block-style' );
}
add_action( 'wp_enqueue_scripts', 'starter_woocommerce_assets_cleaner', 99 );

// add extended comment feature
require_once get_stylesheet_directory() . '/inc/woocommerce/comment/comment.php';

/*filter*/
require_once get_stylesheet_directory() . '/inc/woocommerce/filter/filter.php';

/**
 * Change number of upsells output
 */
function starter_change_number_upsells_products() {
	$limit = get_theme_mod( 'qty_upsell_products', -1 );
	return $limit;
}
add_filter( 'woocommerce_upsells_total', 'starter_change_number_upsells_products' );

/**
 * Change number of related products
 */
function starter_related_products_args( $args ) {
	$args['posts_per_page'] = get_theme_mod( 'qty_related_products', 10 );
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'starter_related_products_args', 20 );

/**
 * Fix search: remove aws plugin's parameter
 *
 * @since starter 1.0
 *
 * @param string $markup .
 */
function starter_aws_searchbox_markup( $markup ) {
	$pattern = '/(<input type="hidden" name="type_aws" value="true">)/i';
	$markup  = preg_replace( $pattern, '', $markup );
	return $markup;
}
add_filter( 'aws_searchbox_markup', 'starter_aws_searchbox_markup' );

/**
 * Show cart contents / total Ajax
 */
function starter_woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	?>
	<span class="notifications_text"><?php echo $woocommerce->cart->cart_contents_count;?></span>
	<?php
	$fragments['.cart-counter .notifications_text'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'starter_woocommerce_header_add_to_cart_fragment' );
