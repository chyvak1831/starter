<?php
/**
 * Template Name: Woocommerce Home
 *
 * @package WordPress
 * @subpackage starter
 * @since starter 1.0
 */

get_header(); ?>

<div class="content_wrapper pt-5 pb-5" role="main">
	<div class="container">
		<!-- full slider -->
		<?php if ( have_rows( 'home_carousel' ) ) : ?>
			<div class="position-relative fullwidth_carousel js_fullwidth_carousel">
				<div class="swiper">
					<div class="swiper-wrapper">
						<?php
						while ( have_rows( 'home_carousel' ) ) :
							the_row();
							$starter_home_url           = get_sub_field( 'url' );
							$starter_home_image_desktop = get_sub_field( 'home_image_desktop' )['ID'];
							$starter_home_image_tablet  = get_sub_field( 'home_image_tablet' ) ? get_sub_field( 'home_image_tablet' )['ID'] : $starter_home_image_desktop;
							$starter_home_image_mobile  = get_sub_field( 'home_image_mobile' ) ? get_sub_field( 'home_image_mobile' )['ID'] : $starter_home_image_desktop;
							?>
								<div class="swiper-slide">
									<?php if ( $starter_home_url ) : ?>
									<a href="<?php echo esc_url( $starter_home_url ); ?>">
									<?php endif; ?>
										<picture class="carousel_img_mobile" style="display: none;">
										<?php
											echo wp_kses(
												starter_img_func(
													array(
														'img_src'   => 'w600',
														'img_sizes' => '(max-width: 575px) calc(100vw - 24px)',
														'img_id'    => $starter_home_image_mobile,
													)
												),
												wp_kses_allowed_html( 'post' )
											);
										?>
										</picture>
										<picture class="carousel_img_tablet" style="display: none;">
										<?php
											echo wp_kses(
												starter_img_func(
													array(
														'img_src'   => 'w800',
														'img_sizes' => '(max-width: 767px) 516px, (max-width: 991px) 696px',
														'img_id'    => $starter_home_image_tablet,
													)
												),
												wp_kses_allowed_html( 'post' )
											);
										?>
										</picture>
										<picture class="carousel_img_desktop" style="display: none;">
										<?php
											echo wp_kses(
												starter_img_func(
													array(
														'img_src'   => 'w1400',
														'img_sizes' => '(max-width: 1199px) 936px, (max-width: 1399px) 1116px, 1296px',
														'img_id'    => $starter_home_image_desktop,
													)
												),
												wp_kses_allowed_html( 'post' )
											);
										?>
										</picture>
									<?php if ( $starter_home_url ) : ?>
									</a>
									<?php endif; ?>
								</div>
							<?php endwhile; ?>
					</div>
				</div>
				<button type="button" class="btn carousel_control_prev" aria-label="Carousel scroll previous"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ); ?></button>
				<button type="button" class="btn carousel_control_next" aria-label="Carousel scroll next"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-right' ) ); ?></button>
			</div>
		<?php endif; ?>
		<!-- END full slider -->
	</div>

	<!-- featured products -->
	<?php
	if ( have_rows( 'home_featured_products' ) ) :
		while ( have_rows( 'home_featured_products' ) ) :
			the_row();
			$starter_title = get_sub_field( 'title' );
			// selected products query!
			$starter_selected_products = get_sub_field( 'relationship_products', false, false );
			if ( $starter_selected_products ) {
				$starter_featured_products = array(
					'post_status'    => array( 'publish' ),
					'has_password'   => false,
					'post_type'      => 'product',
					'post__in'       => $starter_selected_products,
					'orderby'        => 'post__in',
					'posts_per_page' => -1,
					'tax_query'      => array(
						array(
							'taxonomy' => 'product_visibility',
							'field'    => 'name',
							'terms'    => array( 'exclude-from-catalog' ),
							'operator' => 'NOT IN',
						),
					),
				);
			}
			$starter_loop = new WP_Query( $starter_featured_products );
			?>
			<?php if ( $starter_title ) : ?>
			<div class="container">
				<h2 class="title_section"><span><?php echo esc_html( $starter_title ); ?></span></h2>
			</div>
			<?php endif; ?>
			<div class="container">
				<div class="position-relative product_carousel js_product_carousel">
					<div class="swiper">
						<div class="swiper-wrapper">
							<?php
							while ( $starter_loop->have_posts() ) {
								$starter_loop->the_post();
								echo "<div class='wraper_product swiper-slide js_product'>";
								$starter_img_sizes = '(max-width: 575px) calc(50vw - 24px), (max-width: 767px) 246px, (max-width: 991px) 217px, (max-width: 1199px) 217px, (max-width: 1399px) 206px, 242px';
								require get_stylesheet_directory() . '/woocommerce-custom/global/product-item.php';
								echo '</div>';
							}
								wp_reset_postdata();
							?>
						</div>
						<button type="button" class="btn carousel_control_prev" aria-label="Carousel scroll previous"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ); ?></button>
						<button type="button" class="btn carousel_control_next" aria-label="Carousel scroll next"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-right' ) ); ?></button>
					</div>
				</div>
			</div>
			<?php
		endwhile;
		endif;
	?>
	<!-- END featured products -->

</div><!-- .content_wrapper -->


<?php
get_footer();
