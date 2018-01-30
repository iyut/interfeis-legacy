<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Legacy
 */

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

function ifs_legacy_content_class(){

	$class = "col-8";

	echo esc_attr( apply_filters('ifs_legacy_content_class_val', $class) );
}

function ifs_legacy_sidebar_class(){

	$class = "col-4";

	echo esc_attr( apply_filters('ifs_legacy_sidebar_class_val', $class) );
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

if( !function_exists('ifs_legacy_check_pagepost')){
	function ifs_legacy_check_pagepost(){
		global $post;

		if( is_404() || is_archive() || is_attachment() || is_search() ){
			$nvr_custom = false;
		}else{
			$nvr_custom = true;
		}

		return $nvr_custom;
	}
}

if( !function_exists('ifs_legacy_get_postid')){
	function ifs_legacy_get_postid(){
		global $post;

		if( is_home() ){
			$nvr_pid = get_option('page_for_posts');
		}elseif( function_exists( 'is_woocommerce' ) && is_shop() ){
			$nvr_pid = (function_exists('wc_get_page_id'))? wc_get_page_id('shop') : woocommerce_get_page_id( 'shop' );
		}elseif( function_exists( 'is_woocommerce' ) && is_product_category() ){
			$nvr_pid = (function_exists('wc_get_page_id'))? wc_get_page_id('shop') : woocommerce_get_page_id( 'shop' );
		}elseif( function_exists( 'is_woocommerce' ) && is_product_tag() ){
			$nvr_pid = (function_exists('wc_get_page_id'))? wc_get_page_id('shop') : woocommerce_get_page_id( 'shop' );
		}elseif(!ifs_legacy_check_pagepost()){
			$nvr_pid = 0;
		}else{
			$nvr_pid = get_the_ID();
		}

		return $nvr_pid;
	}
}

if(!function_exists("ifs_legacy_is_shop")){
	function ifs_legacy_is_shop(){
		if(function_exists("is_woocommerce")){
			if(is_shop() || is_product_taxonomy()){
				return true;
			}
		}
		return false;
	}
}

if(!function_exists("ifs_legacy_is_product")){
	function ifs_legacy_is_product(){
		if(function_exists("is_woocommerce")){
			if(is_singular('product')){
				return true;
			}
		}
		return false;
	}
}
