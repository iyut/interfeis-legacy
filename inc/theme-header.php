<?php
/**
 * All functions and hooks for header
 *
 * @package Legacy
 */

 /**
  * Hooks for top head ( a container before master head - masthead )
  * @uses ifs_legacy_before_tophead()
  * @uses ifs_legacy_tophead()
  * @uses ifs_legacy_after_tophead()
  */
function ifs_legacy_hook_before_tophead(){
	do_action('ifs_legacy_hook_before_tophead');
}
function ifs_legacy_hook_tophead(){
	do_action('ifs_legacy_hook_tophead');
}
function ifs_legacy_hook_after_tophead(){
	do_action('ifs_legacy_hook_after_tophead');
}

/**
* Generate available option for the footer bar content
*
* @uses ifs_legacy_top_bar_choices()
*/
function ifs_legacy_top_bar_choices(){
    return apply_filters('ifs_legacy_top_bar_choices', array(
        ''              => esc_html__( 'None', 'ifs-legacy' ),
        'text'          => esc_html__( 'Text', 'ifs-legacy' ),
        'menu'          => esc_html__( 'Menu', 'ifs-legacy' ),
        'widget'        => esc_html__( 'Widget', 'ifs-legacy' )
    ));
}

/**
* Get theme top file
*
* @uses ifs_legacy_show_top_bar()
*/
function ifs_legacy_top_bar_columns(){

    if( !ifs_legacy_show_top_bar() ){
        return;
    }

    do_action('ifs_legacy_top_bar_columns');
}
add_action('ifs_legacy_hook_tophead', 'ifs_legacy_top_bar_columns', 10);

/**
* show top bar
*
* @return bool
*/
function ifs_legacy_show_top_bar(){
    $content_1 = get_theme_mod('ifs_legacy_top_bar_1_content', 'text');
    $content_2 = get_theme_mod('ifs_legacy_top_bar_2_content', '');

    if(empty($content_1) && empty($content_2)){
        return false;
    }

    return true;
}

/**
 * Get theme top bar file
 *
 * @uses ifs_legacy_top_bar_col_1()
 */
function ifs_legacy_top_bar_col_1(){
    echo '<div class="top_col_1 top_col col-lg-6">';
        do_action('ifs_legacy_top_bar_col_1');
    echo '</div>';
}
 add_action('ifs_legacy_top_bar_columns', 'ifs_legacy_top_bar_col_1', 10);

 /**
  * Get theme top bar file
  *
  * @uses ifs_legacy_top_bar_col_1()
  */
 function ifs_legacy_top_bar_col_2(){
     echo '<div class="top_col_2 top_col col-lg-6">';
         do_action('ifs_legacy_top_bar_col_2');
     echo '</div>';
 }
  add_action('ifs_legacy_top_bar_columns', 'ifs_legacy_top_bar_col_2', 20);

/**
 * Print content for top bar coolumn 1
 *
 * @uses ifs_legacy_top_bar_col_1()
 */
function ifs_legacy_content_top_col_1(){
	$ifs_legacy_top_bar_content = get_theme_mod('ifs_legacy_top_bar_1_content','text');
	switch ($ifs_legacy_top_bar_content) {
		case "menu":
			ifs_legacy_top_menu();
			break;
		case "widget":
			ifs_legacy_print_top_widget_1();
			break;
		case "text":
			ifs_legacy_print_top_text_1();
			break;
		default:
		   return;
	}
}
add_action('ifs_legacy_top_bar_col_1', 'ifs_legacy_content_top_col_1', 10);

/**
* Print content for top bar column 2
*
* @uses ifs_legacy_top_bar_col_2()
*/
function ifs_legacy_content_top_col_2(){
  $ifs_legacy_top_bar_content = get_theme_mod('ifs_legacy_top_bar_2_content');
  switch ($ifs_legacy_top_bar_content) {
	  case "menu":
		  ifs_legacy_top_menu();
		  break;
	  case "widget":
		  ifs_legacy_print_top_widget_2();
		  break;
	  case "text":
		  ifs_legacy_print_top_text_2();
		  break;
	  default:
		 return;
  }

}
add_action('ifs_legacy_top_bar_col_2', 'ifs_legacy_content_top_col_2', 10);

