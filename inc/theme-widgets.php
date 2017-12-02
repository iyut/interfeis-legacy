<?php
/**
 * Sidebar Registration files
 *
 * @package Legacy
 */


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ifs_legacy_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ifs-legacy' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ifs-legacy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'ifs_legacy_widgets_init' );
