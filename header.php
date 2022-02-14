<?php
/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage starter
 * @since starter 1.0
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body id="topPage" <?php body_class(); ?>>
<a href="#topPage" class="scrollup js_scrollto" role="button" aria-label="<?php esc_attr_e( 'Scroll to top', 'starter' ); ?>">
	<?php echo starter_get_svg( array( 'icon' => 'bi-arrow-up' ) ); ?>
</a>

<div class="main_wrap">
	<header class="main_header">
		<!-- TOP NAV AREA -->
			<?php if ( has_nav_menu( 'header_top_nav' ) ) : ?>
				<div class="header_top_nav border-bottom p-1">
					<div class="container">
						<nav aria-label="<?php esc_attr_e( 'Header Top Nav', 'starter' ); ?>">
							<?php
								wp_nav_menu(
									array(
										'theme_location' => 'header_top_nav',
										'menu_class'     => 'menu list',
									)
								);
							?>
						</nav>
					</div>
				</div>
			<?php endif; ?>
		<!-- END TOP NAV AREA -->

		<!-- TOP MOBILE NAV AREA -->
			<?php if ( has_nav_menu( 'header_top_nav_mobile' ) ) : ?>
				<nav class="header_top_nav_mobile border-bottom p-1" aria-label="<?php esc_attr_e( 'Header Top Mobile Nav', 'starter' ); ?>">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'header_top_nav_mobile',
								'menu_class'     => 'menu list',
							)
						);
					?>
				</nav>
			<?php endif; ?>
		<!-- END TOP MOBILE NAV AREA -->

		<!-- MAIN NAV AREA -->
			<?php if ( has_nav_menu( 'header_main_nav' ) ) : ?>
				<div class="header_main_nav border-bottom p-3">
					<div class="container">
						<nav aria-label="<?php esc_attr_e( 'Header Main Nav', 'starter' ); ?>">
							<?php
								wp_nav_menu(
									array(
										'theme_location' => 'header_main_nav',
										'menu_class'     => 'menu list',
									)
								);
							?>
						</nav>
					</div>
				</div>
			<?php endif; ?>
		<!-- END MAIN NAV AREA -->

		<!-- MOBILE NAV AREA -->
			<?php if ( has_nav_menu( 'header_main_nav_mobile' ) ) : ?>
				<nav class="header_main_nav_mobile border-bottom p-2" aria-label="<?php esc_attr_e( 'Header Mobile Nav', 'starter' ); ?>">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'header_main_nav_mobile',
								'menu_class'     => 'menu list',
							)
						);
					?>
				</nav>
			<?php endif; ?>
		<!-- END MOBILE NAV AREA -->

	</header>