/**
* Print top bar text 1
*
* @uses ifs_legacy_print_top_text_1()
*/
function ifs_legacy_print_top_text_1(){
    $ifs_legacy_top_text = get_theme_mod( 'ifs_legacy_top_bar_1_text', '' );
    ?>
    <div class="top-info"><?php echo ifs_legacy_custom_wp_kses( $ifs_legacy_top_text ); ?></div>
    <?php
}

/**
* Print top bar widget 1
*
* @uses ifs_legacy_print_top_widget_1()
*/
function ifs_legacy_print_top_widget_1(){
  dynamic_sidebar( 'top-bar-1' );
}

/**
* Print top menu
*
* @uses ifs_legacy_top_menu()
*/
function ifs_legacy_top_menu(){
    ?>
    <div class="top-menu">
    <?php
        wp_nav_menu( array(
            'theme_location' => 'top-menu',
            'menu_id'        => 'top-menu',
			'container'		 => 'ul',
            'depth'          => 1
        ) );
    ?>
     </div>
     <?php
}

/**
* Print top bar text 2
*
* @uses ifs_legacy_print_top_text_2()
*/
function ifs_legacy_print_top_text_2(){
    $ifs_legacy_top_text = get_theme_mod( 'ifs_legacy_top_bar_2_text', '' );
    ?>
    <div class="top-info"><?php echo ifs_legacy_custom_wp_kses( $ifs_legacy_top_text ); ?></div>
    <?php
}

/**
* Print top bar widget 2
*
* @uses ifs_legacy_print_top_widget_2()
*/
function ifs_legacy_print_top_widget_2(){
    dynamic_sidebar( 'top-bar-2' );
}

/**
 * hook for theme before header
 *
 * @uses do_action()
 */
function ifs_legacy_theme_before_header(){
	do_action('ifs_legacy_theme_before_header');
}

/**
 * hook for theme header
 *
 * @uses ifs_legacyt_theme_header()
 */
function ifs_legacy_theme_header(){
	do_action('ifs_legacy_theme_header');
}

/**
 * hook for theme after header
 *
 * @uses do_action()
 */
function ifs_legacy_theme_after_header(){
	do_action('ifs_legacy_theme_after_header');
}

/**
 * Check theme header files
 *
 * @uses ifs_legacy_check_theme_headers()
 */
function ifs_legacy_check_theme_header( $header_directory, $header_url ){

	$header_files = array();

	$dirs = scandir( $header_directory );
	if ( ! $dirs ) {
		return $header_files;
	}else{
		foreach ( $dirs as $dir ) {

			if($dir=='.' || $dir=='..') continue;

			$root_to_dir 	= $header_directory . '/' . $dir;
			$url_dir		= $header_url . '/' . $dir;

			if(is_dir( $root_to_dir )){

				$header_tmpl= $root_to_dir . '/header';
				$header_php = $root_to_dir . '/header.php';
				$header_css = $root_to_dir . '/header.css';
				$header_png = $root_to_dir . '/header.jpg';
				$header_js	= $root_to_dir . '/header.js';

				$header_tmpl_url	= $url_dir . '/header';
				$header_css_url		= $url_dir . '/header.css';
				$header_png_url		= $url_dir . '/header.jpg';
				$header_js_url		= $url_dir . '/header.js';

				if( file_exists( $header_php ) && file_exists( $header_css ) && file_exists( $header_png ) ){
					$header_files[$dir] = array(
						'name'	=> $dir,
						'tmpl'	=> $header_tmpl,
						'php' 	=> $header_php,
						'css' 	=> $header_css_url,
						'png' 	=> $header_png_url
					);
				}

				if( file_exists( $header_js ) ){
					$header_files[$dir]['js'] = $header_js_url;
				}

			}

		}
	}
	return apply_filters('ifs_legacy_check_theme_header_files', $header_files);
}

/**
 * Get theme header files
 *
 * @uses ifs_legacy_get_theme_header_locations()
 */
function ifs_legacy_theme_header_locations(){
	return apply_filters('ifs_legacy_theme_header_locations', 'template-parts/headers');
}

/**
 * Get theme header files
 *
 * @uses ifs_legacy_get_theme_headers()
 */
