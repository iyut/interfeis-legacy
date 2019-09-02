<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Legacy
 */

if ( ! function_exists( 'ifs_legacy_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function ifs_legacy_posted_on() {
		
		do_action( 'ifs_legacy_posted_on' );

	}
endif;

if ( ! function_exists( 'ifs_legacy_print_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function ifs_legacy_print_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			'<i class="ifs-icon"></i> %s',
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'ifs-legacy' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
	add_action('ifs_legacy_posted_on', 'ifs_legacy_print_posted_on', 10);
endif;

if ( ! function_exists( 'ifs_legacy_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function ifs_legacy_entry_footer() {
		
		do_action( 'ifs_legacy_entry_footer' );

	}
endif;

if( !function_exists( 'ifs_legacy_print_category_list' ) ){
	/**
	 * Prints HTML with meta information for the categories.
	 */
	function ifs_legacy_print_category_list(){

		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'ifs-legacy' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links"><i class="ifs-icon"></i> %1$s</span>', $categories_list ); // WPCS: XSS OK.
			}

		}
	}
}

if( !function_exists( 'ifs_legacy_print_tag_list' ) ){
	/**
	 * Prints HTML with meta information for the tags.
	 */
	function ifs_legacy_print_tag_list(){

		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'ifs-legacy' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links"><i class="ifs-icon"></i> %1$s</span>', $tags_list ); // WPCS: XSS OK.
			}
			
		}
	}
	add_action('ifs_legacy_entry_footer', 'ifs_legacy_print_tag_list', 20);
}

if ( ! function_exists( 'ifs_legacy_print_comment_link' ) ) :
	/**
	 * Prints HTML with meta information for the comments.
	 */
	function ifs_legacy_print_comment_link() {

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link"><i class="ifs-icon"></i> ';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'ifs-legacy' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

	}
	add_action('ifs_legacy_entry_footer', 'ifs_legacy_print_comment_link', 30);
endif;

if ( ! function_exists( 'ifs_legacy_print_edit_post_link' ) ) :
	/**
	 * Prints HTML with meta information for the edit post link.
	 */
	function ifs_legacy_print_edit_post_link() {

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'ifs-legacy' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
	add_action('ifs_legacy_entry_footer', 'ifs_legacy_print_edit_post_link', 40);
endif;