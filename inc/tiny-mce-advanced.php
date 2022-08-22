<?php
/**
 * WYSIWYG improvements: remove media button, add font-sizes/line-height/letter-spacing/font-families.
 *
 * @package WordPress
 * @subpackage starter
 * @since 1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Remove 'Add media' button.
 *
 * @since starter 1.0
 */
function starter_remove_add_media_buttons() {
	remove_action( 'media_buttons', 'media_buttons' );
}
add_action( 'admin_head', 'starter_remove_add_media_buttons' );

/**
 * Add custom font-sizes.
 *
 * @since starter 1.0
 *
 * @param array $mce_init An array with TinyMCE config.
 * @return array The custom font-sizes.
 */
function starter_tiny_mce_fontsize( $mce_init ) {
	$mce_init['fontsize_formats'] = '9px 10px 11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 21px 22px 23px 24px 25px 26px 27px 28px 29px 30px 31px 32px 33px 34px 35px 36px 37px 38px 39px 40px 41px 42px 43px 44px 45px';
	return $mce_init;
}
add_filter( 'tiny_mce_before_init', 'starter_tiny_mce_fontsize' );

/**
 * Add letter_spacing & line_height.
 *
 * @since starter 1.0
 *
 * @param array $mce_init An array with TinyMCE config.
 * @return array The custom letter-spacing & line-height sets.
 */
function starter_tiny_mce_custom_settings( $mce_init ) {
	$arr_letter_spacing = array();
	for ( $i = -2; $i < 2.1; $i += 0.1 ) {
		$i = round( $i, 1 );
		array_push(
			$arr_letter_spacing,
			array(
				'title'    => $i . 'px',
				'inline'   => 'span',
				'selector' => '*',
				'styles'   => array( 'letterSpacing' => $i . 'px' ),
			)
		);
	}
	$arr_line_height = array();
	for ( $i = 1; $i < 2.1; $i += 0.1 ) {
		$i = round( $i, 1 );
		array_push(
			$arr_line_height,
			array(
				'title'    => $i,
				'selector' => 'p,div,h1,h2,h3,h4,h5,h6',
				'styles'   => array( 'lineHeight' => $i . 'em' ),
			)
		);
	}
	$style_formats             = array(
		array(
			'title' => 'Letter-spacing',
			'items' => $arr_letter_spacing,
		),
		array(
			'title' => 'Line-height',
			'items' => $arr_line_height,
		),
	);
	$mce_init['style_formats'] = wp_json_encode( $style_formats );
	return $mce_init;
}
add_filter( 'tiny_mce_before_init', 'starter_tiny_mce_custom_settings' );

/**
 * Google fonts feature
 * Customizer: add google font.
 *
 * @since starter 1.0
 *
 * @param object $wp_customize Instance of the WP_Customize_Manager class.
 */
function starter_customizer_google_fonts( $wp_customize ) {
	$wp_customize->add_section(
		'font_section',
		array(
			'title'    => 'Fonts',
			'priority' => 40,
			'panel'    => 'starter_theme_panel',
		)
	);
	$wp_customize->add_setting(
		'google_fonts',
		array(
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
			// @codingStandardsIgnoreStart due that's default safe google font css string
			'default'   => '<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">',
			// @codingStandardsIgnoreEnd
		)
	);
	$wp_customize->add_control(
		'google_fonts',
		array(
			'section' => 'font_section',
			'type'    => 'textarea',
			'label'   => 'Google fonts',
		)
	);
	$wp_customize->add_setting(
		'default_google_font',
		array(
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
			'default'   => "font-family: 'Open Sans', sans-serif;",
		)
	);
	$wp_customize->add_control(
		'default_google_font',
		array(
			'section' => 'font_section',
			'label'   => 'Default google font',
		)
	);
}
add_action( 'customize_register', 'starter_customizer_google_fonts', 50 );

/**
 * Extract URL from google font <link>.
 *
 * @since starter 1.0
 * @return string Google font URL
 */
function starter_get_google_fonts_url() {
	// @codingStandardsIgnoreStart due that's default safe google font css string
	$google_fonts = get_theme_mod( 'google_fonts', '<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">' );
	// @codingStandardsIgnoreEnd
	preg_match_all( '/href="([^\s"]+)/', $google_fonts, $google_fonts_url );
	return $google_fonts_url[1][0];
}

/**
 * Extract google font css into array
 *
 * @since starter 1.0
 * @return array Google font array
 */
