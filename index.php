<?php
/**
 * Default homepage
 *
 * @package starter
 */

get_header();
?>

<div class="content_wrapper container" role="main">
	<div class="row">
		<?php
			// Show most recent posts.
			$starter_recent_posts = new WP_Query(
				array(
					'post_status'    => array( 'publish' ),
					'has_password'   => false,
					'post_type'      => 'product',
					'orderby'        => 'publish_date',
					'order'          => 'DESK',
					'posts_per_page' => (int) get_option( 'page_for_posts' ),
					'tax_query'      => array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => array( 'exclude-from-catalog' ),
						'operator' => 'NOT IN',
					),
				)
			);
			if ( $starter_recent_posts->have_posts() ) {
				while ( $starter_recent_posts->have_posts() ) {
					$starter_recent_posts->the_post();
					echo "<div class='wraper_product col-xl-5_per_line col-lg-3 col-md-4 col-6 js_product'>";
					$starter_img_sizes = '(max-width: 575px) calc(50vw - 10px), (max-width: 767px) 260px, (max-width: 991px) 220px, (max-width: 1199px) 220px, 208px';
					require get_stylesheet_directory() . '/woocommerce-custom/global/product-item.php';
					echo '</div>';
				}
				wp_reset_postdata();
			}
			?>
	</div><!-- .row -->
</div><!-- .content_wrapper -->

<?php
get_footer();
