<?php
/**
 * Menus
 *
 * @package WordPress
 * @subpackage starter
 * @since 1.0
 */

/* Register menus locations */
register_nav_menus(
	array(
		'header_top_nav'         => __( 'Header Top Area', 'starter' ),
		'header_top_nav_mobile'  => __( 'Header Top Area Mobile', 'starter' ),
		'header_main_nav'        => __( 'Header Main Area', 'starter' ),
		'header_main_nav_mobile' => __( 'Header Main Area Mobile', 'starter' ),
		'footer_nav'             => __( 'Footer Area', 'starter' ),
		'support_nav'            => __( 'Support Area', 'starter' ),
		'support_nav_mobile'     => __( 'Support Area Mobile', 'starter' ),
	)
);


/**
 * Add style from customizer to top level menus
 *
 * @since starter 1.0
 *
 * @param string   $items The HTML list content for the menu items.
 * @param stdClass $args  An object containing wp_nav_menu() arguments.
 * @return string $items Modified items html
 */
function starter_nav_menu_items( $items, $args ) {
	$menu        = wp_get_nav_menu_object( $args->menu );
	$font_size   = get_field( 'menu_font_size', $menu );
	$icon_size   = get_field( 'menu_icon_size', $menu );
	$color       = get_field( 'menu_color', $menu );
	$color_hover = get_field( 'menu_color_hover', $menu );
	$space       = get_field( 'menu_item_space', $menu );
	$separator   = get_field( 'menu_item_separator', $menu );
	$alignment   = get_field( 'menu_alignment', $menu );
	$menu_style  = '<style>.menu-' . $menu->slug . '-container{font-size:' . $font_size . 'px;color:' . $color . ';}
						   .menu-' . $menu->slug . '-container > ul{justify-content:' . $alignment . ';}
	                       .menu-' . $menu->slug . '-container a:hover, .menu-' . $menu->slug . '-container a:focus, .menu-' . $menu->slug . '-container .current-menu-item > a{color:' . $color_hover . ';}
	                       .menu-' . $menu->slug . '-container .menu_icon{font-size:' . $icon_size . 'px !important;}
	                       .menu-' . $menu->slug . '-container .menu > li::after{content:"' . $separator . '";margin: 0 ' . $space . 'px;}</style>';
	$items       = $menu_style . $items;
	return $items;
}
add_filter( 'wp_nav_menu_items', 'starter_nav_menu_items', 10, 2 );


/**
 * Add style from customizer to nested menus
 *
 * @since starter 1.0
 *
 * @param string  $item_output The menu item's starting HTML output.
 * @param WP_Post $item        Menu item data object.
 * @return string $item_output Modified item_output html
 */
function starter_nested_menu_style( $item_output, $item ) {
	if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {
		$font_size   = get_field( 'menu_font_size', $item->db_id );
		$icon_size   = get_field( 'menu_icon_size', $item->db_id );
		$color       = get_field( 'menu_color', $item->db_id );
		$color_hover = get_field( 'menu_color_hover', $item->db_id );
		$space       = get_field( 'menu_item_space', $item->db_id );
		$separator   = get_field( 'menu_item_separator', $item->db_id );
		$menu_style  = '<style>#menu-item-' . $item->db_id . ' .sub-menu{font-size:' . $font_size . 'px;color:' . $color . ';}
		                       #menu-item-' . $item->db_id . ' .sub-menu a:hover, #menu-item-' . $item->db_id . ' .sub-menu a:focus, #menu-item-' . $item->db_id . ' .sub-menu .current-menu-item > a:focus{color:' . $color_hover . ';}
		                       #menu-item-' . $item->db_id . ' .sub-menu .menu_icon{font-size:' . $icon_size . 'px !important;}
		                       #menu-item-' . $item->db_id . ' > .sub-menu > li::after{content:"' . $separator . '";margin: 0 ' . $space . 'px;}</style>';
		$item_output = $menu_style . $item_output;
	}
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'starter_nested_menu_style', 10, 2 );


/**
 * Add classes for <li> menu's elements, svg and img
 *
 * @since starter 1.0
 *
 * @param array    $sorted_menu_items The menu items, sorted by each menu item's menu order.
 * @param stdClass $args              An object containing wp_nav_menu() arguments.
 * @return array $sorted_menu_items Modified sorted_menu_items array
 */