function ifs_legacy_get_theme_headers(){
	$header_location = ifs_legacy_theme_header_locations();

	$parent_header_root 	= get_template_directory() . '/' . $header_location;
	$parent_header_url 	= get_template_directory_uri() . '/' . $header_location;

	$header_files = ifs_legacy_check_theme_header( $parent_header_root, $parent_header_url );

	if(is_child_theme()){
		$child_header_root 	= get_stylesheet_directory(). '/' . $header_location;
		$child_header_url	= get_stylesheet_directory_uri(). '/' . $header_location;

		if( file_exists( $child_header_root )){
			$child_header_files = ifs_legacy_check_theme_header( $child_header_root, $child_header_url );

			foreach($child_header_files as $child_header_name => $child_header_val ){

				$header_files[$child_header_name] = $child_header_val;

			}
		}
	}
	return apply_filters('ifs_legacy_get_theme_header_files', $header_files);
}

/**
 * Get theme header default value
 *
 * @uses ifs_legacy_get_theme_header_default()
 */
function ifs_legacy_get_theme_header_default(){
	return apply_filters('ifs_legacy_get_theme_header_default', 'header-1');
}

/**
 * Get theme header value from theme option
 *
 * @uses ifs_legacy_get_theme_header_mod()
 */
function ifs_legacy_get_theme_header_mod(){
	$ifs_legacy_header_mod = get_theme_mod( 'ifs_legacy_header_layout_style', ifs_legacy_get_theme_header_default() );

	$post_id 		= ifs_legacy_get_postid();
	$header_type 		= get_post_meta( $post_id, 'ifs_header_type', true);
	$ifs_legacy_headers 	= ifs_legacy_get_theme_headers();

	if( $header_type != '' && $header_type != 'default' && array_key_exists( $header_type, $ifs_legacy_headers)){
		$ifs_legacy_header_mod = $header_type;
	}

	if(array_key_exists($ifs_legacy_header_mod, $ifs_legacy_headers)){
		$css_header_mod = $ifs_legacy_headers[$ifs_legacy_header_mod]['css'];
		$ifs_legacy_header = $ifs_legacy_headers[$ifs_legacy_header_mod];
		return $ifs_legacy_header;
	}else{
		foreach($ifs_legacy_headers as $ifs_legacy_header){
			$return = $ifs_legacy_header;
			return $return;
			break;
		}
	}
}

/**
 * Get theme header value from theme option
 *
 * @uses ifs_legacy_get_theme_header_css()
 */
function ifs_legacy_get_theme_header_css(){

	$ifs_legacy_header_mod = ifs_legacy_get_theme_header_mod();

	wp_enqueue_style('ifs_legacy_header_mod', $ifs_legacy_header_mod['css'] );

	if(isset($ifs_legacy_header_mod['js'])){
		wp_enqueue_script('ifs_legacy_header_mod', $ifs_legacy_header_mod['js'], array('jquery'), '20180316', true );
	}

	add_filter('body_class', 'ifs_legacy_header_add_body_class');

}
add_action( 'wp_enqueue_scripts', 'ifs_legacy_get_theme_header_css', 20);

function ifs_legacy_header_add_body_class( $classes ){
	$ifs_legacy_header_mod = ifs_legacy_get_theme_header_mod();

	$classes[]  = $ifs_legacy_header_mod['name'];
	$classes[]  = $ifs_legacy_header_mod['name'].'-css';

	if( ifs_legacy_show_header_title() ){
		$classes[]	= 'ifs-show-title';
	}else{
		$classes[]	= 'ifs-no-show-title';
	}

	if( ifs_legacy_have_ext_slider() ){
		$classes[]	= 'ifs-show-slider';
	}else{
		$classes[]	= 'ifs-no-show-slider';
	}

	if( trim( ifs_legacy_position_title() ) ){
		$classes[] = 'ifs-title-'.ifs_legacy_position_title();
	}else{
		$classes[] = 'ifs-title-default';
	}


	return apply_filters('ifs_legacy_header_add_body_class', $classes);
}

/**
 * Get theme header file
 *
 * @uses ifs_legacy_get_theme_header()
 */
function ifs_legacy_get_theme_header(){
	$ifs_legacy_header = ifs_legacy_get_theme_header_mod();
	$header_location = ifs_legacy_theme_header_locations();

	get_template_part( $header_location.'/'.$ifs_legacy_header['name'].'/header');
}
add_action('ifs_legacy_theme_header', 'ifs_legacy_get_theme_header', 20);

/**
 * display the background image for the header section
 *
 * @uses ifs_legacy_display_bg_header()
 */
