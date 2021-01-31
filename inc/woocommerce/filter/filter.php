<?php
/**
 * Filter and sorting
 *
 * @package starter
 * @since starter 1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Fork of Widget filter woocommerce/includes/widgets/class-wc-widget-layered-nav.php - Woo version 4.4.1
 *
 * @since starter 1.0
 */
function starter_override_woocommerce_attr_widget() {
	if ( class_exists( 'WC_Widget_Layered_Nav_Filters' ) ) {
		unregister_widget( 'WC_Widget_Layered_Nav_Filters' );
	}
	include_once get_stylesheet_directory() . '/inc/woocommerce/filter/class-wc-widget-layered-nav.php';
	register_widget( 'starter_WC_Widget_Layered_Nav' );
}
add_action( 'widgets_init', 'starter_override_woocommerce_attr_widget', 15 );

/**
 * Filter price: add data from ACF.
 *
 * @since starter 1.0
 *
 * @param array $params .
 * @return array $params modified sort array.
 */
function starter_price_filter_layout( $params ) {
	/*get widget vars*/
	$widget_name = $params[0]['widget_name'];
	$widget_id   = $params[0]['widget_id'];
	/*apply to "Filter Products by Price widget" only*/
	if ( 'Filter Products by Price' !== $widget_name ) {
		return $params;
	}
	/*get widget title*/
	global $wp_registered_widgets;
	$instance = $wp_registered_widgets[ $widget_id ]['callback'][0];
	// @see https://developer.wordpress.org/reference/classes/wp_widget/get_settings/
	$settings = $instance->get_settings();
	$num      = $wp_registered_widgets[ $widget_id ]['params'][0]['number'];
	if ( isset( $settings[ $num ]['title'] ) ) {
		$widget_title = $settings[ $num ]['title'];
	}
	/*get price filter ACF*/
	$filter_view_mobile  = get_field( 'filter_display_type_mobile', 'widget_' . $widget_id );
	$filter_view_desktop = get_field( 'filter_display_type_desktop', 'widget_' . $widget_id );
	/*modify output html*/
	$params[0]['before_widget'] .= '<div class="dropdown ' . $filter_view_desktop . ' ' . $filter_view_mobile . '">';
	$params[0]['before_widget'] .= '<a href="#" class="widget-title" data-toggle="dropdown">' . $widget_title . '<span class="notifications_text js_count_selected_filter d-none">0</span>' . starter_get_svg(
		array(
			'icon'  => 'bi-chevron-down',
			'class' => 'arrow',
		)
	) . '</a>';
	$params[0]['before_widget'] .= '<a href="#collapse_filter_' . $widget_id . '" class="widget-title" data-toggle="collapse">' . $widget_title . '<span class="notifications_text js_count_selected_filter d-none">0</span>' . starter_get_svg(
		array(
			'icon'  => 'bi-chevron-down',
			'class' => 'arrow',
		)
	) . '</a>';
	$params[0]['before_widget'] .= '<div class="collapse" id="collapse_filter_' . $widget_id . '">';
	return $params;

}
add_filter( 'dynamic_sidebar_params', 'starter_price_filter_layout' );

/**
 * Change Price Filter Widget Increment
 *
 * @since starter 1.0
 */
function starter_change_price_filter_step() {
	return 1;
}
add_filter( 'woocommerce_price_filter_widget_step', 'starter_change_price_filter_step', 10, 3 );

/**
 * Sort select.
 *
 * @since starter 1.0
 *
 * @param array $sorting_options .
 * @return array $sorting_options modified sort array.
 */
function starter_wc_customize_product_sorting( $sorting_options ) {
	$sorting_options = array(
		'title'      => __( 'Name A-Z', 'starter' ),
		'title-desc' => __( 'Name Z-A', 'starter' ),
		'price-desc' => __( 'Price to low', 'starter' ),
		'price'      => __( 'Price to high', 'starter' ),
		'date'       => __( 'Newest', 'starter' ),
		'popularity' => __( 'Most popular', 'starter' ),
	);
	return $sorting_options;
}
add_filter( 'woocommerce_catalog_orderby', 'starter_wc_customize_product_sorting' );

/**
 * Register Archive page widget area - for display filter.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function starter_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Archive product', 'starter' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in filter area on archive pages.', 'starter' ),
			'before_widget' => '<li><section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section></li>',
			'before_title'  => '<span class="d-none">',
			'after_title'   => '</span>',
		)
	);
}
add_action( 'widgets_init', 'starter_widgets_init' );
