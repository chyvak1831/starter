<?php
/**
 * Upsell/related products count and customizer
 *
 * @package starter
 * @since starter 1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Customizer: upsell/related
 *
 * @since starter 1.0
 *
 * @param object $wp_customize .
 */
function starter_upsell_related_customizer( $wp_customize ) {
	$wp_customize->add_section(
		'similar_products_section',
		array(
			'title'    => 'Qty upsell/related products',
			'priority' => 5,
			'panel'    => 'woocommerce',
		)
	);
	$wp_customize->add_setting(
		'qty_upsell_products',
		array(
			'default'   => '-1',
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'qty_upsell_products',
		array(
			'section'     => 'similar_products_section',
			'label'       => 'Qty upsells',
			'description' => '0 - hide upsells globally; -1 - display all upsells globally',
			'type'        => 'number',
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
			'label'       => 'Qty related products',
			'description' => '0 - hide related products globally',
			'type'        => 'number',
		)
	);
}
add_action( 'customize_register', 'starter_upsell_related_customizer', 50 );

/**
 * Change number of upsells output
 *
 * @since starter 1.0
 *
 * @return string $limit amount of upsells products
 */
function starter_change_number_upsells_products() {
	$limit = get_theme_mod( 'qty_upsell_products', -1 );
	return $limit;
}
add_filter( 'woocommerce_upsells_total', 'starter_change_number_upsells_products' );

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
