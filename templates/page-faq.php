<?php
/**
 * Template Name: Customer Service
 *
 * @package starter
 */

get_header();
?>

<div class="content_wrapper mt-5 customer_service" role="main">
	<div class="container">
		<!-- breadcrumb -->
		<?php if ( function_exists( 'yoast_breadcrumb' ) ) {
			yoast_breadcrumb( '<div class="yoast_breadcrumb">', '</div>' );
		} ?>
		<!-- END breadcrumb -->
		<div class="row">
			<div class="col-md-3">
				<div class="dropdown customer_service_nav">
					<a href="#" class="mobile_btn_nav" data-toggle="dropdown" role="button" aria-label="<?php esc_attr_e( 'Customer service menu', 'starter' ); ?>"><?php the_title(); ?><?php echo starter_get_svg( array( 'icon' => 'bi-chevron-down' ) ); ?></a>
					<div class="dropdown-menu">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'service_nav',
									'menu_class'     => 'list-unstyled category_list',
								)
							);
							?>
					</div>
				</div>
			</div>
			<div class="col-md-9 pl-md-5 pt-3">
				<?php
					while ( have_posts() ) :
					the_post();
				?>
					<h1 class="main_page_title"><?php the_title(); ?></h1>
					<?php the_content(); ?>
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'service_nav',
								'menu_class'     => 'list-unstyled step_nav js_step_nav',
							)
						);
					?>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
