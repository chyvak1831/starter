<?php
/**
 * The header for our theme
 *
 * @package starter
 */

$starter_is_logged = is_user_logged_in() ? ' user_logged' : ' user_unlogged';
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<script>window.lazySizesConfig=window.lazySizesConfig||{},window.lazySizesConfig.expand=10,lazySizesConfig.expFactor=1.5;</script>
	<?php wp_head(); ?>
</head>
<body id="topPage" class="<?php echo esc_attr( $starter_is_logged ); ?>">
<a href="#topPage" class="scrollup js_scrollto" role="button" aria-label="<?php esc_attr_e( 'Scroll to top', 'starter' ); ?>">
	<?php echo starter_get_svg( array( 'icon' => 'arrow-up' ) ); ?>
</a>
<div class="main_wrap">
	<header class="main_header">
		<!-- TOP NAV AREA -->
			<?php if ( has_nav_menu( 'header_top_nav' ) ) : ?>
				<div class="header_top_nav">
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

		<!-- MAIN NAV AREA -->
			<?php if ( has_nav_menu( 'header_main_nav' ) ) : ?>
				<div class="header_main_nav">
					<div class="container">
						<nav class="jsInnerNav" aria-label="<?php esc_attr_e( 'Header Main Nav', 'starter' ); ?>">
							<?php
								wp_nav_menu(
									array(
										'theme_location' => 'header_main_nav',
										'menu_class'     => 'menu list'
									)
								);
							?>
						</nav>
					</div>
				</div>
			<?php endif; ?>
		<!-- END MAIN NAV AREA -->

		<!-- TOP MOBILE NAV AREA -->
			<?php if ( has_nav_menu( 'header_mobile_top_nav' ) ) : ?>
				<nav class="header_mobile_top_nav" aria-label="<?php esc_attr_e( 'Header Top Mobile Nav', 'starter' ); ?>">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'header_mobile_top_nav',
								'menu_class'     => 'menu list',
							)
						);
					?>
				</nav>
			<?php endif; ?>
		<!-- END TOP MOBILE NAV AREA -->

		<!-- MOBILE NAV AREA -->
			<?php if ( has_nav_menu( 'header_mobile_nav' ) ) : ?>
				<nav class="header_mobile_nav" aria-label="<?php esc_attr_e( 'Header Mobile Nav', 'starter' ); ?>">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'header_mobile_nav',
								'menu_class'     => 'menu list',
							)
						);
					?>
				</nav>
			<?php endif; ?>
		<!-- END MOBILE NAV AREA -->

		<div class="backdrop"></div>
	</header>
