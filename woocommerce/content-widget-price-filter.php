<?php
/**
 * The template for displaying product price filter widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-price-filter.php
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.1
 */

defined( 'ABSPATH' ) || exit;

?>
<?php do_action( 'woocommerce_widget_price_filter_start', $args ); ?>

<form class="js_wrap_price_filter" method="get" action="<?php echo esc_url( $form_action ); ?>">
	<div class="price_slider_wrapper">
		<div class="price_slider_amount row" data-step="<?php echo esc_attr( $step ); ?>">
			<div class="col-6"><input aria-label="minimum price filter" class="form-control" id="min_price" name="min_price" value="<?php echo esc_attr( $current_min_price ); ?>" data-min="<?php echo esc_attr( $min_price ); ?>" placeholder="<?php echo esc_attr__( 'Min price', 'woocommerce' ); ?>"></div>
			<div class="col-6"><input aria-label="maximum price filter" class="form-control" id="max_price" name="max_price" value="<?php echo esc_attr( $current_max_price ); ?>" data-max="<?php echo esc_attr( $max_price ); ?>" placeholder="<?php echo esc_attr__( 'Max price', 'woocommerce' ); ?>"></div>
			<?php /* translators: Filter: verb "to filter" */ ?>
			<div class="col-12 pt-2"><button type="submit" class="btn btn-primary price_filter_btn"><?php echo esc_html__( 'Filter', 'woocommerce' ); ?></button></div>
			<div class="price_label" style="display:none;">
				<?php echo esc_html__( 'Price:', 'woocommerce' ); ?> <span class="from"></span> &mdash; <span class="to"></span>
			</div>
			<?php echo wc_query_string_form_fields( null, array( 'min_price', 'max_price', 'paged' ), '', true ); ?>
			<div class="clear"></div>
		</div>
		<div class="price_slider"></div>
	</div>
	<input class="js_price_slider_file" type="text" hidden="hidden" value="<?php echo esc_attr( WC()->plugin_url() . '/assets/js/frontend/price-slider.min.js' ); ?>">
</form>
</div>
</div>

<?php do_action( 'woocommerce_widget_price_filter_end', $args ); ?>
