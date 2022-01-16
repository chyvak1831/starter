<?php
/**
 * Image modal
 *
 * @package WordPress
 * @subpackage starter
 * @since starter 1.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="modal img_modal js_singlepage_img_modal" id="singleMainImgModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-fullscreen" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<h3 class="modal-title h6 text-uppercase"><?php the_title(); ?></h3>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php esc_attr_e( 'Close', 'starter' ); ?>"></button>
			</div>

			<div class="modal-body swiper js_img_carousel p-0">
				<div class="swiper-wrapper">
					<?php foreach ( $starter_single_images as $starter_single_image ) : ?>
						<picture class="item_img swiper-slide">
							<?php
								echo wp_kses(
									starter_img_func(
										array(
											'img_src'   => 'w1600',
											'img_sizes' => 'calc(100vw - 32px)',
											'img_id'    => $starter_single_image,
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
							<?php foreach ( $starter_single_images as $starter_single_image ) : ?>
							<div class="swiper-slide">
								<picture class="thumbnail">
									<?php
										echo wp_kses(
											starter_img_func(
												array(
													'img_src'   => 'w200',
													'img_sizes' => '80px',
													'img_id'    => $starter_single_image,
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
