<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Legacy
 */

 if( ifs_legacy_sidebar_2_class( false )=='d-none'){
	return;
 }
?>
<div id="sidebar-2-container" class="site-sidebar site-sidebar-2 <?php ifs_legacy_sidebar_2_class();?>">
	<?php if ( is_active_sidebar( 'sidebar-2' ) ) { ?>

		<aside id="tertiary" class="widget-area">
			<?php dynamic_sidebar( 'sidebar-2' ); ?>
		</aside><!-- #tertiary -->

	<?php } ?>
	<div class="clear"></div>
</div>
