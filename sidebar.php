<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Legacy
 */

 if( ifs_legacy_sidebar_class( false )=='d-none'){
	 return;
 }
?>
<div id="sidebar-1-container" class="site-sidebar site-sidebar-1 <?php ifs_legacy_sidebar_class();?>">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) { ?>

		<aside id="secondary" class="widget-area">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</aside><!-- #secondary -->

	<?php } ?>
	<div class="clear"></div>
</div>
