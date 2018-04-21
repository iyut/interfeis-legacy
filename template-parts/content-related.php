<?php
/**
 * Template part for displaying related posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Legacy
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('content-related col-md-4'); ?>>

	<div class="entry-image"><?php the_post_thumbnail('ifs_legacy_related_img'); ?></div>

	<header class="entry-header">
		<?php
			the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
		?>
	</header><!-- .entry-header -->
</article><!-- #post-<?php the_ID(); ?> -->
