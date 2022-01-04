<?php
/**
 * Filter and sorting
 *
 * @package WordPress
 * @subpackage starter
 * @since starter 1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Filters: add dropdown/collapse markup and ACF setting.
 *
 * @since starter 1.0
 *
 * @param array $params .
 * @return array $params modified sort array.
 */
function starter_filter_layout( $params ) {
	/*get widget id*/
	$widget_id = $params[0]['widget_id'];
	/*get widget title*/
	global $wp_registered_widgets;
	$instance = $wp_registered_widgets[ $widget_id ]['callback'][0];
	// @see https://developer.wordpress.org/reference/classes/wp_widget/get_settings/
	$settings     = $instance->get_settings();
	$num          = $wp_registered_widgets[ $widget_id ]['params'][0]['number'];
	$widget_title = '';
	if ( isset( $settings[ $num ]['title'] ) ) {
		$widget_title = $settings[ $num ]['title'];
	}
	/*get ACF*/
	$filter_view_mobile  = get_field( 'filter_display_type_mobile', 'widget_' . $widget_id );
	$filter_view_desktop = get_field( 'filter_display_type_desktop', 'widget_' . $widget_id );
	/*modify output html*/
	$params[0]['before_widget'] .= '<div class="dropdown ' . $filter_view_desktop . ' ' . $filter_view_mobile . '">';
	$params[0]['before_widget'] .= '<a href="#" class="widget-title" data-bs-toggle="dropdown" data-bs-display="static">' . $widget_title . '<span class="notifications_text badge rounded-pill bg-dark js_count_selected_filter"></span>' . starter_get_svg(
		array(
			'icon'  => 'bi-chevron-down',
			'class' => 'arrow',
		)
	) . '</a>';
	$params[0]['before_widget'] .= '<a href="#collapse_filter_' . $widget_id . '" class="widget-title" data-bs-toggle="collapse">' . $widget_title . '<span class="notifications_text badge rounded-pill bg-dark js_count_selected_filter"></span>' . starter_get_svg(
		array(
			'icon'  => 'bi-chevron-down',
			'class' => 'arrow',
		)
	) . '</a>';
	$params[0]['before_widget'] .= '<div class="dropdown-menu"><div class="collapse" id="collapse_filter_' . $widget_id . '">';
	return $params;

}
add_filter( 'dynamic_sidebar_params', 'starter_filter_layout' );

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
 * @since starter 1.0
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

/**
 * Filters: add color markup and ACF.
 *
 * @since starter 1.2
 *
 * @param string $term_html .
 * @param object $term filter item.
 * @param string $link filter link url.
 * @param int    $count filter count.
 * @return string $term_html modified markup.
 */
function starter_filter_link_markup( $term_html, $term, $link, $count ) {
	$indicator_color    = '';
	$color_field_status = get_field( 'color_field_toggler', $term->taxonomy . '_' . $term->term_id );
	if ( $color_field_status ) {
		$color           = strtolower( get_field( 'color_taxonomy', $term->taxonomy . '_' . $term->term_id ) );
		$indicator_color = '<span class="indicator_color" style="background:' . $color . ';"></span>';
	}
	$term_html = '<a class="form-check" rel="nofollow" href="' . esc_url( $link ) . '">' .
						'<input class="form-check-input" type="checkbox" aria-label="Filter">' .
						$indicator_color . '<span class="wrap_text">' . esc_html( $term->name ) . '</span>' .
						apply_filters( 'woocommerce_layered_nav_count', '<small class="text-muted count">(' . absint( $count ) . ')</small>', $count, $term ) .
				 '</a>';
	return $term_html;
}
add_filter( 'woocommerce_layered_nav_term_html', 'starter_filter_link_markup', 10, 4 );

/**
 * Customizer: ajax filter & sort feature
 *
 * @since starter 1.2
 *
 * @param object $wp_customize Instance of the WP_Customize_Manager class.
 */
function starter_customizer_filter_ajax( $wp_customize ) {
	$wp_customize->add_setting(
		'product_filter_sort_ajax',
		array(
			'default'   => true,
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'product_filter_sort_ajax',
		array(
			'section' => 'ajax_section',
			'label'   => 'Product category: filter & sort (woocommerce only)',
			'type'    => 'checkbox',
		)
	);
	$wp_customize->add_setting(
		'product_pagination_ajax',
		array(
			'default'   => true,
			'type'      => 'theme_mod',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'product_pagination_ajax',
		array(
			'section' => 'ajax_section',
			'label'   => 'Product category: pagination (woocommerce only)',
			'type'    => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'starter_customizer_filter_ajax', 50 );
