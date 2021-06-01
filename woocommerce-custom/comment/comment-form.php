<?php
/**
 * Comment part
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;

$starter_post_id                     = get_the_ID();
$starter_comment_name_email_required = get_option( 'require_name_email', 1 ) ? 'required' : '';
$starter_comment_file                = get_theme_mod( 'comment_file', false );
$starter_comment_file_max_length     = get_theme_mod( 'comment_maximum_files', 10 ); /*maximum files*/
$starter_comment_file_max_weight     = get_theme_mod( 'comment_maximum_weight', 15 ); /*MB, each file maximum weight*/
$starter_comment_recaptcha           = get_theme_mod( 'comment_recaptcha', false );
$starter_comment_recaptcha_key       = get_theme_mod( 'public_recaptcha_key' );
$starter_comment_privacy             = get_theme_mod( 'comment_privacy', false );
$starter_comment_rating_required     = wc_review_ratings_required() ? 'required' : '';
$starter_comment_low_rating_modal    = get_theme_mod( 'comment_low_rating_modal', false );
$starter_comment_extended_rating     = get_theme_mod( 'comment_extended_rating', false );
?>
<!-- rating -->
<?php if ( wc_review_ratings_enabled() ) : ?>
	<div class="col-md-5">
		<!-- default rating -->
		<?php if ( ! $starter_comment_extended_rating ) : ?>
			<ul class="list-unstyled form-control ratings_list js_ratings_list">
				<li>
					<span><?php esc_html_e( 'Rating:', 'starter' ); ?></span>
					<div class="d-flex justify-content-end flex-wrap text-right js_rating" data-elem-width="22">
						<?php require get_stylesheet_directory() . '/woocommerce-custom/global/rating.php'; ?>
						<input name="rating" class="js_rating_input" <?php echo esc_attr( $starter_comment_rating_required ); ?> hidden>
						<div class="invalid-feedback"><?php esc_html_e( 'Rating is required.', 'starter' ); ?></div>
					</div>
					<span class="d-none js_total_ratings"></span>
				</li>
			</ul>
		<?php endif; ?>
		<!-- END default rating -->

		<!-- extended rating -->
		<?php if ( $starter_comment_extended_rating ) : ?>
			<ul class="list-unstyled form-control ratings_list js_ratings_list">
				<li>
					<span><?php esc_html_e( 'Price:', 'starter' ); ?></span>
					<div class="d-flex justify-content-end flex-wrap text-right js_rating" data-elem-width="22">
						<?php require get_stylesheet_directory() . '/woocommerce-custom/global/rating.php'; ?>
						<input name="price_rating" id="price_rating_<?php echo esc_attr( $starter_post_id ); ?>" class="js_rating_input" <?php echo esc_attr( $starter_comment_rating_required ); ?> hidden>
						<div class="invalid-feedback"><?php esc_html_e( 'Price rating is required.', 'starter' ); ?></div>
					</div>
				</li>
				<li>
					<span><?php esc_html_e( 'Quality:', 'starter' ); ?></span>
					<div class="d-flex justify-content-end flex-wrap text-right js_rating" data-elem-width="22">
						<?php require get_stylesheet_directory() . '/woocommerce-custom/global/rating.php'; ?>
						<input name="quality_rating" id="quality_rating_<?php echo esc_attr( $starter_post_id ); ?>" class="js_rating_input" <?php echo esc_attr( $starter_comment_rating_required ); ?> hidden>
						<div class="invalid-feedback"><?php esc_html_e( 'Quality rating is required.', 'starter' ); ?></div>
					</div>
				</li>
				<li>
					<span><?php esc_html_e( 'Shipping:', 'starter' ); ?></span>
					<div class="d-flex justify-content-end flex-wrap text-right js_rating" data-elem-width="22">
						<?php require get_stylesheet_directory() . '/woocommerce-custom/global/rating.php'; ?>
						<input name="shipping_rating" id="shipping_rating_<?php echo esc_attr( $starter_post_id ); ?>" class="js_rating_input" <?php echo esc_attr( $starter_comment_rating_required ); ?> hidden>
						<div class="invalid-feedback"><?php esc_html_e( 'Shipping rating is required.', 'starter' ); ?></div>
					</div>
				</li>
				<li class="total_row">
					<span class="text_total_row"><?php esc_html_e( 'Your Overall Rating:', 'starter' ); ?></span>
					<span class="text_total_rating js_total_ratings"></span>
				</li>
			</ul>
		<?php endif; ?>
		<!-- END extended rating -->
	</div>
