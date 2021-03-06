<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Legacy
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('ifs-post-format-default'); ?>>
	<header class="entry-header">
		<?php

		ifs_legacy_print_category_list();
		
		if ( !is_singular() ) :

			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

		endif;

		if ( 'post' === get_post_type() ) : ?>

			<div class="entry-meta">
				<?php ifs_legacy_posted_on(); ?>
			</div><!-- .entry-meta -->
		
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'ifs-legacy' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ifs-legacy' ),
				'after'  => '</div>',
			) );

			if ( !is_singular() ) :

				echo '<a class="entry-more-button" href="'. get_permalink() .'" rel="bookmark">'. esc_html__('Read More', 'ifs-legacy') .'</a>';
	
			endif;
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php ifs_legacy_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
