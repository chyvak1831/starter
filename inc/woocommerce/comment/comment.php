<?php
/**
 * Comment main file: customizer, backend
 *
 * @package starter
 * @since 1.0
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
	require_once get_stylesheet_directory() . '/inc/woocommerce/comment/comment-customizer.php';
}
add_action( 'customize_register', 'starter_comments_customizer', 50 );

/**
 * Comment rating, privacy, image backend
 */
require_once get_stylesheet_directory() . '/inc/woocommerce/comment/comment-backend.php';

/**
 * Ajax load comment (single page)
 *
 * @since starter 1.0
 */
function starter_comment_load() {
	// phpcs:disable
	if ( ! isset( $_POST['product_id'] ) || ! isset( $_POST['offset'] ) ) {
		wp_die();
	}
	$starter_product_id       = sanitize_text_field( wp_unslash( $_POST['product_id'] ) );
	$starter_offset           = sanitize_text_field( wp_unslash( $_POST['offset'] ) );
	$starter_comment_quantity = get_option( 'comments_per_page', 2 );
	$starter_comment_order    = get_option( 'comment_order', 'DESK' );
	// phpcs:enable
	$starter_param = array(
		'offset'  => $starter_offset,
		'status'  => 'approve',
		'post_id' => $starter_product_id,
		'orderby' => 'comment_date',
		'order'   => $starter_comment_order,
		'number'  => $starter_comment_quantity,
	);
	$starter_comments_query   = get_comments( $starter_param );
	foreach ( $starter_comments_query as $starter_comment ) {
		$starter_comment_id = $starter_comment->comment_ID;
		require get_stylesheet_directory() . '/woocommerce-custom/comment/comment-item.php';
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
	// phpcs:enable
	require get_stylesheet_directory() . '/woocommerce-custom/comment/comment-image-modal.php';
	wp_die();
}
add_action( 'wp_ajax_comment_image', 'starter_comment_image' );
add_action( 'wp_ajax_nopriv_comment_image', 'starter_comment_image' );