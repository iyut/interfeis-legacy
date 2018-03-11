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

/**
 * generate css for the base font
 *
 * @uses ifs_legacy_print_base_font_css()
 */
if(!function_exists("ifs_legacy_print_base_font_css")){
	function ifs_legacy_print_base_font_css(){

        $the_font_mod 		= get_theme_mod( 'ifs_legacy_base_font', ifs_legacy_theme_font_default() );
		$the_font_size 		= get_theme_mod( 'ifs_legacy_base_font_size' );
		$the_font_weight	= get_theme_mod( 'ifs_legacy_base_font_weight' );

		$return = '';
		$the_font = call_user_func($the_font_mod);

		if($the_font!=false){
			$return .= 'font-family:'.$the_font['name'].','.$the_font['category'].';';
			if($the_font_size!='')
				$return .= 'font-size:'.$the_font_size.'px;';

			if($the_font_weight!='')
				$return .= 'font-weight:'.$the_font_weight.';';


			$return = 'body{'.$return.'}';
		}

		return apply_filters('ifs_legacy_print_base_font_css', esc_attr($return));
	}
}

/**
 * generate css for the menu font
 *
 * @uses ifs_legacy_print_menu_font_css()
 */
if(!function_exists("ifs_legacy_print_menu_font_css")){
	function ifs_legacy_print_menu_font_css(){

        $the_font_mod 		= get_theme_mod( 'ifs_legacy_menu_font', ifs_legacy_theme_font_default() );
		$the_font_size 		= get_theme_mod( 'ifs_legacy_menu_font_size' );
		$the_font_weight	= get_theme_mod( 'ifs_legacy_menu_font_weight' );

		$return = '';
		$the_font = call_user_func($the_font_mod);

		if($the_font!=false){
			$return .= 'font-family:'.$the_font['name'].','.$the_font['category'].';';
			if($the_font_size!='')
				$return .= 'font-size:'.$the_font_size.'px;';

			if($the_font_weight!='')
				$return .= 'font-weight:'.$the_font_weight.';';


			$return = 'body.ifs .site-header .main-navigation li a{'.$return.'}';
		}

		return apply_filters('ifs_legacy_print_menu_font_css', esc_attr($return));
	}
}

/**
 * generate css for the heading 1 font
 *
 * @uses ifs_legacy_print_h1_font_css()
 */
if(!function_exists("ifs_legacy_print_h1_font_css")){
	function ifs_legacy_print_h1_font_css(){

        $the_font_mod 		= get_theme_mod( 'ifs_legacy_h1_font', ifs_legacy_theme_font_default() );
		$the_font_size 		= get_theme_mod( 'ifs_legacy_h1_font_size' );
		$the_font_weight	= get_theme_mod( 'ifs_legacy_h1_font_weight' );

		$return = '';
		$the_font = call_user_func($the_font_mod);

		if($the_font!=false){
			$return .= 'font-family:'.$the_font['name'].','.$the_font['category'].';';
			if($the_font_size!='')
				$return .= 'font-size:'.$the_font_size.'px;';

			if($the_font_weight!='')
				$return .= 'font-weight:'.$the_font_weight.';';


			$return = 'h1{'.$return.'}';
		}

		return apply_filters('ifs_legacy_print_h1_font_css', esc_attr($return));
	}
}

/**
 * generate css for the heading 2 font
 *
 * @uses ifs_legacy_print_h2_font_css()
 */
if(!function_exists("ifs_legacy_print_h2_font_css")){
	function ifs_legacy_print_h2_font_css(){

        $the_font_mod 		= get_theme_mod( 'ifs_legacy_h2_font', ifs_legacy_theme_font_default() );
		$the_font_size 		= get_theme_mod( 'ifs_legacy_h2_font_size' );
		$the_font_weight	= get_theme_mod( 'ifs_legacy_h2_font_weight' );

		$return = '';
		$the_font = call_user_func($the_font_mod);

		if($the_font!=false){
			$return .= 'font-family:'.$the_font['name'].','.$the_font['category'].';';
			if($the_font_size!='')
				$return .= 'font-size:'.$the_font_size.'px;';

			if($the_font_weight!='')
				$return .= 'font-weight:'.$the_font_weight.';';


			$return = 'h2{'.$return.'}';
		}

		return apply_filters('ifs_legacy_print_h2_font_css', esc_attr($return));
	}
}

/**
 * generate css for the heading 3 font
 *
 * @uses ifs_legacy_print_h3_font_css()
 */
