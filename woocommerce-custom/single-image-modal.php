<?php
/**
 * Image modal
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="modal img_modal js_img_modal" id="singleMainImgModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-fullscreen" role="document">
		<div class="modal-content js_wrap_img_thumbnails">
			<div class="modal-header">
				<h3 class="modal-title h6 text-uppercase"><?php the_title(); ?></h3>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php esc_attr_e( 'Close', 'starter' ); ?>"></button>
			</div>
			<div class="modal-body p-0">
				<picture class="item_img js_main_img">
					<?php
						echo wp_kses(
							starter_img_func(
								array(
									'img_src'   => 'w1600',
									'img_sizes' => 'calc(100vw - 32px)',
									'img_id'    => $starter_img,
								)
							),
							wp_kses_allowed_html( 'post' )
						);
						?>
				</picture>
			</div>
			<div class="modal-footer">
				<div class="wrap_carousel thumbnail_carousel object_fit js_thumbnail_carousel_modal">
					<div class="js_carousel">
						<div>
							<picture class="thumbnail js_thumbnail is_active">
								<?php
									echo wp_kses(
										starter_img_func(
											array(
												'img_src'   => 'w200',
												'img_sizes' => '70px',
												'img_id'    => $starter_img,
											)
										),
										wp_kses_allowed_html( 'post' )
									);
									?>
							</picture>
						</div>
						<?php foreach ( $starter_thumbnails as $starter_key => $starter_modal_img ) : ?>
							<div>
								<picture class="thumbnail js_thumbnail">
									<?php
										echo wp_kses(
											starter_img_func(
												array(
													'img_src'   => 'w200',
													'img_sizes' => '70px',
													'img_id'    => $starter_modal_img,
												)
											),
											wp_kses_allowed_html( 'post' )
										);
									?>
								</picture>
							</div>
						<?php endforeach; ?>
					</div>
					<button class="btn carousel_control_prev js_carousel_control_prev" aria-label="Carousel scroll previous"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ); ?></button>
					<button class="btn carousel_control_next js_carousel_control_next" aria-label="Carousel scroll next"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-right' ) ); ?></button>
				</div>
			</div>
		</div>
	</div>
</div>