<?php endif; ?>
<!-- END rating -->


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
			<textarea class="form-control" name="comment" placeholder="Comment" id="comment_<?php echo esc_attr( $starter_post_id ); ?>" cols="45" rows="8" required></textarea>
			<label for="comment_<?php echo esc_attr( $starter_post_id ); ?>"><?php esc_html_e( 'Your Review', 'starter' ); ?></label>
			<div class="invalid-feedback"><?php esc_html_e( 'This field is required.', 'starter' ); ?></div>
		</div>
	<!-- END comment field -->

	<!-- file field -->
		<?php if ( $starter_comment_file ) : ?>
			<div class="mb-3">
				<div class="form-floating">
					<div class="form-control js_wrap_upload_files">
						<input class="custom-file-input js_field_file_upload" data-length="10" data-weight="10" id="comment_fileupload_<?php echo esc_attr( $starter_post_id ); ?>" type="file" name="files[]" multiple aria-describedby="fileHelp">
						<ul class="list-unstyled list_file_upload js_list_file_upload"></ul>
					</div>
					<label class="file_label_text" for="comment_fileupload_<?php echo esc_attr( $starter_post_id ); ?>"><?php esc_html_e( 'Attachment (Optional)', 'starter' ); ?></label>
					<label class="file_label" for="comment_fileupload_<?php echo esc_attr( $starter_post_id ); ?>"><?php echo starter_get_svg( array( 'icon' => 'bi-image' ) ); ?></label>
					<div class="invalid-feedback filelength_invalid d-none">
						<?php
							// Translators: $s maximum count of files.
							echo sprintf( esc_html__( 'Maximum %s files.', 'starter' ), esc_html( $starter_comment_file_max_length ) );
						?>
					</div>
					<div class="invalid-feedback filesize_invalid d-none">
						<?php
							// Translators: $s maximum count of files.
							echo sprintf( esc_html__( 'File must be less than %sMB.', 'starter' ), esc_html( $starter_comment_file_max_weight ) );
						?>
					</div>
					<div class="invalid-feedback filetype_invalid d-none">
						<?php esc_html_e( 'File type is not valid.', 'starter' ); ?>
					</div>
				</div>
				<input type="hidden" class="hiddenUploadFilesComment" name="hiddenUploadFilesComment">
				<small id="fileHelp" class="form-text text-muted">
					<?php
						// Translators: $s maximum count of files.
						echo sprintf( esc_html__( 'You can upload up to %1$s files in png, jpg or jpeg format size limit %2$s MB each.', 'starter' ), esc_html( $starter_comment_file_max_length ), esc_html( $starter_comment_file_max_weight ) );
					?>
				</small>
			</div>
		<?php endif; ?>
	<!-- END file field -->

	<!-- recaptcha field -->
		<?php if ( $starter_comment_recaptcha ) : ?>
			<div class="mb-4">
				<input type="hidden" class="js_recaptcha_input">
				<div class="g-recaptcha" data-callback="recaptchaCallback" data-recaptchapublickey="<?php echo esc_attr( $starter_comment_recaptcha_key ); ?>"></div>
				<div class="invalid-feedback"><?php esc_html_e( 'This field is required.', 'starter' ); ?></div>
			</div>
		<?php endif; ?>
	<!-- END recaptcha field -->

	<!-- privacy field -->
		<?php if ( $starter_comment_privacy ) : ?>
			<div class="form-check mb-4">
				<input class="form-check-input js_comment_privacy" id="check_privacy_policy_<?php echo esc_attr( $starter_post_id ); ?>" name="privacy_policy" type="checkbox" required checked>
				<label class="form-check-label" for="check_privacy_policy_<?php echo esc_attr( $starter_post_id ); ?>"><?php esc_html_e( 'I have read & accept the Privacy Policy', 'starter' ); ?></label>
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


