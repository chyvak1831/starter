<?php
/**
 * Recaptcha function and setting for recaptcha in customizer
 *
 * @package starter
 * @since 1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Validate recaptcha.
 *
 * @since starter 1.0
 *
 * @param string $response String of $_POST['g-recaptcha-response'].
 * @return recatpcha object
 */
function starter_validate_recaptcha( $response ) {
	$secret_key = get_theme_mod( 'private_recaptcha_key' );
	// @codingStandardsIgnoreStart safe to use due provided by server https://stackoverflow.com/a/39180087/7569674
	$ip_user = $_SERVER['REMOTE_ADDR'];
	// @codingStandardsIgnoreEnd
	$request  = 'https://www.google.com/recaptcha/api/siteverify?secret=' . rawurlencode( $secret_key ) . '&response=' . rawurlencode( $response ) . '&remoteip=' . rawurlencode( $ip_user );
	$response = json_decode( wp_remote_get( $request )['body'], true );
	return $response;
}

/**
 * Customizer: recaptcha
 *
 * @since starter 1.0
 *
 * @param string $wp_customize .
 */
function starter_customizer_recaptcha( $wp_customize ) {
	/**
	 * Add section
	 */
	$wp_customize->add_section(
		'recaptcha_section',
		array(
			'title'    => 'Recaptcha',
			'priority' => 1,
			'panel'    => 'woocommerce',
		)
	);
	/**
	 * Public key
	 */
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
	/**
	 * Private section
	 */
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
	/**
	 * Comment recaptcha
	 */
	$wp_customize->add_setting(
		'comment_recaptcha',
		array(
			'default'   => false,
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'comment_recaptcha',
		array(
			'section' => 'recaptcha_section',
			'label'   => 'Comment',
			'type'    => 'checkbox',
		)
	);
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
			'label'   => 'Login',
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
			'label'   => 'Registration',
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
			'label'   => 'Lost Password',
			'type'    => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'starter_customizer_recaptcha', 50 );

/**
 * Recaptcha markup
 *
 * @since starter 1.1
 */
function starter_recaptcha_markup() { ?>
	<div class="form-row">
		<input type="hidden" class="js_recaptcha_input">
		<div class="g-recaptcha" data-callback="recaptchaCallback" data-recaptchapublickey="<?php echo esc_attr( get_theme_mod( 'public_recaptcha_key' ) ); ?>"></div>
		<div class="invalid-feedback"><?php esc_html_e( 'This field is required.', 'starter' ); ?></div>
	</div>
<?php
}

/**
 * Registration recaptcha: validation
 *
 * @since starter 1.1
 *
 * @param string $errors .
 */
function starter_recaptcha_validation( $errors ) {
	if ( ! empty( $_POST['g-recaptcha-response'] ) && ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
		$response = starter_validate_recaptcha( sanitize_text_field( wp_unslash( $_POST['g-recaptcha-response'] ) ) );
		if ( ! $response['success'] ) {
			$errors->add( 'recaptcha_error', __( 'Please click the reCAPTCHA checkbox to proceed.', 'starter' ) ); /*missing recaptcha field and other cases*/
		}
	} else {
		$errors->add( 'recaptcha_error', __( 'Please click the reCAPTCHA checkbox to proceed.', 'starter' ) ); /*recaptcha textarea wrong value*/
	}
	return $errors;
}


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