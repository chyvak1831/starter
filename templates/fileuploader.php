<?php
/**
 * Fileuploader template
 *
 * @package WordPress
 * @subpackage starter
 * @since starter 2.0
 */

defined( 'ABSPATH' ) || exit;

$starter_comment_file            = get_theme_mod( 'comment_file', false );
$starter_comment_file_max_length = get_theme_mod( 'comment_maximum_files', 10 ); /*maximum files*/
$starter_comment_file_max_weight = get_theme_mod( 'comment_maximum_weight', 15 ); /*MB, each file maximum weight*/
?>

<?php if ( $starter_comment_file ) : ?>
    <div class="mb-3">
        <div class="form-floating">
            <div class="position-relative form-control js_wrap_fileuploader" data-filelength data-filesize data-filetype data-length="<?php echo esc_attr( $starter_comment_file_max_length ); ?>" data-weight="<?php echo esc_attr( $starter_comment_file_max_weight ); ?>">
                <input class="invisible form-control js_field_file_upload" accept="image/jpg, image/jpeg, image/png" id="commentFileupload_<?php echo esc_attr( $starter_post_id ); ?>" type="file" multiple aria-describedby="fileHelp">
                <label class="custom_file_label js_fileuploader_label" for="commentFileupload_<?php echo esc_attr( $starter_post_id ); ?>"><span class="label_text"><?php esc_html_e( 'Attachment (Optional)', 'starter' ); ?></span><?php echo starter_get_svg( array( 'icon' => 'bi-image' ) ); ?></label>
                <div class="d-none js_wrap_hidden_fileinputs"></div>
                <ul class="list_file_upload list-unstyled js_uploaded_list"></ul>
            </div>
            <div class="filelength_invalid invalid-feedback d-none">
                <?php
                    // Translators: $s maximum count of files.
                    echo sprintf( esc_html__( 'Maximum %s files.', 'starter' ), esc_html( $starter_comment_file_max_length ) );
                ?>
            </div>
            <div class="filesize_invalid invalid-feedback d-none">
                <?php
                    // Translators: $s maximum count of files.
                    echo sprintf( esc_html__( 'File must be less than %sMB.', 'starter' ), esc_html( $starter_comment_file_max_weight ) );
                ?>
            </div>
            <div class="filetype_invalid invalid-feedback d-none">
                <?php esc_html_e( 'File type is not valid.', 'starter' ); ?>
            </div>
        </div>
        <small id="fileHelp" class="form-text text-muted">
            <?php
                // Translators: $s maximum count of files.
                echo sprintf( esc_html__( 'You can upload up to %1$s files in png, jpg or jpeg format size limit %2$s MB each.', 'starter' ), esc_html( $starter_comment_file_max_length ), esc_html( $starter_comment_file_max_weight ) );
            ?>
        </small>
    </div>


    <!-- fileupload template - used by js -->
    <div class="js_uploaded_item_tpl d-none" tabindex="-3">
        <li>
            <div class="preview object_fit"><img class="img-fluid" src="" alt="<?php esc_attr_e( 'Comment image preview', 'starter' ); ?>"></div>
            <div class="file_info">
                <div class="file_name js_file_name"></div>
                <div class="file_size js_file_size" data-size></div>
            </div>
            <a href="#" class="btn btn-light cancel remove_thumbnail_img js_remove_thumb" role="button" aria-label="<?php esc_attr_e( 'Remove file', 'starter' ); ?>">
                <?php echo starter_get_svg( array( 'icon' => 'bi-delete' ) ); ?>
            </a>
        </li>
    </div>
    <!-- END fileupload template - used by js -->

    <!-- fileinput tempalte - used by js -->
    <div class="js_fileuploader_input_tpl d-none"><input class="invisible form-control js_field_file_upload" accept="image/jpg, image/jpeg, image/png" type="file" multiple aria-describedby="fileHelp"></div>
    <!-- END fileinput tempalte - used by js -->
<?php endif; ?>