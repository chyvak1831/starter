<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header();
global $wp_query;
$starter_all_count_item = $wp_query->found_posts;

/*filters - get canonical URL*/
global $wp;
if ( '' === get_option( 'permalink_structure' ) ) {
	$starter_archive_url = remove_query_arg( array( 'page', 'paged', 'product-page' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
} else {
	$starter_archive_url = preg_replace( '%\/page/[0-9]+%', '', home_url( trailingslashit( $wp->request ) ) );
}
?>
<input class="js_archive_url" type="hidden" value="<?php echo esc_url( $starter_archive_url ); ?>">
<!-- filters - get canonical URL -->

<?php
$starter_search_page = '';
if ( is_search() ) {
	$starter_search_page = ' search_page';
}
?>
<div class="content_wrapper container mt-5 archive_product js_wrap_archive <?php echo esc_attr( $starter_search_page ); ?>" role="main">

	<!-- breadcrumb -->
	<?php
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<div class="yoast_breadcrumb">', '</div>' );
	}
	?>
	<!-- END breadcrumb -->

	<h1 class="mb-0 text-center">
		<?php
		if ( is_product_taxonomy() ) {
			woocommerce_page_title();
		} elseif ( is_search() ) {
			printf( 'Search Results for: “%s”', '<span>' . get_search_query() . '</span>' );
		} else {
			esc_html_e( 'All products', 'starter' );
		}
		?>
	</h1>
	<h2 class="mb-5 text-center text-muted"><small>(<?php echo esc_html( $starter_all_count_item ); ?><?php esc_html_e( ' products', 'starter' ); ?>)</small></h2>

	<div class="row">

		<!-- filters layout -->
		<div class="col-xl-5_per_line col-lg-3 col-md-4 d-flex justify-content-between d-md-block js_wrap_filters">
			<div class="filter_block">
				<?php if ( wc_get_loop_prop( 'total' ) ) : ?>
					<span class="widget-title border-0"><?php esc_html_e( 'Sort by', 'starter' ); ?></span>
					<?php do_action( 'woocommerce_before_shop_loop' ); ?>
				<?php else : /*for a case when no results*/ ?>
					<form class="woocommerce-ordering">
						<input type="hidden" name="noresults" value="1">
					</form>
				<?php endif; ?>
			</div>
			<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
				<div class="filter_block all_filters">
					<?php do_action( 'woocommerce_sidebar' ); ?>
					<a href="<?php echo esc_url( $starter_archive_url ); ?>" class="btn btn-outline-primary d-none filter_reset_btn js_reset_filters" role="button"><?php esc_html_e( 'Reset', 'starter' ); ?></a>
					<a href="#" class="close_filters js_close_filters" role="button" aria-label="<?php esc_attr_e( 'Close filters', 'starter' ); ?>">
						<?php echo starter_get_svg( array( 'icon' => 'bi-remove' ) ); ?>
					</a>
				</div>
				<a href="#" class="filter_block mobile_filters_btn js_show_filters_btn" role="button"><?php esc_html_e( 'Filters', 'starter' ); ?><span class="ml-1 notifications_text d-none js_all_selected_filter"></span></a>
			<?php endif; ?>
		</div>
		<!-- END filters layout -->

		<div class="col-xl-5_per_line_wrap_4_items col-lg-9 col-md-8"><div class="row">
		<?php
		if ( wc_get_loop_prop( 'total' ) ) {
			while ( have_posts() ) {
				the_post();
				global $product;
				echo "<div class='wraper_product col-xl-3 col-lg-4 col-md-6 col-6 js_product'>";
				$starter_img_sizes = '(max-width: 575px) calc(50vw - 10px), (max-width: 767px) 260px, (max-width: 991px) 220px, (max-width: 1199px) 220px, 208px';
				require get_stylesheet_directory() . '/woocommerce-custom/global/product-item.php';
				echo '</div>';
			}
				wp_reset_postdata();
		} else {
			esc_html_e( 'No products found', 'starter' );
		}
			do_action( 'woocommerce_after_shop_loop' );
		?>
		</div></div>

	</div><!-- .row -->

</div><!-- .content_wrapper -->

<?php
get_footer();
