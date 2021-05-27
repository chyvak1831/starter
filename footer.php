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

<!-- woo alert -->
<div class="js_custom_alert" style="display:none">
<div class="woocommerce-message alert alert-danger alert-dismissible fade show" role="alert">
	<span class="js_custom_alert_txt"></span>
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php esc_attr_e( 'Close', 'starter' ); ?>">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
</div>

<div class="backdrop"></div>

<?php wp_footer(); ?>

<script>
	var svg_icons = "<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/svg-icons.svg";
	var xhr = new XMLHttpRequest();
	xhr.open('GET', svg_icons);
	xhr.onload = function() {
		if (xhr.status === 200) {
			var svg = document.createElement('div');
			svg.innerHTML = xhr.responseText;
			document.getElementsByTagName('body')[0].appendChild(svg);
		}
	};
	xhr.send();
</script>

<script>
	/*detect ios*/
	function getMobileOperatingSystemIOS() {
		var userAgent = navigator.userAgent || navigator.vendor || window.opera;
		if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
			document.getElementsByTagName( 'html' )[0].className += ' iOS mobile';
		}
	}
	getMobileOperatingSystemIOS();
	/*END detect ios*/

	/*detect android*/
	function getMobileOperatingSystemAndroid() {
		var userAgent = navigator.userAgent;
		if (/Android/.test(userAgent)) {
			document.getElementsByTagName( 'html' )[0].className += ' android mobile';
		}
	}
	getMobileOperatingSystemAndroid();
	/*END detect android*/

	/*detect touch*/
	window.addEventListener( 'touchstart', function() {
		document.getElementsByTagName( 'html' )[0].className += ' touch_device';
	});
	/*END detect touch*/
</script>

</body>
</html>
