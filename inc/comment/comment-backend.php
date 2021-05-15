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
	/*validation error array*/
	$errors = array();

	check_ajax_referer( 'comment', 'security' );

	/*privacy validation*/
	if ( get_theme_mod( 'comment_privacy', false ) && ! isset( $_POST['privacy_policy'] ) ) {
		$errors['privacy_policy'] = false;
	}

	/*recaptcha validation*/
	if ( get_theme_mod( 'comment_recaptcha', false ) ) {
		if ( ! empty( $_POST['g-recaptcha-response'] ) && ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
			$response = starter_validate_recaptcha( sanitize_text_field( wp_unslash( $_POST['g-recaptcha-response'] ) ) );
			if ( ! $response['success'] ) {
				$errors['g-recaptcha-response'] = false; /*missing recaptcha field and other cases*/
			}
		} else {
			$errors['g-recaptcha-response'] = false; /*recaptcha textarea wrong value*/
		}
	}

	/*image validation*/
	if ( isset( $_FILES['files'] ) && ! empty( $_FILES['files']['name'][0] ) && get_theme_mod( 'comment_file', false ) ) {
		$starter_maximum_length = get_theme_mod( 'comment_maximum_files', 10 ); /*maximum files*/
		$starter_maximum_weight = get_theme_mod( 'comment_maximum_weight', 15 ) * 1048576; /*MB, each file maximum weight*/
		$starter_allowed_types  = array(
			'image/jpeg',
			'image/jpg',
			'image/png',
		);

		// @codingStandardsIgnoreStart safe to use due here nothing will be uploaded
		$starter_files = $_FILES['files'];
		// @codingStandardsIgnoreEnd
		$starter_files_tmp_name = $starter_files['tmp_name'];

		if ( $starter_maximum_length < count( $starter_files_tmp_name ) ) {
			$errors['limit_files'] = true;
			wp_send_json_error( $errors );
		}

		foreach ( $starter_files_tmp_name as $key => $file ) {
			$starter_img_size = $starter_files['size'][ $key ];
			if ( $starter_maximum_weight < $starter_img_size ) {
				$errors['limit_file_size'] = true;
				wp_send_json_error( $errors );
			}

			if ( ! in_array( $starter_files['type'][ $key ], $starter_allowed_types, true ) ) {
				$errors['not_allowed_type'] = true;
				wp_send_json_error( $errors );
			}
		}
	}

	/*make rating require if rating enabled*/
	if ( class_exists( 'WooCommerce' ) && 'product' == get_post_type( isset( $_POST['comment_post_ID'] ) ) ) {
		if ( wc_review_ratings_enabled() && wc_review_ratings_required() ) {
			if ( get_theme_mod( 'comment_extended_rating', false ) ) {
				if ( ! isset( $_POST['price_rating'] ) ) {
					$errors['price_rating'] = false;
				}
				if ( ! isset( $_POST['quality_rating'] ) ) {
					$errors['quality_rating'] = false;
				}
				if ( ! isset( $_POST['shipping_rating'] ) ) {
					$errors['shipping_rating'] = false;
				}
			}
			/*default rating require*/
			if ( ! get_theme_mod( 'comment_extended_rating', false ) && ! sanitize_text_field( wp_unslash( isset( $_POST['rating'] ) ) ) ) {
				$errors['rating'] = false;
			}
		}
	}

	/*send errors if they are*/
	if ( $errors ) {
		wp_send_json_error( $errors );
	}

	/*run default WordPress submit comment function*/
	$comment = wp_handle_comment_submission( wp_unslash( $_POST ) );

	if ( is_wp_error( $comment ) ) {
		wp_send_json_error( $comment->get_error_message() );
	} else {

		/*upload image if enabled*/
		if ( isset( $_FILES['files'] ) && ! empty( $_FILES['files']['name'][0] ) && get_theme_mod( 'comment_file', false ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			// @codingStandardsIgnoreStart safe to use due will be validated by media_handle_upload
			$starter_files = $_FILES['files'];
			// @codingStandardsIgnoreEnd
			$starter_img_ids = array();
			foreach ( $starter_files['name'] as $key => $value ) {
				$starter_file = array(
					'name'     => $starter_files['name'][ $key ],
					'type'     => $starter_files['type'][ $key ],
					'tmp_name' => $starter_files['tmp_name'][ $key ],
					'error'    => $starter_files['error'][ $key ],
					'size'     => $starter_files['size'][ $key ],
				);
				$_FILES       = array( 'allfiles' => $starter_file );
				foreach ( $_FILES as $starter_file => $array ) {
					$starter_upload_id = media_handle_upload( $starter_file, 0 );
					array_push( $starter_img_ids, $starter_upload_id );
				}
			}
			update_field( 'comment_image', $starter_img_ids, get_comment( $comment->comment_ID ) );
		}

		/*setup custom rating if rating enabled*/
		if ( class_exists( 'WooCommerce' ) && 'product' == get_post_type( isset( $_POST['comment_post_ID'] ) ) ) {
			if ( wc_review_ratings_enabled() && get_theme_mod( 'comment_extended_rating', false ) ) {
				$options      = array(
					'options' => array(
						'default'   => 0,
						'min_range' => 0,
						'max_range' => 5,
					),
				);
				$rating_group = array(
					'price'    => filter_var( wp_unslash( $_POST['price_rating'] ), FILTER_VALIDATE_INT, $options ),
					'quality'  => filter_var( wp_unslash( $_POST['quality_rating'] ), FILTER_VALIDATE_INT, $options ),
					'shipping' => filter_var( wp_unslash( $_POST['shipping_rating'] ), FILTER_VALIDATE_INT, $options ),
				);
				update_field( 'rating_group', $rating_group, $comment );
				update_comment_meta( $comment->comment_ID, 'rating', round( array_sum( $rating_group ) / 3 ), true );
			}
		}

		wp_send_json(
			array(
				'success'    => 'true',
				'comment_id' => $comment->comment_ID,
			)
		);
	}
}
add_action( 'wp_ajax_starter_send_comment', 'starter_save_comment' );
add_action( 'wp_ajax_nopriv_starter_send_comment', 'starter_save_comment' );
