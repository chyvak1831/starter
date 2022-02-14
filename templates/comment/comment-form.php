<?php
/**
 * Template part for displaying comment form
 *
 * @package WordPress
 * @subpackage starter
 * @since starter 1.0
 */

defined( 'ABSPATH' ) || exit;

$starter_comment_name_email_required = get_option( 'require_name_email', 1 ) ? 'required' : '';
$starter_comment_recaptcha           = get_theme_mod( 'comment_recaptcha', false );
$starter_comment_recaptcha_key       = get_theme_mod( 'public_recaptcha_key' );
$starter_comment_privacy             = get_theme_mod( 'comment_privacy', false );
?>

<!-- comment form -->
<div class="col-md-7">

	<!-- name & email fields if not logged -->
		<?php if ( ! is_user_logged_in() ) : ?>
			<div class="row">
				<div class="col-md-6 mb-3">
					<div class="form-floating">
						<input type="text" class="form-control" name="author" placeholder="Name" id="author_<?php echo esc_attr( $starter_post_id ); ?>" <?php echo esc_attr( $starter_comment_name_email_required ); ?>>
						<label for="author_<?php echo esc_attr( $starter_post_id ); ?>"><?php esc_html_e( 'Your name', 'starter' ); ?></label>
						<div class="invalid-feedback"><?php esc_html_e( 'This field is required.', 'starter' ); ?></div>
					</div>
				</div>
				<div class="col-md-6 mb-3">
					<div class="form-floating">
						<input type="email" class="form-control" name="email" placeholder="name@example.com" id="email_<?php echo esc_attr( $starter_post_id ); ?>" <?php echo esc_attr( $starter_comment_name_email_required ); ?>>
						<label for="email_<?php echo esc_attr( $starter_post_id ); ?>"><?php esc_html_e( 'Your Email Address', 'starter' ); ?></label>
						<div class="invalid-feedback"><?php esc_html_e( 'Please enter a valid email address.', 'starter' ); ?></div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	<!-- END name & email fields if not logged -->

	<!-- comment field -->
		<div class="mb-3 form-floating">
			<textarea style="height: 200px" class="form-control" name="comment" placeholder="Comment" id="comment_<?php echo esc_attr( $starter_post_id ); ?>" cols="45" required></textarea>
			<label for="comment_<?php echo esc_attr( $starter_post_id ); ?>"><?php esc_html_e( 'Your Review', 'starter' ); ?></label>
			<div class="invalid-feedback"><?php esc_html_e( 'This field is required.', 'starter' ); ?></div>
		</div>
	<!-- END comment field -->

	<!-- file field -->
		<?php require get_stylesheet_directory() . '/templates/fileuploader.php'; ?>
	<!-- END file field -->

	<!-- recaptcha field -->
		<?php if ( $starter_comment_recaptcha ) : ?>
			<div class="mb-4">
				<div class="g-recaptcha" data-g_recaptcha data-callback="starterRecaptchaCallback" data-recaptcha_public_key="<?php echo esc_attr( $starter_comment_recaptcha_key ); ?>"></div>
				<div class="invalid-feedback"><?php esc_html_e( 'This field is required.', 'starter' ); ?></div>
			</div>
		<?php endif; ?>
	<!-- END recaptcha field -->

	<!-- privacy field -->
		<?php if ( $starter_comment_privacy ) : ?>
			<div class="form-check mb-4">
				<input class="form-check-input" id="checkPrivacyPolicy_<?php echo esc_attr( $starter_post_id ); ?>" name="privacy_policy" type="checkbox" data-privacy_policy required checked>
				<label class="form-check-label" for="checkPrivacyPolicy_<?php echo esc_attr( $starter_post_id ); ?>"><?php esc_html_e( 'I have read & accept the Privacy Policy', 'starter' ); ?></label>
				<div class="invalid-feedback"><?php esc_html_e( 'This field is required.', 'starter' ); ?></div>
			</div>
		<?php endif; ?>
	<!-- END privacy field -->

	<input type="hidden" name="comment_post_ID" value="<?php echo esc_attr( $starter_post_id ); ?>">
	<input type="hidden" name="action" value="starter_send_comment">
	<input type="hidden" name="security" value="<?php echo esc_html( wp_create_nonce( 'comment' ) ); ?>">
	<div class="row">
		<div class="col-lg-5 col-sm-6">
			<button type="submit" class="btn btn-lg btn-primary js_comment_submit">
				<span class="default_txt"><?php esc_html_e( 'Submit review', 'starter' ); ?></span>
				<span class="loading_txt"><?php esc_html_e( 'Loading...', 'starter' ); ?></span>
			</button>
		</div>
	</div>

</div>
<!-- END comment form -->