function starter_google_fonts_array() {
	$google_fonts_css = wp_remote_get( starter_get_google_fonts_url() )['body'];
	$matches          = preg_split( '~(?>@font-face\s*{\s*|\G(?!\A))(\S+)\s*:\s*([^;]+);\s*~', $google_fonts_css, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );
	/*index counter*/
	$i                  = 0;
	$google_fonts_array = array();
	/*PHP 7 doesn't change internal pointer, hence passing by-ref*/
	foreach ( $matches as $key => &$match ) {
		/*Check if we're reaching end of block*/
		if ( strpos( $match, '}' ) !== 0 ) {
			/*Storing current value as key, next as value*/
			$google_fonts_array[ $i ][ $match ] = $matches[ $key + 1 ];
			/*Skip over next value off iteration*/
			unset( $matches[ $key + 1 ] );
			continue;
		}
		/*Increment index counter*/
		$i++;
	}
	return $google_fonts_array;
}

/**
 * Inline google font css.
 *
 * @since starter 1.0
 * @return string Inline google font css
 */
function starter_google_fonts_css() {
	$google_fonts_name_array = array();
	foreach ( starter_google_fonts_array() as $key => $value ) {
		array_push( $google_fonts_name_array, $value['font-family'] );
	}
	$google_fonts_css = '';
	foreach ( array_unique( $google_fonts_name_array ) as $key => $value ) {
		$google_fonts_css .= '[style*=' . $value . '] {font-family:' . $value . ' !important}';
	}
	$default_google_font = get_theme_mod( 'default_google_font', "font-family: 'Open Sans', sans-serif;" );
	$google_fonts_css   .= '#tinymce {' . $default_google_font . '}:root {--bs-body-font-family:' . str_replace( 'font-family:', '', $default_google_font ) . '}';
	$google_font_weights = "[style*='MCEfontweight100'] {font-weight: 100 !important} [style*='MCEfontweight200'] {font-weight: 200 !important} [style*='MCEfontweight300'] {font-weight: 300 !important} [style*='MCEfontweight400'] {font-weight: 400 !important} [style*='MCEfontweight500'] {font-weight: 500 !important} [style*='MCEfontweight600'] {font-weight: 600 !important} [style*='MCEfontweight700'] {font-weight: 700 !important} [style*='MCEfontweight800'] {font-weight: 800 !important} [style*='MCEfontweight900'] {font-weight: 900 !important}";
	return $google_fonts_css . $google_font_weights;
}

/**
 * Add custom font-families to tiny mce.
 *
 * @since starter 1.0
 *
 * @param array $mce_init An array with TinyMCE config.
 * @return array The custom font-families.
 */
function starter_tiny_mce_fontfamily( $mce_init ) {
	$tme_font = '';
	foreach ( starter_google_fonts_array() as $key => $value ) {
		if ( 'normal' === $value['font-style'] ) {
			$family_name = str_replace( "'", '', $value['font-family'] );
			switch ( $value['font-weight'] ) {
				case '100':
					$font_weight_name = ' Thin';
					break;
				case '200':
					$font_weight_name = ' ExtraLight';
					break;
				case '300':
					$font_weight_name = ' Light';
					break;
				case '400':
					$font_weight_name = ' Regular';
					break;
				case '500':
					$font_weight_name = ' Medium';
					break;
				case '600':
					$font_weight_name = ' SemiBold';
					break;
				case '700':
					$font_weight_name = ' Bold';
					break;
				case '800':
					$font_weight_name = ' ExtraBold';
					break;
				case '900':
					$font_weight_name = ' Black';
					break;
			}
			$tme_font .= $family_name . $font_weight_name . '=' . $family_name . 'MCEfontweight' . $value['font-weight'] . ';';
		}
	}
	$mce_init['font_formats']  = $tme_font;
	$mce_init['content_style'] = starter_google_fonts_css();
	return $mce_init;
}
add_filter( 'tiny_mce_before_init', 'starter_tiny_mce_fontfamily' );

/**
 * Load google font into tinymce editor (used directly in wysiwyg - in iframe)
 *
 * @since starter 1.0
 */
function starter_add_editor_styles() {
	add_editor_style( starter_get_google_fonts_url() );
}
add_action( 'admin_init', 'starter_add_editor_styles' );

/**
 * Load google font into WP admin (used in wysiwyg - for font-family dropdown)
 *
 * @since starter 1.0
 */
function starter_admin_google_fonts() {
	wp_enqueue_style( 'google-fonts', starter_get_google_fonts_url(), array(), null );
	wp_add_inline_style( 'google-fonts', starter_google_fonts_css() );
}
add_action( 'admin_enqueue_scripts', 'starter_admin_google_fonts' );


/**
 * Load google font to frontend
 *
 * @since starter 1.0
 */
function starter_frontend_google_fonts() {
	wp_enqueue_style( 'google-fonts', starter_get_google_fonts_url(), array(), null );
	wp_add_inline_style( 'google-fonts', starter_google_fonts_css() );
}
add_action( 'get_footer', 'starter_frontend_google_fonts' );
