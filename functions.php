<?php
/**
 * Functions and definitions
 *
 * @package starter
 * @since starter 1.0
 */

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
 * Remove unnecessary Wordpress assets
 */
require_once get_stylesheet_directory() . '/inc/remove-wp-assets.php';

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
 * Add custom css file into wordpress admin.
 *
 * @since starter 1.0
 */
function starter_admin_style() {
	$starter_admin_css = '/assets/css/wp_admin.css';
	wp_enqueue_style( 'admin-styles', get_template_directory_uri() . $starter_admin_css, '', filemtime( get_stylesheet_directory() . $starter_admin_css ) );
}
add_action( 'admin_enqueue_scripts', 'starter_admin_style' );

/**
 * Customizer: recaptcha keys.
 *
 * @since starter 1.0
 *
 * @param object $wp_customize .
 */
function starter_customizer( $wp_customize ) {
	require_once get_stylesheet_directory() . '/inc/customizer.php';
}
add_action( 'customize_register', 'starter_customizer', 50 );

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
 * Replace stylesheet attr into preload for all pages exception cart/checkout/account
 *
 * @since starter 1.0
 *
 * @param string $tag <link> tag.
 * @return string $tag modified <link> tag.
 */
function starter_css_loader_tag( $tag ) {
	$tag = preg_replace( "/rel='stylesheet'/", "rel='preload' as='style' onload=\"this.rel='stylesheet'\" ", $tag );
	return $tag;
}
function starter_preloader_tag() {
	if ( !is_cart() && !is_checkout() && !is_account_page() ) {
		add_filter( 'style_loader_tag', 'starter_css_loader_tag' );
	}
}
add_action( 'wp_head', 'starter_preloader_tag' );
add_action( 'wp_enqueue_scripts', 'starter_preloader_tag' );

/**
 * Include critical css to head.
 *
 * @since starter 1.0
 */
function starter_critical_css_to_wp_head() {
	global $template;
	$starter_name_template = substr( basename( $template ), 0, -4 );
	$starter_path_css      = get_stylesheet_directory() . '/assets/css/critical/' . $starter_name_template . '.css';
	echo '<style>';
	echo file_get_contents( $starter_path_css );
	echo '</style>';
}
add_action( 'wp_head', 'starter_critical_css_to_wp_head' );

/**
 * Enqueues scripts and styles.
 *
 * @since starter 1.0
 */
function starter_enqueues_styles_scripts() {
	wp_enqueue_style( 'plugins', get_template_directory_uri() . '/assets/css/plugins.css', false, filemtime( get_stylesheet_directory() . '/assets/css/plugins.css' ) );
	wp_enqueue_style( 'styles', get_template_directory_uri() . '/assets/css/styles.css', false, filemtime( get_stylesheet_directory() . '/assets/css/styles.css' ) );
	wp_enqueue_script( 'plugins', get_template_directory_uri() . '/assets/js/plugins.js', array ( 'jquery' ), filemtime( get_stylesheet_directory() . '/assets/js/plugins.js' ), true );
	wp_add_inline_script( 'plugins', file_get_contents( get_stylesheet_directory() . '/assets/js/iosPreloadFix.js' ) );
	wp_enqueue_script( 'script', get_template_directory_uri() . '/assets/js/scripts.js', array ( 'jquery', 'plugins' ), filemtime( get_stylesheet_directory() . '/assets/js/scripts.js' ), true );
	wp_localize_script( 'script', 'starter_ajax', array( 'ajax_url' => WC()->ajax_url() ) );
}
add_action( 'get_footer', 'starter_enqueues_styles_scripts' );
