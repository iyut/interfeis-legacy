<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Legacy
 */

?>
					<div class="clear"></div>
				</div><!-- #content -->

				<?php

				get_sidebar();

				get_sidebar('two');

				?>
				<div class="clear"></div>
			</div>
		</div>
	</div><!-- .outercontainer -->

	<footer id="colophon" class="site-footer">

		<?php ifs_legacy_theme_footer(); ?>

		<div class="outer-footer-bottom">
			<div class="container footer-bottom-cont">
				<div class="row">
					<?php ifs_legacy_bottom_foot(); ?>
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
