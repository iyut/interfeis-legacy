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
		
		if ( !is_singular() ) :

			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

		endif;

		if ( 'post' === get_post_type() ) : ?>

			<div class="entry-meta">
				<?php ifs_legacy_posted_on(); ?>
			</div><!-- .entry-meta -->
		
		<?php
		endif; 
		
		$link = get_post_meta( get_the_ID(), 'ifs_external_url', true );

		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<a href="<?php esc_url( $link ); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', "ifs-legacy" ), the_title_attribute( 'echo=0' ) ); ?>" data-rel="bookmark" class="ifs-format-link">
			<?php the_content(); ?>
		</a>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php ifs_legacy_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
