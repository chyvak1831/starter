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
	$notice = str_replace( 'woocommerce-store-notice__dismiss-link', 'woocommerce-store-notice__dismiss-link btn-close' , $notice );
	$notice = str_replace( 'Dismiss', '<span class="screen-reader-text">Dismiss notification</span>', $notice );
	return str_replace( 'demo_store', 'alert alert-secondary alert-dismissible', $notice );
}
add_filter( 'woocommerce_demo_store', 'starter_replace_dismiss' );

/**
 * Customizer: Product hover image
 *
 * @since starter 1.2
 *
 * @param string $wp_customize .
 */
function starter_customizer_hover_product_image( $wp_customize ) {
	$wp_customize->add_setting(
		'hover_product_image',
		array(
			'default'   => false,
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'hover_product_image',
		array(
			'section'  => 'image_section',
			'label'    => __( 'Enable hover product image', 'starter' ),
			'type'     => 'checkbox',
			'priority' => 2,
		)
	);
}
add_action( 'customize_register', 'starter_customizer_hover_product_image', 50 );

/**
 * Customizer: Related
 *
 * @since starter 1.0
 *
 * @param object $wp_customize .
 */
function starter_related_customizer( $wp_customize ) {
	$wp_customize->add_section(
		'similar_products_section',
		array(
			'title'    => 'Related products',
			'priority' => 80,
			'panel'    => 'starter_theme_panel',
		)
	);
	$wp_customize->add_setting(
		'qty_related_products',
		array(
			'default'   => '10',
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'qty_related_products',
		array(
			'section'     => 'similar_products_section',
			'label'       => 'Quantity related products',
			'description' => '0 - hide related products globally',
			'type'        => 'number',
		)
	);
}
add_action( 'customize_register', 'starter_related_customizer', 50 );

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
	$args['prev_text'] = starter_get_svg( array( 'icon' => 'bi-chevron-left' ) );
	$args['next_text'] = starter_get_svg( array( 'icon' => 'bi-chevron-right' ) );
	return $args;
}
add_filter( 'woocommerce_pagination_args', 'starter_woo_pagination' );
