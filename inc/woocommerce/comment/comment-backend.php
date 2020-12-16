<?php
/**
 * Comment backend
 *
 * @package starter
 * @since 1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Validation, run default wp_handle_comment_submission and save comment to DB.
 * If not valid, return errors.
 *
 * @since starter 1.0
 */
function starter_save_comment() {
	// validation error array
	$errors = [];

	check_ajax_referer( 'comment', 'security' );


	// bugfix for rating enable and review owner only features
	$starter_rating_disabled     = ( ! wc_review_ratings_enabled() && $_POST['rating'] ) ? 1 : 0;
	$starter_customer_not_bought = ( 'yes' === get_option( 'woocommerce_review_rating_verification_required', 'no' ) && ! wc_customer_bought_product( '', get_current_user_id(), absint( $_POST['comment_post_ID'] ) ) ) ? 1 : 0; // woo feature
	if ( $starter_rating_disabled || $starter_customer_not_bought ) {
		wp_send_json_error( __( 'Something went wrong, please reload page and try again', 'starter' ) );
	}


	// privacy validation
	if ( get_theme_mod( 'comment_privacy', true ) && ! $_POST['privacy_policy'] ) {
		$errors['privacy_policy'] = false;
	}


	// recaptcha validation
	if ( get_theme_mod( 'comment_recaptcha', false ) ) {
		if ( ! empty( $_POST['g-recaptcha-response'] ) && ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
			$response = starter_validate_recaptcha( $_POST['g-recaptcha-response'] );
			if ( ! $response['success'] ) {
				$errors['g-recaptcha-response'] = false; // missing recaptcha field and other cases
			}
		} else {
			$errors['g-recaptcha-response'] = false; // recaptcha textarea wrong value
		}
	}


	// image validation
	if ( isset( $_FILES['files'] ) && get_theme_mod( 'comment_file', false ) ) {
		$starter_maximum_length = get_theme_mod( 'comment_maximum_files', 10 ); /*maximum files*/
		$starter_maximum_weight = get_theme_mod( 'comment_maximum_weight', 15 ) * 1048576; /*MB, each file maximum weight*/
		$starter_allowed_types  = array( 'image/jpeg', 'image/jpg', 'image/png' );

		$starter_files          = $_FILES['files'];
		$starter_files_tmp_name = $starter_files['tmp_name'];

		if ( $starter_maximum_length < count( $starter_files_tmp_name ) ) {
			$errors['limit_files'] = true;
			wp_send_json_error( $errors );
		}

		foreach ( $starter_files_tmp_name as $key => $file ) {
			$starter_img_size = $starter_files['size'][$key];
			if ( $starter_maximum_weight < $starter_img_size ) {
				$errors['limit_file_size'] = true;
				wp_send_json_error( $errors );
			}

			if ( ! in_array( $starter_files['type'][$key], $starter_allowed_types ) ) {
				$errors['not_allowed_type'] = true;
				wp_send_json_error( $errors );
			}
		}
	}


	// make rating require if rating enabled
	if ( wc_review_ratings_enabled() && wc_review_ratings_required() ) {
		array_push( $require, 'price_rating', 'shipping_rating', 'quality_rating' );
	}

	foreach ( $require as $item ) {
		if ( empty( $_POST[ $item ] ) ) {
			$errors[ $item ] = true;
		}
	}

	if ( $errors ) {
		wp_send_json_error( $errors );
	}

	$comment = wp_handle_comment_submission( wp_unslash( $_POST ) );

	if ( is_wp_error( $comment ) ) {
		wp_send_json_error( $comment->get_error_message() );
	} else {
		// setup custom rating if rating enabled
		if ( wc_review_ratings_enabled() ) {
			$price_rating    = $_POST['price_rating'];
			$shipping_rating = $_POST['shipping_rating'];
			$quality_rating  = $_POST['quality_rating'];
			$price           = ( $price_rating > 5 || $price_rating < 0 ) ? 5 : $price_rating;
			$shipping        = ( $shipping_rating > 5 || $shipping_rating < 0 ) ? 5 : $shipping_rating;
			$quality         = ( $quality_rating > 5 || $quality_rating < 0 ) ? 5 : $quality_rating;
			$rating_group = array(
				'price'    => intval( $price ),
				'shipping' => intval( $shipping ),
				'quality'  => intval( $quality ),
			);
			update_field( 'rating_group', $rating_group, $comment );
		}

		// upload image if enabled
		if ( isset( $_FILES['files'] ) && get_theme_mod( 'comment_file', false ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			$starter_files   = $_FILES['files'];
			$starter_img_ids = [];
			foreach ( $starter_files['name'] as $key => $value ) {
				$starter_file = array(
					'name'     => $starter_files['name'][$key],
					'type'     => $starter_files['type'][$key],
					'tmp_name' => $starter_files['tmp_name'][$key],
					'error'    => $starter_files['error'][$key],
					'size'     => $starter_files['size'][$key]
				);
				$_FILES = array ( 'allfiles' => $starter_file );
				foreach ( $_FILES as $starter_file => $array ) {
					$starter_upload_id = media_handle_upload( $starter_file, 0 );
					array_push( $starter_img_ids, $starter_upload_id );
				}
			}
			update_field( 'comment_image', $starter_img_ids, get_comment( $comment->comment_ID ) );
		}

		WC_Comments::clear_transients( $comment->comment_post_ID );

		wp_send_json(
			array(
				'success'    => 'true',
				'comment_id' => $comment->comment_ID
			)
		);
	}
}
add_action( 'wp_ajax_starter_send_comment', 'starter_save_comment' );
add_action( 'wp_ajax_nopriv_starter_send_comment', 'starter_save_comment' );
