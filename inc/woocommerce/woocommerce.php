<?php
/**
 * Woocommerce only code
 *
 * @package WordPress
 * @subpackage starter
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
 * Woocommerce customizer
 */
require_once get_stylesheet_directory() . '/inc/woocommerce/woocommerce-customizer.php';

/**
 * Extend filter feature
 */
require_once get_stylesheet_directory() . '/inc/woocommerce/filter.php';

/**
 * Remove woo assets
 *
 * @since starter 1.0
 */
function starter_woocommerce_assets_cleaner() {
	wp_dequeue_script( 'wc-single-product' );
	wp_deregister_style( 'wc-blocks-style' );
	wp_deregister_style( 'tinvwl-webfont-font' );
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
	<span class="notifications_text badge rounded-pill bg-dark"><?php echo esc_html( $woocommerce->cart->cart_contents_count ); ?></span>
	<?php
	$fragments['.cart-counter .notifications_text'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'starter_woocommerce_header_add_to_cart_fragment' );

/**
 * Change dismiss text site wide notice
 *
 * @since ilnp 1.0
 *
 * @param string $notice .
 */
function starter_replace_dismiss( $notice ) {
	$notice = str_replace( 'woocommerce-store-notice__dismiss-link', 'woocommerce-store-notice__dismiss-link btn-close', $notice );
	$notice = str_replace( 'Dismiss', '<span class="screen-reader-text">Dismiss notification</span>', $notice );
	return str_replace( 'demo_store', 'alert alert-secondary alert-dismissible', $notice );
}
add_filter( 'woocommerce_demo_store', 'starter_replace_dismiss' );

/**
 * Change number of related products
 *
 * @since starter 1.0
 *
 * @param array $args Amount and ordering of related products.
 * @return array $args Modified by customizer amount of related products
 */
function starter_related_products_args( $args ) {
	$args['posts_per_page'] = get_theme_mod( 'qty_related_products', 10 );
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'starter_related_products_args', 20 );

/**
 * Woocommerce pagination prev/next link's icons
 *
 * @since starter 2.0
 *
 * @param array $args .
 */
function starter_woo_pagination( $args ) {
	$args['prev_text'] = starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ) . '<span class="screen-reader-text">Previous page</span>';
	$args['next_text'] = starter_get_svg( array( 'icon' => 'bi-chevron-right' ) ) . '<span class="screen-reader-text">Next page</span>';
	return $args;
}
add_filter( 'woocommerce_pagination_args', 'starter_woo_pagination' );

/**
 * Add recaptcha validation for login, register and lostpassword pages.
 * starter_recaptcha_markup - markup for recaptcha, look at file inc/recaptcha.php
 * starter_recaptcha_validation - recaptcha validation, look at file inc/recaptcha.php
 *
 * @since starter 2.0
 */
if ( get_theme_mod( 'login_recaptcha', false ) ) {
	add_action( 'woocommerce_login_form', 'starter_recaptcha_markup' );
	add_action( 'woocommerce_process_login_errors', 'starter_recaptcha_validation', 10, 3 );
}
if ( get_theme_mod( 'register_recaptcha', false ) ) {
	add_action( 'woocommerce_register_form', 'starter_recaptcha_markup' );
	add_action( 'woocommerce_process_registration_errors', 'starter_recaptcha_validation', 10, 3 );
}
if ( get_theme_mod( 'lostpassword_recaptcha', false ) ) {
	add_action( 'woocommerce_lostpassword_form', 'starter_recaptcha_markup' );
	add_action( 'lostpassword_post', 'starter_recaptcha_validation', 10, 3 );
}

/**
 * Remove default Woo image sizes.
 *
 * @since starter 2.0
 *
 * @param array $default_sizes Default image size names.
 * @return array $default_sizes Updated image names
 */
function starter_remove_default_woo_image_sizes( $default_sizes ) {
	return array_diff( $default_sizes, array( 'woocommerce_thumbnail', 'woocommerce_single', 'woocommerce_gallery_thumbnail', 'shop_catalog', 'shop_single', 'shop_thumbnail' ) );
}
add_action( 'intermediate_image_sizes', 'starter_remove_default_woo_image_sizes', 999 );

/**
 * Add classes to <body>: add product archive ajax pagination and product hover images classes.
 *
 * @since starter 2.0
 *
 * @param array $classes .
 */
function starter_woo_body_custom_class( $classes ) {
	$classes[] = get_theme_mod( 'product_filter_sort_ajax', true ) ? ' product_filter_sort_ajax' : '';
	$classes[] = get_theme_mod( 'product_pagination_ajax', true ) ? ' product_pagination_ajax' : '';
	$classes[] = get_theme_mod( 'hover_product_image', false ) ? ' hover_product_image' : '';
	return $classes;
}
add_filter( 'body_class', 'starter_woo_body_custom_class' );
