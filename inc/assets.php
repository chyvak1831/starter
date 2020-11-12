<?php
/**
 * Remove unnecessary Wordpress assets
 *
 * @package starter
 * @since 1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Remove default assest.
 *
 * @since starter 1.0
 */
function starter_remove_default_assets() {
	/*strange embed assets*/
	wp_deregister_script( 'wp-embed' );
	/*wp emojis*/
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	add_filter( 'emoji_svg_url', '__return_false' );
	/*wp version*/
	remove_action( 'wp_head', 'wp_generator' );
	/*blog and windows live clients*/
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	/*REST API*/
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 ); /*Disable REST API link tag*/
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 ); /*Disable oEmbed Discovery Links*/
	remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 ); /*Disable REST API link in HTTP headers*/
}
if ( ! is_admin() ) {
	add_action( 'init', 'starter_remove_default_assets' );
}

/**
 * Remove gutenberg block assets.
 *
 * @since starter 1.0
 */
function starter_remove_block_library_css() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
}
add_action( 'wp_enqueue_scripts', 'starter_remove_block_library_css' );

/**
 * Enqueues scripts.
 *
 * @since starter 1.0
 */
function starter_enqueues_scripts() {
	wp_enqueue_script( 'plugins', get_template_directory_uri() . '/assets/js/plugins.js', array ( 'jquery' ), filemtime( get_stylesheet_directory() . '/assets/js/plugins.js' ), true );
	wp_add_inline_script( 'plugins', file_get_contents( get_stylesheet_directory() . '/assets/js/iosPreloadFix.js' ) );
	wp_enqueue_script( 'script', get_template_directory_uri() . '/assets/js/scripts.js', array ( 'jquery', 'plugins' ), filemtime( get_stylesheet_directory() . '/assets/js/scripts.js' ), true );
	wp_localize_script( 'script', 'starter_ajax', array( 'ajax_url' => WC()->ajax_url() ) );
}
add_action( 'wp_enqueue_scripts', 'starter_enqueues_scripts' );

/**
 * Enqueues styles.
 *
 * @since starter 1.0
 */
function starter_enqueues_styles() {
	wp_enqueue_style( 'plugins', get_template_directory_uri() . '/assets/css/plugins.css', '', filemtime( get_stylesheet_directory() . '/assets/css/plugins.css' ) );
	wp_enqueue_style( 'styles', get_template_directory_uri() . '/assets/css/styles.css', '', filemtime( get_stylesheet_directory() . '/assets/css/styles.css' ) );
}
add_action( 'wp_enqueue_scripts', 'starter_enqueues_styles' );

/**
 * Replace stylesheet attr into preload for all pages exception cart/checkout/account
 *
 * @since starter 1.0
 *
 * @param string $tag <link> tag.
 * @return string $tag modified <link> tag.
 */
function starter_css_preloader_tag( $tag ) {
	$tag = preg_replace( "/rel='stylesheet'/", "rel='preload' as='style' onload=\"this.rel='stylesheet'\" ", $tag );
	return $tag;
}
function starter_preloader_tag() {
	if ( !is_cart() && !is_checkout() && !is_account_page() ) {
		add_filter( 'style_loader_tag', 'starter_css_preloader_tag' );
	}
}
add_action( 'wp_head', 'starter_preloader_tag' );
add_action( 'wp_enqueue_scripts', 'starter_preloader_tag' );

/**
 * Include critical css to head.
 *
 * @since starter 1.0
 */
function starter_enqueues_critical_styles() {
	global $template;
	$starter_name_template = substr( basename( $template ), 0, -4 );
	$starter_path_css      = get_stylesheet_directory() . '/assets/css/critical/' . $starter_name_template . '.css';
	if ( file_exists( $starter_path_css ) ) {
		echo '<style>';
		echo file_get_contents( $starter_path_css );
		echo '</style>';
	}
}
add_action( 'wp_enqueue_scripts', 'starter_enqueues_critical_styles' );

/**
 * Add custom css file into wordpress admin.
 *
 * @since starter 1.0
 */
function starter_enqueues_admin_styles() {
	wp_enqueue_style( 'admin-styles', get_template_directory_uri() . '/assets/css/wp_admin.css', '', filemtime( get_stylesheet_directory() . '/assets/css/wp_admin.css' ) );
}
add_action( 'admin_enqueue_scripts', 'starter_enqueues_admin_styles' );