<?php
/**
 * Legacy functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Legacy
 */

/**
 * Initiate the theme.
 */
require get_template_directory() . '/inc/theme-init.php';

/**
 * Register widget area.
 */
require get_template_directory() . '/inc/theme-widgets.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/theme-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/theme-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/theme-functions.php';

/**
 * Functions which calling the css files
 */
require get_template_directory() . '/inc/theme-styles.php';

/**
 * Functions which calling the javascript files.
 */
require get_template_directory() . '/inc/theme-scripts.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/theme-customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/compatibility/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/compatibility/woocommerce.php';
}
