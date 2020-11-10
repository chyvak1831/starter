<?php
/**
 * Recaptcha function and setting for recaptcha in customizer
 *
 * @package starter
 * @since 1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Customizer: recaptcha
 *
 * @since starter 1.0
 *
 * @param string $wp_customize .
 */
function starter_customizer_recaptcha( $wp_customize ) {
	$wp_customize->add_section(
		'recaptcha_section',
		array(
			'title'    => 'Google recaptcha keys',
			'priority' => 1,
			'panel'    => 'woocommerce',
		)
	);
	$wp_customize->add_setting(
		'public_recaptcha_key',
		array(
			'default'   => '1',
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'public_recaptcha_key',
		array(
			'section' => 'recaptcha_section',
			'label'   => 'Set public key',
			'type'    => 'text',
		)
	);
	$wp_customize->add_setting(
		'private_recaptcha_key',
		array(
			'default'   => '1',
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'private_recaptcha_key',
		array(
			'section' => 'recaptcha_section',
			'label'   => 'Set private key',
			'type'    => 'text',
		)
	);
}
add_action( 'customize_register', 'starter_customizer_recaptcha', 50 );

/**
 * Validate recaptcha.
 *
 * @since starter 1.0
 *
 * @param string $response .
 */
function starter_validate_recaptcha( $response ) {
   $starter_secret_key = get_theme_mod( 'private_recaptcha_key' );
   $starter_ip_user    = $_SERVER['REMOTE_ADDR'];
   $starter_request    = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode( $starter_secret_key ) . '&response=' . urlencode( $response ) . '&remoteip=' . urlencode( $starter_ip_user );
   $starter_response   = json_decode( file_get_contents( $starter_request ), true );
   return $starter_response;
}
