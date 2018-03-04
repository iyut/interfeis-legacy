<?php
/**
 * Register theme styles
 *
 * @package Legacy
 */

/**
* Enqueue styles.
*/
if( !function_exists('ifs_legacy_styles') ){
    function ifs_legacy_styles() {
        wp_enqueue_style( 'ifs-legacy-style', get_stylesheet_uri() );
        wp_enqueue_style( 'ifs-legacy-bootstrap-grid', get_template_directory_uri().'/assets/css/bootstrap-grid.min.css');
        wp_enqueue_style( 'ifs-legacy-bootstrap-reboot', get_template_directory_uri().'/assets/css/bootstrap-reboot.min.css');
        wp_enqueue_style( 'ifs-legacy-font-awesome', get_template_directory_uri().'/assets/css/font-awesome.min.css');
        wp_enqueue_style( 'ifs-legacy-main-style', get_template_directory_uri().'/assets/css/main.css');

        $nvr_custom_css = ifs_legacy_print_stylesheet();
        wp_add_inline_style( 'ifs-legacy-main-style', $nvr_custom_css );

    }
    add_action( 'wp_enqueue_scripts', 'ifs_legacy_styles' );
}

if( !function_exists('ifs_legacy_print_stylesheet') ){
    function ifs_legacy_print_stylesheet(){
        $output_css = '';

        $output_css .= ifs_legacy_header_css_output();

        $output_css .= ifs_legacy_footer_css_output();

        $output_css .= ifs_legacy_footer_bar_css_output();

        return apply_filters('ifs_legacy_print_stylesheet', $output_css);
    }
}
