<?php
/**
 * Image modal
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="modal img_modal js_img_modal" id="singleMainImgModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content js_wrap_img_thumbnails">
			<div class="modal-header">
				<h3 class="modal-title"><?php the_title(); ?></h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="<?php esc_attr_e( 'Close', 'starter' ); ?>"><?php echo starter_get_svg( array( 'icon' => 'bi-remove' ) ); ?></button>
			</div>
			<div class="modal-body">
				<picture class="item_img js_main_img">
					<?php
						echo starter_img_func([
							'img_src'   => 'w1600',
							'img_sizes' => 'calc(100vw - 32px)',
							'img_id'    => $starter_img
						]);
					?>
				</picture>
				<!-- toggle pictures due chrome bug when change srcset -->
				<picture class="item_img js_main_img d-none">
					<?php
						echo starter_img_func([
							'img_src'   => 'w1600',
							'img_sizes' => 'calc(100vw - 32px)',
							'img_id'    => $starter_img
						]);
					?>
				</picture>
			</div>
			<div class="modal-footer">
				<div class="wrap_carousel thumbnail_carousel object_fit js_thumbnail_carousel_modal">
					<div class="js_carousel">
						<div>
							<picture class="thumbnail js_thumbnail is_active">
								<?php
									echo starter_img_func([
										'img_src'   => 'w200',
										'img_sizes' => '70px',
										'img_id'    => $starter_img
									]);
								?>
							</picture>
						</div>
						<?php foreach ( $starter_thumbnails as $key => $starter_modal_img ) : ?>
							<div>
								<picture class="thumbnail js_thumbnail">
									<?php
										echo starter_img_func([
											'img_src'   => 'w200',
											'img_sizes' => '70px',
											'img_id'    => $starter_modal_img
										]);
									?>
								</picture>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="carousel_control_prev js_carousel_control_prev"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ); ?></div>
					<div class="carousel_control_next js_carousel_control_next"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ); ?></div>
				</div>
			</div>
		</div>
	</div>
</div>
