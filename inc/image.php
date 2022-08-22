<?php
/**
 * Image function & settings
 *
 * @package WordPress
 * @subpackage starter
 * @since 1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Image html output
 *
 * @since starter 1.0
 *
 * @param array $atts of image: image ID & sizes.
 * @return string img html
 */
function starter_img_func( $atts ) {
	/*get image ID or placeholder ID*/
	$img = $atts['img_id'] ? $atts['img_id'] : get_theme_mod( 'image_placeholder' );

	/*get image lazy parameter*/
	$lazy = ( isset( $atts['lazy'] ) && 'false' == $atts['lazy'] ) ? '' : 'loading="lazy"';

	/*default values*/
	$img_width  = 'width="100%"';
	$img_height = 'height="100%"';
	$img_markup = '';

	if ( $img ) {

		/*get image sizes, src, srcset*/
		$img_sizes  = "sizes='" . $atts['img_sizes'] . "'";
		$img_src    = esc_url( wp_get_attachment_image_url( $img, $atts['img_src'] ) );
		$img_srcset = wp_get_attachment_image_srcset( $img );

		/*add webp image if enabled*/
		if ( get_theme_mod( 'image_webp', true ) && wp_get_attachment_image_srcset( $img ) ) {
			$img_srcset_webp = str_ireplace( array( '.jpg ', '.jpeg ', '.png ' ), array( '.jpg.webp ', '.jpeg.webp ', '.png.webp ' ), $img_srcset );
			$img_markup      = "<source type='image/webp' srcset=\"$img_srcset_webp\" $img_sizes>";
		}

		/*get image alt if existing or add title instead*/
		$img_alt = "alt='" . esc_attr( get_post_meta( $img, '_wp_attachment_image_alt', true ) ) . "'";
		if ( ! get_post_meta( $img, '_wp_attachment_image_alt', true ) ) {
			$img_alt = "alt='" . get_post( $img )->post_title . "'";
		}

		/*get image sizes*/
		if ( 0 != wp_get_attachment_image_src( $img, 'full' )[1] ) {
			$img_width = "width='" . wp_get_attachment_image_src( $img, 'full' )[1] . "'";
		}
		if ( 0 != wp_get_attachment_image_src( $img, 'full' )[2] ) {
			$img_height = "height='" . wp_get_attachment_image_src( $img, 'full' )[2] . "'";
		}

		/*return image markup*/
		return $img_markup . "<img class='img-fluid' $lazy src=\"$img_src\" srcset=\"$img_srcset\" $img_sizes $img_alt $img_width $img_height>";

	} else {
		/*return onepixel placeholder if both image and placeholder ID missing*/
		return "<img class='img-fluid' src='data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==' alt='Image' $img_width $img_height>";
	}
}

/**
 * Remove default WP image sizes.
 *
 * @since starter 1.0
 *
 * @param array $default_sizes Default image size names.
 * @return array $default_sizes Updated image names
 */
function starter_remove_default_wp_image_sizes( $default_sizes ) {
	return array_diff( $default_sizes, array( 'medium', 'medium_large', 'large', '1536x1536', '2048x2048' ) );
}
add_action( 'intermediate_image_sizes', 'starter_remove_default_wp_image_sizes', 999 );

/**
 * Add custom image sizes.
 *
 * @since starter 1.0
 */
function starter_custom_thumbnail_size() {
	add_image_size( 'w200', 200 );
	add_image_size( 'w400', 400 );
	add_image_size( 'w600', 600 );
	add_image_size( 'w800', 800 );
	add_image_size( 'w1000', 1000 );
	add_image_size( 'w1200', 1200 );
	add_image_size( 'w1400', 1400 );
	add_image_size( 'w1600', 1600 );
	add_image_size( 'w1800', 1800 );
	add_image_size( 'w2000', 2000 );
}
add_action( 'after_setup_theme', 'starter_custom_thumbnail_size', 999 );

/**
 * Add source to allowed wp_kses_post tags
 *
 * @since starter 1.0
 *
 * @param array  $tags Allowed tags, attributes, and/or entities.
 * @param string $context Context to judge allowed tags by.
 *
 * @return array
 */
function starter_wpkses_post_tags( $tags, $context ) {
	$tags['img']['sizes']  = true;
	$tags['img']['srcset'] = true;
	$tags['source']        = array(
		'srcset' => true,
		'sizes'  => true,
		'type'   => true,
	);
	return $tags;
}
add_filter( 'wp_kses_allowed_html', 'starter_wpkses_post_tags', 10, 2 );

/**
 * Allow data protocol
 *
 * @since starter 2.0
 *
 * @param array $protocols Allowed protocols.
 *
 * @return array
 */
function starter_kses_allowed_protocols( $protocols ) {
	$protocols[] = 'data';
	return $protocols;
}
add_filter( 'kses_allowed_protocols', 'starter_kses_allowed_protocols', 10, 2 );

/**
 * Allow upload svg files.
 *
 * @since starter 1.0
 *
 * @param array $mimes Mime types keyed by the file extension regex corresponding to those types.
 * @return array $mimes with svg.
 */
function starter_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'starter_mime_types' );

/**
 * Add image settings
 *
 * @since starter 2.0
 *
 * @param string $wp_customize .
 */
function starter_customizer_image( $wp_customize ) {
	/**
	 * Add image section
	 */
	$wp_customize->add_section(
		'image_section',
		array(
			'title'    => __( 'Image', 'starter' ),
			'priority' => 60,
			'panel'    => 'starter_theme_panel',
		)
	);
	/**
	 * On/off webp image
	 */
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
			'section'  => 'image_section',
			'label'    => __( 'Enable WebP', 'starter' ),
			'type'     => 'checkbox',
			'priority' => 1,
		)
	);
	/**
	 * Add image placeholder
	 */
	$wp_customize->add_setting(
		'image_placeholder',
		array(
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'image_placeholder',
			array(
				'section' => 'image_section',
				'label'   => __( 'Image placeholder', 'starter' ),
			)
		)
	);
}
add_action( 'customize_register', 'starter_customizer_image', 50 );
