<?php
/**
 * Product customizer
 *
 * @package starter
 * @since 1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Set upsell products
 *
 * @since starter 1.0
 */
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
/**
 * Set related products
 *
 * @since starter 1.0
 */
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


/**
 * Set quantity show product/review in My account -> My reviews
 *
 * @since starter 1.0
 */
$wp_customize->add_section(
	'my_reviews_section',
	array(
		'title'    => 'Quantity products/reviews on tab "Pending reviews"/"My reviews"',
		'priority' => 7,
		'panel'    => 'woocommerce',
	)
);
$wp_customize->add_setting(
	'quantity_pending_reviews',
	array(
		'default'   => '5',
		'type'      => 'theme_mod',
		'transport' => 'postMessage',
	)
);
$wp_customize->add_control(
	'quantity_pending_reviews',
	array(
		'section' => 'my_reviews_section',
		'label'   => 'Set number show products on "Pending reviews"',
		'type'    => 'number',
	)
);
$wp_customize->add_setting(
	'quantity_my_reviews',
	array(
		'default'   => '5',
		'type'      => 'theme_mod',
		'transport' => 'postMessage',
	)
);
$wp_customize->add_control(
	'quantity_my_reviews',
	array(
		'section' => 'my_reviews_section',
		'label'   => 'Set number show reviews on "My reviews"',
		'type'    => 'number',
	)
);
