<?php
/**
 * All functions and hooks for footer
 *
 * @package Legacy
 */

 /**
  * hook for theme header
  *
  * @uses ifs_legacyt_theme_footer()
  */
 function ifs_legacy_theme_footer(){
 	do_action('ifs_legacy_theme_footer');
 }

 /**
  * Get theme footer files
  *
  * @uses ifs_legacy_get_theme_footer_locations()
  */
 function ifs_legacy_theme_footer_locations(){
 	return apply_filters('ifs_legacy_theme_footer_locations', 'template-parts/footers');
 }

 /**
  * Check theme footer files
  *
  * @uses ifs_legacy_check_theme_footer()
  */
 function ifs_legacy_check_theme_footer( $directory, $url ){

 	$footer_files = array();

 	$dirs = scandir( $directory );
 	if ( ! $dirs ) {
 		return $footer_files;
 	}else{
 		foreach ( $dirs as $dir ) {

 			if($dir=='.' || $dir=='..') continue;

 			$root_to_dir 	= $directory . '/' . $dir;
 			$url_dir		= $url . '/' . $dir;

 			if(is_dir( $root_to_dir )){

 				$footer_tmpl= $root_to_dir . '/footer';
 				$footer_php = $root_to_dir . '/footer.php';
 				$footer_css = $root_to_dir . '/footer.css';
 				$footer_png = $root_to_dir . '/footer.png';
 				$footer_js	= $root_to_dir . '/footer.js';

 				$footer_tmpl_url	= $url_dir . '/footer';
 				$footer_css_url		= $url_dir . '/footer.css';
 				$footer_png_url		= $url_dir . '/footer.png';
 				$footer_js_url		= $url_dir . '/footer.js';

 				if( file_exists( $footer_php ) && file_exists( $footer_css ) && file_exists( $footer_png ) ){
 					$footer_files[$dir] = array(
 						'name'	=> $dir,
 						'tmpl'	=> $footer_tmpl,
 						'php' 	=> $footer_php,
 						'css' 	=> $footer_css_url,
 						'png' 	=> $footer_png_url
 					);
 				}

 				if( file_exists( $footer_js ) ){
 					$footer_files[$dir]['js'] = $footer_js_url;
 				}

 			}

 		}
 	}
 	return apply_filters('ifs_legacy_check_theme_footer_files', $footer_files);
 }

 /**
  * Get theme footer files
  *
  * @uses ifs_legacy_get_theme_footers()
  */
 function ifs_legacy_get_theme_footers(){

    $footer_location = ifs_legacy_theme_footer_locations();

 	$parent_root      = get_template_directory().'/'.$footer_location;
 	$parent_url       = get_template_directory_uri().'/'.$footer_location;

 	$footer_files = ifs_legacy_check_theme_footer( $parent_root, $parent_url );

 	if(is_child_theme()){
 		$child_root      = get_stylesheet_directory().'/'.$footer_location;
 		$child_url       = get_stylesheet_directory_uri().'/'.$footer_location;

 		$child_files = ifs_legacy_check_theme_footer( $child_root, $child_url );

 		foreach($child_files as $child_name => $child_val ){

 			$footer_files[$child_name] = $child_val;

 		}
 	}
 	return apply_filters('ifs_legacy_get_theme_footer_files', $footer_files);
 }

 /**
  * Get theme footer default value
  *
  * @uses ifs_legacy_get_theme_footer_default()
  */
 function ifs_legacy_get_theme_footer_default(){
 	return apply_filters('ifs_legacy_get_theme_footer_default', 'footer-1');
 }

 /**
  * Get theme footer value from theme option
  *
  * @uses ifs_legacy_get_theme_footer_mod()
  */
 function ifs_legacy_get_theme_footer_mod(){
 	$ifs_legacy_footer_mod = get_theme_mod( 'ifs_legacy_footer_layout_style', 'footer-1' );

    $post_id 		= ifs_legacy_get_postid();
	$footer_type 	= get_post_meta( $post_id, 'ifs_footer_sidebar_type', true);
 	$ifs_legacy_footers = ifs_legacy_get_theme_footers();

    if( $footer_type != '' && $footer_type != 'default' && array_key_exists( $footer_type, $ifs_legacy_footers)){
		$ifs_legacy_footer_mod = $footer_type;
	}

 	if(array_key_exists($ifs_legacy_footer_mod, $ifs_legacy_footers)){
 		$css_footer_mod = $ifs_legacy_footers[$ifs_legacy_footer_mod]['css'];
 		$ifs_legacy_footer = $ifs_legacy_footers[$ifs_legacy_footer_mod];
        $return = $ifs_legacy_footer;
 	}else{
 		foreach($ifs_legacy_footers as $ifs_legacy_footer){
 			$return = $ifs_legacy_footer;
 			break;
 		}
 	}
    return apply_filters('ifs_legacy_get_theme_footer_mod_val',$return);
 }

 /**
  * Get theme footer value from theme option
  *
  * @uses ifs_legacy_get_theme_footer_mod()
  */
 function ifs_legacy_get_theme_footer_css(){

 	$ifs_legacy_footer_mod = ifs_legacy_get_theme_footer_mod();
 	wp_enqueue_style('ifs_legacy_footer_mod', $ifs_legacy_footer_mod['css'] );

    add_filter('body_class', 'ifs_legacy_footer_add_body_class');

}
add_action( 'wp_enqueue_scripts', 'ifs_legacy_get_theme_footer_css', 30);

