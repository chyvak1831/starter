<?php
/**
 * Dev function
 *
 * @package starter
 * @since 1.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Customizer: add Dev panel
 *
 * @since starter 1.1
 *
 * @param string $wp_customize .
 */
function starter_customizer_dev_panel( $wp_customize ) {
	$wp_customize->add_panel(
		'dev_panel',
		array(
			'title'       => __( 'Dev functions', 'starter' ),
			'description' => __( 'Dev functions description', 'starter' ),
			'priority'    => 1000,
		)
	);
}
add_action( 'customize_register', 'starter_customizer_dev_panel', 50 );

/**
 * Customizer: CSS optimization
 *
 * @since starter 1.1
 *
 * @param string $wp_customize .
 */
function starter_customizer_css_optimization( $wp_customize ) {
	$wp_customize->add_section(
		'css_optimization_section',
		array(
			'title'    => __( 'CSS optimization', 'starter' ),
			'priority' => 1,
			'panel'    => 'dev_panel',
		)
	);
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
			'section' => 'css_optimization_section',
			'label'   => __( 'Enable preload', 'starter' ),
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
			'section' => 'css_optimization_section',
			'label'   => __( 'Enable critical', 'starter' ),
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
	$wp_customize->add_section(
		'image_optimization_section',
		array(
			'title'    => __( 'Image optimization', 'starter' ),
			'priority' => 2,
			'panel'    => 'dev_panel',
		)
	);
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
			'section' => 'image_optimization_section',
			'label'   => __( 'Enable WebP', 'starter' ),
			'type'    => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'starter_customizer_image_optimization', 50 );