function ifs_legacy_display_bg_header(){
	$header_bg_image	= get_theme_mod('header_image');

	$post_id 		= ifs_legacy_get_postid();
	$bg_header 	= get_post_meta( $post_id, 'ifs_bg_header', true);

	if($bg_header != ''){
		$header_bg_image = $bg_header;
	}

	return apply_filters('ifs_legacy_display_bg_header', $header_bg_image);
}

/**
 * check the condition whether show the title or not
 *
 * @uses ifs_legacy_show_header_title()
 */
function ifs_legacy_show_header_title(){
	$ifs_show_title_mod = get_theme_mod( 'ifs_legacy_show_page_title', 'true' );

	$post_id 		= ifs_legacy_get_postid();
	$show_title 	= get_post_meta( $post_id, 'ifs_show_title', true);

	if( $show_title != '' && $show_title != 'default'){
		$ifs_show_title_mod = $show_title;
	}

	$return = $ifs_show_title_mod=='true'? true : false;

	if(is_home() && is_front_page()){
		$return = false;
	}

	return apply_filters('ifs_legacy_show_header_title', $return);
}

/**
 * display the background image for the title section
 *
 * @uses ifs_legacy_display_bg_title()
 */
function ifs_legacy_display_bg_title(){
	$title_bg_image		= get_theme_mod('ifs_legacy_page_title_background_image');

	$post_id 		= ifs_legacy_get_postid();
	$bg_title 	= get_post_meta( $post_id, 'ifs_bg_image_title', true);

	if($bg_title != ''){
		$title_bg_image = $bg_title;
	}

	return apply_filters('ifs_legacy_display_bg_title', $title_bg_image);
}

/**
 * display the background color for the title section
 *
 * @uses ifs_legacy_bg_color_title()
 */
function ifs_legacy_bg_color_title(){
	$title_bg		= get_theme_mod('ifs_legacy_page_title_background_color');

	$post_id 		= ifs_legacy_get_postid();
	$bg_title 		= get_post_meta( $post_id, 'ifs_bg_color_title', true);

	if($bg_title != ''){
		$title_bg = $bg_title;
	}

	return apply_filters('ifs_legacy_bg_color_title', $title_bg);
}

/**
 * aligning the text for the title section
 *
 * @uses ifs_legacy_position_title()
 */
function ifs_legacy_position_title(){
	$ifs_pos_title	= get_theme_mod('ifs_legacy_page_title_position');

	$post_id 		= ifs_legacy_get_postid();
	$pos_title 		= get_post_meta( $post_id, 'ifs_position_title', true);

	if($pos_title != ''){
		$ifs_pos_title = $pos_title;
	}

	return apply_filters('ifs_legacy_position_title', $ifs_pos_title);
}

/**
 * call the title file
 *
 * @uses ifs_legacy_header_title()
 */
function ifs_legacy_header_title(){

	do_action('ifs_legacy_header_title');

}

/**
 * call the header title file
 *
 * @uses ifs_legacy_show_header_title()
 */
function ifs_legacy_get_template_header_title(){

	if( ifs_legacy_show_header_title() ){
		get_template_part('template-parts/header-title');
	}

	if( function_exists('woocommerce_breadcrumb')){
		add_action( 'ifs_legacy_the_title', 'woocommerce_breadcrumb', 5 );
	}

}
add_action('ifs_legacy_header_title', 'ifs_legacy_get_template_header_title', 15);

/**
 * check if have external slider or not
 *
 * @uses ifs_legacy_get_postid()
 */
function ifs_legacy_have_ext_slider(){

	$post_id 		= ifs_legacy_get_postid();
	$pos_slider 	= get_post_meta( $post_id, 'ifs_ext_slider', true);

	return trim($pos_slider)!='' ? $pos_slider : "";

}

/**
 * display external slider
 *
 * @uses ifs_legacy_have_ext_slider()
 * @uses do_shortcode()
 */
function ifs_legacy_display_ext_slider(){

	$pos_slider 	= ifs_legacy_have_ext_slider();
	if( $pos_slider!='' ){
		echo '<div class="ext_slider_container">';
			echo do_shortcode( $pos_slider );
		echo '</div>';
	}

}
add_action('ifs_legacy_header_title', 'ifs_legacy_display_ext_slider', 25);

/**
 * Get page title
 *
 * @uses ifs_legacy_get_the_header_title()
 */
