<?php
/**
 * The template for displaying the footer
 *
 * @package starter
 */

?>

<footer class="main_footer">
	<div class="container">
		<?php if ( has_nav_menu( 'footer_nav' ) ) : ?>
			<nav aria-label="<?php esc_attr_e( 'Footer Nav', 'starter' ); ?>">
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer_nav',
							'menu_class'     => 'list footer_nav',
						)
					);
				?>
			</nav>
		<?php endif; ?>
	</div>
</footer>
</div>

<!-- alert -->
<div class="js_custom_alert" style="display:none">
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	<span class="js_custom_alert_txt"></span>
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php esc_attr_e( 'Close', 'starter' ); ?>"></button>
</div>
</div>

<?php wp_footer(); ?>

</body>
</html>
