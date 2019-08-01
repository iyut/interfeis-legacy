<?php

/**
 * add a class to body element
 *
 * @uses ifs_legacy_content_layout_chosen()
 * @uses ifs_legacy_container_layout_chosen()
 */
function ifs_legacy_content_add_body_class( $classes ){

	$classes[]  = 'ifs-content-'.ifs_legacy_content_layout_chosen();
	$classes[]  = ifs_legacy_container_layout_chosen();

	return apply_filters('ifs_legacy_content_add_body_class', $classes);
}
add_filter('body_class', 'ifs_legacy_content_add_body_class');

/**
 * add a class to outer content container element
 *
 * @uses ifs_legacy_content_layout_chosen()
 * @uses ifs_legacy_container_layout_chosen()
 */
function ifs_legacy_content_container_class(){

	$class = array(
		ifs_legacy_content_layout_chosen(),
		ifs_legacy_container_layout_chosen()
	);

	$str_class = implode(' ', $class);

	echo esc_attr( apply_filters('ifs_legacy_content_container_class', $str_class) );

}

/**
 * add a class to content element
 *
 * @uses ifs_legacy_content_class()
 */
function ifs_legacy_content_class( $echo=true ){

    $layout_chosen = ifs_legacy_content_layout_chosen();

    if($layout_chosen=='one-col'){
        $class = 'col-12';
    }elseif($layout_chosen=='two-col-left'){
        $class = "col-md-8";
    }elseif($layout_chosen=='two-col-right'){
        $class = "col-md-8";
    }elseif($layout_chosen=='three-col-left'){
        $class = "col-md-6";
    }elseif($layout_chosen=='three-col-mid'){
        $class = "col-md-6";
    }elseif($layout_chosen=='three-col-right'){
        $class = "col-md-6";
    }

    if($echo==true){
	    echo esc_attr( apply_filters('ifs_legacy_content_class_val', $class) );
    }else{
        return apply_filters('ifs_legacy_content_class_val', $class);
    }
}

/**
 * add a class to sidebar 1 container
 *
 * @uses ifs_legacy_sidebar_class()
 */
function ifs_legacy_sidebar_class( $echo=true ){

    $layout_chosen = ifs_legacy_content_layout_chosen();

    if($layout_chosen=='one-col'){
        $class = 'd-none';
    }elseif($layout_chosen=='two-col-left'){
        $class = "col-md-4";
    }elseif($layout_chosen=='two-col-right'){
        $class = "col-md-4";
    }elseif($layout_chosen=='three-col-left'){
        $class = "col-md-3";
    }elseif($layout_chosen=='three-col-mid'){
        $class = "col-md-3";
    }elseif($layout_chosen=='three-col-right'){
        $class = "col-md-3";
    }

    if($echo==true){
        echo esc_attr( apply_filters('ifs_legacy_sidebar_class_val', $class) );
    }else{
        return apply_filters('ifs_legacy_sidebar_class_val', $class);
    }
}

/**
 * add a class to sidebar 2 container
 *
 * @uses ifs_legacy_sidebar_2_class()
 */
function ifs_legacy_sidebar_2_class( $echo=true ){

    $layout_chosen = ifs_legacy_content_layout_chosen();

    if($layout_chosen=='one-col'){
        $class = 'd-none';
    }elseif($layout_chosen=='two-col-left'){
        $class = 'd-none';
    }elseif($layout_chosen=='two-col-right'){
        $class = 'd-none';
    }elseif($layout_chosen=='three-col-left'){
        $class = "col-md-3";
    }elseif($layout_chosen=='three-col-mid'){
        $class = "col-md-3";
    }elseif($layout_chosen=='three-col-right'){
        $class = "col-md-3";
    }

    if($echo==true){
        echo esc_attr( apply_filters('ifs_legacy_sidebar_2_class_val', $class) );
    }else{
        return apply_filters('ifs_legacy_sidebar_2_class_val', $class);
    }
}

/**
 * return the layout width value
 *
 * @uses ifs_legacy_layout_width_value()
 */
if(!function_exists('ifs_legacy_layout_width_value')){
    function ifs_legacy_layout_width_value(){

        $ifs_legacy_width_mod = get_theme_mod( 'ifs_legacy_layout_width', '' );

        return apply_filters('ifs_legacy_layout_width_value', $ifs_legacy_width_mod);
    }
}

