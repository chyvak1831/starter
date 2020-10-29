<?php
/**
 * Template Name: Support page
 *
 * @package starter
 */

get_header();
?>

<div class="content_wrapper" role="main">
	<div class="container">
		<!-- breadcrumb -->
		<?php if ( function_exists( 'yoast_breadcrumb' ) ) {
			yoast_breadcrumb( '<div class="yoast_breadcrumb">', '</div>' );
		} ?>
		<!-- END breadcrumb -->
		<div class="row mt-4">
			<?php if ( has_nav_menu( 'support_nav' ) ) : ?>
				<div class="col-md-3 pr-md-5 support_nav">
					<nav aria-label="<?php esc_attr_e( 'Support navigation', 'starter' ); ?>">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'support_nav',
									'menu_class'     => 'list-unstyled menu list',
								)
							);
						?>
					</nav>
				</div>
			<?php endif; ?>
			<div class="col-md-9">
				<?php
					while ( have_posts() ) :
					the_post();
				?>
					<h1 class="main_page_title"><?php the_title(); ?></h1>
					<?php the_content(); ?>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
