<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $upsells ) : ?>

<section class="pt-5 mt-5">
	<div class="container">
		<?php
		$heading = apply_filters( 'woocommerce_product_upsells_products_heading', __( 'You may also like&hellip;', 'woocommerce' ) );

		if ( $heading ) :
			?>
			<h2 class="title_section"><span><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
	</div>
	<div class="container">
		<div class="position-relative product_carousel js_product_carousel">
			<div class="swiper">
				<div class="swiper-wrapper">
				<?php foreach ( $upsells as $upsell ) : ?>

					<?php
					$post_object = get_post( $upsell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
						echo "<div class='wraper_product swiper-slide js_product'>";
						$starter_img_sizes = '(max-width: 575px) calc(50vw - 10px), (max-width: 767px) 260px, (max-width: 991px) 220px, (max-width: 1199px) 220px, (max-width: 1399px) 208px, 244px';
						require get_stylesheet_directory() . '/woocommerce-custom/global/product-item.php';
						echo '</div>';
					?>

				<?php endforeach; ?>
				</div>
			</div>
			<button type="button" class="btn carousel_control_prev" aria-label="Carousel scroll previous"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ); ?></button>
			<button type="button" class="btn carousel_control_next" aria-label="Carousel scroll next"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-right' ) ); ?></button>
		</div>
	</div>
</section>


	<?php
endif;

wp_reset_postdata();