/**
 * return all choices of content layouts.
 *
 * @uses ifs_legacy_content_layout_choices()
 */
if(!function_exists('ifs_legacy_content_layout_choices')){
    function ifs_legacy_content_layout_choices(){
        $ifs_optlayout = array(
    		'one-col' => esc_html__('One column',"ifs-legacy"),
    		'two-col-left' => esc_html__('Two columns - left content',"ifs-legacy"),
    		'two-col-right' => esc_html__('Two columns - right content',"ifs-legacy"),
            'three-col-left' => esc_html__('Three columns - left content',"ifs-legacy"),
            'three-col-mid' => esc_html__('Three columns - middle content',"ifs-legacy"),
            'three-col-right' => esc_html__('Three columns - right content',"ifs-legacy")
    	);
        return apply_filters('ifs_legacy_content_layout_choices', $ifs_optlayout);
    }
}

/**
 * return all choices of content layouts.
 *
 * @uses ifs_legacy_content_layout_choices()
 */
if(!function_exists('ifs_legacy_content_layout_choices_with_default')){
    function ifs_legacy_content_layout_choices_with_default(){
        $ifs_optlayout = array(
    		'' => esc_html__('Default - Base Content Layout',"ifs-legacy")
    	);

		$ifs_optlayout = array_merge( $ifs_optlayout, ifs_legacy_content_layout_choices());

        return apply_filters('ifs_legacy_content_layout_choices_with_default', $ifs_optlayout);
    }
}

/**
 * return the chosen content layout.
 *
 * @uses ifs_legacy_content_layout_choices()
 */
if(!function_exists('ifs_legacy_content_layout_chosen')){
    function ifs_legacy_content_layout_chosen(){

        $ifs_legacy_content_mod = get_theme_mod( 'ifs_legacy_content_layout', ifs_legacy_content_layout_default() );

        $post_id = ifs_legacy_get_postid();

        $post_layout = get_post_meta( $post_id, 'ifs_content_layout', true);
        $post_layout_choices = ifs_legacy_content_layout_choices();

		if(is_archive()){
			$ifs_legacy_temp_content_mod = get_theme_mod( 'ifs_legacy_archive_content_layout', '' );
			if($ifs_legacy_temp_content_mod!=''){
				$ifs_legacy_content_mod = $ifs_legacy_temp_content_mod;
			}
		}

		if(is_single()){
			$ifs_legacy_temp_content_mod = get_theme_mod( 'ifs_legacy_single_content_layout', '' );
			if($ifs_legacy_temp_content_mod!=''){
				$ifs_legacy_content_mod = $ifs_legacy_temp_content_mod;
			}
		}

		if(is_404()){
			$ifs_legacy_temp_content_mod = get_theme_mod( 'ifs_legacy_404_content_layout', '' );
			if($ifs_legacy_temp_content_mod!=''){
				$ifs_legacy_content_mod = $ifs_legacy_temp_content_mod;
			}
		}

		if(is_attachment()){
			$ifs_legacy_temp_content_mod = get_theme_mod( 'ifs_legacy_attachment_content_layout', '' );
			if($ifs_legacy_temp_content_mod!=''){
				$ifs_legacy_content_mod = $ifs_legacy_temp_content_mod;
			}
		}

		if(is_search()){
			$ifs_legacy_temp_content_mod = get_theme_mod( 'ifs_legacy_search_content_layout', '' );
			if($ifs_legacy_temp_content_mod!=''){
				$ifs_legacy_content_mod = $ifs_legacy_temp_content_mod;
			}
		}

		if(is_post_type_archive( 'product' )){
			$ifs_legacy_temp_content_mod = get_theme_mod( 'ifs_legacy_shop_content_layout', '' );
			if($ifs_legacy_temp_content_mod!=''){
				$ifs_legacy_content_mod = $ifs_legacy_temp_content_mod;
			}
		}

		if(is_singular( 'product' )){
			$ifs_legacy_temp_content_mod = get_theme_mod( 'ifs_legacy_product_content_layout', '' );
			if($ifs_legacy_temp_content_mod!=''){
				$ifs_legacy_content_mod = $ifs_legacy_temp_content_mod;
			}
		}

        if( $post_layout != '' && $post_layout != 'default' && array_key_exists( $post_layout, $post_layout_choices)){
            $ifs_legacy_content_mod = $post_layout;
        }



        return apply_filters('ifs_legacy_content_layout_chosen', $ifs_legacy_content_mod);
    }
}