function ifs_legacy_get_the_header_title(){

	//custom meta field
	$ifs_pid = ifs_legacy_get_postid();
	$ifs_custom = ifs_legacy_get_customdata($ifs_pid);
	$ifs_cf_pagetitle = (isset($ifs_custom["ifs_page_title"][0]))? $ifs_custom["ifs_page_title"][0] : "";

	if(is_attachment()){

		$ifs_the_title = get_the_title();

	}elseif( function_exists('is_woocommerce') && is_woocommerce() ){

		$ifs_the_title = woocommerce_page_title( false );

	}elseif(is_archive()){

		$ifs_the_title = get_the_archive_title();

	}elseif(is_search()){

		$ifs_the_title = sprintf( esc_html__( 'Search Results for', "ifs-legacy" ).' %s', '<span>' . get_search_query() . '</span>' );

	}elseif(is_404()){

		$ifs_the_title = esc_html__( '404', "ifs-legacy" );

	}elseif( is_home() ){
		$ifs_postspage = get_option('page_for_posts');
		$ifs_posttitle = get_the_title($ifs_postspage);

		$ifs_the_title = ($ifs_postspage)? $ifs_posttitle : esc_html__('Blog', "ifs-legacy" );

	}else{

		if($ifs_cf_pagetitle == ""){
			$ifs_the_title = get_the_title();
		}else{
			$ifs_the_title = $ifs_cf_pagetitle;
		}

	}

	return apply_filters('ifs_legacy_get_the_header_title', $ifs_the_title);

}

/**
 * Get page title
 *
 * @uses ifs_legacy_get_the_header_title()
 */
function ifs_legacy_the_header_title(){
	echo '<h1 class="page-title"><span>' . ifs_legacy_get_the_header_title() . '</span></h1>';
}
add_action('ifs_legacy_the_title','ifs_legacy_the_header_title',15);

/**
 * Get page description
 *
 * @uses ifs_legacy_get_the_header_desc()
 */
function ifs_legacy_get_the_header_desc(){

	//custom meta field
	$ifs_pid = ifs_legacy_get_postid();
	$ifs_cf_pagedesc = get_post_meta( $ifs_pid, 'ifs_pagedesc', true);

	return apply_filters('ifs_legacy_get_the_header_desc', $ifs_cf_pagedesc);

}

/**
 * Get page description
 *
 * @uses ifs_legacy_get_the_header_desc()
 */
function ifs_legacy_the_header_desc(){
	if( ifs_legacy_get_the_header_desc() == '' ){
		echo '';
	}else{
		echo '<div class="page-desc"><span>' . ifs_legacy_get_the_header_desc() . '</span></div>';
	}
}
add_action('ifs_legacy_the_title','ifs_legacy_the_header_desc',25);

