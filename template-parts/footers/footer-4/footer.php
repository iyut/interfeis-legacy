<?php
/**
 * The footer no 4 for our theme
 *
 * This is the footer widget template  number 4 that display 2 widgets inside footer widget container
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
		</div>
	</div>
</div>
