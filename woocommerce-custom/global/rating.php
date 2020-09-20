<?php
/**
 * Rating list
 *
 * @package starter
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="wrap_rating_list">
	<ul class="list">
		<?php for ( $starter_i = 0; $starter_i < 5; $starter_i++ ) : ?>
			<li><?php echo starter_get_svg( array( 'icon' => 'bi-star-outline' ) ); ?></li>
		<?php endfor; ?>
	</ul>
	<ul class="list filled_star" style="width:<?php echo ( esc_attr( $starter_comment_rating ) / 5 ) * 100; ?>%">
		<?php for ( $starter_i = 0; $starter_i < 5; $starter_i++ ) : ?>
			<li><?php echo starter_get_svg( array( 'icon' => 'bi-star' ) ); ?></li>
		<?php endfor; ?>
	</ul>
</div>