/**
 * get default content layout
 * @return string
 */
function ifs_legacy_content_layout_default(){

    $layout_default = 'two-col-left';

    if( is_404() ){

        $layout_default = 'one-col';
    
    }
    
    return apply_filters( 'ifs_legacy_content_layout_default', $layout_default );
}

/**
 * return all choices of container layouts.
 *
 * @return array
 */
if(!function_exists('ifs_legacy_container_layout_choices')){
    function ifs_legacy_container_layout_choices(){
        $ifs_optlayout = array(
    		'ifs-content-default-width' 		=> esc_html__('Default width',"ifs-legacy"),
    		'ifs-content-full-width' 			=> esc_html__('Full-width',"ifs-legacy"),
    		'ifs-content-full-width-no-padding'	=> esc_html__('Full-width without padding',"ifs-legacy")
    	);
        return apply_filters('ifs_legacy_container_layout_choices', $ifs_optlayout);
    }
}

/**
 * return the chosen container layout.
 *
 * @uses ifs_legacy_container_layout_choices()
 * @return string
 */
if(!function_exists('ifs_legacy_container_layout_chosen')){
    function ifs_legacy_container_layout_chosen(){

        $ifs_legacy_cont_mod = get_theme_mod( 'ifs_legacy_container_layout', ifs_legacy_container_layout_default() );

        $post_id = ifs_legacy_get_postid();

        $post_layout = get_post_meta( $post_id, 'ifs_container_layout', true);
        $post_layout_choices = ifs_legacy_container_layout_choices();

        if( $post_layout != '' && $post_layout != 'default' && array_key_exists( $post_layout, $post_layout_choices)){
            $ifs_legacy_cont_mod = $post_layout;
        }

        return apply_filters('ifs_legacy_container_layout_chosen', $ifs_legacy_cont_mod);
    }
}

/**
 * get default container layout
 * @return string
 */
function ifs_legacy_container_layout_default(){
	return apply_filters( 'ifs_legacy_container_layout_default', 'ifs-content-default-width');
}

/**
 * return the padding top value of the content.
 *
 * @uses ifs_legacy_content_padding_top()
 */
if(!function_exists('ifs_legacy_content_padding_top')){
    function ifs_legacy_content_padding_top(){

        $post_id = ifs_legacy_get_postid();

        $padding_val = get_post_meta( $post_id, 'ifs_main_paddingtop', true);

        return apply_filters('ifs_legacy_content_padding_top', $padding_val);
    }
}

/**
 * return the padding top value of the content.
 *
 * @uses ifs_legacy_content_padding_bottom()
 */
if(!function_exists('ifs_legacy_content_padding_bottom')){
    function ifs_legacy_content_padding_bottom(){

        $post_id = ifs_legacy_get_postid();

        $padding_val = get_post_meta( $post_id, 'ifs_main_paddingbottom', true);

        return apply_filters('ifs_legacy_content_padding_bottom', $padding_val);
    }
}

if( !function_exists('ifs_legacy_after_post_navigation')){
	function ifs_legacy_after_post_navigation(){
		do_action('ifs_legacy_after_post_navigation');
	}
}

if( !function_exists('ifs_legacy_content_css_output') ){
	function ifs_legacy_content_css_output(){

        $layout_width       = ifs_legacy_layout_width_value();
		$padding_top        = ifs_legacy_content_padding_top();
        $padding_bottom     = ifs_legacy_content_padding_bottom();
		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */

		// If we get this far, we have custom styles. Let's do this.
		$output_css = '';

        if($layout_width!=''){
            $output_css .= '@media only screen and (min-width:1200px){
                body.ifs .container{
                    max-width: '.$layout_width.'px;
                }
            }';
        }
		if($padding_top!=''){
			$output_css .= '.outercontainer .site-content, .outercontainer .site-sidebar{
				margin-top: '. esc_attr( $padding_top ).';
			}';
		}
        if($padding_bottom!=''){
			$output_css .= '.outercontainer .site-content, .outercontainer .site-sidebar{
				margin-bottom: '. esc_attr( $padding_bottom ).';
			}';
		}

		return apply_filters('ifs_legacy_content_css_output', $output_css );

	}
}
