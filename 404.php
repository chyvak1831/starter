<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package starter
 */

get_header(); ?>


<div class="content_wrapper container" role="main">
	<div class="container text-center mt-5">
		<h4 class="status_type"><?php echo esc_html( __( '404', 'starter' ) ); ?></h4>
		<h1 class="text-uppercase"><?php echo esc_html( __( 'Not found', 'starter' ) ); ?></h1>
		<a href="<?php echo esc_url( site_url() ); ?>" class="btn btn-primary"><?php echo esc_html( __( 'back to shop', 'starter' ) ); ?></a>
	</div>
</div>

<?php
get_footer();
