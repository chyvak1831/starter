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
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $upsells ) : ?>
<section class="pt-5 mt-5">
	<div class="container">
		<h2 class="title_section"><span><?php esc_html_e( 'You may also like&hellip;', 'starter' ); ?></span></h2>
	</div>
	<div class="container">
		<div class="wrap_carousel product_carousel js_product_carousel">
			<div class="js_carousel">
				<?php foreach ( $upsells as $upsell ) {
					$post_object = get_post( $upsell->get_id() );
					setup_postdata( $GLOBALS['post'] =& $post_object );
					echo "<div class='wraper_product js_product'>";
					$starter_img_sizes = '(max-width: 575px) calc(50vw - 10px), (max-width: 767px) 260px, (max-width: 991px) 220px, (max-width: 1199px) 220px, 208px';
					require get_stylesheet_directory() . '/woocommerce-custom/global/product-item.php';
					echo '</div>';
				} ?>
			</div>
			<button class="btn carousel_control_prev js_carousel_control_prev"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ); ?></button>
			<button class="btn carousel_control_next js_carousel_control_next"><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ); ?></button>
		</div>
	</div>
</section>


<?php endif;

wp_reset_postdata();
