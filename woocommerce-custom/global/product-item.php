<?php
/**
 * Product item
 *
 * @package WordPress
 * @subpackage starter
 * @since starter 1.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Detect plugin. For use on Front End only.
 */
require_once ABSPATH . 'wp-admin/includes/plugin.php';

$starter_img             = $product->get_image_id();
$starter_thumbnails      = ! empty( $product->get_gallery_image_ids() ) ? $product->get_gallery_image_ids()[0] : $starter_img;
$starter_comment_enabled = wc_reviews_enabled() && $product->get_reviews_allowed() ? 1 : 0; /*woo feature - check if all reviews and for certain product enabled*/
$starter_comment_count   = $product->get_review_count();
$starter_comment_rating  = $product->get_average_rating();

/*new label*/
$starter_terms      = wp_get_post_terms( get_the_id(), 'product_tag' );
$starter_term_array = array();
foreach ( $starter_terms as $starter_term ) {
	$starter_term_array[] = $starter_term->name;
}
/*END new label*/
?>

<div class="box_product_item">

	<!-- main image -->
	<div class="position-relative">
		<a href="<?php echo esc_url( get_the_permalink() ); ?>">
			<picture class="main_img item_img">
				<?php
					echo wp_kses(
						starter_img_func(
							array(
								'img_src'   => 'w600',
								'img_sizes' => $starter_img_sizes,
								'img_id'    => $starter_img,
							)
						),
						wp_kses_allowed_html( 'post' )
					);
					?>
			</picture>
			<picture class="thumbnail_img item_img">
				<?php
					echo wp_kses(
						starter_img_func(
							array(
								'img_src'   => 'w600',
								'img_sizes' => $starter_img_sizes,
								'img_id'    => $starter_thumbnails,
							)
						),
						wp_kses_allowed_html( 'post' )
					);
					?>
			</picture>
		</a>
		<ul class="list flex-column label_product_list">
			<?php if ( is_plugin_active( 'ti-woocommerce-wishlist/ti-woocommerce-wishlist.php' ) && tinv_get_option( 'add_to_wishlist_catalog', 'show_in_loop' ) ) : ?>
				<li><div class="wrap_label"><?php echo do_shortcode( '[ti_wishlists_addtowishlist loop=yes]' ); ?></div></li>
			<?php endif; ?>
			<?php if ( in_array( 'new', $starter_term_array, true ) ) : ?>
				<li><div class="wrap_label"><?php esc_html_e( 'New', 'starter' ); ?></div></li>
			<?php endif; ?>
			<?php if ( $product->is_on_sale() ) : ?>
				<li><div class="wrap_label"><?php echo starter_get_svg( array( 'icon' => 'bi-percent' ) ); ?></div></li>
			<?php endif; ?>
		</ul>
	</div>
	<!-- END main image -->

	<div class="description_block">
		<div class="top_part_description">
			<h3 class="main_heading"><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo esc_html( the_title() ); ?></a></h3>

			<!-- rating -->
			<?php if ( $starter_comment_enabled && $starter_comment_count ) : ?>
				<div class="d-flex align-items-center justify-content-center">
					<?php
					if ( wc_review_ratings_enabled() && $starter_comment_rating ) {
						require get_stylesheet_directory() . '/woocommerce-custom/global/rating.php';
					} else {
						esc_html_e( 'Reviews&nbsp;', 'starter' );
					}
					?>
					<span class="count_votes">(<?php echo esc_html( $starter_comment_count ); ?>)</span>
				</div>
			<?php endif; ?>
			<!-- END rating -->

			<!-- price -->
			<?php if ( $product->is_in_stock() ) : ?>
				<?php wc_get_template( 'loop/price.php' ); ?>
			<?php else : ?>
				<span><?php esc_html_e( 'Sold Out', 'starter' ); ?></span>
			<?php endif; ?>
			<!-- END price -->

		</div>

		<!-- add to cart -->
		<?php woocommerce_template_loop_add_to_cart( 'btn_class=btn btn-outline-primary d-block' ); ?>
		<!-- END add to cart -->

	</div><!-- END description_block -->

</div><!-- END box_product_item -->
