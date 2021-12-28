<?php
/**
 * Template part for displaying comment item
 *
 * @package WordPress
 * @subpackage starter
 * @since starter 1.0
 */

defined( 'ABSPATH' ) || exit;

$starter_comment             = get_comment( $starter_comment_id );
$starter_comment_description = $starter_comment->comment_content;
$starter_comment_author      = $starter_comment->comment_author;
$starter_comment_date        = $starter_comment->comment_date_gmt;
$starter_comment_img_ids     = get_field( 'comment_image', $starter_comment );
$starter_comment_total_img   = $starter_comment_img_ids ? count( $starter_comment_img_ids ) : false;
?>

<div class="wrap_comment js_comment_item" data-comment_id="<?php echo esc_attr( $starter_comment_id ); ?>">

	<!-- author, date and verified badge -->
	<ul class="list details_comment_list">
		<?php if ( $starter_comment_author ) : ?>
		<li>
			<?php echo esc_html( $starter_comment_author ); ?>
		</li>
		<?php endif; ?>
		<li><?php echo esc_html( gmdate( 'F j, Y', strtotime( $starter_comment_date ) ) ); ?></li>
	</ul>
	<!-- END author, date and verified badge -->

	<!-- text and image comment content -->
	<?php echo esc_html( $starter_comment_description ); ?>
	<?php if ( 0 < $starter_comment_total_img ) : ?>
		<div class="attached_img_comment mt-4">
			<?php /* translators: count of images. */ ?>
			<small class="attached_img_title"><?php printf( esc_html( _n( 'Attached %s Photo', 'Attached %s Photos', $starter_comment_total_img, 'starter' ) ), esc_html( $starter_comment_total_img ) ); ?></small>
			<ul class="list object_fit">
				<?php foreach ( $starter_comment_img_ids as $starter_comment_img ) : ?>
					<li class="js_comment_img_modal_btn">
						<a href="/" role="button" aria-label="Open comment modal">
							<picture class="item_img">
								<?php
									echo wp_kses(
										starter_img_func(
											array(
												'img_src'   => 'w200',
												'img_sizes' => '90px',
												'img_id'    => $starter_comment_img,
											)
										),
										wp_kses_allowed_html( 'post' )
									);
								?>
							</picture>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
	<!-- END text and image comment content -->
</div>
