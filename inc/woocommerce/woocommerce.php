<?php
/**
 * Woocommerce only code
 *
 * @package starter
 * @since starter 1.0
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

/**
 * Extend comment feature
 */
require_once get_stylesheet_directory() . '/inc/woocommerce/comment/comment.php';

/**
 * Extend filter feature
 */
require_once get_stylesheet_directory() . '/inc/woocommerce/filter/filter.php';

/**
 * Extend upsell/related feature
 */
require_once get_stylesheet_directory() . '/inc/woocommerce/upsell-related.php';

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
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Fix search: remove aws plugin's parameter
 *
 * @since starter 1.0
 *
 * @param string $markup .
 * @return string $markup modified aws markup - without input [type_aws].
 */
function starter_aws_searchbox_markup( $markup ) {
	$pattern = '/(<input type="hidden" name="type_aws" value="true">)/i';
	$markup  = preg_replace( $pattern, '', $markup );
	return $markup;
}
add_filter( 'aws_searchbox_markup', 'starter_aws_searchbox_markup' );

/**
 * Show cart contents / total Ajax
 *
 * @since starter 1.0
 *
 * @param array $fragments Cart fragments .
 * @return array $fragments .
 */
function starter_woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	?>
	<span class="notifications_text"><?php echo esc_html( $woocommerce->cart->cart_contents_count ); ?></span>
	<?php
	$fragments['.cart-counter .notifications_text'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'starter_woocommerce_header_add_to_cart_fragment' );
