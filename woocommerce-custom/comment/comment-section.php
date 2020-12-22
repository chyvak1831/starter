<?php
/**
 * Comment section
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;

// default and total count of comments
$starter_comment_quantity = get_option( 'page_comments', 0 ) ? get_option( 'comments_per_page', 2 ) : 0; // wp feature
$starter_comment_order    = get_option( 'comment_order', 'DESK' ); // wp feature
$starter_param            = array(
	'status'  => 'approve',
	'post_id' => $starter_product_id,
	'orderby' => 'comment_date',
	'order'   => $starter_comment_order,
	'number'  => $starter_comment_quantity,
);
$starter_comments_query   = get_comments( $starter_param );
$starter_only_logged      = get_option( 'comment_registration' ) && ! is_user_logged_in(); // wp feature
$starter_only_verified    = ( 'yes' === get_option( 'woocommerce_review_rating_verification_required', 'no' ) && ! wc_customer_bought_product( '', get_current_user_id(), $starter_product_id ) ); // woo feature
?>

<div class="container mt-4" id="comments_wrap">
	<!-- comments -->
	<h2 class="title_section"><span><?php esc_html_e( 'Customer Reviews', 'starter' ); ?></span></h2>
	<div class="comment_list js_comment_list" data-comment-total="<?php echo esc_attr( $starter_comment_count ); ?>">
		<?php
		foreach ( $starter_comments_query as $starter_comment ) {
			$starter_comment_id = $starter_comment->comment_ID;
			require get_stylesheet_directory() . '/woocommerce-custom/comment/comment-item.php';
		}
		?>
	</div>
	<?php if ( $starter_comment_count > $starter_comment_quantity && 0 != $starter_comment_quantity ) : ?>
		<div class="text-center">
			<a href="#" class="btn btn-outline-primary btn-lg js_comment_show_more" data-product_id="<?php echo esc_attr( $starter_product_id ); ?>">
				<span class="default_txt"><?php esc_html_e( 'Show more', 'starter' ); ?></span>
				<span class="loading_txt"><?php esc_html_e( 'Loading...', 'starter' ); ?></span>
			</a>
		</div>
	<?php endif; ?>
	<?php if ( !$starter_comment_count ) : ?>
		<p class="text-center h5"><?php esc_html_e( 'Create review - be first!', 'starter' ); ?></p>
	<?php endif; ?>
	<!-- END comments -->

	<!-- comment form -->
	<div id="write_comment">
		<?php if ( $starter_only_verified ) : ?><!-- only buyers of this product can write review -->
			<h4 class="text-center mt-5 pt-2"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'starter' ); ?></h4>
		<?php endif; ?>

		<?php if ( ! $starter_only_verified && $starter_only_logged ) : ?><!-- only logged users can write review -->
			<h4 class="text-center mt-5 pt-2"><?php esc_html_e( 'You must be ', 'starter' ); ?><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><?php esc_html_e('logged in','starter'); ?></a><?php esc_html_e( ' to post a review.', 'starter' ); ?></h4>
		<?php endif; ?>

		<?php if ( ! $starter_only_verified && ! $starter_only_logged ) : ?><!-- anyone can write review -->
			<h2 class="title_section mt-5 pt-2"><span><?php esc_html_e( 'Write Review', 'starter' ); ?></span></h2>
			<h4 class="text-center js_comment_form_sent" style="display: none;"><?php esc_html_e( 'Thanks for your feedback!', 'starter' ); ?></h4>
			<form class="row comment_block justify-content-center js_form_with_recaptcha js_comment_form" novalidate method="post" enctype="multipart/form-data">
				<?php require get_stylesheet_directory() . '/woocommerce-custom/comment/comment-form.php'; ?>
			</form>
		<?php endif; ?>
	</div>
	<!-- END comment form -->
</div>
