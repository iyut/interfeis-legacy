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
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-layer-1"><div class="widget-layer-2">',
		'after_widget'  => '</div></div></section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar 2', 'ifs-legacy' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here.', 'ifs-legacy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-layer-1"><div class="widget-layer-2">',
		'after_widget'  => '</div></div></section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'ifs-legacy' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here.', 'ifs-legacy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-layer-1"><div class="widget-layer-2">',
		'after_widget'  => '</div></div></section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'ifs-legacy' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Add widgets here.', 'ifs-legacy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-layer-1"><div class="widget-layer-2">',
		'after_widget'  => '</div></div></section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'ifs-legacy' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Add widgets here.', 'ifs-legacy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-layer-1"><div class="widget-layer-2">',
		'after_widget'  => '</div></div></section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 4', 'ifs-legacy' ),
		'id'            => 'footer-4',
		'description'   => esc_html__( 'Add widgets here.', 'ifs-legacy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-layer-1"><div class="widget-layer-2">',
		'after_widget'  => '</div></div></section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Bar 1', 'ifs-legacy' ),
		'id'            => 'footer-bar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ifs-legacy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-layer-1"><div class="widget-layer-2">',
		'after_widget'  => '</div></div></section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Bar 2', 'ifs-legacy' ),
		'id'            => 'footer-bar-2',
		'description'   => esc_html__( 'Add widgets here.', 'ifs-legacy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-layer-1"><div class="widget-layer-2">',
		'after_widget'  => '</div></div></section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'ifs_legacy_widgets_init' );