function starter_nav_menu_objects( $sorted_menu_items, $args ) {
	foreach ( $sorted_menu_items as &$item ) {
		$text_visibility  = get_field( 'menu_item_label_visibility', $item );
		$img_visibility   = get_field( 'menu_item_img_visibility', $item );
		$icon_img_toggler = get_field( 'menu_item_img_toggler', $item );
		$icon             = get_field( 'menu_item_icon', $item );
		$icon_response    = wp_remote_get( wp_get_attachment_image_src( $icon['ID'] )[0] );
		$img              = get_field( 'menu_item_img', $item );
		$img_width        = get_field( 'menu_item_img_width', $item ) . 'px';
		$item_grow_shrink = get_field( 'menu_item_flex_width', $item );
		$item_align       = get_field( 'menu_item_align', $item );
		$item_visibility  = get_field( 'menu_item_visibility', $item );

		$item_nested_type = get_field( 'menu_nested_type', $item );
		$dropdown_align   = get_field( 'menu_dropdown_alignment', $item );
		$dropdown_arrow   = get_field( 'menu_dropdown_arrow', $item ) ? '' : 'arrow_hide';

		if ( ! $text_visibility ) {
			$item->title = '<span class="screen-reader-text">' . $item->title . '</span>';
		}

		$item->title .= "<span class='notifications_text'></span>";

		if ( $img_visibility ) {
			if ( 'menu_item_icon_on' === $icon_img_toggler && '200' == $icon_response['response']['code'] ) {
				$item->title .= '<span class="menu_icon">' . $icon_response['body'] . '</span>';
			} elseif ( 'menu_item_img_on' === $icon_img_toggler && $img ) {
				$item->title .= '<picture style="max-width:' . $img_width . '">' . starter_img_func(
					array(
						'img_src'   => 'w1000',
						'img_sizes' => $img_width,
						'img_id'    => $img['ID'],
						'lazy'      => 'false',
					)
				) . '</picture>';
			}
		}

		if ( $item_grow_shrink ) {
			$item->classes = array_merge( $item->classes, $item_grow_shrink );
			if ( in_array( 'flex-grow-1', $item_grow_shrink, true ) ) {
				array_push( $item->classes, $item_align );
			}
		}

		if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {
			array_push( $item->classes, 'dropdown' );
			array_push( $item->classes, $dropdown_align );
		}

		array_push( $item->classes, $item_visibility, $item_nested_type, $dropdown_arrow );
	}
	return $sorted_menu_items;
}
add_filter( 'wp_nav_menu_objects', 'starter_nav_menu_objects', 10, 2 );


/**
 * Add 'dropdown-menu' css class to submenu
 *
 * @since starter 1.0
 *
 * @param array $classes Array of the CSS classes that are applied to the menu `<ul>` element.
 * @return array $classes Modified classes array
 */
function starter_submenu_add_class( $classes ) {
	$classes[] = 'dropdown-menu';
	return $classes;
}
add_filter( 'nav_menu_submenu_css_class', 'starter_submenu_add_class', 10, 1 );


/**
 * Add 'dropdown-item' css class to dropdown links
 *
 * @since starter 1.0
 *
 * @param array    $atts {
 *        The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
 *
 *     @type string $title        Title attribute.
 *     @type string $target       Target attribute.
 *     @type string $rel          The rel attribute.
 *     @type string $href         The href attribute.
 *     @type string $aria_current The aria-current attribute.
 * }
 * @param WP_Post  $item  The current menu item.
 * @param stdClass $args  An object of wp_nav_menu() arguments.
 * @param int      $depth Depth of menu item. Used for padding.
 * @return array $atts Modified atts array
 */
function starter_menu_link_change_attr( $atts, $item, $args, $depth ) {
	if ( 0 !== $depth ) {
		$atts['class'] = 'dropdown-item';
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'starter_menu_link_change_attr', 10, 4 );


/**
 * Add dropdown icon for dropdown top link.
 *
 * @since starter 1.0
 *
 * @param string  $title The menu item's title.
 * @param WP_Post $item  The current menu item.
 * @return string $title Modified title string
 */
function starter_add_dropdown_icon_menu_link( $title, $item ) {
	if ( in_array( 'menu-item-has-children', $item->classes, true ) || in_array( 'page_item_has_children', $item->classes, true ) ) {
		$title = $title . starter_get_svg(
			array(
				'icon'  => 'bi-chevron-down',
				'class' => 'arrow',
			)
		);
	}
	return $title;
}
add_filter( 'nav_menu_item_title', 'starter_add_dropdown_icon_menu_link', 10, 4 );
