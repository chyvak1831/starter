<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage starter
 * @since starter 1.0
 */

get_header(); ?>

<div class="content_wrapper pt-5 pb-5" role="main">
	<div class="container">

		<!-- breadcrumb -->
		<?php
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			yoast_breadcrumb( '<div class="yoast_breadcrumb">', '</div>' );
		}
		?>
		<!-- END breadcrumb -->

		<?php
		while ( have_posts() ) {
			the_post();
			the_title( '<h1 class="entry-title">', '</h1>' );

			if ( class_exists( 'WooCommerce' ) ) {
				/*if woocommerce enabled*/
				switch ( $post->ID ) {
					case wc_get_page_id( 'cart' ):
						echo "<div class='cart_page'>" . do_shortcode( '[woocommerce_cart]' ) . '</div>';
						break;
					case wc_get_page_id( 'checkout' ):
						echo "<div class='checkout_page'>" . do_shortcode( '[woocommerce_checkout]' ) . '</div>';
						break;
					case wc_get_page_id( 'myaccount' ):
						echo "<div class='account_page'>" . do_shortcode( '[woocommerce_my_account]' ) . '</div>';
						break;
					default:
						echo '<div class="mt-5">';
						the_content();
						echo '</div>';
				}
				/*END if woocommerce enabled*/
			} else {
				echo '<div class="mt-5">';
				the_content();
				echo '</div>';
			}
		}
		?>
	</div>
</div><!-- .content_wrapper -->

<?php
get_footer();
