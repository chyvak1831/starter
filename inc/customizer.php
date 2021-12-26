<?php
/**
 * Starter theme customizer
 *
 * @package WordPress
 * @subpackage starter
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
 * Add CSS section
 *
 * @since starter 1.1
 *
 * @param string $wp_customize .
 */
function starter_customizer_css( $wp_customize ) {
	/**
	 * Add CSS section
	 */
	$wp_customize->add_section(
		'css_section',
		array(
			'title'    => __( 'CSS', 'starter' ),
			'priority' => 35,
			'panel'    => 'starter_theme_panel',
		)
	);
	/**
	 * On/off CSS preload
	 */
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
			'section' => 'css_section',
			'label'   => __( 'Enable preload CSS', 'starter' ),
			'type'    => 'checkbox',
		)
	);
	/**
	 * On/off critical CSS
	 */
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
			'section' => 'css_section',
			'label'   => __( 'Enable critical CSS', 'starter' ),
			'type'    => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'starter_customizer_css', 50 );

/**
 * Customizer: Add post ajax pagination
 *
 * @since starter 2.0
 *
 * @param string $wp_customize .
 */
function starter_customizer_post( $wp_customize ) {
	$wp_customize->add_setting(
		'post_ajax_pagination',
		array(
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'post_ajax_pagination',
		array(
			'section' => 'ajax_section',
			'label'   => __( 'Post category: pagination', 'starter' ),
			'type'    => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'starter_customizer_post', 50 );
