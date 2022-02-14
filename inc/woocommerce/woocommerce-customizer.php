<?php
/**
 * Woocommerce setting in customizer
 *
 * @package WordPress
 * @subpackage starter
 * @since starter 2.0
 */

/**
 * Customizer: Product panel & hover image setting on product
 *
 * @since starter 1.2
 *
 * @param string $wp_customize .
 */
function starter_customizer_product( $wp_customize ) {
	$wp_customize->add_section(
		'product_section',
		array(
			'title'    => 'Product (woocommerce only)',
			'priority' => 80,
			'panel'    => 'starter_theme_panel',
		)
	);
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
			'section'  => 'product_section',
			'label'    => __( 'Enable hover product image', 'starter' ),
			'type'     => 'checkbox',
			'priority' => 2,
		)
	);
}
add_action( 'customize_register', 'starter_customizer_product', 50 );

/**
 * Customizer: Related products
 *
 * @since starter 1.0
 *
 * @param object $wp_customize .
 */
function starter_related_customizer( $wp_customize ) {
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
			'section' => 'product_section',
			'label'   => 'Quantity related products',
			'type'    => 'number',
		)
	);
}
add_action( 'customize_register', 'starter_related_customizer', 50 );

/**
 * Customizer: WooCommerce recaptcha
 *
 * @since starter 1.0
 *
 * @param object $wp_customize .
 */
function starter_customizer_wc_recaptcha( $wp_customize ) {
	/**
	 * Login recaptcha
	 */
	$wp_customize->add_setting(
		'login_recaptcha',
		array(
			'default'   => false,
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'login_recaptcha',
		array(
			'section' => 'recaptcha_section',
			'label'   => 'Login (woocommerce only)',
			'type'    => 'checkbox',
		)
	);
	/**
	 * Register recaptcha
	 */
	$wp_customize->add_setting(
		'register_recaptcha',
		array(
			'default'   => false,
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'register_recaptcha',
		array(
			'section' => 'recaptcha_section',
			'label'   => 'Registration (woocommerce only)',
			'type'    => 'checkbox',
		)
	);
	/**
	 * Lost password
	 */
	$wp_customize->add_setting(
		'lostpassword_recaptcha',
		array(
			'default'   => false,
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'lostpassword_recaptcha',
		array(
			'section' => 'recaptcha_section',
			'label'   => 'Lost Password (woocommerce only)',
			'type'    => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'starter_customizer_wc_recaptcha', 50 );

/**
 * Customizer: WooCommerce comment
 *
 * @since starter 1.0
 *
 * @param object $wp_customize .
 */
function starter_wc_comment_customizer( $wp_customize ) {
	/**
	 * Extended rating
	 */
	$wp_customize->add_setting(
		'comment_extended_rating',
		array(
			'default'   => false,
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'comment_extended_rating',
		array(
			'section' => 'comments_section',
			'label'   => 'Extended rating (woocommerce only)',
			'type'    => 'checkbox',
		)
	);
	/**
	 * Low-rating modal
	 */
	$wp_customize->add_setting(
		'comment_low_rating_modal',
		array(
			'default'   => false,
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'comment_low_rating_modal',
		array(
			'section' => 'comments_section',
			'label'   => 'Low-rating popup (woocommerce only)',
			'type'    => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'starter_wc_comment_customizer', 50 );
