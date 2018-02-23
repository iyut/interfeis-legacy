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
		</div>
	</div><!-- .outercontainer -->

	<footer id="colophon" class="site-footer">

		<?php ifs_legacy_theme_footer(); ?>

		<div class="outer-site-info">
			<div class="container site-info-cont">
				<div class="site-info">
					<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'ifs-legacy' ) ); ?>"><?php
						/* translators: %s: CMS name, i.e. WordPress. */
						printf( esc_html__( 'Proudly powered by %s', 'ifs-legacy' ), 'WordPress' );
					?></a>
					<span class="sep"> | </span>
					<?php
						/* translators: 1: Theme name, 2: Theme author. */
						printf( esc_html__( 'Theme: %1$s by %2$s.', 'ifs-legacy' ), 'Legacy', '<a href="http://www.novarostudio.com">Novaro Studio</a>' );
					?>
				</div><!-- .site-info -->
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
