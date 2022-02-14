<?php
/**
 * Template part for displaying comment image modal
 *
 * @package WordPress
 * @subpackage starter
 * @since starter 1.0
 */

defined( 'ABSPATH' ) || exit;

$starter_comment            = get_comment( $starter_comment_id );
$starter_comment_author     = $starter_comment->comment_author;
$starter_comment_thumbnails = get_field( 'comment_image', $starter_comment );
$starter_comment_img_count  = count( $starter_comment_thumbnails );
?>

<div class="modal img_modal js_comment_img_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-fullscreen" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<h3 class="modal-title h6 text-uppercase">
					<?php
						echo esc_html( $starter_comment_author );
						/* translators: count images of comment. */
						printf( esc_html( _n( ' Attached %s Photo', ' Attached %s Photos', $starter_comment_img_count, 'starter' ) ), esc_html( $starter_comment_img_count ) );
					?>
				</h3>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php esc_attr_e( 'Close', 'starter' ); ?>"></button>
			</div>

			<div class="modal-body swiper js_img_carousel p-0">
				<div class="swiper-wrapper">
					<?php foreach ( $starter_comment_thumbnails as $starter_comment_modal_img ) : ?>
					<picture class="item_img swiper-slide">
						<?php
							echo wp_kses(
								starter_img_func(
									array(
										'img_src'   => 'w1600',
										'img_sizes' => '100vw',
										'img_id'    => $starter_comment_modal_img,
									)
								),
								wp_kses_allowed_html( 'post' )
							);
						?>
					</picture>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="modal-footer">
				<div class="position-relative thumbnail_carousel object_fit js_thumbnail_carousel">
					<div class="swiper">
						<div class="swiper-wrapper">
							<?php foreach ( $starter_comment_thumbnails as $starter_comment_modal_img ) : ?>
								<div class="swiper-slide">
									<picture class="thumbnail">
										<?php
											echo wp_kses(
												starter_img_func(
													array(
														'img_src'   => 'w200',
														'img_sizes' => '80px',
														'img_id'    => $starter_comment_modal_img,
													)
												),
												wp_kses_allowed_html( 'post' )
											);
										?>
									</picture>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<button type="button" class="btn carousel_control_prev" aria-label="Carousel scroll previous"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ); ?></button>
					<button type="button" class="btn carousel_control_next" aria-label="Carousel scroll next"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-right' ) ); ?></button>
				</div>
			</div>
		</div>
	</div>
</div>
