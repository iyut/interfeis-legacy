<?php
/**
 * Register theme styles
 *
 * @package Legacy
 */

/**
* Enqueue styles.
*/
function ifs_legacy_styles() {
    wp_enqueue_style( 'ifs-legacy-style', get_stylesheet_uri() );
    wp_enqueue_style( 'ifs-legacy-bootstrap', get_template_directory_uri().'/assets/css/bootstrap.min.css');
    wp_enqueue_style( 'ifs-legacy-main-style', get_template_directory_uri().'/assets/css/main.css');

}
add_action( 'wp_enqueue_scripts', 'ifs_legacy_styles' );
