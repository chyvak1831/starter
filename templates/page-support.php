<?php
/**
 * Template Name: Support page
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

		<div class="row mt-4">
			<!-- desktop nav -->
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
			<!-- END desktop nav -->

			<!-- mobile nav -->
			<?php if ( has_nav_menu( 'support_nav_mobile' ) ) : ?>
				<div class="col-md-3 pr-md-5 support_nav_mobile">
					<nav aria-label="<?php esc_attr_e( 'Support navigation', 'starter' ); ?>">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'support_nav_mobile',
									'menu_class'     => 'list-unstyled menu list',
								)
							);
						?>
					</nav>
				</div>
			<?php endif; ?>
			<!-- END mobile nav -->

			<div class="col-md-9">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
				<?php endwhile; ?>
			</div>
		</div>

	</div>
</div><!-- .content_wrapper -->

<?php
get_footer();
