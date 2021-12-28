<?php
/**
 * Template part for displaying comment item
 *
 * @package WordPress
 * @subpackage starter
 * @since starter 1.0
 */

defined( 'ABSPATH' ) || exit;

$starter_comment             = get_comment( $starter_comment_id );
$starter_comment_description = $starter_comment->comment_content;
$starter_comment_author      = $starter_comment->comment_author;
$starter_comment_date        = $starter_comment->comment_date_gmt;
$starter_comment_img_ids     = get_field( 'comment_image', $starter_comment );
$starter_comment_total_img   = $starter_comment_img_ids ? count( $starter_comment_img_ids ) : false;
$starter_comment_verified    = ( 'yes' === get_option( 'woocommerce_review_rating_verification_label', 'yes' ) ) ? wc_review_is_from_verified_owner( $starter_comment->comment_ID ) : 0; /*woo feature*/

$starter_comment_default_rating  = get_comment_meta( $starter_comment->comment_ID, 'rating', true );
$starter_comment_extended_rating = get_theme_mod( 'comment_extended_rating', false );
$starter_comment_price_rating    = get_field( 'rating_group', $starter_comment ) ? get_field( 'rating_group', $starter_comment )['price'] : 0;
$starter_comment_quality_rating  = get_field( 'rating_group', $starter_comment ) ? get_field( 'rating_group', $starter_comment )['quality'] : 0;
$starter_comment_shipping_rating = get_field( 'rating_group', $starter_comment ) ? get_field( 'rating_group', $starter_comment )['shipping'] : 0;
$starter_comment_average_rating  = ( $starter_comment_price_rating + $starter_comment_quality_rating + $starter_comment_shipping_rating ) / 3;
?>

<div class="wrap_comment js_comment_item" data-comment_id="<?php echo esc_attr( $starter_comment_id ); ?>">
	<!-- display default rating if extended disabled -->
	<?php if ( wc_review_ratings_enabled() && ! $starter_comment_extended_rating && $starter_comment_default_rating ) : ?>
		<div class="dropdown d-flex align-items-center mb-2">
			<?php
				$starter_comment_rating = $starter_comment_default_rating;
				require get_stylesheet_directory() . '/woocommerce-custom/global/rating.php';
			?>
		</div>
	<?php endif; ?>
	<!-- END display default rating if extended disabled -->

	<!-- display extended rating if enabled -->
	<?php if ( wc_review_ratings_enabled() && $starter_comment_extended_rating && $starter_comment_average_rating ) : ?>
		<div class="dropdown d-flex align-items-center mb-2">
			<?php
				$starter_comment_rating = $starter_comment_average_rating;
				require get_stylesheet_directory() . '/woocommerce-custom/global/rating.php';
			?>
			<a href="#" class="ml-1" data-bs-toggle="dropdown"><?php echo esc_html( number_format( round( $starter_comment_average_rating, 1 ), 1, '.', '' ) ); ?></a>
			<div class="dropdown-menu">
				<table class="table table-striped table_ratings">
					<tr>
						<td><?php echo esc_html_e( 'Price:', 'starter' ); ?></td>
						<td>
							<?php
								$starter_comment_rating = $starter_comment_price_rating;
								require get_stylesheet_directory() . '/woocommerce-custom/global/rating.php';
							?>
						</td>
					</tr>
					<tr>
						<td><?php echo esc_html_e( 'Quality:', 'starter' ); ?></td>
						<td>
							<?php
								$starter_comment_rating = $starter_comment_quality_rating;
								require get_stylesheet_directory() . '/woocommerce-custom/global/rating.php';
							?>
						</td>
					</tr>
					<tr>
						<td><?php echo esc_html_e( 'Shipping:', 'starter' ); ?></td>
						<td>
							<?php
								$starter_comment_rating = $starter_comment_shipping_rating;
								require get_stylesheet_directory() . '/woocommerce-custom/global/rating.php';
							?>
						</td>
					</tr>
				</table>
			</div>
		</div>
	<?php endif; ?>
	<!-- END display extended rating if enabled -->

	<!-- author, date and verified badge -->
	<ul class="list details_comment_list">
		<?php if ( $starter_comment_author ) : ?>
		<li>
			<?php
			echo esc_html( $starter_comment_author );
			if ( $starter_comment_verified ) {
				echo starter_get_svg( array( 'icon' => 'bi-patch-check' ) );
			}
			?>
		</li>
		<?php endif; ?>
		<li><?php echo esc_html( gmdate( 'F j, Y', strtotime( $starter_comment_date ) ) ); ?></li>
	</ul>
	<!-- END author, date and verified badge -->

	<!-- text and image comment content -->
	<?php echo esc_html( $starter_comment_description ); ?>
	<?php if ( 0 < $starter_comment_total_img ) : ?>
		<div class="attached_img_comment mt-4">
			<?php /* translators: count of images. */ ?>
			<small class="attached_img_title"><?php printf( esc_html( _n( 'Attached %s Photo', 'Attached %s Photos', $starter_comment_total_img, 'starter' ) ), esc_html( $starter_comment_total_img ) ); ?></small>
			<ul class="list object_fit">
				<?php foreach ( $starter_comment_img_ids as $starter_comment_img ) : ?>
					<li class="js_comment_img_modal_btn">
						<a href="/" role="button" aria-label="Open review modal">
							<picture class="item_img">
								<?php
									echo wp_kses(
										starter_img_func(
											array(
												'img_src'   => 'w200',
												'img_sizes' => '90px',
												'img_id'    => $starter_comment_img,
											)
										),
										wp_kses_allowed_html( 'post' )
									);
								?>
							</picture>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
	<!-- END text and image comment content -->
</div>
