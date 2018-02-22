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
 * hook for theme header
 *
 * @uses ifs_legacyt_theme_header()
 */
function ifs_legacy_theme_header(){
	do_action('ifs_legacy_theme_header');
}

/**
 * Check theme header files
 *
 * @uses ifs_legacy_check_theme_headers()
 */
function ifs_legacy_check_theme_header( $header_directory, $header_url ){

	$header_files = array();

	$dirs = @ scandir( $header_directory );
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
				$header_png = $root_to_dir . '/header.png';
				$header_js	= $root_to_dir . '/header.js';

				$header_tmpl_url	= $url_dir . '/header';
				$header_css_url		= $url_dir . '/header.css';
				$header_png_url		= $url_dir . '/header.png';
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

	$parent_header_root = get_template_directory() . '/' . $header_location;
	$parent_header_url 	= get_template_directory_uri() . '/' . $header_location;

	$header_files = ifs_legacy_check_theme_header( $parent_header_root, $parent_header_url );

	if(is_child_theme()){
		$child_header_root 	= get_stylesheet_directory(). '/' . $header_location;
		$child_header_url	= get_stylesheet_directory_uri(). '/' . $header_location;

		$child_header_files = ifs_legacy_check_theme_header( $child_header_root, $child_header_url );

		foreach($child_header_files as $child_header_name => $child_header_val ){

			$header_files[$child_header_name] = $child_header_val;

		}
	}
	return apply_filters('ifs_legacy_get_theme_header_files', $header_files);
}

/**
 * Get theme header value from theme option
 *
 * @uses ifs_legacy_get_theme_header_mod()
 */
function ifs_legacy_get_theme_header_mod(){
	$ifs_legacy_header_mod = get_theme_mod( 'ifs_legacy_header_layout_style' );
	$ifs_legacy_headers = ifs_legacy_get_theme_headers();
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

	add_filter('body_class', function (array $classes) {
		$ifs_legacy_header_mod = ifs_legacy_get_theme_header_mod();

	    $classes[]  = $ifs_legacy_header_mod['name'];
	    $classes[]  = $ifs_legacy_header_mod['name'].'-css';

		return $classes;
	});

}
add_action( 'wp_enqueue_scripts', 'ifs_legacy_get_theme_header_css', 20);

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
 * check the condition whether show the title or not
 *
 * @uses ifs_legacy_show_header_title()
 */
function ifs_legacy_show_header_title(){
	return apply_filters('ifs_legacy_show_header_title', true);
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
 * @uses ifs_legacy_get_template_header_title()
 */
function ifs_legacy_get_template_header_title(){

	if( ifs_legacy_show_header_title() ){
		get_template_part('template-parts/header-title');
	}

}
add_action('ifs_legacy_header_title', 'ifs_legacy_get_template_header_title', 15);

/**
 * Get page title
 *
 * @uses ifs_legacy_get_the_header_title()
 */
function ifs_legacy_get_the_header_title(){

	//custom meta field
	$ifs_pid = ifs_legacy_get_postid();
	$ifs_custom = ifs_legacy_get_customdata($ifs_pid);
	$ifs_cf_pagetitle = (isset($ifs_custom["nvr_page-title"][0]))? $ifs_custom["nvr_page-title"][0] : "";

	if(is_attachment()){

		$ifs_the_title = get_the_title();

	}elseif( function_exists('is_woocommerce') && is_woocommerce() ){

		$ifs_the_title = woocommerce_page_title( false );

	}elseif(is_archive()){

		$ifs_the_title = get_the_archive_title();

	}elseif(is_search()){

		$ifs_the_title = sprintf( esc_html__( 'Search Results for', "ifs-legacy" ).' %s', '<span>' . get_search_query() . '</span>' );

	}elseif(is_404()){

		$ifs_the_title = esc_html__( '404 Page', "ifs-legacy" );

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
 * Set up the WordPress core custom header feature.
 *
 * @uses ifs_legacy_header_style()
 */
function ifs_legacy_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'ifs_legacy_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 1000,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'ifs_legacy_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'ifs_legacy_custom_header_setup' );

if( !function_exists('ifs_legacy_header_css_output') ){
	function ifs_legacy_header_css_output(){

		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return '';
		}

		// If we get this far, we have custom styles. Let's do this.
		$output_css = '';

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
		return apply_filters('ifs_legacy_header_css_output', $output_css );

	}
}

if ( ! function_exists( 'ifs_legacy_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see ifs_legacy_custom_header_setup().
	 */
	function ifs_legacy_header_style() {
		?>
		<style type="text/css">
		<?php echo ifs_legacy_header_css_output(); ?>
		</style>
		<?php
	}
endif;
