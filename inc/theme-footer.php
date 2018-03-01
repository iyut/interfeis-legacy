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

 	$dirs = @ scandir( $directory );
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
  * Get theme footer value from theme option
  *
  * @uses ifs_legacy_get_theme_footer_mod()
  */
 function ifs_legacy_get_theme_footer_mod(){
 	$ifs_legacy_footer_mod = get_theme_mod( 'ifs_legacy_footer_layout_style', 'footer-1' );
 	$ifs_legacy_footers = ifs_legacy_get_theme_footers();
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

    add_filter('body_class', function (array $classes) {

        $ifs_legacy_footer_mod = ifs_legacy_get_theme_footer_mod();

	    $classes[]  = $ifs_legacy_footer_mod['name'];
	    $classes[]  = $ifs_legacy_footer_mod['name'].'-css';

		return apply_filters('ifs_legacy_get_theme_footer_css_filter', $classes);
	});

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
  * Get theme footer file
  *
  * @uses ifs_legacy_bottom_foot()
  */
function ifs_legacy_bottom_foot(){
    do_action('ifs_legacy_bottom_foot');
}

/**
 * Get theme footer file
 *
 * @uses ifs_legacy_bottom_foot_col_1()
 */
function ifs_legacy_bottom_foot_col_1(){
    echo '<div class="foot_col_1 foot_col col-6">';
        do_action('ifs_legacy_bottom_foot_col_1');
    echo '</div>';
}
 add_action('ifs_legacy_bottom_foot', 'ifs_legacy_bottom_foot_col_1', 10);

 /**
  * Get theme footer file
  *
  * @uses ifs_legacy_bottom_foot_col_1()
  */
 function ifs_legacy_bottom_foot_col_2(){
     echo '<div class="foot_col_2 foot_col col-6">';
         do_action('ifs_legacy_bottom_foot_col_2');
     echo '</div>';
 }
  add_action('ifs_legacy_bottom_foot', 'ifs_legacy_bottom_foot_col_2', 20);

  /**
   * Print content for footer bar coolumn 1
   *
   * @uses ifs_legacy_bottom_foot_col_1()
   */
  function ifs_legacy_content_foot_col_1(){
      ifs_legacy_print_copyright();
  }
  add_action('ifs_legacy_bottom_foot_col_1', 'ifs_legacy_content_foot_col_1', 10);

  /**
   * Print content for footer bar coolumn 1
   *
   * @uses ifs_legacy_bottom_foot_col_2()
   */
  function ifs_legacy_content_foot_col_2(){
      ifs_legacy_footer_menu();
  }
  add_action('ifs_legacy_bottom_foot_col_2', 'ifs_legacy_content_foot_col_2', 10);

  /**
   * Print copyright text
   *
   * @uses ifs_legacy_print_copyright()
   */
  function ifs_legacy_print_copyright(){
    ?>
    <div class="site-info">
    <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'ifs-legacy' ) ); ?>"><?php
        /* translators: %s: CMS name, i.e. WordPress. */
        printf( esc_html__( 'Proudly powered by %s', 'ifs-legacy' ), 'WordPress' );
    ?></a>
    <span class="sep"> | </span>
    <?php
        /* translators: 1: Theme name, 2: Theme author. */
        printf( esc_html__( 'Theme: %1$s by %2$s.', 'ifs-legacy' ), 'Legacy', '<a href="http://www.interfeis.com">Interfeis Team</a>' );
     ?>
     </div>
     <?php
  }

  /**
   * Print copyright text
   *
   * @uses ifs_legacy_print_copyright()
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
