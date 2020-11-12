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
			<div class="wrap_carousel fullwidth_carousel js_fullwidth_carousel">
				<div class="js_carousel">
					<?php
						while ( have_rows( 'home_carousel' ) ) :
							the_row();
							$starter_home_url           = get_sub_field( 'url' );
							$starter_home_image_desktop = get_sub_field( 'home_image_desktop' )[ 'ID' ];
							$starter_home_image_tablet  = get_sub_field( 'home_image_tablet' ) ? get_sub_field( 'home_image_tablet' )[ 'ID' ] : $starter_home_image_desktop;
							$starter_home_image_mobile  = get_sub_field( 'home_image_mobile' ) ? get_sub_field( 'home_image_mobile' )[ 'ID' ] : $starter_home_image_desktop;
							?>
							<div>
								<?php if ( $starter_home_url ) : ?>
								<a href="<?php echo esc_url( $starter_home_url ); ?>">
								<?php endif; ?>
									<picture class="carousel_img_mobile" style="display: none;">
										<?php
											echo starter_img_func([
												'img_src'   => 'w600',
												'img_sizes' => '(max-width: 575px) calc(100vw - 10px)',
												'img_id'    => $starter_home_image_mobile
											]);
										?>
									</picture>
									<picture class="carousel_img_tablet" style="display: none;">
										<?php
											echo starter_img_func([
												'img_src'   => 'w800',
												'img_sizes' => '(max-width: 767px) 530px, (max-width: 991px) 700px',
												'img_id'    => $starter_home_image_tablet
											]);
										?>
									</picture>
									<picture class="carousel_img_desktop" style="display: none;">
										<?php
											echo starter_img_func([
												'img_src'   => 'w1200',
												'img_sizes' => '(max-width: 1199px) 940px, 1120px',
												'img_id'    => $starter_home_image_desktop
											]);
										?>
									</picture>
								<?php if ( $starter_home_url ) : ?>
								</a>
								<?php endif; ?>
							</div>
					<?php
						endwhile;
					?>
				</div>
				<button class="btn carousel_control_prev js_carousel_control_prev"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ); ?></button>
				<button class="btn carousel_control_next js_carousel_control_next"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ); ?></button>
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
			<?php if ( $starter_title ) : ?>
			<div class="container">
				<h2 class="title_section"><span><?php echo esc_html( $starter_title ); ?></span></h2>
			</div>
			<?php endif; ?>
			<div class="container">
				<div class="wrap_carousel product_carousel js_product_carousel">
					<div class="js_carousel">
						<?php
							while ( $starter_loop->have_posts() ) {
								$starter_loop->the_post();
								echo "<div class='wraper_product js_product'>";
								$starter_img_sizes = '(max-width: 575px) calc(50vw - 10px), (max-width: 767px) 260px, (max-width: 991px) 220px, (max-width: 1199px) 220px, 208px';
								require get_stylesheet_directory() . '/woocommerce-custom/global/product-item.php';
								echo '</div>';
							}
							wp_reset_postdata();
						?>
					</div>
					<button class="btn carousel_control_prev js_carousel_control_prev"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ); ?></button>
					<button class="btn carousel_control_next js_carousel_control_next"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ); ?></button>
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
