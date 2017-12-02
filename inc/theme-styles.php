<?php
/**
 * Register theme styles
 *
 * @package Legacy
 */

/**
* Enqueue scripts and styles.
*/
function ifs_legacy_styles() {
    wp_enqueue_style( 'ifs-legacy-style', get_stylesheet_uri() );

}
add_action( 'wp_enqueue_scripts', 'ifs_legacy_styles' );
