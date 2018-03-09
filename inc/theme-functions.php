<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Legacy
 */

 /**
  * check if the page is of any post type ( including post or page )
  *
  * @param void
  * @return bool
  */
 if( !function_exists('ifs_legacy_check_pagepost')){
 	function ifs_legacy_check_pagepost(){
 		global $post;

 		if( is_404() || is_archive() || is_attachment() || is_search() ){
 			$ifs_custom = false;
 		}else{
 			$ifs_custom = true;
 		}

 		return apply_filters('ifs_legacy_check_pagepost', $ifs_custom);
 	}
 }

 /**
  * get postid on any page
  *
  * @param void
  * @return int
  */
 if( !function_exists('ifs_legacy_get_postid')){
 	function ifs_legacy_get_postid(){
 		global $post;

 		if( is_home() ){
 			$ifs_pid = get_option('page_for_posts');
 		}elseif( function_exists( 'is_woocommerce' ) && is_shop() ){
 			$ifs_pid = (function_exists('wc_get_page_id'))? wc_get_page_id('shop') : woocommerce_get_page_id( 'shop' );
 		}elseif( function_exists( 'is_woocommerce' ) && is_product_category() ){
 			$ifs_pid = (function_exists('wc_get_page_id'))? wc_get_page_id('shop') : woocommerce_get_page_id( 'shop' );
 		}elseif( function_exists( 'is_woocommerce' ) && is_product_tag() ){
 			$ifs_pid = (function_exists('wc_get_page_id'))? wc_get_page_id('shop') : woocommerce_get_page_id( 'shop' );
 		}elseif(!ifs_legacy_check_pagepost()){
 			$ifs_pid = 0;
 		}else{
 			$ifs_pid = get_the_ID();
 		}

 		return apply_filters('ifs_legacy_get_postid', $ifs_pid);
 	}
 }

 /**
  * get metabox value from any post or page
  *
  * @param int Post or Page id
  * @return array
  */
 if( !function_exists('ifs_legacy_get_customdata')){
 	function ifs_legacy_get_customdata($ifs_pid=""){
 		global $post;

 		if($ifs_pid!=""){
 			$ifs_custom = get_post_custom($ifs_pid);
 			return $ifs_custom;
 		}

 		if($ifs_pid==""){
 			$ifs_pid = ifs_legacy_get_postid();
 		}

 		if( ifs_legacy_check_pagepost() ){
 			$ifs_custom = get_post_custom($ifs_pid);
 		}else{
 			$ifs_custom = array();
 		}

 		return apply_filters('ifs_legacy_get_customdata', $ifs_custom);
 	}
 }

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ifs_legacy_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return apply_filters('ifs_legacy_body_classes_val', $classes);
}
add_filter( 'body_class', 'ifs_legacy_body_classes' );

/**
 * add a class to outer content container element
 *
 * @uses ifs_legacy_content_container_class()
 */
function ifs_legacy_content_container_class(){

	echo esc_attr( apply_filters('ifs_legacy_content_container_class', ifs_legacy_content_layout_chosen()) );

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
        $class = "col-8";
    }elseif($layout_chosen=='two-col-right'){
        $class = "col-8";
    }elseif($layout_chosen=='three-col-left'){
        $class = "col-6";
    }elseif($layout_chosen=='three-col-mid'){
        $class = "col-6";
    }elseif($layout_chosen=='three-col-right'){
        $class = "col-6";
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
        $class = "col-4";
    }elseif($layout_chosen=='two-col-right'){
        $class = "col-4";
    }elseif($layout_chosen=='three-col-left'){
        $class = "col-3";
    }elseif($layout_chosen=='three-col-mid'){
        $class = "col-3";
    }elseif($layout_chosen=='three-col-right'){
        $class = "col-3";
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
        $class = "col-3";
    }elseif($layout_chosen=='three-col-mid'){
        $class = "col-3";
    }elseif($layout_chosen=='three-col-right'){
        $class = "col-3";
    }

    if($echo==true){
        echo esc_attr( apply_filters('ifs_legacy_sidebar_2_class_val', $class) );
    }else{
        return apply_filters('ifs_legacy_sidebar_2_class_val', $class);
    }
}

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function ifs_legacy_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'ifs_legacy_pingback_header' );

/**
 * check if the page is a shop page or not
 *
 * @uses ifs_legacy_is_shop()
 */
if(!function_exists("ifs_legacy_is_shop")){
	function ifs_legacy_is_shop(){

        $return = false;

		if(function_exists("is_woocommerce")){
			if(is_shop() || is_product_taxonomy()){
				$return = true;
			}
		}
		return apply_filters('ifs_legacy_is_shop', $return);
	}
}

/**
 * check if the page is a product page or not
 *
 * @uses ifs_legacy_is_shop()
 */
if(!function_exists("ifs_legacy_is_product")){
	function ifs_legacy_is_product(){

        $return = false;

		if(function_exists("is_woocommerce")){
			if(is_singular('product')){
				$return = true;
			}
		}
		return apply_filters('ifs_legacy_is_product', $return);
	}
}
