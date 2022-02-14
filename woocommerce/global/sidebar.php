<?php
/**
 * The sidebar containing the main archive widget area.
 *
 * @package starter
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<ul class="sidebar_list list-unstyled">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</ul>
