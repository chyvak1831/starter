<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage starter
 * @since starter 1.0
 */

get_header(); ?>

<div class="content_wrapper container pt-5 pb-5" role="main">
	<div class="container text-center mt-5">
		<h4 class="status_type"><?php echo esc_html( __( '404', 'starter' ) ); ?></h4>
		<h1 class="text-uppercase"><?php echo esc_html( __( 'Not found', 'starter' ) ); ?></h1>
		<a href="<?php echo esc_url( site_url() ); ?>" class="btn btn-primary"><?php echo esc_html( __( 'Back to home', 'starter' ) ); ?></a>
	</div>
</div>

<?php
get_footer();