<!-- fileupload template -->
<div class="js_fileupload_tpl d-none" tabindex="-3">
	<li class="template-upload">
		<div class="preview"></div>
		<div class="file_info">
			<div class="file_name js_file_name"></div>
			<div class="file_size js_file_size" data-size></div>
		</div>
		<a href="#" class="cancel remove_thumbnail_img" role="button" aria-label="Remove file">
			<?php echo starter_get_svg( array( 'icon' => 'bi-remove' ) ); ?>
		</a>
	</li>
</div>
<!-- END fileupload template -->


<!-- low-rating modal -->
<?php if ( $starter_comment_low_rating_modal ) : ?>
	<div class="modal low_rating_modal js_low_rating_modal" tabindex="-1" role="dialog" data-minimum-rating="4">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title"><?php esc_html_e( 'Sorry to interrupt!', 'starter' ); ?></h3>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php esc_attr_e( 'Close', 'starter' ); ?>"><?php echo starter_get_svg( array( 'icon' => 'bi-remove' ) ); ?></button>
				</div>
				<div class="modal-body">
					<div class="alert alert-secondary" role="alert">
						<?php echo starter_get_svg( array( 'icon' => 'sad_face' ) ); ?>
						<p><?php esc_html_e( 'We are extremely sorry to interrupt but it looks like you were not happy with our product!', 'starter' ); ?></p>
					</div>
					<p><?php esc_html_e( 'We want you to know that we value you as a customer and it\'s super important to us that you\'re 100% satisfied with your order!', 'starter' ); ?></p>
					<p><?php esc_html_e( 'Please contact us and give us the opportunity to take care of any issues you may be having. We\'re here for you!', 'starter' ); ?></p>
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-sm-6 wrap_btn">
							<a href="#" class="btn btn-outline-primary js_comment_submit_anyway" role="button"><?php esc_html_e( 'Submit review anyway', 'starter' ); ?></a>
						</div>
						<div class="col-sm-6 wrap_btn">
							<a href="<?php echo esc_url( wc_get_endpoint_url( 'contact-us', '', site_url() ) ); ?>" class="btn btn-primary" role="button"><?php esc_html_e( 'Contact support', 'starter' ); ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<!-- END low-rating modal -->

<?php
	$starter_blueimp_script = array(
		get_template_directory_uri() . '/assets/js/blueimp/vendor/jquery.ui.widget.js',
		get_template_directory_uri() . '/assets/js/blueimp/blueimp-tmpl/js/tmpl.js',
		get_template_directory_uri() . '/assets/js/blueimp/blueimp-load-image/js/load-image.all.min.js',
		get_template_directory_uri() . '/assets/js/blueimp/blueimp-canvas-to-blob/js/canvas-to-blob.js',
		get_template_directory_uri() . '/assets/js/blueimp/jquery.iframe-transport.js',
		get_template_directory_uri() . '/assets/js/blueimp/jquery.fileupload.js',
		get_template_directory_uri() . '/assets/js/blueimp/jquery.fileupload-process.js',
		get_template_directory_uri() . '/assets/js/blueimp/jquery.fileupload-image.js',
		get_template_directory_uri() . '/assets/js/blueimp/jquery.fileupload-validate.js',
		get_template_directory_uri() . '/assets/js/blueimp/jquery.fileupload-ui.js',
	);
	?>
<script>
	var blueimp_script = <?php echo wp_json_encode( $starter_blueimp_script ); ?>;
</script>
