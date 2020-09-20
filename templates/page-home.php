<?php
/**
 * Template Name: Home
 *
 * @package starter
 */

get_header();
?>

<div class="content_wrapper" role="main">
	<div class="container">
		<!-- full slider -->
		<?php if ( have_rows( 'home_carousel' ) ) : ?>
			<div class="wrap_carousel fullwidth_carousel js_wrap_fullwidth_carousel">
				<div class="swiper-container js_fullwidth_carousel">
					<div class="swiper-wrapper">
						<?php
							while ( have_rows( 'home_carousel' ) ) :
								the_row();
								$starter_url = get_sub_field( 'url' );
								?>
								<div class="swiper-slide">
									<a href="<?php echo esc_url( $starter_url ); ?>">
										<picture class="carousel_img_desktop" style="display: none;">
											<?php $starter_home_image_desktop = get_sub_field( 'image_desktop' )[ 'ID' ]; ?>
											<?php echo do_shortcode( "[img img_src='w1200' img_sizes='(max-width: 1199px) 940px, 1120px' img_object=\"$starter_home_image_desktop\"]" ); ?>
										</picture>
										<picture class="carousel_img_tablet" style="display: none;">
											<?php $starter_home_image_tablet = ( get_sub_field( 'image_tablet' ) ) ? get_sub_field( 'image_tablet' )[ 'ID' ] : $starter_home_image_desktop; ?>
											<?php echo do_shortcode( "[img img_src='w800' img_sizes='(max-width: 575px) calc(100vw - 10px), (max-width: 767px) 530px, (max-width: 991px) 700px' img_object=\"$starter_home_image_tablet\"]" ); ?>
										</picture>
										<picture class="carousel_img_mobile" style="display: none;">
											<?php $starter_home_image_mobile = ( get_sub_field( 'image_mobile' ) ) ? get_sub_field( 'image_mobile' )[ 'ID' ] : $starter_home_image_desktop; ?>
											<?php echo do_shortcode( "[img img_src='w400' img_sizes='(max-width: 375px) calc(100vw - 10px)' img_object=\"$starter_home_image_mobile\"]" ); ?>
										</picture>
									</a>
								</div>
						<?php
							endwhile;
						?>
					</div>
				</div>
				<div class="carousel_control_prev js_carousel_control_prev"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ); ?></div>
				<div class="carousel_control_next js_carousel_control_next"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ); ?></div>
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
						)
					)
				);
			}
			$starter_loop = new WP_Query( $starter_featured_products );
			?>
			<div class="container">
				<h2 class="title_section"><span><?php echo esc_html( $starter_title ); ?></span></h2>
			</div>
			<div class="container container_product_carousel">
				<div class="wrap_carousel js_wrap_product_carousel">
					<div class="swiper-container js_product_carousel">
						<div class="swiper-wrapper">
							<?php
								while ( $starter_loop->have_posts() ) {
									$starter_loop->the_post();
									echo "<div class='swiper-slide'>";
									echo "<div class='wraper_product js_product'>";
									$starter_img_sizes = '(max-width: 575px) calc(50vw - 10px), (max-width: 767px) 260px, (max-width: 991px) 220px, (max-width: 1199px) 220px, 208px';
									require get_stylesheet_directory() . '/woocommerce-custom/global/product-item.php';
									echo '</div>';
									echo '</div>';
								}
								wp_reset_postdata();
							?>
						</div>
					</div>
					<div class="carousel_control_prev js_carousel_control_prev"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ); ?></div>
					<div class="carousel_control_next js_carousel_control_next"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ); ?></div>
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
