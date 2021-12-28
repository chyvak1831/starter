<?php
/**
 * Comment main file: customizer, backend
 *
 * @package WordPress
 * @subpackage starter
 * @since starter 1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Customizer: add comment settings.
 *
 * @since starter 1.0
 *
 * @param object $wp_customize .
 */
function starter_comments_customizer( $wp_customize ) {
	require_once get_stylesheet_directory() . '/inc/comment/comment-customizer.php';
}
add_action( 'customize_register', 'starter_comments_customizer', 50 );

/**
 * Comment rating, privacy, image backend
 */
require_once get_stylesheet_directory() . '/inc/comment/comment-backend.php';

/**
 * Ajax load comment (single page)
 *
 * @since starter 1.0
 */
function starter_comment_load() {
	// phpcs:disable
	if ( ! isset( $_POST['post_id'] ) || ! isset( $_POST['offset'] ) ) {
		wp_die();
	}
	$offset           = sanitize_text_field( wp_unslash( $_POST['offset'] ) );
	$post_id          = sanitize_text_field( wp_unslash( $_POST['post_id'] ) );
	$comment_quantity = get_option( 'page_comments', 0 ) ? get_option( 'comments_per_page', 2 ) : 0; // wp feature
	$comment_order    = get_option( 'comment_order', 'DESK' ); // wp feature
	// phpcs:enable
	$param          = array(
		'offset'  => $offset,
		'status'  => 'approve',
		'post_id' => $post_id,
		'orderby' => 'comment_date',
		'order'   => $comment_order,
		'number'  => $comment_quantity,
	);
	$comments_query = get_comments( $param );
	foreach ( $comments_query as $comment ) {
		$starter_comment_id = $comment->comment_ID;
		if ( class_exists( 'WooCommerce' ) && 'product' == get_post_type( $post_id ) ) {
			require get_stylesheet_directory() . '/woocommerce-custom/comment/comment-item.php';
		} else {
			require get_stylesheet_directory() . '/templates/comment/comment-item.php';
		}
	}
	wp_die();
}
add_action( 'wp_ajax_comment_load', 'starter_comment_load' );
add_action( 'wp_ajax_nopriv_comment_load', 'starter_comment_load' );

/**
 * Ajax load comment image modal
 *
 * @since starter 1.0
 */
function starter_comment_image() {
	// phpcs:disable
	if ( ! isset( $_POST['comment_id'] ) ) {
		wp_die();
	}
	$starter_comment_id = sanitize_text_field( wp_unslash( $_POST['comment_id'] ) );
	$comment            = get_comment( $starter_comment_id ); 
	$post_id            = $comment->comment_post_ID ;
	// phpcs:enable
	if ( class_exists( 'WooCommerce' ) && 'product' == get_post_type( $post_id ) ) {
		require get_stylesheet_directory() . '/woocommerce-custom/comment/comment-image-modal.php';
	} else {
		require get_stylesheet_directory() . '/templates/comment/comment-image-modal.php';
	}
	wp_die();
}
add_action( 'wp_ajax_comment_image', 'starter_comment_image' );
add_action( 'wp_ajax_nopriv_comment_image', 'starter_comment_image' );
