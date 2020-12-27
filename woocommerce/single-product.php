<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
global $post;

/**
 * Detect plugin. For use on Front End only.
 */
require_once ABSPATH . 'wp-admin/includes/plugin.php';
?>

<?php if ( ! post_password_required( $post ) ) : ?>

	<?php
	while ( have_posts() ) :
		the_post();
		$starter_img             = $product->get_image_id();
		$starter_thumbnails      = $product->get_gallery_image_ids();
		$starter_product_id      = $product->get_id();
		$starter_short_desc      = has_excerpt() ? get_the_excerpt() : '';
		$starter_comment_enabled = wc_reviews_enabled() && $product->get_reviews_allowed() ? 1 : 0; /*woo feature - check if all reviews and for certain product enabled*/
		$starter_comment_count   = $product->get_review_count();
		$starter_comment_rating  = $product->get_average_rating();
		?>


<div class="content_wrapper single_product" role="main">
	<!-- breadcrumb -->
	<div class="container mb-3">
		<?php
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			yoast_breadcrumb( '<div class="yoast_breadcrumb">', '</div>' );
		}
		?>
	</div>
	<!-- END breadcrumb -->


		<div class="container">
			<div class="row">

			<!-- images -->
				<div class="col-md-6 wrap_single_images js_wrap_img_thumbnails">
					<div class="position-relative mb-2">
						<div class="js_zoom_wrap">
							<picture class="single_main_img item_img js_main_img" data-zoom-img="<?php echo esc_attr( wp_get_attachment_image_src( $starter_img, 'w2000' )[0] ); ?>">
								<?php
									echo wp_kses(
										starter_img_func(
											array(
												'img_src'   => 'w800',
												'img_sizes' => '(max-width: 575px) calc(100vw - 10px), (max-width: 767px) 530px, (max-width: 991px) 340px, (max-width: 1199px) 460px, 550px',
												'img_id'    => $starter_img,
												'lazy'      => 'false',
											)
										),
										wp_kses_allowed_html( 'post' )
									);
								?>
							</picture>
							<div class="js_zoom_element"></div>
							<!-- toggle pictures due chrome bug when change srcset -->
							<picture class="single_main_img item_img js_main_img d-none" data-zoom-img="<?php echo esc_attr( wp_get_attachment_image_src( $starter_img, 'w2000' )[0] ); ?>">
								<?php
									echo wp_kses(
										starter_img_func(
											array(
												'img_src'   => 'w800',
												'img_sizes' => '(max-width: 575px) calc(100vw - 10px), (max-width: 767px) 530px, (max-width: 991px) 340px, (max-width: 1199px) 460px, 550px',
												'img_id'    => $starter_img,
											)
										),
										wp_kses_allowed_html( 'post' )
									);
								?>
							</picture>
						</div>
						<a href="#singleMainImgModal" class="loop_btn" data-toggle="modal" role="button" aria-label="<?php esc_attr_e( 'Image zoom', 'starter' ); ?>"><?php echo starter_get_svg( array( 'icon' => 'bi-plus-circle' ) ); ?></a>
					</div>
						<?php if ( $starter_thumbnails ) : ?>
						<div class="wrap_carousel thumbnail_carousel object_fit js_thumbnail_carousel_main_img">
							<div class="js_carousel">
								<div>
									<picture class="thumbnail js_thumbnail is_active" data-zoom-img="<?php echo esc_attr( wp_get_attachment_image_src( $starter_img, 'w2000' )[0] ); ?>">
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
								<?php foreach ( $starter_thumbnails as $starter_thumbnail_img ) : ?>
									<div>
										<picture class="thumbnail js_thumbnail" data-zoom-img="<?php echo esc_attr( wp_get_attachment_image_src( $starter_thumbnail_img, 'w2000' )[0] ); ?>">
											<?php
												echo wp_kses(
													starter_img_func(
														array(
															'img_src'   => 'w200',
															'img_sizes' => '70px',
															'img_id'    => $starter_thumbnail_img,
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
							<button class="btn carousel_control_next js_carousel_control_next" aria-label="Carousel scroll next"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ); ?></button>
						</div>
					<?php endif; ?>
				</div>
				<!-- image modal -->
						<?php require get_stylesheet_directory() . '/woocommerce-custom/single-image-modal.php'; ?>
				<!-- END image modal -->
			<!-- END images -->


			<!-- right part -->
				<div class="col-md-6 single_main_content">
					<div class="single_top_titles">
						<h2><?php the_title(); ?></h2>
						<h1 class="h6"><?php echo esc_html( $starter_short_desc ); ?></h1>
					</div>
					<ul class="list single_tool_list">
							<?php if ( $starter_comment_enabled ) : ?>
								<?php if ( $starter_comment_count ) : ?>
							<li>
								<a href="#comments_wrap" class="d-flex align-items-center js_scrollto" role="button" aria-label="<?php esc_attr_e( 'Average rating', 'starter' ); ?>">
									<?php
									if ( wc_review_ratings_enabled() && $starter_comment_rating ) {
										require get_stylesheet_directory() . '/woocommerce-custom/global/rating.php';
									} else {
										esc_html_e( 'See Reviews&nbsp;', 'starter' );
									}
									?>
									<span class="count_votes">(<?php echo esc_html( $starter_comment_count ); ?>)</span>
								</a>
							</li>
							<?php endif; ?>
							<li class="tool_link">
								<a href="#write_comment" class="js_scrollto" role="button" aria-label="<?php esc_attr_e( 'Write review', 'starter' ); ?>"><?php echo starter_get_svg( array( 'icon' => 'bi-pen' ) ); ?><?php esc_html_e( 'review', 'starter' ); ?></a>
							</li>
						<?php endif; ?>
						<li class="tool_link dropdown share_dropdown">
							<a href="#" class="link_dropdown" data-toggle="dropdown" role="button"><?php echo starter_get_svg( array( 'icon' => 'share' ) ); ?><?php esc_html_e( 'share', 'starter' ); ?></a>
							<ul class="list-unstyled dropdown-menu dropdown-menu-right">
								<li>
									<a class="twitter" href="https://twitter.com/share?url=<?php echo esc_url( get_the_permalink() ); ?>" rel="noopener" target="_blank"><?php echo starter_get_svg( array( 'icon' => 'twitter' ) ); ?><?php esc_html_e( 'Twitter', 'starter' ); ?></a>
								</li>
								<li>
									<a class="facebook" href="https://www.facebook.com/sharer.php?u=<?php echo esc_url( get_the_permalink() ); ?>" rel="noopener" target="_blank"><?php echo starter_get_svg( array( 'icon' => 'facebook' ) ); ?><?php esc_html_e( 'Facebook', 'starter' ); ?></a>
								</li>
							</ul>
						</li>
							<?php if ( is_plugin_active( 'ti-woocommerce-wishlist/ti-woocommerce-wishlist.php' ) ) : ?>
							<li class="tool_link"><?php echo do_shortcode( '[ti_wishlists_addtowishlist]' ); ?></li>
						<?php endif; ?>
					</ul>

					<!-- price -->
					<div class="wrap_price">
							<?php if ( $product->is_in_stock() ) : ?>
								<?php wc_get_template( 'loop/price.php' ); ?>
						<?php else : ?>
							<span><?php esc_html_e( 'Sold Out', 'starter' ); ?></span>
						<?php endif; ?>
					</div>
					<!-- END price -->

						<?php the_content(); ?>

						<?php if ( $product->is_type( 'variable' ) ) : ?>
							<?php woocommerce_template_single_add_to_cart(); ?>
					<?php else : ?>

						<ul class="list mt-3">
							<li>
								<div class="count_block js_count_add_product">
									<a href="#" class="count_block_btn js_minus_count_btn_product" role="button" aria-label="<?php esc_attr_e( 'Minus product', 'starter' ); ?>"><?php echo starter_get_svg( array( 'icon' => 'bi-minus' ) ); ?></a>
									<div class="wrap_count_input"><input aria-label="count add to cart" type="number" class="form-control" value="1" readonly></div>
									<a href="#" class="count_block_btn js_plus_count_btn_product" role="button" aria-label="<?php esc_attr_e( 'Plus product', 'starter' ); ?>"><?php echo starter_get_svg( array( 'icon' => 'bi-plus' ) ); ?></a>
								</div>
							</li>
							<li>
								<!-- add to cart -->
								<div>
									<?php woocommerce_template_loop_add_to_cart( 'btn_class=btn-outline-primary btn btn-block btn-lg' ); ?>
								</div>
								<!-- END add to cart -->
							</li>
						</ul>
					<?php endif; ?>
				</div>
			<!-- END right part -->

			</div><!-- row -->
		</div><!-- container -->


		<!-- related products -->
			<?php
			if ( get_field( 'upsell_products' ) && get_theme_mod( 'qty_upsell_products', -1 ) ) {
				add_action( 'starter_single_product_upsell', 'woocommerce_upsell_display', 20 );
				do_action( 'starter_single_product_upsell' );
			}
			if ( get_field( 'related_products' ) ) {
				add_action( 'starter_single_product_related', 'woocommerce_output_related_products', 30 );
				do_action( 'starter_single_product_related' );
			}
			?>
		<!-- END related products -->

		<!-- comment section -->
			<?php
			if ( $starter_comment_enabled ) {
				require get_stylesheet_directory() . '/woocommerce-custom/comment/comment-section.php'; }
			?>
		<!-- END comment section -->

</div><!-- .content_wrapper -->
	<?php endwhile; // end of the loop. ?>


	<?php
else :
	echo "<div class='content_wrapper' role='main'><div class='container mt-5'><div class='col-md-5 col-lg-4 col-xl-3'>";
	echo esc_html( get_the_password_form() );
	echo '</div></div></div>';
endif;

get_footer();
