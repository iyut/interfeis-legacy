<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
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
function ifs_legacy_check_theme_header( $header_directory ){

	$header_files = array();

	$dirs = @ scandir( $header_directory );
	if ( ! $dirs ) {
		return $header_files;
	}else{
		foreach ( $dirs as $dir ) {

			if($dir=='.' || $dir=='..') continue;

			$root_to_dir = $header_directory . '/' . $dir;

			if(is_dir( $root_to_dir )){

				$header_tmpl= $root_to_dir . '/header';
				$header_php = $root_to_dir . '/header.php';
				$header_css = $root_to_dir . '/header.css';
				$header_png = $root_to_dir . '/header.png';

				if( file_exists( $header_php ) && file_exists( $header_css ) && file_exists( $header_png ) ){
					$header_files[$dir] = array(
						'tmpl'	=> $header_tmpl,
						'php' 	=> $header_php,
						'css' 	=> $header_css,
						'png' 	=> $header_png
					);
				}

			}

		}
	}
	return apply_filters('ifs_legacy_check_theme_header_files', $header_files);
}

/**
 * Get theme header files
 *
 * @uses ifs_legacy_get_theme_headers()
 */
function ifs_legacy_get_theme_headers(){
	$parent_header_root = get_template_directory().'/headers';

	$header_files = ifs_legacy_check_theme_header( $parent_header_root );

	if(is_child_theme()){
		$child_header_root = get_stylesheet_directory().'/headers';

		$child_header_files = ifs_legacy_check_theme_header( $child_header_root );

		foreach($child_header_files as $child_header_name => $child_header_val ){

			$header_files[$child_header_name] = $child_header_val;

		}
	}
	return apply_filters('ifs_legacy_get_theme_header_files', $header_files);
}

/**
 * Get theme header file
 *
 * @uses ifs_legacy_get_theme_header()
 */
function ifs_legacy_get_theme_header(){
	$ifs_legacy_header = 'header-1';
	get_template_part( 'headers/'.$ifs_legacy_header.'/header');
}
add_action('ifs_legacy_theme_header', 'ifs_legacy_get_theme_header', 20);

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

if ( ! function_exists( 'ifs_legacy_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see ifs_legacy_custom_header_setup().
	 */
	function ifs_legacy_header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
		?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
			// If the user has set a custom color for the text use that.
			else :
		?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;
