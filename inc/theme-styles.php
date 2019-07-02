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

		do_action('ifs_legacy_styles_after_stylesheet');

        wp_enqueue_style( 'ifs-legacy-bootstrap-grid', get_template_directory_uri().'/assets/css/bootstrap-grid.min.css');
        wp_enqueue_style( 'ifs-legacy-bootstrap-reboot', get_template_directory_uri().'/assets/css/bootstrap-reboot.min.css');
        wp_enqueue_style( 'ifs-legacy-font-awesome', get_template_directory_uri().'/assets/css/font-awesome.min.css');
        wp_enqueue_style( 'ifs-legacy-main-style', get_template_directory_uri().'/assets/css/main.css');

		do_action('ifs_legacy_styles_after_mainstyle');

    }
    add_action( 'wp_enqueue_scripts', 'ifs_legacy_styles' );
}

if( !function_exists('ifs_legacy_chosen_custom_font_1') ){
    function ifs_legacy_chosen_custom_font_1(){
        
        $chosen_font_mod    = apply_filters( 'ifs_legacy_custom_font_1_value', get_theme_mod('ifs_legacy_custom_font_1') );

        $chosen_font        = IFS_Fonts::get_the_font( $chosen_font_mod );

		$return = false;
        if($chosen_font!=false){
			$chosen_font['id'] = $chosen_font_mod;
			$return = $chosen_font;
        }

		return apply_filters('ifs_legacy_chosen_custom_font_1', $return);
    }
}

if( !function_exists('ifs_legacy_print_custom_font_1') ){
    function ifs_legacy_print_custom_font_1(){
		$chosen_font = ifs_legacy_chosen_custom_font_1();

		if($chosen_font!=false){

			wp_enqueue_style( 'ifs-legacy-'.esc_attr($chosen_font['id']), $chosen_font['url'] );

		}
	}
	add_action('ifs_legacy_styles_after_stylesheet', 'ifs_legacy_print_custom_font_1', 15);
}

if( !function_exists('ifs_legacy_chosen_custom_font_2') ){
    function ifs_legacy_chosen_custom_font_2(){

        $chosen_font_mod    = apply_filters( 'ifs_legacy_custom_font_2_value', get_theme_mod('ifs_legacy_custom_font_2') );

        $chosen_font        = IFS_Fonts::get_the_font( $chosen_font_mod );

		$return = false;
        if($chosen_font!=false){
			$chosen_font['id'] = $chosen_font_mod;
			$return = $chosen_font;
        }

		return apply_filters('ifs_legacy_chosen_custom_font_2', $return);
    }
}

if( !function_exists('ifs_legacy_print_custom_font_2') ){
    function ifs_legacy_print_custom_font_2(){
		$chosen_font = ifs_legacy_chosen_custom_font_2();

		if($chosen_font!=false){

			wp_enqueue_style( 'ifs-legacy-'.esc_attr($chosen_font['id']), $chosen_font['url'] );

		}
	}
	add_action('ifs_legacy_styles_after_stylesheet', 'ifs_legacy_print_custom_font_2', 25);
}

if( !function_exists('ifs_legacy_chosen_custom_font_3') ){
    function ifs_legacy_chosen_custom_font_3(){

        $chosen_font_mod    = apply_filters( 'ifs_legacy_custom_font_3_value', get_theme_mod('ifs_legacy_custom_font_3') );
        
        $chosen_font        = IFS_Fonts::get_the_font( $chosen_font_mod );

		$return = false;
        if($chosen_font!=false){
			$chosen_font['id'] = $chosen_font_mod;
			$return = $chosen_font;
        }

		return apply_filters('ifs_legacy_chosen_custom_font_3', $return);
    }
}

if( !function_exists('ifs_legacy_print_custom_font_3') ){
    function ifs_legacy_print_custom_font_3(){
		$chosen_font = ifs_legacy_chosen_custom_font_3();

		if($chosen_font!=false){

			wp_enqueue_style( 'ifs-legacy-'.esc_attr($chosen_font['id']), $chosen_font['url'] );

		}
	}
	add_action('ifs_legacy_styles_after_stylesheet', 'ifs_legacy_print_custom_font_3', 25);
}

if( !function_exists('ifs_legacy_generate_stylesheet') ){
    function ifs_legacy_generate_stylesheet(){
        $output_css = '';

        $output_css .= ifs_legacy_print_all_font_css();

		$output_css .= ifs_legacy_print_general_color_css();

        $output_css .= ifs_legacy_header_css_output();

        $output_css .= ifs_legacy_content_css_output();

        $output_css .= ifs_legacy_footer_css_output();

        $output_css .= ifs_legacy_footer_bar_css_output();

        return apply_filters('ifs_legacy_generate_stylesheet', $output_css);
    }
}

if( !function_exists('ifs_legacy_print_stylesheet') ){
    function ifs_legacy_print_stylesheet(){
		$nvr_custom_css = ifs_legacy_generate_stylesheet();
        wp_add_inline_style( 'ifs-legacy-main-style', $nvr_custom_css );
	}
	add_action('ifs_legacy_styles_after_mainstyle', 'ifs_legacy_print_stylesheet', 10);
}
