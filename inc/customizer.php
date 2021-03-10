<?php
/**
 * Starter theme customizer
 *
 * @package starter
 * @since 1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Customizer: add Starter theme panel
 *
 * @since starter 1.1
 *
 * @param string $wp_customize .
 */
function starter_customizer_startertheme_panel( $wp_customize ) {
	$wp_customize->add_panel(
		'starter_theme_panel',
		array(
			'title'       => __( 'Starter Theme', 'starter' ),
			'description' => __( 'Starter theme features', 'starter' ),
			'priority'    => 0,
		)
	);
}
add_action( 'customize_register', 'starter_customizer_startertheme_panel', 50 );

/**
 * Customizer: Add analytics
 *
 * @since starter 1.2
 *
 * @param string $wp_customize .
 */
function starter_customizer_analytics( $wp_customize ) {
	$wp_customize->add_section(
		'analytics_section',
		array(
			'title'    => __( 'Analytics', 'starter' ),
			'priority' => 10,
			'panel'    => 'starter_theme_panel',
		)
	);
	$wp_customize->add_setting(
		'analytics',
		array(
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'analytics',
		array(
			'section' => 'analytics_section',
			'label'   => __( 'Insert analytics like Google Analytics, Facebook etc.', 'starter' ),
			'type'    => 'textarea',
		)
	);
}
add_action( 'customize_register', 'starter_customizer_analytics', 50 );

/**
 * Customizer: add ajax section
 *
 * @since starter 1.2
 *
 * @param object $wp_customize Instance of the WP_Customize_Manager class.
 */
function starter_customizer_ajax( $wp_customize ) {
	$wp_customize->add_section(
		'ajax_section',
		array(
			'title'    => 'Ajax',
			'priority' => 20,
			'panel'    => 'starter_theme_panel',
		)
	);
}
add_action( 'customize_register', 'starter_customizer_ajax', 50 );

/**
 * Add optimization section
 *
 * @since starter 1.1
 *
 * @param string $wp_customize .
 */
function starter_customizer_optimization( $wp_customize ) {
	$wp_customize->add_section(
		'optimization_section',
		array(
			'title'    => __( 'Optimization', 'starter' ),
			'priority' => 50,
			'panel'    => 'starter_theme_panel',
		)
	);
}
add_action( 'customize_register', 'starter_customizer_optimization', 50 );

/**
 * Customizer: CSS optimization
 *
 * @since starter 1.1
 *
 * @param string $wp_customize .
 */
function starter_customizer_css_optimization( $wp_customize ) {
	$wp_customize->add_setting(
		'preload_css',
		array(
			'default'   => true,
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'preload_css',
		array(
			'section' => 'optimization_section',
			'label'   => __( 'Enable preload CSS', 'starter' ),
			'type'    => 'checkbox',
		)
	);
	$wp_customize->add_setting(
		'critical_css',
		array(
			'default'   => true,
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'critical_css',
		array(
			'section' => 'optimization_section',
			'label'   => __( 'Enable critical CSS', 'starter' ),
			'type'    => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'starter_customizer_css_optimization', 50 );

/**
 * Customizer: Image optimization
 *
 * @since starter 1.1
 *
 * @param string $wp_customize .
 */
function starter_customizer_image_optimization( $wp_customize ) {
	$wp_customize->add_setting(
		'image_webp',
		array(
			'default'   => true,
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'image_webp',
		array(
			'section' => 'optimization_section',
			'label'   => __( 'Enable WebP', 'starter' ),
			'type'    => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'starter_customizer_image_optimization', 50 );

/**
 * Add product section
 *
 * @since starter 1.2
 *
 * @param string $wp_customize .
 */
function starter_customizer_product( $wp_customize ) {
	$wp_customize->add_section(
		'product_section',
		array(
			'title'    => __( 'Product', 'starter' ),
			'priority' => 60,
			'panel'    => 'starter_theme_panel',
		)
	);
}
add_action( 'customize_register', 'starter_customizer_product', 50 );


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
			'section' => 'product_section',
			'label'   => __( 'Enable hover product image', 'starter' ),
			'type'    => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'starter_customizer_hover_product_image', 50 );