function ifs_legacy_footer_add_body_class(){
	$ifs_legacy_footer_mod = ifs_legacy_get_theme_footer_mod();

	$classes[]  = $ifs_legacy_footer_mod['name'];
	$classes[]  = $ifs_legacy_footer_mod['name'].'-css';

	return apply_filters('ifs_legacy_get_theme_footer_css_filter', $classes);
}

 /**
  * Get theme footer file
  *
  * @uses ifs_legacy_get_theme_footer()
  */
 function ifs_legacy_get_theme_footer(){
 	$ifs_legacy_footer = ifs_legacy_get_theme_footer_mod();
    $footer_location = ifs_legacy_theme_footer_locations();

 	get_template_part( $footer_location.'/'.$ifs_legacy_footer['name'].'/footer');
 }
 add_action('ifs_legacy_theme_footer', 'ifs_legacy_get_theme_footer', 20);

/**
* Generate available option for the footer bar content
*
* @uses ifs_legacy_footer_bar_choices()
*/
function ifs_legacy_footer_bar_choices(){
    return apply_filters('ifs_legacy_footer_bar_choices', array(
        ''              => esc_html__( 'None', 'ifs-legacy' ),
        'text'          => esc_html__( 'Text', 'ifs-legacy' ),
        'menu'          => esc_html__( 'Menu', 'ifs-legacy' ),
        'widget'        => esc_html__( 'Widget', 'ifs-legacy' )
    ));
}

 /**
  * Print footer bar
  *
  * @uses ifs_legacy_footer_bar()
  */
function ifs_legacy_footer_bar(){
    do_action('ifs_legacy_footer_bar');
}

/**
* Get theme footer file
*
* @uses ifs_legacy_show_footer_bar()
*/
function ifs_legacy_footer_bar_columns(){

    if( !ifs_legacy_show_footer_bar() ){
        return;
    }
    ?>
    <div class="outer-footer-bottom">
        <div class="container footer-bottom-cont">
            <div class="row">
                <?php do_action('ifs_legacy_footer_bar_columns'); ?>
            </div>
        </div>
    </div>
    <?php
}
add_action('ifs_legacy_footer_bar', 'ifs_legacy_footer_bar_columns', 10);

