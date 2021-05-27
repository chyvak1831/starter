<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage starter
 * @since starter 1.0
 */

get_header();
?>

<div class="content_wrapper container" role="main">

	<?php
	if ( ! is_front_page() ) {
		the_archive_title( '<h1>', '</h1>' );
	}
	?>
	<div class="row">
		<?php
		if ( have_posts() ) :

			while ( have_posts() ) :
				the_post();
				?>
				<article class="col-sm-6 col-lg-4">
					<a class="card" href="<?php echo esc_url( get_permalink() ); ?>">
						<picture class="card-img-top overflow-hidden">
							<?php
								echo wp_kses(
									starter_img_func(
										array(
											'img_src'   => 'w600',
											'img_sizes' => '(max-width: 575px) calc(100vw - 10px), (max-width: 767px) 258px, (max-width: 991px) 334px, (max-width: 1199px) 294px, (max-width: 1399px) 354px, 414px',
											'img_id'    => get_post_thumbnail_id(),
										)
									),
									wp_kses_allowed_html( 'post' )
								);
							?>
						</picture>
						<div class="card-body">
							<h2 class="card-text h5 text-uppercase"><?php the_title(); ?></h2>
						</div>
					</a>
				</article>

				<?php
		endwhile;
			?>
	</div>

			<?php
			the_posts_pagination(
				array(
					'type'               => 'list',
					'prev_text'          => starter_get_svg( array( 'icon' => 'bi-chevron-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'starter' ) . '</span>',
					'next_text'          => '<span class="screen-reader-text">' . __( 'Next page', 'starter' ) . '</span>' . starter_get_svg( array( 'icon' => 'bi-chevron-right' ) ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'starter' ) . ' </span>',
				)
			);
		endif;
		?>

</div>

<?php

get_footer();
