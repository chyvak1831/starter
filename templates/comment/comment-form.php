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
			<textarea class="form-control" name="comment" placeholder="Comment" id="comment_<?php echo esc_attr( $starter_post_id ); ?>" cols="45" rows="8" required></textarea>
			<label for="comment_<?php echo esc_attr( $starter_post_id ); ?>"><?php esc_html_e( 'Your Review', 'starter' ); ?></label>
			<div class="invalid-feedback"><?php esc_html_e( 'This field is required.', 'starter' ); ?></div>
		</div>
	<!-- END comment field -->

	<!-- file field -->
		<?php if ( $starter_comment_file ) : ?>
			<div class="mb-3">
				<div class="form-floating js_parent_upload_files">
					<div class="form-control js_wrap_upload_files">
						<input class="custom-file-input js_field_file_upload" data-length="<?php echo esc_attr( $starter_comment_file_max_length ); ?>" data-weight="<?php echo esc_attr( $starter_comment_file_max_weight ); ?>" id="comment_fileupload_<?php echo esc_attr( $starter_post_id ); ?>" type="file" name="files[]" multiple aria-describedby="fileHelp">
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
		<a href="#" class="btn btn-light cancel remove_thumbnail_img" role="button" aria-label="Remove file">
			<?php echo starter_get_svg( array( 'icon' => 'bi-remove' ) ); ?>
		</a>
	</li>
</div>
<!-- END fileupload template -->

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