/**
* show footer bar
*
* @return bool
*/
function ifs_legacy_show_footer_bar(){
    $content_1 = get_theme_mod('ifs_legacy_footer_bar_1_content', 'text');
    $content_2 = get_theme_mod('ifs_legacy_footer_bar_2_content', '');

    $post_id 		= ifs_legacy_get_postid();
	$footer_bar 	= get_post_meta( $post_id, 'ifs_show_footer_bar', true);

    $return = true;

    if($footer_bar=='false'){
        $return = false;
    }

    if(empty($content_1) && empty($content_2)){
        $return = false;
    }

    return apply_filters('ifs_legacy_show_footer_bar', $return);
}

/**
 * Get theme footer file
 *
 * @uses ifs_legacy_bottom_foot_col_1()
 */
function ifs_legacy_bottom_foot_col_1(){
    echo '<div class="foot_col_1 foot_col col-lg-6">';
        do_action('ifs_legacy_bottom_foot_col_1');
    echo '</div>';
}
 add_action('ifs_legacy_footer_bar_columns', 'ifs_legacy_bottom_foot_col_1', 10);

 /**
  * Get theme footer file
  *
  * @uses ifs_legacy_bottom_foot_col_1()
  */
 function ifs_legacy_bottom_foot_col_2(){
     echo '<div class="foot_col_2 foot_col col-lg-6">';
         do_action('ifs_legacy_bottom_foot_col_2');
     echo '</div>';
 }
  add_action('ifs_legacy_footer_bar_columns', 'ifs_legacy_bottom_foot_col_2', 20);

  /**
   * Print content for footer bar coolumn 1
   *
   * @uses ifs_legacy_bottom_foot_col_1()
   */
  function ifs_legacy_content_foot_col_1(){
      $ifs_legacy_foot_bar_content = get_theme_mod('ifs_legacy_footer_bar_1_content','text');
      switch ($ifs_legacy_foot_bar_content) {
          case "menu":
              ifs_legacy_footer_menu();
              break;
          case "widget":
              ifs_legacy_print_footer_widget_1();
              break;
          case "text":
              ifs_legacy_print_copyright();
              break;
          default:
             return;
      }
  }
  add_action('ifs_legacy_bottom_foot_col_1', 'ifs_legacy_content_foot_col_1', 10);

/**
* Print content for footer bar coolumn 1
*
* @uses ifs_legacy_bottom_foot_col_2()
*/
function ifs_legacy_content_foot_col_2(){
    $ifs_legacy_foot_bar_content = get_theme_mod('ifs_legacy_footer_bar_2_content');
    switch ($ifs_legacy_foot_bar_content) {
        case "menu":
            ifs_legacy_footer_menu();
            break;
        case "widget":
            ifs_legacy_print_footer_widget_2();
            break;
        case "text":
            ifs_legacy_print_footer_text_2();
            break;
        default:
           return;
    }

}
add_action('ifs_legacy_bottom_foot_col_2', 'ifs_legacy_content_foot_col_2', 10);

  /**
   * Print copyright text
   *
   * @uses ifs_legacy_print_copyright()
   */
function ifs_legacy_print_copyright(){
    $ifs_legacy_footer_text = get_theme_mod( 'ifs_legacy_footer_bar_1_text', '' );
    ?>
    <div class="site-info">
    <?php
    if( trim($ifs_legacy_footer_text)==''){
    ?>
        <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'ifs-legacy' ) ); ?>"><?php
            /* translators: %s: CMS name, i.e. WordPress. */
            printf( esc_html__( 'Proudly powered by %s', 'ifs-legacy' ), 'WordPress' );
        ?></a>
        <span class="sep"> | </span>
        <?php
            /* translators: 1: Theme name, 2: Theme author. */
            printf( esc_html__( 'Theme: %1$s by %2$s.', 'ifs-legacy' ), 'Legacy', '<a href="http://www.interfeis.com">Interfeis Team</a>' );
         ?>

    <?php
    }else{
        echo esc_html( $ifs_legacy_footer_text );
    }
    ?>
    </div>
    <?php
}

