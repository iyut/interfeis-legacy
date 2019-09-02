<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Legacy
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
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
		<blockquote class="quote-text"><?php the_title(); ?></blockquote>
		<span class="quote-name"><?php the_excerpt(); ?></span>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php ifs_legacy_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
