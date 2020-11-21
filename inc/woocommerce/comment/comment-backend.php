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
	check_ajax_referer( 'comment', 'security' );

	$require = [ 'privacy_policy' ];

	// make rating require if rating enabled
	if ( wc_review_ratings_enabled() && wc_review_ratings_required() ) {
		array_push( $require, 'price_rating', 'shipping_rating', 'quality_rating' );
	}

	// bugfix for rating enable and review owner only features
	$starter_rating_disabled     = ( ! wc_review_ratings_enabled() && $_POST['rating'] ) ? 1 : 0;
	$starter_customer_not_bought = ( 'yes' === get_option( 'woocommerce_review_rating_verification_required', 'no' ) && ! wc_customer_bought_product( '', get_current_user_id(), absint( $_POST['comment_post_ID'] ) ) ) ? 1 : 0; // woo feature
	if ( $starter_rating_disabled || $starter_customer_not_bought ) {
		wp_send_json_error( __( 'Something went wrong, please reload page and try again', 'starter' ) );
	}

	// Validations
	$errors = [];
	foreach ( $require as $item ) {
		if ( empty( $_POST[ $item ] ) ) {
			$errors[ $item ] = true;
		}
	}

	if ( get_theme_mod( 'comment_recaptcha', false ) ) {
		if ( ! empty( $_POST['g-recaptcha-response'] ) && ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
			$response = starter_validate_recaptcha( $_POST['g-recaptcha-response'] );
			if ( ! $response['success'] ) {
				$errors['g-recaptcha-response'] = true; // missing recaptcha field and other cases
			}
		} else {
			$errors['g-recaptcha-response'] = true; // recaptcha textarea wrong value
		}
	}

	if ( isset( $_FILES['files'] ) && ! empty( $_FILES['files']['tmp_name'][0] ) && ! empty( $_FILES['files']['name'][0] ) ) {
		$starter_maximum_length = get_theme_mod( 'comment_maximum_files', 10 ); /*maximum files*/
		$starter_maximum_weight = get_theme_mod( 'comment_maximum_weight', 15 ) * 1048576; /*MB, each file maximum weight*/

		$allowed_types  = array( 'jpg','jpeg','png' );
		$files          = $_FILES['files'];
		$files_tmp_name = $files['tmp_name'];

		if ( $starter_maximum_length < count( $files_tmp_name ) ) {
			$errors['limit_files'] = true;
			wp_send_json_error( $errors );
		}

		foreach ( $files_tmp_name as $key => $file ) {
			$name        = $files['name'][$key];
			$type        = pathinfo( $name, PATHINFO_EXTENSION );
			$size        = $files['size'][$key];
			if ( $starter_maximum_weight < $size ) {
				$errors['limit_file_size'] = true;
				wp_send_json_error( $errors );
			}
			if ( ! in_array( $type, $allowed_types ) ) {
				$errors['not_allowed_type'] = true;
				wp_send_json_error( $errors );
			}
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

		if ( isset( $_FILES['files'] ) && ! empty( $_FILES['files']['tmp_name'][0] ) && ! empty( $_FILES['files']['name'][0] ) ) {
			$files          = $_FILES['files'];
			$files_tmp_name = $files['tmp_name'];

			foreach ( $files_tmp_name as $key => $file ) {
				$name     = $files['name'][$key];
				$tmp_name = $files['tmp_name'][$key];
				starter_send_image_to_comment( $comment->comment_ID, $name, $tmp_name );
			}
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


/**
 * Uploads an image from tmp directory to WP media
 *
 * @param string $temp_file path to uploaded tmp file.
 * @param string $image image name.
 *
 * @return mixed $attach_id or false
 * @since starter 1.0
 */
function starter_upload_images_from_url( $temp_file, $image ) {
	if ( ! is_wp_error( $temp_file ) ) {
		$filetype = wp_check_filetype( basename( $temp_file ) );
		$file     = array(
			'name'     => $image,
			'type'     => $filetype['type'],
			'tmp_name' => $temp_file,
			'error'    => 0,
			'size'     => filesize( $temp_file ),
		);
		$results  = wp_handle_sideload(
			$file,
			array(
				'test_form' => false,
				'test_size' => true,
			)
		);

		$filetype    = wp_check_filetype( basename( $results['url'] ) );
		$attachment  = array(
			'guid'           => $results['url'],
			'post_mime_type' => $filetype['type'],
			'post_title'     => $image,
			'post_content'   => '',
			'post_status'    => 'inherit',
		);
		$attach_id   = wp_insert_attachment( $attachment, $results['file'] );
		$attach_data = wp_generate_attachment_metadata( $attach_id, $results['file'] );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		return $attach_id;
	}

	return false;
}


/**
 * Upload images to WP media and attach them to comment.
 *
 * @since starter 1.0
 */
function starter_send_image_to_comment( $comment_id, $file_name, $file_tmp_name ) {
	$name = sanitize_file_name( wp_unslash( $file_name ) );
	$id   = starter_upload_images_from_url( $file_tmp_name, $name );
	add_comment_meta( $comment_id, 'images_ids', $id );

	$all_ids = get_comment_meta( $comment_id, 'images_ids' );
	update_field( 'comment_image', $all_ids, get_comment( $comment_id ) );
}