if(!function_exists("ifs_legacy_print_h3_font_css")){
	function ifs_legacy_print_h3_font_css(){

        $the_font_mod 		= get_theme_mod( 'ifs_legacy_h3_font', ifs_legacy_theme_font_default() );
		$the_font_size 		= get_theme_mod( 'ifs_legacy_h3_font_size' );
		$the_font_weight	= get_theme_mod( 'ifs_legacy_h3_font_weight' );

		$return = '';
		$the_font = call_user_func($the_font_mod);

		if($the_font!=false){
			$return .= 'font-family:'.$the_font['name'].','.$the_font['category'].';';
			if($the_font_size!='')
				$return .= 'font-size:'.$the_font_size.'px;';

			if($the_font_weight!='')
				$return .= 'font-weight:'.$the_font_weight.';';


			$return = 'h3{'.$return.'}';
		}

		return apply_filters('ifs_legacy_print_h3_font_css', esc_attr($return));
	}
}

/**
 * generate css for the heading 4 font
 *
 * @uses ifs_legacy_print_h4_font_css()
 */
if(!function_exists("ifs_legacy_print_h4_font_css")){
	function ifs_legacy_print_h4_font_css(){

        $the_font_mod 		= get_theme_mod( 'ifs_legacy_h4_font', ifs_legacy_theme_font_default() );
		$the_font_size 		= get_theme_mod( 'ifs_legacy_h4_font_size' );
		$the_font_weight	= get_theme_mod( 'ifs_legacy_h4_font_weight' );

		$return = '';
		$the_font = call_user_func($the_font_mod);

		if($the_font!=false){
			$return .= 'font-family:'.$the_font['name'].','.$the_font['category'].';';
			if($the_font_size!='')
				$return .= 'font-size:'.$the_font_size.'px;';

			if($the_font_weight!='')
				$return .= 'font-weight:'.$the_font_weight.';';


			$return = 'h4{'.$return.'}';
		}

		return apply_filters('ifs_legacy_print_h4_font_css', esc_attr($return));
	}
}

/**
 * generate css for the heading 5 font
 *
 * @uses ifs_legacy_print_h5_font_css()
 */
if(!function_exists("ifs_legacy_print_h5_font_css")){
	function ifs_legacy_print_h5_font_css(){

        $the_font_mod 		= get_theme_mod( 'ifs_legacy_h5_font', ifs_legacy_theme_font_default() );
		$the_font_size 		= get_theme_mod( 'ifs_legacy_h5_font_size' );
		$the_font_weight	= get_theme_mod( 'ifs_legacy_h5_font_weight' );

		$return = '';
		$the_font = call_user_func($the_font_mod);

		if($the_font!=false){
			$return .= 'font-family:'.$the_font['name'].','.$the_font['category'].';';
			if($the_font_size!='')
				$return .= 'font-size:'.$the_font_size.'px;';

			if($the_font_weight!='')
				$return .= 'font-weight:'.$the_font_weight.';';


			$return = 'h5{'.$return.'}';
		}

		return apply_filters('ifs_legacy_print_h5_font_css', esc_attr($return));
	}
}

/**
 * generate css for the heading 6 font
 *
 * @uses ifs_legacy_print_h6_font_css()
 */
if(!function_exists("ifs_legacy_print_h6_font_css")){
	function ifs_legacy_print_h6_font_css(){

        $the_font_mod 		= get_theme_mod( 'ifs_legacy_h6_font', ifs_legacy_theme_font_default() );
		$the_font_size 		= get_theme_mod( 'ifs_legacy_h6_font_size' );
		$the_font_weight	= get_theme_mod( 'ifs_legacy_h6_font_weight' );

		$return = '';
		$the_font = call_user_func($the_font_mod);

		if($the_font!=false){
			$return .= 'font-family:'.$the_font['name'].','.$the_font['category'].';';
			if($the_font_size!='')
				$return .= 'font-size:'.$the_font_size.'px;';

			if($the_font_weight!='')
				$return .= 'font-weight:'.$the_font_weight.';';


			$return = 'h6{'.$return.'}';
		}

		return apply_filters('ifs_legacy_print_h6_font_css', esc_attr($return));
	}
}

/**
 * generate css for all font
 *
 * @uses ifs_legacy_print_all_font_css()
 */
if(!function_exists("ifs_legacy_print_all_font_css")){
	function ifs_legacy_print_all_font_css(){

		$output_css = '';

		$output_css .= ifs_legacy_print_base_font_css();

		$output_css .= ifs_legacy_print_menu_font_css();

		$output_css .= ifs_legacy_print_h1_font_css();

		$output_css .= ifs_legacy_print_h2_font_css();

		$output_css .= ifs_legacy_print_h3_font_css();

		$output_css .= ifs_legacy_print_h4_font_css();

		$output_css .= ifs_legacy_print_h5_font_css();

		$output_css .= ifs_legacy_print_h6_font_css();

		return apply_filters('ifs_legacy_print_all_font_css', esc_attr($output_css));
	}
}
