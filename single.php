<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Legacy
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main single-main single-main-<?php echo esc_attr( get_post_type() ); ?>">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', get_post_format() );

			the_post_navigation( ifs_legacy_post_navigation_setting() );

			ifs_legacy_after_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
