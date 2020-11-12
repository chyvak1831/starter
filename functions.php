<?php
/**
 * Functions and definitions
 *
 * @package starter
 * @since starter 1.0
 */

/**
 * Manage assets
 */
require_once get_stylesheet_directory() . '/inc/assets.php';

/**
 * Fork of twentyseventeen/inc/icon-functions.php.
 */
require_once get_stylesheet_directory() . '/inc/icon-functions.php';

/**
 * Image function & settings.
 */
require_once get_stylesheet_directory() . '/inc/image.php';

/**
 * Menu improvements: icons, font-size, colors and more.
 */
require_once get_stylesheet_directory() . '/inc/menu.php';

/**
 * Recaptcha feature
 */
require_once get_stylesheet_directory() . '/inc/recaptcha.php';

/**
 * WYSIWYG improvements: remove "Add media" button, add font-sizes/font-families/line-height/letter-spacing.
 */
require_once get_stylesheet_directory() . '/inc/tiny-mce-advanced.php';

/**
 * Include woocommerce funstions if plugin enabled.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require_once get_stylesheet_directory() . '/inc/woocommerce/woocommerce.php';
}

/**
 * Main settings theme - fork from twentyseventeen/functions.php.
 *
 * @since starter 1.0
 */
function starter_setup() {
	/*
	 * Make theme available for translation.
	 * Use a find and replace to change 'starter' to the name of your theme in all the template files.
	 * https://developer.wordpress.org/reference/functions/load_theme_textdomain/
	 */
	load_theme_textdomain( 'starter' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'starter_setup' );

/**
 * Get unique ID - fork from twentyseventeen/functions.php.

 *
 * This is a PHP implementation of Underscore's uniqueId method. A static variable
 * contains an integer that is incremented with each call. This number is returned
 * with the optional prefix. As such the returned value is not universally unique,
 * but it is unique across the life of the PHP process.
 *
 * @since starter 1.0
 * @see wp_unique_id() Themes requiring WordPress 5.0.3 and greater should use this instead.
 *
 * @staticvar int $id_counter
 *
 * @param string $prefix Prefix for the returned ID.
 * @return string Unique ID.
 */
function starter_unique_id( $prefix = '' ) {
	static $id_counter = 0;
	if ( function_exists( 'wp_unique_id' ) ) {
		return wp_unique_id( $prefix );
	}
	return $prefix . (string) ++$id_counter;
}

/**
 * Custom path save acf fields.
 *
 * @since starter 1.0
 *
 * @param string $path .
 */
function starter_custom_acf_save( $path ) {
	$path = get_stylesheet_directory() . '/inc/acf-json';
	return $path;
}
add_filter( 'acf/settings/save_json', 'starter_custom_acf_save' );

/**
 * Custom path load acf fields.
 *
 * @since starter 1.0
 *
 * @param string $paths .
 */
function starter_custom_acf_load( $paths ) {
	unset( $paths[0] );
	$paths[] = get_stylesheet_directory() . '/inc/acf-json';
	return $paths;
}
add_filter( 'acf/settings/load_json', 'starter_custom_acf_load' );

/**
 * Change dismiss text site wide notice
 *
 * @since ilnp 1.0
 */
function starter_replace_dismiss( $notice ) {
	return str_replace( 'Dismiss', starter_get_svg( array( 'icon' => 'bi-remove' ) ), $notice );
}
add_filter( 'woocommerce_demo_store','starter_replace_dismiss' );