/**
* Print footer bar widget 1
*
* @uses ifs_legacy_print_footer_widget_1()
*/
function ifs_legacy_print_footer_widget_1(){
    dynamic_sidebar( 'footer-bar-1' );
}

/**
* Print footer menu
*
* @uses ifs_legacy_footer_menu()
*/
function ifs_legacy_footer_menu(){
    ?>
    <div class="footer-menu">
    <?php
        wp_nav_menu( array(
            'theme_location' => 'footer-menu',
            'menu_id'        => 'footer-menu',
            'depth'          => 1
        ) );
    ?>
     </div>
     <?php
}

/**
* Print footer bar text 2
*
* @uses ifs_legacy_print_footer_text_2()
*/
function ifs_legacy_print_footer_text_2(){
    $ifs_legacy_footer_text = get_theme_mod( 'ifs_legacy_footer_bar_2_text', '' );
    ?>
    <div class="site-info"><?php echo esc_html( $ifs_legacy_footer_text ); ?></div>
    <?php
}

/**
* Print footer bar widget 2
*
* @uses ifs_legacy_print_footer_widget_2()
*/
function ifs_legacy_print_footer_widget_2(){
    dynamic_sidebar( 'footer-bar-2' );
}

if( !function_exists('ifs_legacy_footer_css_output') ){
	function ifs_legacy_footer_css_output(){

		$footer_text_color	= get_theme_mod('ifs_legacy_footer_text_color');
        $footer_link_color	= get_theme_mod('ifs_legacy_footer_link_color');
		$footer_bg_color	= get_theme_mod('ifs_legacy_footer_background_color');
		$footer_bg_image	= get_theme_mod('ifs_legacy_footer_background_image');

		// If we get this far, we have custom styles. Let's do this.
		$output_css = '';

        if( $footer_text_color!=''){
			$output_css .= '#colophon{
				color: '. esc_attr( $footer_text_color ).';
			}';
		}

        if( $footer_link_color!=''){
			$output_css .= '#colophon a, #colophon a:visited{
				color: '. esc_attr( $footer_link_color ).';
			}';
		}

		if( $footer_bg_color!=''){
			$output_css .= '#colophon{
				background-color: '. esc_attr( $footer_bg_color ).';
			}';
		}

		if($footer_bg_image!='' && $footer_bg_mage!='remove-image'){
			$output_css .= '#colophon{
				background-image: url('. esc_attr( $footer_bg_image ).');
			}';
		}

		return apply_filters('ifs_legacy_footer_css_output', $output_css );

	}
}

if( !function_exists('ifs_legacy_footer_bar_css_output') ){
	function ifs_legacy_footer_bar_css_output(){

		$footer_text_color	= get_theme_mod('ifs_legacy_footer_bar_text_color');
        $footer_link_color	= get_theme_mod('ifs_legacy_footer_bar_link_color');
		$footer_bg_color	= get_theme_mod('ifs_legacy_footer_bar_background_color');
		$footer_bg_image	= get_theme_mod('ifs_legacy_footer_bar_background_image');

		// If we get this far, we have custom styles. Let's do this.
		$output_css = '';

        if( $footer_text_color!=''){
			$output_css .= '#colophon .outer-footer-bottom{
				color: '. esc_attr( $footer_text_color ).';
			}';
		}

        if( $footer_link_color!=''){
			$output_css .= '#colophon .outer-footer-bottom a, #colophon .outer-footer-bottom a:visited{
				color: '. esc_attr( $footer_link_color ).';
			}';
		}

		if( $footer_bg_color!=''){
			$output_css .= '#colophon .outer-footer-bottom{
				background-color: '. esc_attr( $footer_bg_color ).';
			}';
		}

		if($footer_bg_image!='' && $footer_bg_image!='remove-image'){
			$output_css .= '#colophon .outer-footer-bottom{
				background-image: url('. esc_attr( $footer_bg_image ).');
			}';
		}

		return apply_filters('ifs_legacy_footer_bar_css_output', $output_css );

	}
}
