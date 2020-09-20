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
