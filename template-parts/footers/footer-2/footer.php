<?php
/**
 * The footer no 2 for our theme
 *
 * This is the footer widget template  number 2 that display 4 widgets inside footer widget container
 *
 * @package Legacy
 */

?>
<div id="site-footer-widgets" class="footer-widgets-container">
	<div class="container">
		<div class="row">
			<div class="col-sm">
				<?php dynamic_sidebar( 'footer-1' ); ?>
			</div>
			<div class="col-sm">
				<?php dynamic_sidebar( 'footer-2' ); ?>
			</div>
			<div class="col-sm">
				<?php dynamic_sidebar( 'footer-3' ); ?>
			</div>
			<div class="col-sm">
				<?php dynamic_sidebar( 'footer-4' ); ?>
			</div>
		</div>
	</div>
</div>