if( !function_exists('ifs_legacy_header_css_output') ){
	function ifs_legacy_header_css_output(){

		$topbar_1_pos		= get_theme_mod('ifs_legacy_top_bar_1_position');
		$topbar_2_pos		= get_theme_mod('ifs_legacy_top_bar_2_position');
		$topbar_link_color	= get_theme_mod('ifs_legacy_top_bar_link_color');
		$topbar_text_color	= get_theme_mod('ifs_legacy_top_bar_text_color');
		$topbar_link_color	= get_theme_mod('ifs_legacy_top_bar_link_color');
		$topbar_bg_color	= get_theme_mod('ifs_legacy_top_bar_background_color');
		$topbar_bg_image	= get_theme_mod('ifs_legacy_top_bar_background_image');

		$header_text_color	= get_header_textcolor();
		$header_bg_color	= get_theme_mod('ifs_legacy_header_background_color');
		$header_border_color 	= get_theme_mod('ifs_legacy_header_border_color');
		$menu_color		= get_theme_mod('ifs_legacy_header_menu_color');
		$menuactive_color	= get_theme_mod('ifs_legacy_header_menuactive_color');
		$submenu_color		= get_theme_mod('ifs_legacy_header_submenu_color');
		$submenuactive_color	= get_theme_mod('ifs_legacy_header_submenuactive_color');
		$header_bg_image	= ifs_legacy_display_bg_header();

		$title_bg_color		= ifs_legacy_bg_color_title();
		$title_bg_image		= ifs_legacy_display_bg_title();
		$title_pos			= ifs_legacy_position_title();
		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */

		// If we get this far, we have custom styles. Let's do this.
		$output_css = '';

		if( $topbar_1_pos!=''){
			$output_css .= '.ifs .top_col_1 *{
				text-align: '. esc_attr( $topbar_1_pos ).';
			}';
		}

		if( $topbar_2_pos!=''){
			$output_css .= '.ifs .top_col_2 *{
				text-align: '. esc_attr( $topbar_2_pos ).';
			}';
		}

		if( $topbar_text_color!=''){
			$output_css .= '.ifs .site-before-header{
				color: '. esc_attr( $topbar_text_color ).';
			}';
		}

		if( $topbar_link_color!=''){
			$output_css .= '.ifs .site-before-header a, .ifs .site-before-header a:visited{
				color: '. esc_attr( $topbar_link_color ).';
			}
			.ifs site-before-header a:hover{
				text-decoration:underline;
			}';
		}

		if( $topbar_bg_color!=''){
			$output_css .= '.ifs .site-before-header{
				background-color: '. esc_attr( $topbar_bg_color ).';
			}';
		}

		if($topbar_bg_image!='' && $topbar_bg_image!='remove-image' && $topbar_bg_image!='remove-header'){
			$output_css .= '.ifs .site-before-header{
				background-image: url('. esc_attr( $topbar_bg_image ).');
			}';
		}

		// Has the text been hidden?
		if ( ! display_header_text() ){
			$output_css .= '
				.site-title,
				.site-description {
					position: absolute;
					clip: rect(1px, 1px, 1px, 1px);
				}
			';

		// If the user has set a custom color for the text use that.
		}else{
			$output_css .= '
				.site-title a,
				.site-description {
					color: #'. esc_attr( $header_text_color ) .' !important;
				}
			';
		}

		if( $header_bg_color!=''){
			$output_css .= 'body.ifs .site-header{
				background-color: '. esc_attr( $header_bg_color ).';
			}';
		}

		if( $header_border_color!=''){
			$output_css .= 'body.ifs .site-header{
				border-color: '. esc_attr( $header_border_color ).';
			}';
		}

		if( $menu_color!=''){

			$output_css .= 'body.ifs .site-header .main-navigation ul.nav-menu > li > a{
				color: '. esc_attr( $menu_color ).';
			}';

		}

		if( $menuactive_color!=''){

			$output_css .= 'body.ifs .site-header .main-navigation ul.nav-menu > li.current-menu-item a,
			body.ifs .site-header .main-navigation ul.nav-menu > li.current_page_item a,
			body.ifs .site-header .main-navigation ul.nav-menu > li.current-menu-parent a,
			body.ifs .site-header .main-navigation ul.nav-menu > li.current_page_parent a,
			body.ifs .site-header .main-navigation ul.nav-menu > li.current-menu-ancestor a,
			body.ifs .site-header .main-navigation ul.nav-menu > li.current_page_ancestor a,
			body.ifs .site-header .main-navigation ul.nav-menu > li a:hover{
				color: '. esc_attr( $menuactive_color ).';
			}';
		}

		if( $submenu_color!=''){

			$output_css .= 'body.ifs .site-header .main-navigation ul.nav-menu li li a{
				color: '. esc_attr( $submenu_color ).';
			}';
		}

		if( $submenuactive_color!=''){

			$output_css .= 'body.ifs .site-header .main-navigation ul.nav-menu li li.current-menu-item a,
			body.ifs .site-header .main-navigation ul.nav-menu li li.current_page_item a,
			body.ifs .site-header .main-navigation ul.nav-menu li li.current-menu-parent a,
			body.ifs .site-header .main-navigation ul.nav-menu li li.current_page_parent a,
			body.ifs .site-header .main-navigation ul.nav-menu li li a:hover{
				color: '. esc_attr( $submenuactive_color ).';
			}';
		}

		if($header_bg_image!='' && $header_bg_image!='remove-image' && $header_bg_image!='remove-header'){
			$output_css .= '#header-container{
				background-image: url('. esc_attr( $header_bg_image ).');
			}';
		}

		if($title_bg_color!='' && $title_bg_color!='remove-image'){
			$output_css .= '#outerafterheader{
				background-color: '. esc_attr( $title_bg_color ).';
			}';
		}

		if($title_bg_image!='' && $title_bg_image!='remove-image'){
			$output_css .= '#outerafterheader{
				background-image: url('. esc_attr( $title_bg_image ).');
			}';
		}
		if($title_pos!=''){
			$output_css .= '#pagetitlecontainer{
				text-align: '.esc_attr( $title_pos ).';
			}';
		}

		return apply_filters('ifs_legacy_header_css_output', $output_css );

	}
}
